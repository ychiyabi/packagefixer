<?php

namespace App\Controller;

use App\Entity\Composer;
use App\Event\FileUploadEvent;
use App\Form\ComposerType;
use App\Service\ComposerService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class ComposerController extends AbstractController
{
    #[Route('/composer', name: 'app_composer')]
    public function index(EventDispatcherInterface $dispatcher, Request $request, ComposerService $service, EntityManagerInterface $db_handler): Response
    {

        $composer = new Composer();
        $form = $this->createForm(ComposerType::class, $composer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var UploadedFile $composeFile */
            $composer_file = $form->get('file_name')->getData();
            if ($composer_file) {
                $event = new FileUploadEvent($composer_file);
                $dispatcher->dispatch($event, FileUploadEvent::NAME);
            }
        }
        return $this->render('composer/composer_form.html.twig', [
            'form' => $form,
        ]);
    }
}
