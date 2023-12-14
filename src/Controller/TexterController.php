<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TexterController extends AbstractController
{
    #[Route('/texter', name: 'app_texter')]
    public function index(Request $request): JsonResponse
    {
        $composer = $request->get("composer");
        if (json_validate($composer)) {
            return $this->json("request successfuly");
        } else {
            return $this->json("request failed");
        }
    }
}
