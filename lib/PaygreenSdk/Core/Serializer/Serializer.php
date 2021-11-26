<?php

namespace Paygreen\Sdk\Core\Serializer;

use Exception;
use Paygreen\Sdk\Core\Encoder\EncoderInterface;
use Paygreen\Sdk\Core\Normalizer\NormalizerInterface;

class Serializer
{
    /** @var NormalizerInterface[] */
    private $normalizers;

    /** @var EncoderInterface[] */
    private $encoders;

    /**
     * @param NormalizerInterface[] $normalizers
     * @param EncoderInterface[] $encoders
     */
    public function __construct($normalizers, $encoders)
    {
        $this->normalizers = $normalizers;
        $this->encoders = $encoders;
    }

    /**
     * @param array $data
     * @param string $format
     * @return mixed
     */
    public function serialize(array $data, $format = null)
    {
        foreach ($this->normalizers as $normalizer) {
            if ($normalizer->supportsNormalization($data)) {
                $data = $normalizer->normalize($data);
            }
        }

        foreach ($this->encoders as $encoder) {
            /** @phpstan-ignore-next-line */
            if ($encoder::ENCODER_NAME === $format && $encoder->supportsEncoding($format)) {
                return $encoder->encode($data);
            }
        }

        return $data;
    }
}
