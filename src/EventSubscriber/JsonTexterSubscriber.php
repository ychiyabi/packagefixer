<?php

namespace App\EventSubscriber;

use App\Entity\Composer;
use App\Event\ProvideSolutionEvent;
use App\Service\ComposerService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class JsonTexterSubscriber implements EventSubscriberInterface
{
    protected $service;
    protected $db_handler;
    protected $dispatcher;
    public function __construct(EntityManagerInterface $db_handler, ComposerService $service, EventDispatcherInterface $dispatcher)
    {
        $this->db_handler = $db_handler;
        $this->service = $service;
        $this->dispatcher = $dispatcher;
    }
    public function onJsonTexter($event): void
    {
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, []);
        $texter = $event->getText();
        $texter = json_decode($texter);
        $texter = $serializer->normalize($texter);
        $json = new Composer();
        $json->setContent($texter);
        $json->setState(false);
        $json->setFileName("");
        $json->setDateSubmit(new \DateTime());
        $json->setPhpVersion($event->getPhp());
        $json->setOperatingSystem($event->getOs());
        $this->db_handler->persist($json);
        $this->db_handler->flush();
        $this->service->analyzePackageComposer($json);
        $this->service->analyzeExtensionComposer($json);
        $event = new ProvideSolutionEvent($json);
        $this->dispatcher->dispatch($event, ProvideSolutionEvent::NAME);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'JsonTexterEvent' => 'onJsonTexter',
        ];
    }
}
