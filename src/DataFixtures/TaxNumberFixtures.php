<?php

namespace App\DataFixtures;

use App\Entity\TaxNumber;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TaxNumberFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $germany = new TaxNumber();
        $germany->setCountryName('Germany');
        $germany->setFormat('DEXXXXXXXXX');
        $germany->setValue(19);
        $manager->persist($germany);

        $italy = new TaxNumber();
        $italy->setCountryName('Italy');
        $italy->setFormat('ITXXXXXXXXXXX');
        $italy->setValue(22);
        $manager->persist($italy);

        $france = new TaxNumber();
        $france->setCountryName('France');
        $france->setFormat('FRYYXXXXXXXXXX');
        $france->setValue(20);
        $manager->persist($france);

        $greece = new TaxNumber();
        $greece->setCountryName('Greece');
        $greece->setFormat('GRXXXXXXXXX');
        $greece->setValue(24);
        $manager->persist($greece);

        $manager->flush();
    }
}
