<?php

namespace Paygreen\Sdk\Core\Normalizer;

class CleanEmptyValueNormalizer implements NormalizerInterface
{
    /**
     * @param array $data
     * 
     * @return array
     */
    public function normalize(array $data)
    {
        return $this->cleanEmptyValues($data);
    }

    /**
     * @param mixed $data
     * @return bool
     */
    public function supportsNormalization($data)
    {
        return is_array($data);
    }

    /**
     * @param array $array
     *
     * @return array
     */
    private function cleanEmptyValues(array &$array)
    {
        foreach ($array as $key => $value) {
            if (is_array($value) && !empty($value)) {
                $array[$key] = self::cleanEmptyValues($value);
            }

            if (empty($value) && ($value !== false) && ($value !== 0)) {
                unset($array[$key]);
            }
        }

        return $array;
    }
}