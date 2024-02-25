<?php

namespace App\Controller;

use App\Entity\Product;
use App\Service\Calculator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class CalculatorController extends AbstractController
{
    private $calculator;

    public function __construct(Calculator $calculator)
    {
        $this->calculator = $calculator;
    }

    #[Route('/calculate-price', name: 'calculate_price')]
    public function calculate_price(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        if (empty($data['product']) || empty($data['taxNumber'])) {
            return $this->json([
                'message' => 'Invalid request',
            ], 400);
        }
        $idProduct = $data['product'];
        $taxNumber = $data['taxNumber'];
        $couponCode = $data['couponCode'] ?? null;


        $totalPrice = $this->calculator->calculateTotalPrice($idProduct, $taxNumber, $couponCode);

        return $this->json([
            'totalPrice' => $totalPrice,
        ]);
    }
}
