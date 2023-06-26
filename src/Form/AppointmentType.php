<?php

namespace App\Form;

use App\Entity\Service;
use App\Entity\Appointment;
use App\Repository\ServiceRepository;
use App\Repository\ScheduleRepository;
use App\EventSubscriber\DateSubscriber;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use App\Repository\AppointmentRepository;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;

class AppointmentType extends AbstractType
{
    public function __construct(private EntityManagerInterface $entityManager, private ScheduleRepository $scheduleRepository, private ServiceRepository $serviceRepository, private AppointmentRepository $appointmentRepository)
    {
        $this->entityManager = $entityManager;
        $this->scheduleRepository = $scheduleRepository;
        $this->serviceRepository = $serviceRepository;
        $this->appointmentRepository = $appointmentRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // Ajout du FormEventSubscriber au formulaire
        $builder->addEventSubscriber(new DateSubscriber($this->scheduleRepository, $this->serviceRepository, $this->appointmentRepository));
        $builder
            ->add('date', DateType::class, [
                'label' => 'Date :',
                'widget' => 'single_text',
                'attr' => ['min' => date('d-m-Y')],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner une date pour votre repas s\'il vous plait'
                    ]),
                    new GreaterThanOrEqual([
                        'value' => 'today',
                        'message' => 'La date sélectionnée doit être supérieure ou égale à la date actuelle'
                    ])
                ]
            ])
            // ->add('hour')
            ->add('surname')
            ->add('age')
            ->add('breed')
            ->add('sexe')
            ->add('service', EntityType::class, [
                'class' => Service::class,
                'choice_label' => 'name',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Appointment::class,
            'em' => null,
        ]);
    }
}
