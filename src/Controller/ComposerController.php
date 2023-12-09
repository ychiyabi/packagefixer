<?php

namespace App\Controller;

use App\Entity\Composer;
use App\Form\ComposerType;
use App\Service\ComposerService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Routing\Annotation\Route;

class ComposerController extends AbstractController
{
    #[Route('/composer', name: 'app_composer')]
    public function index(Request $request, ComposerService $service, EntityManagerInterface $db_handler): Response
    {
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, []);
        $composer = new Composer();
        $form = $this->createForm(ComposerType::class, $composer);
        $form->handleRequest($request);



        if ($form->isSubmitted() && $form->isValid()) {

            /** @var UploadedFile $composeFile */
            $composer_file = $form->get('file_name')->getData();
            if ($composer_file) {
                $composer_fileName = $service->upload($composer_file);
                $json = file_get_contents("http://localhost:8000/uploads/composers/composer-6574fbf23c6ad.json");
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
                $db_handler->persist($composer);
                $db_handler->flush();
            }
        }
        return $this->render('composer/composer_form.html.twig', [
            'form' => $form,
        ]);
    }
}
