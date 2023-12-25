<?php

namespace App\EventSubscriber;

use App\Service\SolutionService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ProvideSolutionSubscriber implements EventSubscriberInterface
{
    protected $db_handler;
    private SolutionService $service;
    public function __construct(EntityManagerInterface $db_handler, SolutionService $service)
    {
        $this->db_handler = $db_handler;
        $this->service = $service;
    }
    public function onProvideSolutionEvent($event): void
    {
        $solution = $this->service->initiateSolution($event->getComposer());
        $this->service->provideEssentialExtensions($event->getComposer(), $solution);
        $this->service->provideEssentialPackages($event->getComposer(), $solution);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'ProvideSolutionEvent' => 'onProvideSolutionEvent',
        ];
    }
}
