<?php

namespace Paygreen\Sdk\Core\Validator;

use Exception;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validation;

class Validator
{
    /**
     * @param object $model
     * @param string $groups
     * @return ConstraintViolationList
     * @throws Exception
     */
    static public function validateModel($model, $groups = null)
    {
        if (!is_object($model)) {
            throw new Exception('$model must be an object model, ' . gettype($model) . ' provided.');
        }

        $validator = Validation::createValidatorBuilder()
            ->addMethodMapping('loadValidatorMetadata')
            ->getValidator()
        ;

        return $validator->validate($model, null, $groups);
    }
}