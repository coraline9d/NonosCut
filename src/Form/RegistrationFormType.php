<?php

namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Karser\Recaptcha3Bundle\Form\Recaptcha3Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Karser\Recaptcha3Bundle\Validator\Constraints\Recaptcha3;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nickName', TextType::class, [
                'label' => 'Prénom *',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner votre prénom',
                    ])
                ]
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Nom *',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner votre nom',
                    ])
                ]
            ])
            ->add('mobile', null, [
                'label' => 'Numéro de Téléphone *',
                'attr' => [
                    'placeholder' => '+33625122512',
                ],
                'constraints' => [
                    new Regex([
                        'pattern' => '/^\+33[67]\d{8}$/',
                        'message' => 'Le numéro de téléphone doit être de la forme +33625122512'
                    ]),
                    new NotBlank([
                        'message' => 'Veuillez renseigner votre numéro de téléphone',
                    ])
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email *',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner votre adresse email',
                    ]),
                    new Email([
                        'message' => 'Veuillez renseigner votre adresse email',
                    ]),
                ],
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'label' => 'J\'accepte les conditions générales d\'utilisation *',
                'constraints' => [
                    new IsTrue([
                        'message' => 'Veuillez accepter nos conditions générales d\'utilisation',
                    ]),
                ],
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passe sont différents',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options'  => ['label' => 'Mot de Passe *'],
                'second_options' => ['label' => 'Confirmer Mot de Passe *'],
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new Regex([
                        'pattern' => '/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{14,}$/',
                        'message' => 'Le mot de passe doit faire 14 caractères et contenir des majuscules, minuscules, caractères spéciaux et des chiffres'
                    ]),
                    new NotBlank([
                        'message' => 'Veuillez renseigner votre mot de passe',
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
