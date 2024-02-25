<?php

namespace App\Validator;

use App\Repository\TaxNumberRepository;
use App\Validator\Constraints\TaxNumberConstraint;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class TaxNumberValidator extends ConstraintValidator
{
    private $taxNumberRepository;


    public function __construct(TaxNumberRepository $taxNumberRepository)
    {
        $this->taxNumberRepository = $taxNumberRepository;
    }



    public function validate($value, Constraint $constraint): void
    {
        if (!$constraint instanceof TaxNumberConstraint) {
            throw new UnexpectedTypeException($constraint, TaxNumberConstraint::class);
        }

        if (null === $value || '' === $value) {
            return;
        }
        $countryCode = substr($value, 0, 2);
        $taxNumberEntity = $this->taxNumberRepository->findOneBy(['countryCode' => $countryCode]);

        if (!$taxNumberEntity) {
            $this->context->buildViolation($constraint->message)
                ->setCode(Response::HTTP_BAD_REQUEST)
                ->setParameter('{{ value }}', $value)
                ->addViolation();
            return;
        }

        $isValid = preg_match($taxNumberEntity->getFormat(), $value);
        if (!$isValid) {

            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $value)
                ->setCode(Response::HTTP_BAD_REQUEST)
                ->addViolation();
        }
    }
}
