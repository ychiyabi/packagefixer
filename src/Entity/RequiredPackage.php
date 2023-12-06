<?php

namespace App\Entity;

use App\Repository\RequiredPackageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RequiredPackageRepository::class)]
class RequiredPackage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'requiredPackages')]
    private ?Package $require = null;

    #[ORM\ManyToOne(inversedBy: 'requiredPackages')]
    private ?Package $dependencer = null;

    #[ORM\Column(length: 255)]
    private ?string $type_requirement = null;

    #[ORM\Column(length: 255)]
    private ?string $version = null;

    #[ORM\Column(length: 255)]
    private ?string $php_version = null;

    #[ORM\Column(length: 255)]
    private ?string $parent_package_version = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRequire(): ?Package
    {
        return $this->require;
    }

    public function setRequire(?Package $require): static
    {
        $this->require = $require;

        return $this;
    }

    public function getDependencer(): ?Package
    {
        return $this->dependencer;
    }

    public function setDependencer(?Package $dependencer): static
    {
        $this->dependencer = $dependencer;

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

    public function getVersion(): ?string
    {
        return $this->version;
    }

    public function setVersion(string $version): static
    {
        $this->version = $version;

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

    public function getParentPackageVersion(): ?string
    {
        return $this->parent_package_version;
    }

    public function setParentPackageVersion(string $parent_package_version): static
    {
        $this->parent_package_version = $parent_package_version;

        return $this;
    }
}
