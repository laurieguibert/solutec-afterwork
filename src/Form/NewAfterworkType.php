<?php

namespace App\Form;

use App\Entity\Afterwork;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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
            ])
            ->add('users', EntityType::class, [
                'mapped' => false,
                'class' => 'App\Entity\User',
                'choice_label' => 'fullName',
                'multiple'  => true,
                'label' => 'Consultants à inviter',
                'label_attr' => [
                    'style' => 'font-size :14px;'
                ],
            ])
            ->add('content', CKEditorType::class, [
                'mapped' => false,
                'label_attr' => [
                    'style' => 'font-size :14px;'
                ],
                'label' => 'Contenu du mail',
                'required' => true
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Afterwork::class,
        ]);
    }
}
