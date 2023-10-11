<?php

namespace App\Form;

use App\Entity\Student;
use App\Entity\Specialitate; 
use Symfony\Bridge\Doctrine\Form\Type\EntityType; 
use Symfony\Component\Form\AbstractType; 
use Symfony\Component\Form\Extension\Core\Type\NumberType; 
use Symfony\Component\Form\Extension\Core\Type\TextType; 
use Symfony\Component\Form\Extension\Core\Type\DataTimeType; 
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Mime\Message;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Type;

class StudentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('NumePrenume',TextType::class, [
            'label' => 'Username',
            'attr'=> ['placeholder'=> 'Type your name',
            'class'=> 'Student',
            'id'=> 'name',
            'requierd' => false,
            ],
            'constraints' => [
                new Length(
                    min:5,
                    max: 30,
                    minMessage: 'Your first name must be at least {{ limit }} characters long',
                    maxMessage: 'Your first name cannot be longer than {{ limit }} characters',
                ),
                new NotNull(),
                new Regex(
                    pattern:'/[A-Za-z]/',
                    message:'introdu doar litere',
                ),
            ]
            ])
            ->add('Media',NumberType::class, [
                'constraints'=>[
                    new Regex(
                        pattern:'/^(10|\d{1}(.\d{2})?)$/',
                        message:'Campul trebuie sa contina cifre pana la 10',
                    ),
                    new NotNull(),
                ]
            ])
            ->add('BirthDate',DateType::class, [
                'constraints'=>[
                    new Date(
                        message:'Introdu ziua ta de nastere',
                    )
                ]
            ])
            ->add('Grupa')
            ->add('specialitate', EntityType::class,[
                'class'=> Specialitate::class, //clasa entitatii specialitate
                'choice_label' => 'nume',
                'label'=> 'Specialitate',
                'placeholder'=> 'choice specialitate',
            'constraints'=>[
                new Type(Specialitate::class,
                message:'Introdu cpesialitate veridica',
                )
            ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Save',
                'attr' => [
                    'class' => 'btn btn-primary',
                ],

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Student::class,
        ]);
    }
}
