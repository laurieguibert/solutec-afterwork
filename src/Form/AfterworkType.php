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
            ->add('name', TextType::class)
            ->add('date', DateTimeType::class, [
                'widget' => 'single_text'
            ])
            ->add('address', TextType::class)
            ->add('zipCode', TextType::class)
            ->add('city', TextType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Afterwork::class,
        ]);
    }
}
