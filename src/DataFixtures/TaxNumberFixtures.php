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
        $germany->setCountryCode('DE');
        $germany->setFormat('/^DE\d{9}$/');
        $germany->setValue(19);
        $manager->persist($germany);

        $italy = new TaxNumber();
        $italy->setCountryCode('IT');
        $italy->setFormat('/^IT\d{11}$/');
        $italy->setValue(22);
        $manager->persist($italy);

        $france = new TaxNumber();
        $france->setCountryCode('FR');
        $france->setFormat('/^FR[A-Z]{2}\d{11}$/');
        $france->setValue(20);
        $manager->persist($france);

        $greece = new TaxNumber();
        $greece->setCountryCode('GR');
        $greece->setFormat('/^GR\d{9}$/');
        $greece->setValue(24);
        $manager->persist($greece);

        $manager->flush();
    }
}
