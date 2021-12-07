<?php

namespace Paygreen\Sdk\Climate\V2;

use Couchbase\User;
use Exception;
use Paygreen\Sdk\Climate\V2\Request\AccountRequest;
use Paygreen\Sdk\Climate\V2\Request\FootprintRequest;
use Paygreen\Sdk\Climate\V2\Request\LoginRequest;
use Paygreen\Sdk\Climate\V2\Request\UserRequest;
use Paygreen\Sdk\Core\Exception\ConstraintViolationException;
use Paygreen\Sdk\Core\GreenClient;
use Psr\Http\Message\ResponseInterface;

class ClimateClient extends GreenClient
{
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
        $this->logger->info("Login to climate API with client id '{$clientId}' and username '{$username}'.");

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

        $request = (new LoginRequest($this->requestFactory, $this->environment))->getRefreshTokenRequest(
            $clientId,
            $refreshToken
        );

        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        if (200 === $response->getStatusCode()) {
            $this->logger->info('Climate tokens successfully refreshed.');
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

    /**
     * @param string $footprintId
     *
     * @throws ConstraintViolationException
     * @throws Exception
     *
     * @return ResponseInterface
     */
    public function createEmptyFootprint($footprintId)
    {
        $this->logger->info("Create empty footprint with id '{$footprintId}'.");

        $request = (new FootprintRequest($this->requestFactory, $this->environment))->getCreateRequest($footprintId);

        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        if (201 === $response->getStatusCode()) {
            $this->logger->info('Footprint successfully created.');
        }

        return $response;
    }

    /**
     * @param string $footprintId
     *
     * @throws ConstraintViolationException
     * @throws Exception
     *
     * @return ResponseInterface
     */
    public function getFootprint($footprintId, $detailed = false)
    {
        $this->logger->info("Get footprint with id '{$footprintId}'.");

        $request = (new FootprintRequest($this->requestFactory, $this->environment))->getGetRequest(
            $footprintId,
            $detailed
        );

        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        if (200 === $response->getStatusCode()) {
            $this->logger->info('Footprint successfully retrieved.');
        }

        return $response;
    }
}
