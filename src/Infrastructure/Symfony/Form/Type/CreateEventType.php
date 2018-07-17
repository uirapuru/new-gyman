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

class CreateEventType extends AbstractType implements DataMapperInterface
{
    public function buildForm(FormBuilderInterface $builder, array $options) : void
    {
        $builder
            ->add('calendarId', ChoiceType::class, [
                'required'     => true,
                'choices'   => $options["calendars"],
            ])
            ->add('name', TextType::class)
            ->add('startDate', DateType::class, [
                "data" => new DateTime(),
                "widget" => "single_text",
            ])
            ->add('endDate', DateType::class, [
                "data" => new DateTime("+1 month"),
                "widget" => "single_text",
            ])
            ->add("timeSpan", TimeSpanType::class)
            ->add('days', ChoiceType::class, [
                "choices" => [
                    "monday" => "monday",
                    "tuesday" => "tuesday",
                    "wednesday" => "wednesday",
                    "thursday" => "thursday",
                    "friday" => "friday",
                    "saturday" => "saturday",
                    "sunday" => "sunday",
                ],
                "multiple" => true,
                "expanded" => true
            ])
            ->add('submit', SubmitType::class)
        ;

        $builder->setDataMapper($this);
    }

    public function configureOptions(OptionsResolver $resolver) : void
    {
        $resolver->setDefaults([
            'data_class' => CreateEvent::class,
            "calendars" => []
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

    /**
     * @param CreateEvent $data
     * @param FormInterface[]|\Traversable $forms
     */
    public function mapDataToForms($data, $forms)
    {
        if(null === $data) {
            return;
        }

        $forms = iterator_to_array($forms);

        $forms["calendarId"]->setData($data->calendarId());
        $forms["name"]->setData($data->name());
        $forms["startDate"]->setData($data->startDate());
        $forms["endDate"]->setData($data->endDate());
        $forms["timeSpan"]->setData($data->timeSpan());
        $forms["days"]->setData($data->days());
    }

    /**
     * @param FormInterface[]|\Traversable $forms
     * @param CreateEvent $data
     */
    public function mapFormsToData($forms, &$data)
    {
        $forms = iterator_to_array($forms);
        $data = CreateEvent::withData(
            Uuid::fromString($forms["calendarId"]->getData()),
            $forms['name']->getData(),
            $forms['startDate']->getData(),
            $forms['endDate']->getData(),
            $forms['timeSpan']->getData(),
            $forms['days']->getData()
        );
    }
}