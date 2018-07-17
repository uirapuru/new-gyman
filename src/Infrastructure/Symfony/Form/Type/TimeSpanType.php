<?php

namespace App\Form\Type;

use Calendar\Calendar;
use Calendar\Command\CreateEvent;
use Calendar\Event\TimeSpan;
use DateTime;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TimeSpanType extends AbstractType implements DataMapperInterface
{
    public function buildForm(FormBuilderInterface $builder, array $options) : void
    {
        $builder
            ->add("start", TimeType::class, [
                "widget" => "single_text",
                "data" => new DateTime("12:00"),
            ])
            ->add("end", TimeType::class, [
                "widget" => "single_text",
                "data" => new DateTime("13:00"),
            ])
        ;

        $builder->setDataMapper($this);
    }

    public function configureOptions(OptionsResolver $resolver) : void
    {
        $resolver->setDefaults([
            'data_class' => TimeSpan::class,
            'empty_data' => TimeSpan::fromString("12:00-13:00")
        ]);
    }

    public function getBlockPrefix() : string
    {
        return $this->getName();
    }

    public function getName() : string
    {
        return 'timespan';
    }

    /**
     * @param TimeSpan $data
     * @param FormInterface[]|\Traversable $forms
     */
    public function mapDataToForms($data, $forms)
    {
        if(null === $data) {
            return;
        }

        $forms = iterator_to_array($forms);

        $forms["start"]->setData($data->start()->toDateTime());
        $forms["end"]->setData($data->end()->toDateTime());
    }

    /**
     * @param FormInterface[]|\Traversable $forms
     * @param TimeSpan $data
     */
    public function mapFormsToData($forms, &$data)
    {
        $forms = iterator_to_array($forms);
        $data = TimeSpan::fromString(sprintf(
            "%s-%s",
            $forms['start']->getData()->format("H:i"),
            $forms['end']->getData()->format("H:i")
        ));
    }
}