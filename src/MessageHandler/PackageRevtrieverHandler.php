<?php

namespace App\MessageHandler;

use App\Message\PackageRevtriever;
use App\Service\ApiService;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class PackageRevtrieverHandler
{
    private $service;
    public function __construct(ApiService $service)
    {
        $this->service=$service;
    }
    public function __invoke(PackageRevtriever $message)
    {
        
        $this->service->getPackageDetails($message->getPackage());
        dump($message->getPackage());
    }
}
