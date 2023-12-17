<?php

namespace App\Service;

use App\Entity\Composer;
use App\Entity\Extension;
use App\Entity\ExtensionComposer;
use App\Entity\Solution;
use App\Entity\SolutionElement;
use Doctrine\ORM\EntityManagerInterface;

class SolutionService
{
    protected $db_handler;
    public function __construct(EntityManagerInterface $db_handler)
    {
        $this->db_handler = $db_handler;
    }

    protected function initiateSolution(Composer $composer): Solution
    {
        $solution = new Solution();
        $solution->setComposer($composer);
        $solution->setDateDelivery(new \Datetime);

        return $solution;
    }

    public function provideEssentialExtensions(Composer $composer, Solution $solution)
    {

        $list_of_ext = $this->db_handler->getRepository(ExtensionComposer::class)->findBy(["composer" => $composer->getId()]);
        foreach ($list_of_ext as $ext) {
            $extension = $this->db_handler->getRepository(Extension::class)->find($ext->getExtension()->getId());
            $solution_element = new SolutionElement();
            $solution_element->setIdElement($extension->getId());
            $solution_element->setTypeElement("extension");
            $solution_element->setVersionElement("*");
            $solution_element->setSolution($solution);
            $this->db_handler->persist($solution_element);
            $this->db_handler->flush();
        }
    }
}
