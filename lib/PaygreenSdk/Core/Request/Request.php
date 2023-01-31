<?php

namespace Paygreen\Sdk\Core\Request;

use Exception;
use Paygreen\Sdk\Core\Environment;
use Paygreen\Sdk\Core\Factory\RequestFactory;
use Paygreen\Sdk\Payment\V3\Request\Traits\RequestTrait;

abstract class Request
{
    use RequestTrait;

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
