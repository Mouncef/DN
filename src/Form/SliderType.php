<?php

namespace App\Form;

use App\Entity\Slider;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SliderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('slideName', FileType::class, [
                'label' =>  'Slider Picture'
            ])
            ->add('caption1')
            ->add('caption2')
        ;
        $builder->get('slideName')
            ->addModelTransformer(new CallbackTransformer(
                function ($slideNameAsFile) {
                    // transform the array to a string
                    return '/uploads/Slides/images/'.$slideNameAsFile;
                },
                function ($slideNaemAsString) {
                    // transform the string back to an array
                    return $slideNaemAsString;
                }
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // uncomment if you want to bind to a class
            'data_class' => Slider::class,
        ]);
    }
}
