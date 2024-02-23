<?php

namespace App\Tests\Unit\Validator;

use App\Entity\TaxNumber;
use App\Validator\Constraints\TaxNumberConstraint;
use App\Validator\TaxNumberValidator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Violation\ConstraintViolationBuilderInterface;

class TaxNumberValidatorTest extends KernelTestCase
{
    private $validator;
    private $context;
    private $constraint;
    private $taxNumberRepository;

    protected function setUp(): void
    {
        self::bootKernel();
        $container = static::getContainer();
        $entityManager = $container->get(EntityManagerInterface::class);
        $this->taxNumberRepository = $entityManager->getRepository(TaxNumber::class);

        $this->validator = new TaxNumberValidator($this->taxNumberRepository);
        $this->constraint = new TaxNumberConstraint();
        $this->context = $this->createMock(ExecutionContextInterface::class);
        $this->validator->initialize($this->context);
    }

    public function taxNumberProvider()
    {
        return [
            // Format: ['ValidTaxNumber', 'InvalidTaxNumber']
            ['DE123456789', 'DE12345678'], // 9 digits for Germany
            ['IT12345678901', 'IT123456789'], // 11 digits for Italy
            ['FRAB12345678901', 'FR12345678901'], // 2 letters followed by 11 digits for France
            ['GR123456789', 'GR12345678'], // 9 digits for Greece
        ];
    }

    /**
     * @dataProvider taxNumberProvider
     */
    public function testValidateValidTaxNumber($validTaxNumber)
    {
        $this->context->expects($this->never())->method('buildViolation');

        $this->validator->validate($validTaxNumber, $this->constraint);
    }

    /**
     * @dataProvider taxNumberProvider
     */
    public function testValidateInvalidTaxNumber($_, $invalidTaxNumber)
    {
        $this->context->expects($this->once())
            ->method('buildViolation')
            ->willReturn($this->createMock(ConstraintViolationBuilderInterface::class));

        $this->validator->validate($invalidTaxNumber, $this->constraint);
    }
}
