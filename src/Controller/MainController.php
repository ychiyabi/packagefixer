<?php

namespace App\Controller;

use App\Service\ApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/main', name: 'app_main')]
    public function index(ApiService $service): Response
    {
        
        $service->getPackageDetails("aws/aws-sdk-php");
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
}
