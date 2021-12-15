<?php

namespace Paygreen\Sdk\Climate\V2;

use Exception;
use Paygreen\Sdk\Climate\V2\Model\DeliveryData;
use Paygreen\Sdk\Climate\V2\Model\WebBrowsingData;
use Paygreen\Sdk\Climate\V2\Request\AccountRequest;
use Paygreen\Sdk\Climate\V2\Request\FootprintRequest;
use Paygreen\Sdk\Climate\V2\Request\LoginRequest;
use Paygreen\Sdk\Climate\V2\Request\ProductRequest;
use Paygreen\Sdk\Climate\V2\Request\UserRequest;
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

    /**
     * @param string $footprintId
     * @param string $status
     *
     * @throws ConstraintViolationException
     * @throws Exception
     *
     * @return ResponseInterface
     */
    public function closeFootprint($footprintId, $status)
    {
        $this->logger->info("Close footprint with id '{$footprintId}' and status '{$status}'.");

        $request = (new FootprintRequest($this->requestFactory, $this->environment))->getCloseRequest(
            $footprintId,
            $status
        );

        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        if (200 === $response->getStatusCode()) {
            $this->logger->info('Footprint successfully retrieved.');
        }

        return $response;
    }

    /**
     * @param string $footprintId
     * @param WebBrowsingData $webBrowsingData
     *
     * @throws ConstraintViolationException
     * @throws Exception
     *
     * @return ResponseInterface
     */
    public function addWebBrowsingData($footprintId, WebBrowsingData $webBrowsingData)
    {
        $this->logger->info("Add web browsing data to footprint with id '{$footprintId}'.");

        $request = (new FootprintRequest($this->requestFactory, $this->environment))->getAddWebBrowsingDataRequest(
            $footprintId,
            $webBrowsingData
        );

        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        if (200 === $response->getStatusCode()) {
            $this->logger->info('Web browsing data successfully added.');
        }

        return $response;
    }

    /**
     * @param string $footprintId
     * @param DeliveryData $deliveryData
     *
     * @throws ConstraintViolationException
     * @throws Exception
     *
     * @return ResponseInterface
     */
    public function addDeliveryData($footprintId, DeliveryData $deliveryData)
    {
        $this->logger->info("Add delivery data to footprint with id '{$footprintId}'.");

        $request = (new FootprintRequest($this->requestFactory, $this->environment))->getAddDeliveryDataRequest(
            $footprintId,
            $deliveryData
        );

        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        if (201 === $response->getStatusCode()) {
            $this->logger->info('Delivery data successfully added.');
        }

        return $response;
    }

    /**
     * @param string $footprintId
     * @param string $productExternalId
     * @param integer $quantity
     *
     * @throws ConstraintViolationException
     * @throws Exception
     *
     * @return ResponseInterface
     */
    public function addProductData($footprintId, $productExternalId, $quantity)
    {
        $this->logger->info("Add product data to footprint with id '{$footprintId}'.");

        $request = (new ProductRequest($this->requestFactory, $this->environment))->getAddProductDataRequest(
            $footprintId,
            $productExternalId,
            $quantity
        );

        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        if (201 === $response->getStatusCode()) {
            $this->logger->info('Product data successfully added.');
        }

        return $response;
    }
}