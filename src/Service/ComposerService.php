<?php

namespace App\Service;

use App\Entity\Extension;
use App\Entity\ExtensionComposer;
use App\Entity\Package;
use App\Entity\PackageComposer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class ComposerService
{

    public function __construct(
        private string $targetDirectory,
        private SluggerInterface $slugger,
        private EntityManagerInterface $db_handler,
    ) {
    }

    public function upload(UploadedFile $file): string
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $fileName = $safeFilename . '-' . uniqid() . '.' . $file->guessExtension();

        try {
            $file->move($this->getTargetDirectory(), $fileName);
        } catch (FileException $e) {
            // ... handle exception if something happens during file upload
        }

        return $fileName;
    }

    public function getTargetDirectory(): string
    {
        return $this->targetDirectory;
    }

    public function analyzePackageComposer($composer)
    {

        if (isset($composer->getContent()['require'])) {
            foreach ($composer->getContent()['require'] as $package_extension => $version) {
                $package_req = $this->db_handler->getRepository(Package::class)->findOneBy(['name' => $package_extension]);
                if ($package_req) {
                    $package_composer = new PackageComposer();
                    $package_composer->setComposer($composer);
                    $package_composer->setPackage($package_req);
                    $package_composer->setVersion($version);
                    $package_composer->setTypeRequirement("require");
                    $this->db_handler->persist($package_composer);
                    $this->db_handler->flush();
                }
            }
        }
        if (isset($composer->getContent()['require-dev'])) {
            foreach ($composer->getContent()['require-dev'] as $package_extension => $version) {
                $ext_req = $this->db_handler->getRepository(Package::class)->findOneBy(['name' => $package_extension]);
                if ($package_req) {
                    $package_composer = new PackageComposer();
                    $package_composer->setComposer($composer);
                    $package_composer->setPackage($package_req);
                    $package_composer->setVersion($version);
                    $package_composer->setTypeRequirement("require-dev");
                    $this->db_handler->persist($package_composer);
                    $this->db_handler->flush();
                }
            }
        }
    }

    public function analyzeExtensionComposer($composer)
    {

        if (isset($composer->getContent()['require'])) {
            foreach ($composer->getContent()['require'] as $package_extension => $version) {
                $ext_req = $this->db_handler->getRepository(Extension::class)->findOneBy(['name' => $package_extension]);
                if ($ext_req) {

                    $extension_composer = new ExtensionComposer();
                    $extension_composer->setComposer($composer);
                    $extension_composer->setExtension($ext_req);
                    $extension_composer->setTypeRequirement("require");
                    $this->db_handler->persist($extension_composer);
                    $this->db_handler->flush();
                }
            }
        }
        if (isset($composer->getContent()['require-dev'])) {
            foreach ($composer->getContent()['require-dev'] as $package_extension => $version) {
                $ext_req = $this->db_handler->getRepository(Extension::class)->findOneBy(['name' => $package_extension]);
                if ($ext_req) {
                    $extension_composer = new ExtensionComposer();
                    $extension_composer->setComposer($composer);
                    $extension_composer->setExtension($ext_req);
                    $extension_composer->setTypeRequirement("require");
                    $this->db_handler->persist($extension_composer);
                    $this->db_handler->flush();
                }
            }
        }
    }
}
