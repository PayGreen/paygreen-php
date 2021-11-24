<?php

namespace Paygreen\Sdk\Payment\Response;

use Paygreen\Sdk\Core\Exception\ResponseMalformedException;
use Paygreen\Sdk\Core\Response\JsonResponse;
use Paygreen\Sdk\Core\Response\ResponseInterface;
use stdClass;

class Response extends JsonResponse implements ResponseInterface
{
    /** @var bool */
    private $success;

    /** @var string */
    private $message;

    /** @var int */
    private $code;

    /**
     * @throws ResponseMalformedException
     *
     * @return stdClass
     */
    public function getData()
    {
        $data = parent::getData();

        if (!property_exists($data, 'success')
            || !property_exists($data, 'message')
            || !property_exists($data, 'code')
            || !property_exists($data, 'data')
        ) {
            throw new ResponseMalformedException('Malformed response.');
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
            [
                'message' => $this->message,
                'success' => $this->success,
                'code' => $this->code,
            ],
            parent::toArray()
        );
    }
}
