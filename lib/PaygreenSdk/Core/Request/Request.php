<?php

namespace Paygreen\Sdk\Core\Request;

use Exception;
use Paygreen\Sdk\Core\Environment;
use Paygreen\Sdk\Payment\Factory\RequestFactory;

abstract class Request
{
    /**
     * @var RequestFactory
     */
    protected $requestFactory;
    /**
     * @var Environment
     */
    protected $environment;

    /**
     * @param RequestFactory $requestFactory
     * @param Environment $environment
     *
     * @throws Exception
     */
    public function __construct(
        $requestFactory,
        $environment
    ) {
        $this->requestFactory = $requestFactory;
        $this->environment = $environment;
    }
}
