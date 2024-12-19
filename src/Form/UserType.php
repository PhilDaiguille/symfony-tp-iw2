<?php

namespace App\Form;

use App\Entity\Subscription;
use App\Entity\User;
use App\Enum\UserAccountStatusEnum;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, [
                'attr' => [
                    'class' => 'w-full px-3 py-2 border border-gray-300 rounded-md',
                ],
            ])
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'w-full px-3 py-2 border border-gray-300 rounded-md',
                ],
            ])
            ->add('password', PasswordType::class, [
                'attr' => [
                    'class' => 'w-full px-3 py-2 border border-gray-300 rounded-md',
                ],
            ])
            ->add('accountStatus', ChoiceType::class, [
                'choices' => UserAccountStatusEnum::cases(),
                'choice_label' => function ($choice) {
                    return $choice->name;
                },
                'choice_value' => function ($choice) {
                    return $choice->value;
                },
                'attr' => [
                    'class' => 'w-full px-3 py-2 border border-gray-300 rounded-md',
                ],
            ])
            ->add('profilePicture', TextType::class, [
                'attr' => [
                    'class' => 'w-full px-3 py-2 border border-gray-300 rounded-md',
                ],
            ])
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Admin' => 'ROLE_ADMIN',
                    'User' => 'ROLE_USER',
                ],
                'multiple' => true,
                'expanded' => true,
                'attr' => [
                    'class' => 'w-full px-3 py-2 border border-gray-300 rounded-md',
                ],
            ])
            ->add('currentSubscription', EntityType::class, [
                'class' => Subscription::class,
                'choice_label' => 'name',
                'attr' => [
                    'class' => 'w-full px-3 py-2 border border-gray-300 rounded-md',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
