<?php

namespace App\EventSubscriber;

use App\Entity\Composer;
use App\Service\ComposerService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class FileUploadSubscriber implements EventSubscriberInterface
{
    private $service;
    private $db_handler;
    public function __construct(ComposerService $service, EntityManagerInterface $db_handler)
    {
        $this->service = $service;
        $this->db_handler = $db_handler;
    }
    public function onFileUploadEvent($event): void
    {

        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, []);
        $composer_fileName = $this->service->upload($event->getFile());
        $json = file_get_contents("http://localhost:8000/uploads/composers/" . $composer_fileName);
        $composer = new Composer();
        $composer->setFileName($composer_fileName);
        $composer->setDateSubmit(new \DateTime());
        if (json_validate($json)) {
            $json = json_decode($json);
            $json = $serializer->normalize($json);
            $composer->setContent($json);
        } else {
            $composer->setContent([]);
        }
        $composer->setState(false);
        $this->db_handler->persist($composer);
        $this->db_handler->flush();
        $this->afterUpload($composer);
    }

    public function afterUpload($composer)
    {
        $this->service->analyzePackageComposer($composer);
        $this->service->analyzeExtensionComposer($composer);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'FileUploadEvent' => 'onFileUploadEvent',
        ];
    }
}
