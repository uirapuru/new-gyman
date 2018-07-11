<?php

use App\Kernel;
use App\Repository\CalendarRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;

class FunctionalContext extends IntegrationContext
{
    /** @var Kernel */
    private $kernel;

    public function __construct(Kernel $kernel)
    {
        $this->kernel = $kernel;
        $this->calendarRepository = $kernel->getContainer()->get(CalendarRepository::class);
    }

    protected function get(string $serviceName) : ?object
    {
        return $this->kernel->getContainer()->get($serviceName);
    }

    public function calendarRepositoryIsEmpty()
    {
        /** @var EntityManagerInterface $em */
        $em = $this->get('doctrine')->getManager();

        $metaData = $em->getMetadataFactory()->getAllMetadata();

        $tool = new SchemaTool($em);
        $tool->dropSchema($metaData);
        $tool->createSchema($metaData);
    }
}