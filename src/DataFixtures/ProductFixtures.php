<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Product;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $iphone = new Product();
        $iphone->setName('iPhone');
        $iphone->setPrice(100);
        $manager->persist($iphone);

        $headphones = new Product();
        $headphones->setName('Headphones');
        $headphones->setPrice(20);
        $manager->persist($headphones);

        $case = new Product();
        $case->setName('Case');
        $case->setPrice(10);
        $manager->persist($case);

        $manager->flush();
    }
}
