<?php

namespace Paygreen\Sdk\Core\Component\Response;

use Paygreen\Sdk\Core\Exception\ResponseMalformedException;
use stdClass;

class JsonResponse extends Response
{
    /**
     * @param mixed $data
     * @return mixed
     * @throws ResponseMalformedException
     */
    protected function format($data)
    {
        $data = parent::format($data);

        $decodeData = json_decode($data);

        if (!$decodeData instanceof stdClass) {
            throw new ResponseMalformedException("Invalid JSON result.");
        }

        return $decodeData;
    }
}