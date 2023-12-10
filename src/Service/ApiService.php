<?php

namespace App\Service;

use App\Entity\Extension;
use App\Entity\ExtensionPackage;
use App\Entity\Package;
use App\Entity\RequiredPackage;
use App\Entity\Version;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class ApiService
{

    protected $params;
    protected $client;
    protected $logger;
    protected $db_handler;

    public function __construct(ParameterBagInterface $params, HttpClientInterface $client, LoggerInterface $logger, EntityManagerInterface $em)
    {
        $this->params = $params;
        $this->client = $client;
        $this->logger = $logger;
        $this->db_handler = $em;
    }

    public function fetchApi($page_number)
    {
        $response = $this->client->request(
            'GET',
            $this->params->get('apiUrl') . '?page=' . $page_number . '&per_page=100'
        );

        $statusCode = $response->getStatusCode();
        $content = $response->getContent();
        $packages = null;

        if (json_validate($content) && $statusCode == 200) {
            $packages = json_decode($content);
        } else {
            $this->logger->error("The json is invalid");
            return;
        }

        foreach ($packages->packages as $pkg) {
            $local_package = new Package();
            $local_package->setUrl($pkg->url);
            $local_package->setName($pkg->name);
            $local_package->setDescription($pkg->description);
            $this->db_handler->persist($local_package);
            $this->db_handler->flush();
        }
    }

    public function getPackageDetails($package)
    {
        $reduced_package = $this->db_handler->getRepository(Package::class)->findOneBy(['name' => $package]);
        $reduced_package->setChecked(true);
        $this->db_handler->persist($reduced_package);
        $this->db_handler->flush();
        $response = $this->client->request(
            'GET',
            $this->params->get('apiSpecificPackage') . "" . $package . ".json"
        );

        $statusCode = $response->getStatusCode();
        $content = $response->getContent();
        $pkg = null;
        if (json_validate($content) && $statusCode == 200) {
            $pkg = json_decode($content);
        } else {
            $this->logger->error("The json is invalid");
            return;
        }
        //NOTE - insert A package versions


        $all_versions = (array)$pkg->package->versions;
        $this->insertVersion(array_keys((array)$all_versions), $reduced_package);

        //ANCHOR - Requirement (package & extension treatements)
        foreach ($all_versions as $parent => $version) {
            $php_version = "*";
            if (isset($version->require)) {
                $attributes = array_keys((array)$version->require);
                $this->verifyAttributes($attributes, $reduced_package);
                if (isset($version->require->php)) {
                    $php_version = $version->require->php;
                }
                $this->insertRequiredPackage((array)$version->require, $reduced_package, 'require', $php_version, $parent);
            }

            if (isset($version->{'require-dev'})) {
                $attributes_dev = array_keys((array)$version->{'require-dev'});
                $this->verifyAttributes($attributes_dev, $reduced_package);
                $this->insertRequiredPackage((array)$version->{'require-dev'}, $reduced_package, 'require_dev', $php_version, $parent);
            }
        }

        echo "im Done !";
    }

    protected function insertExtension($name)
    {
        $extension = $this->db_handler->getRepository(Extension::class)->findOneBy(['name' => $name]);
        if (!$extension) {
            $extension = new Extension();
            $extension->setName($name);
            $this->db_handler->persist($extension);
            $this->db_handler->flush();
        }
        return $extension;
    }

    protected function insertExtensionPackage($extension, $package)
    {
        $extension_package = $this->db_handler->getRepository(ExtensionPackage::class)->findOneBy(['extension' => $extension->getId(), 'package' => $package->getId()]);
        if (!$extension_package) {
            $ext_pkg = new ExtensionPackage();
            $ext_pkg->setPackage($package);
            $ext_pkg->setExtension($extension);
            $this->db_handler->persist($ext_pkg);
            $this->db_handler->flush();
        }
    }

    protected function insertVersion($versions, $package)
    {
        foreach ($versions as $version) {
            $ver = new Version();
            $ver->setLabelVersion($version);
            $ver->setPackage($package);
            $this->db_handler->persist($ver);
            $this->db_handler->flush();
        }
    }

    protected function insertRequiredPackage($require, $dependencer, $type_require, $php_version, $parent_package_version)
    {

        foreach ($require as $key => $req) {
            $package_req = $this->db_handler->getRepository(Package::class)->findOneBy(['name' => $key]);
            if ($package_req) {
                $required = new RequiredPackage();
                $required->setDependencer($dependencer);
                $required->setRequire($package_req);
                $required->setVersion($req);
                $required->setPhpVersion($php_version);
                $required->setParentPackageVersion($parent_package_version);
                $required->setTypeRequirement($type_require);
                $this->db_handler->persist($required);
                $this->db_handler->flush();
            }
        }
    }


    protected function verifyAttributes($attributes, $package)
    {

        foreach ($attributes as $attribute) {
            if (str_contains($attribute, "ext-")) {
                $this->insertExtensionPackage($this->insertExtension($attribute), $package);
            }
        }
    }
}
