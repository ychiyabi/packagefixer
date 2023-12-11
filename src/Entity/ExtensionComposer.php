<?php

namespace App\Entity;

use App\Repository\ExtensionComposerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExtensionComposerRepository::class)]
class ExtensionComposer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'extensionComposers')]
    private ?Extension $extension = null;

    #[ORM\ManyToOne(inversedBy: 'extensionComposers')]
    private ?Composer $composer = null;

    #[ORM\Column(length: 255)]
    private ?string $type_requirement = null;

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

    public function getComposer(): ?Composer
    {
        return $this->composer;
    }

    public function setComposer(?Composer $composer): static
    {
        $this->composer = $composer;

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
