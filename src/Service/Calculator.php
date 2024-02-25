<?php

namespace App\Service;

use App\Entity\CouponCode;
use App\Entity\Product;
use App\Entity\TaxNumber;
use App\Validator\Constraints\TaxNumberConstraint;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class Calculator
{
    private $entityManager;
    private $validator;
    private $taxNumberRepository;


    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        $this->entityManager = $entityManager;
        $this->taxNumberRepository = $entityManager->getRepository(TaxNumber::class);
        $this->validator = $validator;
    }

    public function calculateTotalPrice($idProduct, $taxNumber, $couponCode): float
    {
        $product  = $this->entityManager->getRepository(Product::class)->find($idProduct);
        if (!$product) {
            throw new BadRequestHttpException('Invalid product');
        }
        $price = $product->getPrice();
        $taxRate = $this->getTaxRateForTaxNumber($taxNumber);
        if ($couponCode) {
            $discount = $this->getDiscountForCoupon($couponCode);
            if ($discount) {
                if ($discount['isPercentage']) {
                    $discount = $price * $discount['value'] / 100;
                } else {
                    $discount = $discount['value'];
                }
            }
        } else {
            $discount = 0;
        }
        $price = $price - $discount;
        $totalPrice = ($price + ($price * $taxRate / 100));

        return $totalPrice;
    }

    private function getTaxRateForTaxNumber($taxNumber)
    {
        $violations =  $this->validator->validate($taxNumber, new TaxNumberConstraint());
        if (count($violations) > 0) {
            throw new BadRequestHttpException("Invalid tax number");
        }
        $countryCode = substr($taxNumber, 0, 2);
        $taxNumberEntity = $this->taxNumberRepository->findOneBy(['countryCode' => $countryCode]);
        if (!$taxNumberEntity) {
            throw new BadRequestHttpException('Invalid tax number');
        }
        return $taxNumberEntity->getValue();
    }

    private function getDiscountForCoupon($couponCode): ?array
    {
        $entityManager = $this->entityManager;
        $couponCode = $entityManager->getRepository(CouponCode::class)->findOneBy(['code' => $couponCode]);
        if (!$couponCode) {
            return null;
        } else {
            return ["value" => $couponCode->getDiscount(), "isPercentage" => $couponCode->isIsPercent()];
        }
    }
}
