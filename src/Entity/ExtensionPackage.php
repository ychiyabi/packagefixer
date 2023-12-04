<?php

namespace App\Entity;

use App\Repository\ExtensionPackageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExtensionPackageRepository::class)]
class ExtensionPackage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'extensionPackages')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Extension $extension = null;

    #[ORM\ManyToOne(inversedBy: 'extensionPackages')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Package $package = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getExtension(): ?Extension
    {
        return $this->extension;
    }

    public function setExtension(?Extension $extension): static
    {
        $this->extension = $extension;

        return $this;
    }

    public function getPackage(): ?Package
    {
        return $this->package;
    }

    public function setPackage(?Package $package): static
    {
        $this->package = $package;

        return $this;
    }
}
