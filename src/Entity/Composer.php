<?php

namespace App\Entity;

use App\Repository\ComposerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ComposerRepository::class)]
class Composer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private array $content = [];

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_submit = null;

    #[ORM\Column]
    private ?bool $state = null;

    #[ORM\OneToMany(mappedBy: 'composer', targetEntity: PackageComposer::class)]
    private Collection $packageComposers;

    public function __construct()
    {
        $this->packageComposers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): array
    {
        return $this->content;
    }

    public function setContent(array $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getDateSubmit(): ?\DateTimeInterface
    {
        return $this->date_submit;
    }

    public function setDateSubmit(\DateTimeInterface $date_submit): static
    {
        $this->date_submit = $date_submit;

        return $this;
    }

    public function isState(): ?bool
    {
        return $this->state;
    }

    public function setState(bool $state): static
    {
        $this->state = $state;

        return $this;
    }

    /**
     * @return Collection<int, PackageComposer>
     */
    public function getPackageComposers(): Collection
    {
        return $this->packageComposers;
    }

    public function addPackageComposer(PackageComposer $packageComposer): static
    {
        if (!$this->packageComposers->contains($packageComposer)) {
            $this->packageComposers->add($packageComposer);
            $packageComposer->setComposer($this);
        }

        return $this;
    }

    public function removePackageComposer(PackageComposer $packageComposer): static
    {
        if ($this->packageComposers->removeElement($packageComposer)) {
            // set the owning side to null (unless already changed)
            if ($packageComposer->getComposer() === $this) {
                $packageComposer->setComposer(null);
            }
        }

        return $this;
    }
}
