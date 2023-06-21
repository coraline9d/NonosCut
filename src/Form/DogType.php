<?php

namespace App\Form;

use App\Entity\Dog;
use App\Entity\Service;
use App\Entity\Appointment;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class DogType extends AbstractType
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nickname')
            ->add('age')
            ->add('breed')
            ->add('sexe', ChoiceType::class, [
                'label' => 'Sexe :',
                'choices' => [
                    'Femelle' => 'Femelle',
                    'Mâle' => 'Mâle'
                ],
                'placeholder' => 'Choisir le sexe de votre chien',
                'multiple' => false,
                'expanded' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner le sexe de votre chien'
                    ])
                ]
            ])
            ->add('service', EntityType::class, [
                'class' => Service::class,
                'mapped' => false,
                'choice_label' => 'name',
            ])
            ->add('date', DateType::class, [
                'widget' => 'single_text',
                'mapped' => false
                // Ajouter des options supplémentaires si nécessaire
            ])
            ->add('hour', TimeType::class, [
                'widget' => 'single_text',
                'mapped' => false
                // Ajouter des options supplémentaires si nécessaire
            ]);
        $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
            $dog = $event->getData();
            $form = $event->getForm();

            // Récupérer la date et l'heure choisies dans le formulaire
            $date = $form->get('date')->getData();
            $hour = $form->get('hour')->getData();

            // Créer une nouvelle entité Appointment avec la date et l'heure choisies
            $appointment = new Appointment();
            $appointment->setDate($date);
            $appointment->setHour($hour);

            // Associer l'entité Appointment à l'entité Dog soumise
            $dog->addAppointment($appointment);

            // Enregistrer l'entité Appointment dans la base de données
            $this->entityManager->persist($appointment);
        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Dog::class
        ]);
    }
}
