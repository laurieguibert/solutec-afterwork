<?php

namespace App\Form;

use App\Entity\Afterwork;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class NewAfterworkType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => [
                    'placeholder' => 'Nom de l\'afterwork'
                ],
                'label_attr' => [
                    'style' => 'font-size :14px;'
                ],
            ])
            ->add('date', DateTimeType::class, [
                'widget' => 'single_text',
                'label' => 'Date de l\'évènement',
                'label_attr' => [
                    'style' => 'font-size :14px;'
                ],
                'attr' => [
                    'style' => 'font-size :14px; color : lightslategrey'
                ]
            ])
            ->add('placeName', TextType::class, [
                'attr' => array(
                    'placeholder' => 'Lieu (nom du restaurant, du bar, ...)'
                ),
                'label_attr' => [
                    'style' => 'font-size :14px;'
                ],
            ])
            ->add('address', TextType::class, [
                'attr' => array(
                    'placeholder' => 'Adresse'
                ),
                'label_attr' => [
                    'style' => 'font-size :14px;'
                ],
            ])
            ->add('zipCode', TextType::class, [
                'attr' => array(
                    'placeholder' => 'Code postal'
                ),
                'label_attr' => [
                    'style' => 'font-size :14px;'
                ],
            ])
            ->add('city', TextType::class, [
                'attr' => array(
                    'placeholder' => 'Ville'
                ),
                'label_attr' => [
                    'style' => 'font-size :14px;'
                ],
            ])
            ->add('imageFile', VichImageType::class, [
                'required' => false,
                'allow_delete' => true,
                'label' => 'Photo de l\'afterwork',
                'label_attr' => [
                    'style' => 'font-size :14px;'
                ],
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Afterwork::class,
        ]);
    }
}
