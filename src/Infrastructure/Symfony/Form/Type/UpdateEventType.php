<?php

namespace App\Form\Type;

use Calendar\Command\CreateEvent;
use Calendar\Command\UpdateEvent;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UpdateEventType extends CreateEventType
{
    public function buildForm(FormBuilderInterface $builder, array $options) : void
    {

        parent::buildForm($builder, $options);

        $builder
            ->remove('startDate')
            ->remove('days')
            ->add('submit', SubmitType::class)
        ;

        $builder->setDataMapper($this);
    }

    public function configureOptions(OptionsResolver $resolver) : void
    {
        $resolver->setDefaults([
            'data_class' => UpdateEvent::class,
            "calendars" => []
        ]);
    }

    public function getName() : string
    {
        return 'update_event';
    }

    /**
     * @param UpdateEvent $data
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