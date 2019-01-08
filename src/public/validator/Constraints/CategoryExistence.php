<?php

namespace app\validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class CategoryExistence extends Constraint
{
    public $message = 'Category does not exist.';
}