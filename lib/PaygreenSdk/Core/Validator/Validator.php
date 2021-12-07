<?php

namespace Paygreen\Sdk\Core\Validator;

use Exception;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validation;

class Validator
{
    /**
     * @param object $model
     * @param string $groups
     *
     * @throws Exception
     *
     * @return ConstraintViolationListInterface
     */
    public static function validateModel($model, $groups = null)
    {
        if (!is_object($model)) {
            throw new Exception('$model must be an object model, '.gettype($model).' provided.');
        }

        $validator = Validation::createValidatorBuilder()
            ->addMethodMapping('loadValidatorMetadata')
            ->getValidator()
        ;

        return $validator->validate($model, null, $groups);
    }

    /**
     * @param mixed                        $value
     * @param null|Constraint|Constraint[] $constraints Must provide at least one constraint
     * @param null|array                   $groups
     *
     * @return ConstraintViolationListInterface
     */
    public static function validateValue($value, $constraints, $groups = null)
    {
        return Validation::createValidator()->validate($value, $constraints, $groups);
    }
}
