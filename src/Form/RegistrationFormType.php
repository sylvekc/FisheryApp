<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', EmailType::class,['label'=>'E-mail'])
            ->add('name', TextType::class,['label'=>'Imię'])
            ->add('surname', TextType::class,['label'=>'Nazwisko'])
            ->add('agreeTerms', CheckboxType::class, ['label'=>'Akcepuję regulamin łowiska',
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Zaakceptuj regulamin.',
                    ]),
                ],
            ])
            
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Hasła muszą być takie same.',
                'options' => ['attr' => ['class' => 'password-field']],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Wpisz hasło',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Twoje hasło musi się składać z minimum {{ limit }} znaków',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
                'required' => true,
                'first_options'  => ['label' => 'Hasło'],
                'second_options' => ['label' => 'Powtórz Hasło'],
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
