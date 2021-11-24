<?php

namespace Paygreen\Sdk\Core\Exception;

use Exception;
use Symfony\Component\Validator\ConstraintViolationList;

class ConstraintViolationException extends Exception
{
    /** @var ConstraintViolationList */
    private $violations;

    /**
     * @param ConstraintViolationList $violations
     * @param string $message
     */
    public function __construct(ConstraintViolationList $violations, $message = 'Validation has failed.')
    {
        $this->violations = $violations;

        parent::__construct($message);
    }

    public function getViolationMessages()
    {
        $messages = [];

        foreach ($this->violations as $violation) {
            $parameterName = get_class($violation->getRoot()) . '.' . $violation->getPropertyPath();
            $messages[$parameterName] = $violation->getMessage();
        }
        return $messages;
    }
}