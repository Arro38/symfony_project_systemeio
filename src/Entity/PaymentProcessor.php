<?php

namespace App\Entity;

use App\Repository\PaymentProcessorRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Systemeio\TestForCandidates\PaymentProcessor\PaypalPaymentProcessor;
use Systemeio\TestForCandidates\PaymentProcessor\StripePaymentProcessor;

#[ORM\Entity(repositoryClass: PaymentProcessorRepository::class)]
class PaymentProcessor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\Column(type: Types::OBJECT)]
    private ?object $type = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getType(): ?object
    {
        return $this->type;
    }

    public function setType(object $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function pay(float $amount): void
    {
        if ($this->type instanceof PaypalPaymentProcessor) {
            $this->type->pay($amount);
        } elseif ($this->type instanceof StripePaymentProcessor) {
            $this->type->processPayment($amount);
        } else {
            throw new \RuntimeException('Invalid payment processor type');
        }
    }
}
