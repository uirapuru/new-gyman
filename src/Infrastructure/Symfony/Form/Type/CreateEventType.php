<?php

namespace App\Form\Type;

use Calendar\Calendar;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreateEventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options) : void
    {
        $builder
            ->add('calendar', EntityType::class, [
                'required'     => false,
                'class'        => Calendar::class,
                'choice_label' => 'name',
                'choice_value' => 'id',
                'label'        => 'calendar',
                'placeholder'  => 'choose calendar',
            ])
            ->add('name', TextType::class)
            ->add('startDate', DateType::class)
            ->add('endDate', DateType::class)
            ->add('days', ChoiceType::class, [
                "choices" => [
                    "monday" => 1,
                    "tuesday" => 2,
                    "wednesday" => 3,
                    "thursday" => 4,
                    "friday" => 5,
                    "saturday" => 6,
                    "sunday" => 0,
                ],
                "multiple" => true,
                "expanded" => true
            ])
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver) : void
    {
        $resolver->setDefaults([
            'data_class'         => null,
        ]);
    }

    public function getBlockPrefix() : string
    {
        return $this->getName();
    }

    public function getName() : string
    {
        return 'create_event';
    }
}