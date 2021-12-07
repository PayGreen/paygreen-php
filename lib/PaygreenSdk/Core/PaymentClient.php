<?php

namespace Paygreen\Sdk\Core;

use Paygreen\Sdk\Payment\Factory\RequestFactory;
use Psr\Log\LoggerInterface;

abstract class PaymentClient extends Client
{
    /** @var RequestFactory */
    protected $requestFactory;

    /** @var PaymentEnvironment */
    protected $environment;

    public function __construct(
        $client,
        PaymentEnvironment $environment,
        LoggerInterface $logger = null
    ) {
        $this->environment = $environment;
        $this->requestFactory = new RequestFactory($this->environment);
        
        parent::__construct($client, $logger);
    }
}
