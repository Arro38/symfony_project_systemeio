<?php

namespace App\DataFixtures;

use App\Entity\CouponCode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CouponCodeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $p10 = new CouponCode();
        $p10->setCode('P10');
        $p10->setDiscount(10);
        $p10->setIsPercent(true);
        $manager->persist($p10);

        $p6 = new CouponCode();
        $p6->setCode('P6');
        $p6->setDiscount(6);
        $p6->setIsPercent(true);
        $manager->persist($p6);

        $p100 = new CouponCode();
        $p100->setCode('P100');
        $p100->setDiscount(100);
        $p100->setIsPercent(true);
        $manager->persist($p100);

        $d10 = new CouponCode();
        $d10->setCode('D10');
        $d10->setDiscount(10);
        $d10->setIsPercent(false);
        $manager->persist($d10);

        $manager->flush();
    }
}
