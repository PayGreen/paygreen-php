<?php

namespace Paygreen\Sdk\Core;

use Exception;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger as MonologLogger;
use Psr\Log\LoggerInterface;

class Logger implements LoggerInterface
{
    const LOG_BASE_PATH = "/var/logs";
    const DATE_FORMAT = "Y-m-d H:i:s";
    const LOG_FORMAT = "[%datetime%] | %level_name% | %message% \n %context% \n";

    /** @var MonologLogger */
    private $logger;

    /**
     * @throws Exception
     */
    public function __construct($area = 'sdk')
    {
        $this->logger = new MonologLogger($area);
        $formatter = new LineFormatter(self::LOG_FORMAT, self::DATE_FORMAT);
        $path = $_SERVER['DOCUMENT_ROOT'] . self::LOG_BASE_PATH . DIRECTORY_SEPARATOR . $area . '.log';

        if (!file_exists($path)) {
            $this->createLogFile($path);
        }

        $handler = new StreamHandler($path, MonologLogger::DEBUG);
        $handler->setFormatter($formatter);
        $this->logger->pushHandler($handler);
    }

    /**
     * @throws Exception
     */
    public function emergency($message, array $context = [])
    {
        $this->log('emergency', $message, $context);
    }

    public function alert($message, array $context = [])
    {
        $this->log('alert', $message, $context);
    }

    public function critical($message, array $context = [])
    {
        $this->log('critical', $message, $context);
    }

    public function error($message, array $context = [])
    {
        $this->log('error', $message, $context);
    }

    public function warning($message, array $context = [])
    {
        $this->log('warning', $message, $context);
    }

    public function notice($message, array $context = [])
    {
        $this->log('notice', $message, $context);
    }

    public function info($message, array $context = [])
    {
        $this->log('info', $message, $context);
    }

    public function debug($message, array $context = [])
    {
        $this->log('debug', $message, $context);
    }

    /**
     * @inheritDoc
     */
    public function log($level, $message, array $context = [])
    {
        if (!is_array($context)) {
            $context = [$context];
        }

        $this->logger->$level($message, $context);
    }

    /**
     * @param string $path
     * @return void
     */
    private function createLogFile($path)
    {
        $logFolderPath = pathinfo($path, PATHINFO_DIRNAME);

        if (!file_exists($logFolderPath)) {
            mkdir($logFolderPath);
        }

        file_put_contents($path, '', FILE_APPEND);
    }
}