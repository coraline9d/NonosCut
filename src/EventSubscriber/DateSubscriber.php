<?php

namespace App\EventSubscriber;

use App\Repository\AppointmentRepository;
use App\Repository\ServiceRepository;
use Symfony\Component\Form\FormEvent;
use App\Repository\ScheduleRepository;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class DateSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private ScheduleRepository $scheduleRepository,
        private ServiceRepository $serviceRepository,
        private AppointmentRepository $appointmentRepository
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            FormEvents::PRE_SUBMIT => 'onPreSubmit',
        ];
    }

    public function onPreSubmit(FormEvent $event)
    {
        $form = $event->getForm();
        $data = $event->getData();
        $dateString = $data['date'];
        $nameService = $data['service'];

        // Call the calculateAvailableHours function with the retrieved data
        $availableHours = $this->calculateAvailableHours($dateString, $nameService);
        $availableHours = array_map(function ($hour) {
            return $hour->format('H:i');
        }, $availableHours);

        $form->add('hour', ChoiceType::class, [
            'label' => 'Heure de la réservation :',
            'attr' => ['id' => 'hour'],
            'choices' => array_combine($availableHours, $availableHours),
            'placeholder' => 'Choisir une heure',

            'constraints' => [
                new NotBlank([
                    'message' => 'Veuillez renseigner une heure pour votre repas s\'il vous plait'
                ])
            ]
        ]);
    }

    public function calculateAvailableHours($dateString, $nameService)
    {
        // Récupérer le jour de la semaine pour la date sélectionnée
        if (is_array($dateString)) {
            $dateString = sprintf('%04d-%02d-%02d', $dateString['year'], $dateString['month'], $dateString['day']);
        }

        $date = \DateTime::createFromFormat('Y-m-d', $dateString);
        $dayOfWeek = $date->format('l');
        $daysOfWeek = [
            'Monday' => 'Lundi',
            'Tuesday' => 'Mardi',
            'Wednesday' => 'Mercredi',
            'Thursday' => 'Jeudi',
            'Friday' => 'Vendredi',
            'Saturday' => 'Samedi',
            'Sunday' => 'Dimanche'
        ];

        $dayOfWeek = $daysOfWeek[$dayOfWeek];

        // Trouver les horaires pour le jour de la semaine sélectionné
        $daySchedule = $this->scheduleRepository->findOneBy(['day' => $dayOfWeek]);

        // Si les horaires pour le jour sélectionné sont trouvés, mettre à jour les heures d'ouverture, de fermeture et de pause déjeuner
        if ($daySchedule) {
            $openingHour = \DateTime::createFromFormat('H', (string)$daySchedule->getOpeningHour());
            $closingHour = \DateTime::createFromFormat('H', (string)$daySchedule->getClosingHour());
            $beginningBreakHour = \DateTime::createFromFormat('H', (string)$daySchedule->getBeginningBreakHour());
            $endingBreakHour = \DateTime::createFromFormat('H', (string)$daySchedule->getEndingBreakHour());
        }
        // Si les horaires pour le jour sélectionné ne sont pas trouvés, utiliser les horaires par défaut
        else {
            return [];
        }

        // Récupérer la durée du service sélectionné
        $serviceDuration = 0;

        if ($nameService) {
            $service = $this->serviceRepository->find($nameService);
            if ($service) {

                $serviceDuration = (int)$service->getDuration();
            }
        }

        $availableHours = [];

        // Parcourir les heures entre l'heure d'ouverture et l'heure de début de pause déjeuner
        for ($hour = clone $openingHour; $hour < $beginningBreakHour; $hour->modify('+1 hour')) {
            // Vérifier si l'heure actuelle plus la durée du service est inférieure à l'heure de début de pause déjeuner
            $serviceEndTime = clone $hour;
            $serviceEndTime->modify(sprintf('+%d hour', $serviceDuration));
            if ($serviceEndTime <= $beginningBreakHour) {
                // Ajouter l'heure actuelle à la liste des heures disponibles pour le service
                $availableHours[] = clone $hour;
            }
        }

        // Parcourir les heures entre l'heure de fin de pause déjeuner et l'heure de fermeture
        for ($hour = clone $endingBreakHour; $hour < $closingHour; $hour->modify('+1 hour')) {
            // Vérifier si l'heure actuelle plus la durée du service est inférieure à l'heure de fermeture
            $serviceEndTime = clone $hour;
            $serviceEndTime->modify(sprintf('+%d hour', $serviceDuration));
            if ($serviceEndTime <= $closingHour) {
                // Ajouter l'heure actuelle à la liste des heures disponibles pour le service
                $availableHours[] = clone $hour;
            }
        }

        // Récupérer les rendez-vous pour la date sélectionnée
        $date = \DateTime::createFromFormat('Y-m-d', $dateString);
        $appointments = $this->appointmentRepository->findBy(['date' => $date]);

        // Parcourir les heures disponibles pour le service
        foreach ($availableHours as $key => $availableHour) {
            // Vérifier si l'heure disponible pour le service est déjà réservée pour un rendez-vous
            foreach ($appointments as $appointment) {
                $appointmentHour = \DateTime::createFromFormat('H:i', $appointment->getHour());
                if ($appointmentHour === false) {
                    // Gérer l'erreur
                    continue;
                }
                $appointmentEndTime = clone $appointmentHour;
                $appointmentServiceDuration = (int)$appointment->getService()->getDuration();
                $appointmentEndTime->modify(sprintf('+%d hour', $appointmentServiceDuration));
                if ($availableHour >= $appointmentHour && $availableHour < $appointmentEndTime) {
                    // Supprimer l'heure disponible pour le service de la liste des heures disponibles
                    unset($availableHours[$key]);
                    break;
                }

                // Vérifier si le rendez-vous proposé chevauche un autre rendez-vous qui commence après l'heure disponible
                $proposedAppointmentEndTime = clone $availableHour;
                $proposedAppointmentEndTime->modify(sprintf('+%d hour', $serviceDuration));
                if ($proposedAppointmentEndTime > $appointmentHour && $availableHour < $appointmentHour) {
                    // Supprimer l'heure disponible pour le service de la liste des heures disponibles
                    unset($availableHours[$key]);
                    break;
                }
            }
        }
        return array_values($availableHours);
    }
}
