<?php

namespace App\DataFixtures;

use App\Entity\PaymentProcessor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Systemeio\TestForCandidates\PaymentProcessor\PaypalPaymentProcessor;
use Systemeio\TestForCandidates\PaymentProcessor\StripePaymentProcessor;

class PaymentProcessorFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $paypal = new PaymentProcessor();
        $paypal->setName('paypal');
        $paypal->setType(new PaypalPaymentProcessor());
        $manager->persist($paypal);

        $stripe = new PaymentProcessor();
        $stripe->setName('stripe');
        $stripe->setType(new StripePaymentProcessor());
        $manager->persist($stripe);

        $manager->flush();
    }
}
