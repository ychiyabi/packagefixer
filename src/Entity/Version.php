<?php

namespace App\Entity;

use App\Repository\VersionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VersionRepository::class)]
class Version
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $label_version = null;

    #[ORM\ManyToOne(inversedBy: 'versions')]
    private ?Package $package = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabelVersion(): ?string
    {
        return $this->label_version;
    }

    public function setLabelVersion(string $label_version): static
    {
        $this->label_version = $label_version;

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
