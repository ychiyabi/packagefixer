<?php

namespace App\Service;

use App\Entity\Composer;
use App\Entity\Extension;
use App\Entity\ExtensionComposer;
use App\Entity\ExtensionPackage;
use App\Entity\Package;
use App\Entity\PackageComposer;
use App\Entity\RequiredPackage;
use App\Entity\Solution;
use App\Entity\SolutionElement;
use Doctrine\ORM\EntityManagerInterface;

class SolutionService
{
    protected $db_handler;
    protected $extensions_solution = [];
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
            $solution_element->setTypeRequirement("ext");
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

    public function makeFinalSolution(Composer $composer, Solution $solution)
    {
        $json = $composer->getContent();
        unset($json['require']);
        $solution_elements = $this->db_handler->getRepository(SolutionElement::class)->findBy([
            'solution' => $solution->getId(), 'type_requirement' => 'require'
        ]);
        foreach ($solution_elements as $solution_element) {
            $package_required = $this->db_handler->getRepository(RequiredPackage::class)->find($solution_element->getIdElement());
            $package_key = $this->db_handler->getRepository(Package::class)->find($package_required->getRequire()->getId());
            $json['require'][$package_key->getName()] = $solution_element->getVersionElement();
            $this->extensionFinder($package_key);
            //dd($json);
        }
        unset($json['require-dev']);
        unset($solution_elements);
        $solution_elements = $this->db_handler->getRepository(SolutionElement::class)->findBy([
            'solution' => $solution->getId(), 'type_requirement' => 'require-dev'
        ]);
        foreach ($solution_elements as $solution_element) {
            $package_required = $this->db_handler->getRepository(RequiredPackage::class)->find($solution_element->getIdElement());
            $package_key = $this->db_handler->getRepository(Package::class)->find($package_required->getRequire()->getId());
            $json['require-dev'][$package_key->getName()] = $solution_element->getVersionElement();
            //dd($json);
        }
        $json['require']['php'] = ">=" . $composer->getPhpVersion();
        $resolve['composer'] = $json;
        $resolve['extensions'] = $this->extensions_solution;
        $solution->setDeliveredSolution($resolve);
        $this->db_handler->persist($solution);
        $this->db_handler->flush();
        return $solution->getId();
    }

    protected function extensionFinder(Package $package)
    {
        $extensions = [];
        $i = 0;
        $all_ext = $this->db_handler->getRepository(ExtensionPackage::class)->findBy(['package' => $package->getId()]);
        foreach ($all_ext as $ext) {
            $extensions[$i] = $this->db_handler->getRepository(Extension::class)->find($ext->getExtension()->getId());
            if (!in_array($extensions[$i]->getName(), $this->extensions_solution)) {
                array_push($this->extensions_solution, $extensions[$i]->getName());
            }
            $i++;
        }
    }
}
