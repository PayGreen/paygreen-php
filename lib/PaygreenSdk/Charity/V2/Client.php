<?php

namespace Paygreen\Sdk\Charity\V2;

use Exception;
use Paygreen\Sdk\Charity\V2\Request\LoginRequest;
use Paygreen\Sdk\Charity\V2\Request\AccountRequest;
use Paygreen\Sdk\Charity\V2\Request\UserRequest;
use Paygreen\Sdk\Core\Exception\ConstraintViolationException;
use Paygreen\Sdk\Core\Factory\RequestFactory;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;

class Client extends \Paygreen\Sdk\Core\Client
{
    /** @var RequestFactory */
    protected $requestFactory;

    /** @var Environment*/
    protected $environment;

    public function __construct(
        $client,
        Environment $environment,
        LoggerInterface $logger = null
    ) {
        $this->environment = $environment;
        $this->requestFactory = new RequestFactory($this->environment);

        parent::__construct($client, $logger);
    }

    /**
     * @param string      $clientId
     * @param string      $username
     * @param string      $password
     *
     * @throws ConstraintViolationException
     * @throws Exception
     *
     * @return ResponseInterface
     */
    public function login(
        $clientId,
        $username,
        $password
    ) {
        $this->logger->info("Login to Charity API with client id '{$clientId}' and username '{$username}'.");

        $request = (new LoginRequest($this->requestFactory, $this->environment))->getFirstAuthenticationRequest(
            $clientId,
            $username,
            $password
        );

        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        if (200 === $response->getStatusCode()) {
            $this->logger->info('Successful connection to the API.');
        }

        return $response;
    }

    /**
     * @param string      $clientId
     * @param string      $refreshToken
     *
     * @throws ConstraintViolationException
     * @throws Exception
     *
     * @return ResponseInterface
     */
    public function refresh(
        $clientId,
        $refreshToken
    ) {
        $this->logger->info("Refresh connection with token : '{$refreshToken}'.");

        $request = (new \Paygreen\Sdk\Charity\V2\Request\LoginRequest($this->requestFactory, $this->environment))->getRefreshTokenRequest(
            $clientId,
            $refreshToken
        );

        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        if (200 === $response->getStatusCode()) {
            $this->logger->info('Charity tokens successfully refreshed.');
        }

        return $response;
    }

    /**
     * @param string $clientId
     *
     * @throws ConstraintViolationException
     * @throws Exception
     *
     * @return ResponseInterface
     */
    public function getAccountInfos($clientId)
    {
        $this->logger->info("Get account '{$clientId}'.");

        $request = (new AccountRequest($this->requestFactory, $this->environment))->getGetRequest($clientId);

        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        if (200 === $response->getStatusCode()) {
            $this->logger->info('Account successfully retrieved.');
        }

        return $response;
    }

    /**
     * @param string $clientId
     * @param string $username
     *
     * @throws ConstraintViolationException
     * @throws Exception
     *
     * @return ResponseInterface
     */
    public function getUserInfos($clientId, $username)
    {
        $this->logger->info("Get user infos for account '{$clientId}' and username '{$username}'.");

        $request = (new UserRequest($this->requestFactory, $this->environment))->getGetRequest($clientId, $username);

        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        if (200 === $response->getStatusCode()) {
            $this->logger->info('User data successfully retrieved.');
        }

        return $response;
    }
}
