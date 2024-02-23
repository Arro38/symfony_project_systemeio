<?php

namespace App\Tests\Service;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PurchaseTest extends KernelTestCase
{
    public function testPurchase(): void
    {
        self::bootKernel();
    }
}
