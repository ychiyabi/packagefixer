<?php

namespace App\Service;

use App\Entity\Composer;
use App\Entity\Extension;
use App\Entity\ExtensionComposer;
use App\Entity\PackageComposer;
use App\Entity\RequiredPackage;
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

    public function initiateSolution(Composer $composer): Solution
    {
        $solution = new Solution();
        $solution->setComposer($composer);
        $solution->setDateDelivery(new \Datetime);
        $this->db_handler->persist($solution);
        $this->db_handler->flush();
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

    public function provideEssentialPackages(Composer $composer, Solution $solution)
    {
        $list_of_pkg = $this->db_handler->getRepository(PackageComposer::class)->findBy(["composer" => $composer->getId()]);
        foreach ($list_of_pkg as $pkg) {
            $prepared_version = str_replace(".*", "", $pkg->getVersion());
            $prepared_version = str_replace("^", "", $prepared_version);
            $packages = $this->db_handler->getRepository(RequiredPackage::class)->getRequiredPackages($pkg->getPackage()->getId(), $prepared_version, $composer->getPhpVersion());
            foreach ($packages as $package) {
                $solution_element = new SolutionElement();
                $solution_element->setIdElement(($package->getId()));
                $solution_element->setTypeElement("package");
                $solution_element->setVersionElement($package->getVersion());
                $solution_element->setSolution($solution);
                $solution_element->setTypeRequirement($pkg->getTypeRequirement());
                $this->db_handler->persist($solution_element);
                $this->db_handler->flush();
            }
        }
    }
}
