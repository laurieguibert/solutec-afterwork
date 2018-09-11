<?php

namespace App\Form;

use App\Entity\Afterwork;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AfterworkType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => [
                    'placeholder' => 'Nom de l\'afterwork'
                ]
            ])
            ->add('date', DateTimeType::class, [
                'widget' => 'single_text',
                'label' => 'Date de l\'évènement',
                'label_attr' => [
                    'style' => 'font-size :14px; color : lightslategrey'
                ],
                'attr' => [
                    'style' => 'font-size :14px; color : lightslategrey'
                ]
            ])
            ->add('placeName', TextType::class, [
                'attr' => array(
                    'placeholder' => 'Lieu (nom du restaurant, du bar, ...)'
                )
            ])
            ->add('address', TextType::class, [
                'attr' => array(
                    'placeholder' => 'Adresse'
                )
            ])
            ->add('zipCode', TextType::class, [
                'attr' => array(
                    'placeholder' => 'Code postal'
                )
            ])
            ->add('city', TextType::class, [
                'attr' => array(
                    'placeholder' => 'Ville'
                )
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Afterwork::class,
        ]);
    }
}
