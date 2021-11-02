<?php

namespace Paygreen\Sdk\Core;

use Exception;
use Monolog\Formatter\LineFormatter;
use Monolog\Logger as MonologLogger;
use Monolog\Handler\StreamHandler;

abstract class Logger
{
    const DATE_FORMAT = "Y-m-d H:i:s";
    const LOG_FORMAT = "[%datetime%] | %level_name% | %message% \n %context% \n";

    /**
     * @param string $message
     * @param array $data
     * @throws Exception
     */
    static public function debug($message, $data = [])
    {
        self::log('debug', $message, $data);
    }

    /**
     * @param string $message
     * @param array $data
     * @throws Exception
     */
    static public function info($message, $data = [])
    {
        self::log('info', $message, $data);
    }

    /**
     * @param string $message
     * @param array $data
     * @throws Exception
     */
    static public function notice($message, $data = [])
    {
        self::log('notice', $message, $data);
    }

    /**
     * @param string $message
     * @param array $data
     * @throws Exception
     */
    static public function warning($message, $data = [])
    {
        self::log('warning', $message, $data);
    }

    /**
     * @param string $message
     * @param array $data
     * @throws Exception
     */
    static public function error($message, $data = [])
    {
        self::log('error', $message, $data);
    }

    /**
     * @param string $message
     * @param array $data
     * @throws Exception
     */
    static public function critical($message, $data = [])
    {
        self::log('critical', $message, $data);
    }

    /**
     * @param string $level
     * @param string $message
     * @param array $data
     * @throws Exception
     */
    static private function log($level, $message, $data)
    {
        $logger = new MonologLogger('sdk');
        $formatter = new LineFormatter(self::LOG_FORMAT, self::DATE_FORMAT);
        $path = $_SERVER['DOCUMENT_ROOT'] . '/logs/sdk.log';

        if (!file_exists($path)) {
            self::createLogFile($path);
        }

        $handler = new StreamHandler($path, MonologLogger::DEBUG);
        $handler->setFormatter($formatter);
        $logger->pushHandler($handler);

        if (!is_array($data)) {
            $data = [$data];
        }

        $logger->$level($message, $data);
    }

    /**
     * @param string $path
     * @return void
     */
    static private function createLogFile($path)
    {
        $logFolderPath = pathinfo($path, PATHINFO_DIRNAME);

        if (!file_exists($logFolderPath)) {
            mkdir($logFolderPath);
        }

        file_put_contents($path, '', FILE_APPEND);
    }
}