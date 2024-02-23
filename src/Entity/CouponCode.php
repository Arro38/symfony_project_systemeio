<?php

namespace App\Entity;

use App\Repository\CouponCodeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CouponCodeRepository::class)]
class CouponCode
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $isPercent = null;

    #[ORM\Column(length: 50)]
    private ?string $code = null;

    #[ORM\Column]
    private ?float $discount = null;

    public function getId(): ?int
    {
        return $this->id;
    }


    public function isIsPercent(): ?bool
    {
        return $this->isPercent;
    }

    public function setIsPercent(bool $isPercent): static
    {
        $this->isPercent = $isPercent;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

        return $this;
    }

    public function getDiscount(): ?float
    {
        return $this->discount;
    }

    public function setDiscount(float $discount): static
    {
        $this->discount = $discount;

        return $this;
    }
}
