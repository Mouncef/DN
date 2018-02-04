<?php

namespace App\Form;

use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('cover', FileType::class, [
                'label' =>  'Category Cover',
                'data_class'    => null,
                'required'  =>  null
            ])
            ->add('categoryStyle', ChoiceType::class, [
                'choices'   =>  [
                    'Cover with caption' => 'CoverWithCaption',
                    'Cover without caption' => 'CoverWithoutCaption'
                ]
            ])
            ->add('caption', null, [
                'required' =>   null
            ])
            ->add('isPublicated')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // uncomment if you want to bind to a class
            'data_class' => Category::class,
        ]);
    }
}
