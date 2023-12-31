<?php

namespace App\DataFixtures;

use App\Entity\OperatingSystem;
use App\Entity\PhpVersion;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $versions = array("8.3", "8.2", "8.1", "8.0", "7.4", "7.3", "7.2", "7.1", "7.0", "5.6", "5.5", "5.4", "5.3", "5.2", "5.1", "5.0");
        foreach ($versions as $verion) {
            $v = new PhpVersion();
            $v->setLabel($verion);
            $manager->persist($v);
            $manager->flush();
        }
        $operating_systems = array("ubuntu", "windows");
        foreach ($operating_systems as $os) {
            $operation_system = new OperatingSystem();
            $operation_system->setLabel($os);
            $manager->persist($operation_system);
            $manager->flush();
        }
    }
}
