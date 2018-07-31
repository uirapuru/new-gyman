<?php

use Behat\Gherkin\Node\TableNode;
use Webmozart\Assert\Assert;

class WebContext extends FunctionalContext
{
    public function iAddToEvents(string $calendar, TableNode $table)
    {
        $calendar = $this->calendarRepository->findByName($calendar);
        Assert::notNull($calendar);

        $client = $this->get('test.client');

        $hash = $table->getHash();
        foreach ($hash as $row) {
            list($startDate, $endDate, $days) = $this->parseExpression($row['expression']);

            $crawler = $client->request("GET", "/add-event");

            list($startHour, $endHour) = explode("-", $row['hours']);

            $form = $crawler->filter("form")->form([
                'create_event[calendarId]' => $calendar->id(),
                'create_event[name]' => $row['name'],
                'create_event[startDate]' => $startDate ? $startDate->format("Y-m-d") : null,
                'create_event[endDate]' => $endDate ? $endDate->format("Y-m-d") : null,
                'create_event[timeSpan][start]' => $startHour,
                'create_event[timeSpan][end]' => $endHour,
            ]);

            foreach($days as $day) {

                $number = (int) (new DateTime($day))->format("w") - 1;
                if($number === -1) $number = 6;
                $form["create_event[days]"][$number]->tick();
            }

            $client->submit($form);
        }
    }

    public function calendarHasEvents(string $calendarName, int $eventsCount)
    {



        Assert::eq($calendar->count(), $eventsCount);
    }
}