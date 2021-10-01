<?php

namespace App\Form;

use App\Entity\DailyMenu;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class DailyMenuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Ajouter votre nom de menu',
                'required' => false
            ])

         
            ->add('description', TextareaType::class, [
                'label' => 'Ajouter une description',
                'required' => false
            ])

            ->add('image_upload', FileType::class, [
                            'label' => 'ajouter une image',
                            'mapped'=> false
                        ])
         
       ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => DailyMenu::class,
        ]);
    }
}
