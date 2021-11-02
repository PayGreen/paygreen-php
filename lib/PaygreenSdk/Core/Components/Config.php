<?php

namespace Paygreen\Sdk\Core\Components;

use ArrayAccess;
use Exception;
use Symfony\Component\Yaml\Yaml;

class Config implements ArrayAccess
{
    /** @var Bag */
    private $bag;

    private $configFiles = [];

    public function __construct()
    {
        $this->bag = new Bag();
        $this->loadConfig();
    }

    /**
     * @return Bag
     */
    public function getBag()
    {
        return $this->bag;
    }

    private function loadConfig()
    {
        $path = $_SERVER['DOCUMENT_ROOT'] . '/lib/PaygreenSdk/config';

        $this->findConfigFile($path);

        foreach ($this->configFiles as $file) {
            $this->bag->merge(Yaml::parse(file_get_contents($file)));
        }
    }

    /**
     * @param string $path
     */
    private function findConfigFile($path)
    {
        foreach (glob($path . DIRECTORY_SEPARATOR . '*.yml') as $filename) {
            $this->configFiles[] = $filename;
        }

        foreach (glob($path . DIRECTORY_SEPARATOR . '*', GLOB_ONLYDIR) as $subDirectory) {
            $this->findConfigFile($subDirectory);
        }
    }

    /**
     * @param string $name
     * @param mixed $value
     * @throws Exception
     */
    public function offsetSet($name, $value)
    {
        throw new Exception("Can not manually add an element.");
    }

    /**
     * @param string $name
     * @return bool
     */
    public function offsetExists($name)
    {
        return isset($this->bag[$name]);
    }

    /**
     * @param string $name
     * @throws Exception
     */
    public function offsetUnset($name)
    {
        throw new Exception("Can not manually delete an element.");
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function offsetGet($name)
    {
        return $this->bag[$name];
    }
}