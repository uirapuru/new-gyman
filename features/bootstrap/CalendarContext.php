<?php

use App\Kernel;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Calendar\Calendar;
use Calendar\Event;
use Doctrine\Common\Collections\ArrayCollection;
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

        Assert::eq($calendar->count(), $eventsCount);
    }

    /**
     * @When /^I add to \'(.*)\' new event \'(.*)\' on \'(.*)\' at \'(.*)\'$/
     */
    public function iAddNewToNewEventOnAt(string $calendar, string $name, string $expression, string $hours)
    {
        $calendar = $this->calendarRepository->findByName($calendar);

        $calendar->events()->add(Event::create(Uuid::uuid4(), $name, $expression, $hours));
    }

    /**
     * @Given /^date \'([^\']*)\' matches event \'([^\']*)\' in calendar \'([^\']*)\'$/
     */
    public function dateMatchesEventInCalendar(string $date, string $eventName, string $calendarName)
    {
        /** @var Calendar $calendar */
        $calendar = $this->calendarRepository->findByName($calendarName);

        /** @var Event[] $events */
        $events = $calendar->matchingEvents(new DateTime($date));

        Assert::count($events, 1);
        Assert::eq($events[0]->name(), $eventName);
    }

    /**
     * @When /^I add to \'([^\']*)\' events:$/
     */
    public function iAddToEvents(string $calendar, TableNode $table)
    {
        $calendar = $this->calendarRepository->findByName($calendar);

        $hash = $table->getHash();
        foreach ($hash as $row) {
            $calendar->addEvent(Event::create(Uuid::uuid4(), $row['name'], $row['expression'], $row['hours']));
        }
    }

    /**
     * @Then /^I get (.*) events for range from (.*) to (.*) in calendar \'([^\']*)\'$/
     */
    public function iGetEventsForRangeFromTo(int $count, string $dateFrom, string $dateTo, string $calendar)
    {
        $calendar = $this->calendarRepository->findByName($calendar);
        $period = new DatePeriod(new DateTime($dateFrom), new DateInterval('P1D'), new DateTime($dateTo));

        $result = new ArrayCollection();

        foreach($period as $day) {
            $result = new ArrayCollection(
                array_merge($calendar->matchingEvents($day)->toArray(), $result->toArray())
            );
        }

        Assert::count($result, $count);
    }
}
