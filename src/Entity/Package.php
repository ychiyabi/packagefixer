<?php

namespace App\Entity;

use App\Repository\PackageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PackageRepository::class)]
class Package
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $command = null;

    #[ORM\OneToMany(mappedBy: 'id_pkg', targetEntity: ExtensionPackage::class)]
    private Collection $extensionPackages;

    #[ORM\OneToMany(mappedBy: 'package', targetEntity: PackageComposer::class)]
    private Collection $packageComposers;

    #[ORM\OneToMany(mappedBy: 'require', targetEntity: RequiredPackage::class)]
    private Collection $requiredPackages;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $url = null;

    #[ORM\Column]
    private ?bool $checked = null;

    public function __construct()
    {
        $this->extensionPackages = new ArrayCollection();
        $this->packageComposers = new ArrayCollection();
        $this->requiredPackages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCommand(): ?string
    {
        return $this->command;
    }

    public function setCommand(string $command): static
    {
        $this->command = $command;

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
            $extensionPackage->setIdPkg($this);
        }

        return $this;
    }

    public function removeExtensionPackage(ExtensionPackage $extensionPackage): static
    {
        if ($this->extensionPackages->removeElement($extensionPackage)) {
            // set the owning side to null (unless already changed)
            if ($extensionPackage->getIdPkg() === $this) {
                $extensionPackage->setIdPkg(null);
            }
        }

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
            $packageComposer->setPackage($this);
        }

        return $this;
    }

    public function removePackageComposer(PackageComposer $packageComposer): static
    {
        if ($this->packageComposers->removeElement($packageComposer)) {
            // set the owning side to null (unless already changed)
            if ($packageComposer->getPackage() === $this) {
                $packageComposer->setPackage(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, RequiredPackage>
     */
    public function getRequiredPackages(): Collection
    {
        return $this->requiredPackages;
    }

    public function addRequiredPackage(RequiredPackage $requiredPackage): static
    {
        if (!$this->requiredPackages->contains($requiredPackage)) {
            $this->requiredPackages->add($requiredPackage);
            $requiredPackage->setRequire($this);
        }

        return $this;
    }

    public function removeRequiredPackage(RequiredPackage $requiredPackage): static
    {
        if ($this->requiredPackages->removeElement($requiredPackage)) {
            // set the owning side to null (unless already changed)
            if ($requiredPackage->getRequire() === $this) {
                $requiredPackage->setRequire(null);
            }
        }

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): static
    {
        $this->url = $url;

        return $this;
    }

    public function isChecked(): ?bool
    {
        return $this->checked;
    }

    public function setChecked(bool $checked): static
    {
        $this->checked = $checked;

        return $this;
    }
}
