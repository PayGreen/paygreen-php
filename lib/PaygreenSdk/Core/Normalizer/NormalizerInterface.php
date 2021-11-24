<?php

namespace Paygreen\Sdk\Core\Normalizer;

interface NormalizerInterface
{
    /**
     * @param array $data
     * 
     * @return mixed
     */
    public function normalize(array $data);

    /**
     * @param mixed $data
     *
     * @return bool
     */
    public function supportsNormalization($data);
}