<?php

namespace App\Entity;

use App\Repository\SolutionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SolutionRepository::class)]
class Solution
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 3000)]
    private ?string $bash = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_delivery = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Composer $composer = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBash(): ?string
    {
        return $this->bash;
    }

    public function setBash(string $bash): static
    {
        $this->bash = $bash;

        return $this;
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
}
