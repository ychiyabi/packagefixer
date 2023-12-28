<?php

namespace App\Controller;

use App\Service\ApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class GetPackageController extends AbstractController
{
    #[Route('/get/package/{package}', name: 'app_get_package')]
    public function index(ApiService $service, string $package): JsonResponse
    {

        $package = str_replace('$2F', '/', $package);

        $service->getPackageDetails($package);
        return $this->json([
            'message' => 'package fetched',

        ]);
    }
}
