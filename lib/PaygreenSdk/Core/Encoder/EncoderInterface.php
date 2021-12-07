<?php

namespace Paygreen\Sdk\Core\Encoder;

interface EncoderInterface
{    
    /**
     * @param array $data
     *
     * @return mixed
     */
    public function encode(array $data);

    /** 
     * @param string $format
     *
     * @return bool 
     */
    public function supportsEncoding($format);
}