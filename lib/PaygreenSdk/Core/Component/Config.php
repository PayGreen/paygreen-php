<?php

namespace Paygreen\Sdk\Core\Component;

use ArrayAccess;
use Exception;
use Symfony\Component\Yaml\Yaml;

class Config implements ArrayAccess
{
    /** @var Bag */
    private $bag;

    /** @var array<string> */
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

    /**
     * @return void
     */
    private function loadConfig()
    {
        $path = $_SERVER['DOCUMENT_ROOT'] . '/lib/PaygreenSdk/config';

        $configFiles = $this->findConfigFiles($path);
        $this->setConfigFiles($configFiles);

        foreach ($this->getConfigFiles() as $file) {
            $this->bag->merge(Yaml::parse(file_get_contents($file)));
        }
    }

    /**
     * @return array<string>
     */
    public function getConfigFiles()
    {
        return $this->configFiles;
    }

    /**
     * @param array<string> $configFiles
     */
    private function setConfigFiles($configFiles)
    {
        $this->configFiles = $configFiles;
    }

    /**
     * @param string $path
     * @return array<string>
     */
    private function findConfigFiles($path)
    {
        $configFiles = [];

        foreach (glob($path . DIRECTORY_SEPARATOR . '*.yml') as $filename) {
            $configFiles[] = $filename;
        }

        foreach (glob($path . DIRECTORY_SEPARATOR . '*', GLOB_ONLYDIR) as $subDirectory) {
            $configFiles = array_merge($configFiles, $this->findConfigFiles($subDirectory));
        }

        return $configFiles;
    }

    /**
     * @param string $offset
     * @param mixed $value
     * @throws Exception
     */
    public function offsetSet($offset, $value)
    {
        throw new Exception("Can not manually add an element.");
    }

    /**
     * @param string $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->bag[$offset]);
    }

    /**
     * @param string $offset
     * @throws Exception
     */
    public function offsetUnset($offset)
    {
        throw new Exception("Can not manually delete an element.");
    }

    /**
     * @param string $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->bag[$offset];
    }
}