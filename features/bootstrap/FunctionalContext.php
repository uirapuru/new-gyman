<?php

use App\Kernel;
use App\Repository\CalendarRepository;

class FunctionalContext extends IntegrationContext
{
    private $calendarRepository;

    public function __construct(Kernel $kernel)
    {
        $this->calendarRepository = $kernel->getContainer()->get(CalendarRepository::class);
    }
}