<?php

namespace App\Entity;

use App\Repository\SolutionElementRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SolutionElementRepository::class)]
class SolutionElement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'solutionElements')]
    private ?Solution $solution = null;

    #[ORM\Column]
    private ?int $id_element = null;

    #[ORM\Column(length: 255)]
    private ?string $type_element = null;

    #[ORM\Column(length: 255)]
    private ?string $version_element = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSolution(): ?Solution
    {
        return $this->solution;
    }

    public function setSolution(?Solution $solution): static
    {
        $this->solution = $solution;

        return $this;
    }

    public function getIdElement(): ?int
    {
        return $this->id_element;
    }

    public function setIdElement(int $id_element): static
    {
        $this->id_element = $id_element;

        return $this;
    }

    public function getTypeElement(): ?string
    {
        return $this->type_element;
    }

    public function setTypeElement(string $type_element): static
    {
        $this->type_element = $type_element;

        return $this;
    }

    public function getVersionElement(): ?string
    {
        return $this->version_element;
    }

    public function setVersionElement(string $version_element): static
    {
        $this->version_element = $version_element;

        return $this;
    }
}
