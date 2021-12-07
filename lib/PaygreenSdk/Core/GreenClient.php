<?php

namespace Paygreen\Sdk\Core;

use Paygreen\Sdk\Payment\Factory\RequestFactory;
use Psr\Log\LoggerInterface;

abstract class GreenClient extends Client
{
    /** @var RequestFactory */
    protected $requestFactory;

    /** @var GreenEnvironment */
    protected $environment;

    public function __construct(
        $client,
        GreenEnvironment $environment,
        LoggerInterface $logger = null
    ) {
        $this->environment = $environment;
        $this->requestFactory = new RequestFactory($this->environment);
        
        parent::__construct($client, $logger);
    }
}
