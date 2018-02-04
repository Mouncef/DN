<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('price')
            ->add('category')
            ->add('description')
            ->add('isPublished')
            ->add('isAvailable')
            ->add('principalCover', FileType::class, [
                'label' =>  'Article Principal Cover',
                'data_class'    => null,
                'required'  =>  null
            ])
            ->add('coverSecond', FileType::class, [
                'label' =>  'Picture n° 2',
                'data_class'    => null,
                'required'  =>  null
            ])
            ->add('coverThird',  FileType::class, [
                'label' =>  'Picture n° 3',
                'data_class'    => null,
                'required'  =>  null
            ])
            ->add('coverFourth',  FileType::class, [
                'label' =>  'Picture n° 4',
                'data_class'    => null,
                'required'  =>  null
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // uncomment if you want to bind to a class
            'data_class' => Article::class,
        ]);
    }
}
