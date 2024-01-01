<?php

namespace App\Controller;

use App\Entity\OperatingSystem;
use App\Entity\PhpVersion;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class StaticDataController extends AbstractController
{
    #[Route('/static/data/php', name: 'static_data_php')]
    public function getPhpVersions(EntityManagerInterface $em): JsonResponse
    {
        $php_versions = $em->getRepository(PhpVersion::class)->findAll();
        return $this->json($php_versions);
    }

    #[Route('/static/data/SE', name: 'static_data_se')]
    public function getAllSE(EntityManagerInterface $em): JsonResponse
    {
        $SE = $em->getRepository(OperatingSystem::class)->findAll();
        return $this->json($SE);
    }
}
