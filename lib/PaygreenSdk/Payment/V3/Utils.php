<?php

namespace Paygreen\Sdk\Payment\V3;

use stdClass;

class Utils
{
    /**
     * @return stdClass
     */
    public static function decodeJWT($token)
    {
        return json_decode(base64_decode(str_replace('_', '/', str_replace('-','+',explode('.', $token)[1]))));
    }
}
