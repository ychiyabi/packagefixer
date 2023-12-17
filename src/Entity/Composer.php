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

    #[ORM\Column(length: 255)]
    private ?string $file_name = null;

    #[ORM\OneToMany(mappedBy: 'composer', targetEntity: ExtensionComposer::class)]
    private Collection $extensionComposers;

    #[ORM\Column(length: 255)]
    private ?string $php_version = null;

    #[ORM\Column(length: 255)]
    private ?string $operating_system = null;


    public function __construct()
    {
        $this->packageComposers = new ArrayCollection();
        $this->extensionComposers = new ArrayCollection();
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

    public function getFileName(): ?string
    {
        return $this->file_name;
    }

    public function setFileName(string $file_name): static
    {
        $this->file_name = $file_name;

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
            $extensionComposer->setComposer($this);
        }

        return $this;
    }

    public function removeExtensionComposer(ExtensionComposer $extensionComposer): static
    {
        if ($this->extensionComposers->removeElement($extensionComposer)) {
            // set the owning side to null (unless already changed)
            if ($extensionComposer->getComposer() === $this) {
                $extensionComposer->setComposer(null);
            }
        }

        return $this;
    }

    public function getPhpVersion(): ?string
    {
        return $this->php_version;
    }

    public function setPhpVersion(string $php_version): static
    {
        $this->php_version = $php_version;

        return $this;
    }

    public function getOperatingSystem(): ?string
    {
        return $this->operating_system;
    }

    public function setOperatingSystem(string $operating_system): static
    {
        $this->operating_system = $operating_system;

        return $this;
    }
}
