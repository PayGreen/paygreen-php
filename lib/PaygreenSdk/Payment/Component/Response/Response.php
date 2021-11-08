<?php

namespace Paygreen\Sdk\Payment\Component\Response;

use Paygreen\Sdk\Core\Component\Response\JsonResponse;
use Paygreen\Sdk\Core\Exception\ResponseMalformedException;

class Response extends JsonResponse
{
    /** @var bool */
    private $success;

    /** @var string */
    private $message = null;
    
    /** @var int */
    private $code;

    /**
     * @inheritDoc
     */
    public function format($data)
    {
        $data = parent::format($data);

        if (empty($data)
            || !property_exists($data, 'success')
            || !property_exists($data, 'message')
            || !property_exists($data, 'code')
            || !property_exists($data, 'data')
        ) {
            throw new ResponseMalformedException("Malformed response.");
        }

        $this->code = (int) $data->code;
        $this->success = (bool) $data->success;
        $this->message = (string) $data->message;

        return $data->data;
    }

    /**
     * @return int
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return bool
     */
    public function isSuccess()
    {
        return $this->success;
    }

    /**
     * @return null|string
     */
    public function getMessage()
    {
        return $this->message;
    }

    public function toArray()
    {
        return array_merge(
            array(
                'message' => $this->message,
                'success' => $this->success,
                'code' => $this->code
            ),
            
            parent::toArray()
        );
    }
}