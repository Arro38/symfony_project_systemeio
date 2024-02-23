<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class TaxNumberConstraint extends Constraint
{
    public $message = 'The tax number "{{ value }}" is not valid.';
}
