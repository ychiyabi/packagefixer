<?php

namespace App\Controller;

use App\Entity\Composer;
use App\Entity\Solution;
use App\Event\JsonTexterEvent;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class TexterController extends AbstractController
{
    #[Route('/texter', name: 'app_texter')]
    public function index(Request $request, EventDispatcherInterface $dispatcher, EntityManagerInterface $em): JsonResponse
    {
        $composer = $request->get("composer");
        $php = $request->get("php");
        $os = $request->get("os");
        if (json_validate($composer)) {
            $event = new JsonTexterEvent($composer, $os, $php);
            $result = $dispatcher->dispatch($event, JsonTexterEvent::NAME);
            $after_composer = $em->getRepository(Composer::class)->find($result->getComposer());
            $solution = $em->getRepository(Solution::class)->findBy(['composer' => $after_composer->getId()]);
            return $this->json($solution[0]->getDeliveredSolution());
        } else {
            return $this->json("request failed");
        }
    }
}
