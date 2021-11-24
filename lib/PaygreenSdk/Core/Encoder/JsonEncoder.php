<?php

namespace Paygreen\Sdk\Core\Encoder;

class JsonEncoder implements EncoderInterface
{
    const ENCODER_NAME = 'json';

    /**
     * @param array $data
     * 
     * @return false|string
     */
    public function encode(array $data)
    {
        return json_encode($data);
    }

    /**
     * @param string $format
     * 
     * @return bool
     */
    public function supportsEncoding($format)
    {
        return self::ENCODER_NAME === $format;
    }
}