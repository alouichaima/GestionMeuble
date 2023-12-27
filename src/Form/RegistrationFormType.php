<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('email', EmailType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Please enter an email address.']),
                    new Email(['message' => 'The email "{{ value }}" is not a valid email.']),
                ],
            ])
            ->add('nom', TextType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Please enter a  First name.']),
                ],
            ])

            ->add('prenom', TextType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Please enter a  Last name.']),
                ],
            ])
            ->add('adresse', TextType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Please enter an adress.']),
                ],
            ])
            ->add('telephone', IntegerType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Please enter a telephone number.']),
                    new Regex([
                        'pattern' => '/^\d+$/',
                        'message' => 'Please enter a valid telephone number (numeric characters only).',
                    ]),
                ],
            ])
            ->add("roles",ChoiceType::class,
                [
                    "choices" =>[
                        "ROLE_CLIENT"=>"ROLE_CLIENT",
                        "ROLE_ADMIN"=>"ROLE_ADMIN"
                    ]
                ])
            ->add('agreeTerms', CheckboxType::class, [
                                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
        ;
        $builder->get('roles')
            ->addModelTransformer(new CallbackTransformer(
                function ($tagsAsArray): string {
                    // transform the array to a string
                    return implode(', ', $tagsAsArray);
                },
                function ($tagsAsString): array {
                    // transform the string back to an array
                    return explode(', ', $tagsAsString);
                }
            ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
