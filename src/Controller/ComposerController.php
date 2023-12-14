<?php

namespace App\Controller;

use App\Event\FileUploadEvent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class ComposerController extends AbstractController
{
    #[Route('/composer', name: 'app_composer')]
    public function index(EventDispatcherInterface $dispatcher, Request $request): JsonResponse
    {


        $composer_file = $request->files->get('composer');
        if ($composer_file) {
            $event = new FileUploadEvent($composer_file);
            $dispatcher->dispatch($event, FileUploadEvent::NAME);
        }


        return new JsonResponse(['message' => 'Request handled successfully']);
    }
}
