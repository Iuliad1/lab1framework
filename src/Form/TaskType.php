<?php

namespace App\Form;

use App\Entity\Task;
use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints\Type;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title' , TextType::class, [
                'label' => 'Username',
                'attr'=> ['placeholder'=> 'Type your name',
                'id'=> 'name',
                'requierd' => false,
                ],
                'constraints' => [
                    new Length(
                        min:4,
                        max: 20,
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
            ->add('description')
            ->add('dueData', DateType::class, [
                'data' => new \DateTime(), // Setează data curentă automat
                'widget' => 'single_text', // Afișează câmpul ca un singur text (alte opțiuni posibile: 'choice' sau 'text')
                'format' => 'yyyy-MM-dd', // Formatarea datei
                'label' => 'Due Date',
            ])
        
            ->add('createdAt')
            ->add('category', EntityType::class,[
                'class'=> Category::class, //clasa entitatii specialitate
                'choice_label' => 'name',
                'label'=> 'Category',
                'placeholder'=> 'choice category',
            'constraints'=>[
                new Type(Category::class,
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Task::class,
        ]);
    }
}
