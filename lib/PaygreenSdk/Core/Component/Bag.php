<?php

namespace Paygreen\Sdk\Core\Component;

use Paygreen\Sdk\Core\Tool\Collection;
use ArrayAccess;
use Exception;

class Bag implements ArrayAccess
{
    private $data;

    private $dotSeparator = true;

    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    /**
     * @param bool $dotSeparator
     * @return void
     */
    public function setDotSeparator($dotSeparator)
    {
        $this->dotSeparator = (bool) $dotSeparator;
    }

    public function get($key)
    {
        return $this->searchData($key);
    }

    public function toArray()
    {
        return $this->data;
    }

    public function merge(array $data)
    {
        Collection::merge($this->data, $data);
    }

    /**
     * @param string $name
     * @param mixed $value
     * @throws Exception
     */
    public function offsetSet($name, $value)
    {
        throw new Exception('A data tree cannot be modified.');
    }

    /**
     * @param string $name
     * @return bool
     */
    public function offsetExists($name)
    {
        return ($this->searchData($name) !== null);
    }

    /**
     * @param string $name
     * @throws Exception
     */
    public function offsetUnset($name)
    {
        throw new Exception('A data tree cannot be modified.');
    }

    /**
     * @param $var
     * @return mixed|null
     */
    public function offsetGet($var)
    {
        return $this->get($var);
    }

    /**
     * @param false $key
     * @param false $data
     * @return mixed|null
     */
    private function searchData($key = false, &$data = false)
    {
        if (!$data) {
            $data = &$this->data;
        }

        if ($key === false) {
            return $data;
        }

        if ($this->dotSeparator) {
            $allKeys = explode('.', $key);
            $firstKey = array_shift($allKeys);
        } else {
            $allKeys = [];
            $firstKey = $key;
        }

        if (is_array($data) and isset($data[$firstKey])) {
            $data =& $data[$firstKey];
        } else {
            return null;
        }

        if (!empty($allKeys)) {
            $key = implode('.', $allKeys);
            return $this->searchData($key, $data);
        } else {
            return $data;
        }
    }
}
