<?php

namespace App\Controller;

use App\Event\JsonTexterEvent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class TexterController extends AbstractController
{
    #[Route('/texter', name: 'app_texter')]
    public function index(Request $request, EventDispatcherInterface $dispatcher): JsonResponse
    {
        $composer = $request->get("composer");
        $php = $request->get("php");
        $os = $request->get("os");
        if (json_validate($composer)) {
            $event = new JsonTexterEvent($composer, $os, $php);
            $dispatcher->dispatch($event, JsonTexterEvent::NAME);
            return $this->json("request successfuly");
        } else {
            return $this->json("request failed");
        }
    }
}
