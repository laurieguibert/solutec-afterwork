<?php

namespace App\Form;

use App\Entity\Site;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'required' => true,
                'label' => 'Email',
                'attr' => [
                    'placeholder' => 'Email'
                ],
                'label_attr' => [
                    'style' => 'font-size :14px;'
                ],
            ])
            ->add('civility', EntityType::class, [
                'class' => 'App\Entity\Civility',
                'choice_label' => 'name',
                'label' => 'Civilité',
                'label_attr' => [
                    'style' => 'font-size :14px;'
                ],
            ])
            ->add('firstName', TextType::class, [
                'required' => true,
                'label' => 'Prénom',
                'attr' => [
                    'placeholder' => 'Prénom'
                ],
                'label_attr' => [
                    'style' => 'font-size :14px;'
                ],
            ])
            ->add('lastName', TextType::class, [
                'required' => true,
                'label' => 'Nom',
                'attr' => [
                    'placeholder' => 'Nom'
                ],
                'label_attr' => [
                    'style' => 'font-size :14px;'
                ],
            ])
            ->add('phone', TelType::class, [
                'required' => false,
                'label' => 'Téléphone',
                'attr' => [
                    'placeholder' => 'Téléphone'
                ],
                'label_attr' => [
                    'style' => 'font-size :14px;'
                ],
            ])
            ->add('site', EntityType::class, [
                'class' => 'App\Entity\Site',
                'choice_label' => 'name',
                'required' => true,
                'label_attr' => [
                    'style' => 'font-size :14px;'
                ],
            ])
            ->add('imageFile', VichImageType::class, [
                'required' => false,
                'allow_delete' => true,
                'label' => 'Photo du consultant',
                'label_attr' => [
                    'style' => 'font-size :14px;'
                ]
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
