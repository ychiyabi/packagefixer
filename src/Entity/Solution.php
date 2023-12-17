<?php

namespace App\Entity;

use App\Repository\SolutionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SolutionRepository::class)]
class Solution
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_delivery = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Composer $composer = null;

    #[ORM\OneToMany(mappedBy: 'solution', targetEntity: SolutionElement::class)]
    private Collection $solutionElements;

    public function __construct()
    {
        $this->solutionElements = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }


    public function getDateDelivery(): ?\DateTimeInterface
    {
        return $this->date_delivery;
    }

    public function setDateDelivery(\DateTimeInterface $date_delivery): static
    {
        $this->date_delivery = $date_delivery;

        return $this;
    }

    public function getComposer(): ?Composer
    {
        return $this->composer;
    }

    public function setComposer(Composer $composer): static
    {
        $this->composer = $composer;

        return $this;
    }

    /**
     * @return Collection<int, SolutionElement>
     */
    public function getSolutionElements(): Collection
    {
        return $this->solutionElements;
    }

    public function addSolutionElement(SolutionElement $solutionElement): static
    {
        if (!$this->solutionElements->contains($solutionElement)) {
            $this->solutionElements->add($solutionElement);
            $solutionElement->setSolution($this);
        }

        return $this;
    }

    public function removeSolutionElement(SolutionElement $solutionElement): static
    {
        if ($this->solutionElements->removeElement($solutionElement)) {
            // set the owning side to null (unless already changed)
            if ($solutionElement->getSolution() === $this) {
                $solutionElement->setSolution(null);
            }
        }

        return $this;
    }
}
