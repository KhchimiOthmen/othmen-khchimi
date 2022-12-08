<?php

namespace App\Form;

use App\Entity\Reclamation;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use VictorPrdh\RecaptchaBundle\Form\ReCaptchaType;

class ReclamationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class , [
                
                "attr"=> [ 
                    'placeholder' => 'Name',
                    "class" => "form-control"
                ]
            ])
            ->add('mail', EmailType::class , [
                "attr"=> [ 
                    'placeholder' => 'E-mail',
                    "class" => "form-control"
                ]
            ] )

            ->add('phone', NumberType::class , [
                "attr"=> [ 
                    'placeholder' => 'Phone Number',
                     'style'=> "color:red"
                ]
            ])
            ->add('message' , TextareaType::class , [
                "attr"=> [ 
                    'placeholder' => '',
                    "class" => "form-control"
                ]
            ])
            
            ->add("recaptcha", ReCaptchaType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reclamation::class,
        ]);
    }
}
