<?php
namespace App\Message;

use App\Entity\Package;
use Doctrine\ORM\EntityManagerInterface;

class PackageRevtriever{

    private $db_handler;

    public function __construct(EntityManagerInterface $db_handler)
    {
        $this->db_handler=$db_handler;
    }

    public function getPackage():string{
        $package = $this->db_handler->getRepository(Package::class)->findOneBy(['checked' => false]);
        return $package->getName();
    }
}