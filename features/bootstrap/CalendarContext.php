<?php

use App\Kernel;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Calendar\Calendar;
use Calendar\Event;
use Ramsey\Uuid\Uuid;
use Test\Infrastructure\InMemoryCalendarRepository;
use Webmozart\Assert\Assert;

class CalendarContext implements Context
{
    private $calendarRepository;

    public function __construct(Kernel $kernel)
    {
        $this->calendarRepository = new InMemoryCalendarRepository();
    }

    /**
     * @Given /^there is (\d+) calendars in calendar repository$/
     */
    public function thereIsCalendarsInCalendarRepository(int $count)
    {
        Assert::count($this->calendarRepository->findAll(), $count);
    }

    /**
     * @When /^I add new \'([^\']*)\' calendar$/
     */
    public function iAddNewCalendar(string $name)
    {
        $calendar = new Calendar(Uuid::uuid4(), $name);

        $this->calendarRepository->save($calendar);
    }

    /**
     * @Given /^calendar \'([^\']*)\' has (\d+) events$/
     */
    public function calendarHasEvents(string $calendarName, int $eventsCount)
    {
        $calendar = $this->calendarRepository->findByName($calendarName);

        Assert::count($calendar->events(), $eventsCount);
    }

    /**
     * @When /^I add new to \'([^\']*)\' calendar new event with data:$/
     */
    public function iAddNewToCalendarNewEventWithData($arg1, TableNode $table)
    {
        throw new \Behat\Behat\Tester\Exception\PendingException();
    }

    /**
     * @When /^I add new to (.*) new event (.*) on (.*) at (.*)$/
     */
    public function iAddNewToNewEventOnAt(string $calendar, string $name, string $expression, string $hours, TableNode $table)
    {
        $calendar = $this->calendarRepository->findByName($calendar);

        $calendar->events()->add(Event::create());
    }
}
