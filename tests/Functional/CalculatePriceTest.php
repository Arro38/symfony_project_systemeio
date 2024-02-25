<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CalculatorControllerTest extends WebTestCase
{

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
    public function testCalculatePriceRoute($productId, $taxNumber, $couponCode, $result)
    {
        $client = static::createClient();
        $client->request('POST', '/calculate-price', [], [], [], json_encode([
            'product' => $productId,
            'taxNumber' => $taxNumber,
            'couponCode' => $couponCode
        ]));
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertJson($client->getResponse()->getContent());
        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('totalPrice', $data);
        $this->assertEquals($result, $data['totalPrice']);
    }

    public function testInvalidRequestOnlyProduct()
    {
        $client = static::createClient();
        $client->request('POST', '/calculate-price', [], [], [], json_encode([
            'product' => 1,
        ]));
        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertJson($client->getResponse()->getContent());
        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('message', $data);
        $this->assertEquals('Invalid request', $data['message']);
    }

    public function testInvalidRequestOnlyTaxNumber()
    {
        $client = static::createClient();
        $client->request('POST', '/calculate-price', [], [], [], json_encode([
            'taxNumber' => 'GR123456789',
        ]));
        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertJson($client->getResponse()->getContent());
        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('message', $data);
        $this->assertEquals('Invalid request', $data['message']);
    }

    public function testValidWithoutCouponCode()
    {
        $client = static::createClient();
        $client->request('POST', '/calculate-price', [], [], [], json_encode([
            'product' => 1,
            'taxNumber' => 'GR123456789',
        ]));
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertJson($client->getResponse()->getContent());
        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('totalPrice', $data);
        $this->assertEquals(124, $data['totalPrice']);
    }

    public function testInvalidTaxNumber()
    {
        $client = static::createClient();
        $client->request('POST', '/calculate-price', [], [], [], json_encode([
            'product' => 1,
            'taxNumber' => 'GR1234567890112',
        ]));
        $this->assertEquals(400, $client->getResponse()->getStatusCode());
    }
}
