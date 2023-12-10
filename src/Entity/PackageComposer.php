<?php

namespace App\Entity;

use App\Repository\PackageComposerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PackageComposerRepository::class)]
class PackageComposer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'packageComposers')]
    private ?Composer $composer = null;

    #[ORM\ManyToOne(inversedBy: 'packageComposers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Package $package = null;

    #[ORM\Column(length: 255)]
    private ?string $version = null;

    #[ORM\Column(length: 255)]
    private ?string $type_requirement = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getComposer(): ?Composer
    {
        return $this->composer;
    }

    public function setComposer(?Composer $composer): static
    {
        $this->composer = $composer;

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

    public function getVersion(): ?string
    {
        return $this->version;
    }

    public function setVersion(string $version): static
    {
        $this->version = $version;

        return $this;
    }

    public function getTypeRequirement(): ?string
    {
        return $this->type_requirement;
    }

    public function setTypeRequirement(string $type_requirement): static
    {
        $this->type_requirement = $type_requirement;

        return $this;
    }
}
