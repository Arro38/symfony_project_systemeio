<?php

namespace App\Tests\Service;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CalculatePriceTest extends KernelTestCase
{
    public function testCalculatePrice(): void
    {
        self::bootKernel();
    }
}
