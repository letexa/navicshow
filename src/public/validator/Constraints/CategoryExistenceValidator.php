<?php

namespace app\validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use app\model\Category;

class CategoryExistenceValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if ($value) {
            try {
                Category::find($value);
            } catch (\ActiveRecord\RecordNotFound $ex) {
                $this->context->buildViolation($constraint->message)->addViolation();
            }
        }
        
    }
}
