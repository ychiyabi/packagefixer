<?php

namespace App\Entity;

use App\Repository\ExtensionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExtensionRepository::class)]
class Extension
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;


    #[ORM\OneToMany(mappedBy: 'extension', targetEntity: ExtensionPackage::class)]
    private Collection $extensionPackages;

    #[ORM\OneToMany(mappedBy: 'extension', targetEntity: ExtensionComposer::class)]
    private Collection $extensionComposers;

    public function __construct()
    {
        $this->extensionPackages = new ArrayCollection();
        $this->extensionComposers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }


    /**
     * @return Collection<int, ExtensionPackage>
     */
    public function getExtensionPackages(): Collection
    {
        return $this->extensionPackages;
    }

    public function addExtensionPackage(ExtensionPackage $extensionPackage): static
    {
        if (!$this->extensionPackages->contains($extensionPackage)) {
            $this->extensionPackages->add($extensionPackage);
            $extensionPackage->setExtension($this);
        }

        return $this;
    }

    public function removeExtensionPackage(ExtensionPackage $extensionPackage): static
    {
        if ($this->extensionPackages->removeElement($extensionPackage)) {
            // set the owning side to null (unless already changed)
            if ($extensionPackage->getExtension() === $this) {
                $extensionPackage->setExtension(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ExtensionComposer>
     */
    public function getExtensionComposers(): Collection
    {
        return $this->extensionComposers;
    }

    public function addExtensionComposer(ExtensionComposer $extensionComposer): static
    {
        if (!$this->extensionComposers->contains($extensionComposer)) {
            $this->extensionComposers->add($extensionComposer);
            $extensionComposer->setExtension($this);
        }

        return $this;
    }

    public function removeExtensionComposer(ExtensionComposer $extensionComposer): static
    {
        if ($this->extensionComposers->removeElement($extensionComposer)) {
            // set the owning side to null (unless already changed)
            if ($extensionComposer->getExtension() === $this) {
                $extensionComposer->setExtension(null);
            }
        }

        return $this;
    }
}
