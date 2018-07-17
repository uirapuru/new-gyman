<?php

use Behat\Gherkin\Node\TableNode;
use Webmozart\Assert\Assert;

class WebContext extends FunctionalContext
{
    public function iAddToEvents(string $calendar, TableNode $table)
    {
        $calendar = $this->calendarRepository->findByName($calendar);
        Assert::notNull($calendar);

        $client = $this->kernel->getContainer()->get('test.client');
//        $client->setServerParameters($server);

        $hash = $table->getHash();
        foreach ($hash as $row) {
            list($startDate, $endDate, $days) = $this->parseExpression($row['expression']);

            $crawler = $client->request("GET", "/add-event");

            list($startHour, $endHour) = explode("-", $row['hours']);

            $form = $crawler->filter("form")->form([
                'create_event[calendarId]' => $calendar->id(),
                'create_event[name]' => $row['name'],
                'create_event[startDate]' => $startDate->format("Y-m-d"),
                'create_event[endDate]' => $endDate->format("Y-m-d"),
                'create_event[timeSpan][start]' => $startHour,
                'create_event[timeSpan][end]' => $endHour,
            ]);

            $client->submit($form);
        }
    }
}