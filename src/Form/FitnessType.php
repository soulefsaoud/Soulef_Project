<?php

namespace App\Form;

use App\Entity\Fitness;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class FitnessType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('name', TextType::class, [
            'label' => 'Ajouter votre nom et prénom',
            'required' => false
        ])


        ->add('description', TextareaType::class, [
            'label' => 'Ajouter une description',
            'required' => false
        ])

        ->add('createdAt', DateType::class, [
            'label' => 'Date de publication'
        ])

            ->add('videoUrl')
            ->add('user')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Fitness::class,
        ]);
    }
}
