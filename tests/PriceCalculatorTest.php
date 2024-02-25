<?php

namespace App\Tests\Unit\Validator;

use App\Service\Calculator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PriceCalculatorTest extends KernelTestCase
{
    private $calculator;

    protected function setUp(): void
    {
        parent::setUp();
        $container = self::getContainer();
        $entityManager = $container->get(EntityManagerInterface::class);
        $validator = $container->get(ValidatorInterface::class);
        $this->calculator = new Calculator($entityManager, $validator);
    }


    public function orderProvider()
    {
        return [
            [1, 'GR123456789', null, 124],
            [1, 'GR123456789', 'P6', 116.56],
            [3, 'IT12345678901', 'P100', 0]
        ];
    }

    /**
     * @dataProvider orderProvider
     */
    public function testCalculateTotalPrice($productId, $taxNumber, $couponCode, $result)
    {
        $totalPrice = $this->calculator->calculateTotalPrice($productId, $taxNumber, $couponCode);
        $this->assertEquals($result, $totalPrice);
    }
}
