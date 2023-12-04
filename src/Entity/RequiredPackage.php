<?php

namespace App\Entity;

use App\Repository\RequiredPackageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RequiredPackageRepository::class)]
class RequiredPackage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'requiredPackages')]
    private ?Package $require = null;

    #[ORM\ManyToOne(inversedBy: 'requiredPackages')]
    private ?Package $dependencer = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRequire(): ?Package
    {
        return $this->require;
    }

    public function setRequire(?Package $require): static
    {
        $this->require = $require;

        return $this;
    }

    public function getDependencer(): ?Package
    {
        return $this->dependencer;
    }

    public function setDependencer(?Package $dependencer): static
    {
        $this->dependencer = $dependencer;

        return $this;
    }
}
