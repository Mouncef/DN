<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('adressText',TextareaType::class,[
                'label' =>  'Address',
                'required'  =>  true
            ])
//            ->add('city', ChoiceType::class, [
//                'label' =>  'City',
//                'choices'   =>  array(),
//                'required'  =>  true,
//                'multiple'  => false,
//                'choice_value'  =>  'value'
//            ])
            ->add('zipCode', TextType::class,[
                'label' =>  'Zip Code',
                'required'  =>  true
            ])
//            ->add('country', ChoiceType::class, [
//                'label' =>  'Country',
//                'choices'   =>  array(),
//                'required'  =>  true,
//                'multiple'  => false,
//                'choice_value'  =>  'value'
//            ])
            ->add('phone', TextType::class, [
                'label' =>  'Phone Number',
                'required'  =>  true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // uncomment if you want to bind to a class
            'data_class' => Address::class,
        ]);
    }
}
