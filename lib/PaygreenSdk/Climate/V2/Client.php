<?php

namespace Paygreen\Sdk\Climate\V2;

use Exception;
use Paygreen\Sdk\Climate\V2\Model\CartItem;
use Paygreen\Sdk\Climate\V2\Model\DeliveryData;
use Paygreen\Sdk\Climate\V2\Model\WebBrowsingData;
use Paygreen\Sdk\Climate\V2\Request\AccountRequest;
use Paygreen\Sdk\Climate\V2\Request\EmissionFactorRequest;
use Paygreen\Sdk\Climate\V2\Request\FootprintRequest;
use Paygreen\Sdk\Climate\V2\Request\LoginRequest;
use Paygreen\Sdk\Climate\V2\Request\ProductRequest;
use Paygreen\Sdk\Climate\V2\Request\StatisticRequest;
use Paygreen\Sdk\Climate\V2\Request\TokenRequest;
use Paygreen\Sdk\Climate\V2\Request\UserRequest;
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
     * @throws Exception
     *
     * @return ResponseInterface
     */
    public function getCurrentUserInfos()
    {
        $this->logger->info("Get current user infos for account.");

        $request = (new UserRequest($this->requestFactory, $this->environment))->getGetCurrentUserRequest();

        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        if (200 === $response->getStatusCode()) {
            $this->logger->info('Current user data successfully retrieved.');
        }

        return $response;
    }

    /**
     * @param string $userId
     * 
     * @throws Exception
     *
     * @return ResponseInterface
     */
    public function getFavoriteProject($userId)
    {
        $this->logger->info("Get favorite project for user '$userId'.");

        $request = (new UserRequest($this->requestFactory, $this->environment))->getGetFavoriteProjectRequest($userId);

        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        if (200 === $response->getStatusCode()) {
            $this->logger->info('User favorite project successfully retrieved.');
        }

        return $response;
    }

    /**
     * @param string $footprintId
     *
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
     * @param bool $detailed
     *
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
            $this->logger->info('Footprint successfully closed.');
        }

        return $response;
    }

    /**
     * @param string $footprintId
     * @param int $amount
     *
     * @throws Exception
     *
     * @return ResponseInterface
     */
    public function userContribute($footprintId, $amount)
    {
        $this->logger->info("User contribute footprint with id '{$footprintId}' and amount '{$amount}'.");

        $request = (new FootprintRequest($this->requestFactory, $this->environment))->getUserContributedRequest(
            $footprintId,
            $amount
        );

        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        if (200 === $response->getStatusCode()) {
            $this->logger->info('Footprint successfully user contributed.');
        }

        return $response;
    }

    /**
     * @param string $footprintId
     * @param WebBrowsingData $webBrowsingData
     *
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

    /**
     * @param string $footprintId
     * @param CartItem[] $cartItems
     *
     * @throws Exception
     *
     * @return ResponseInterface
     */
    public function addProductsData($footprintId, $cartItems)
    {
        $this->logger->info("Add products data to footprint with id '{$footprintId}'.");

        $request = (new ProductRequest($this->requestFactory, $this->environment))->getAddProductsDataRequest(
            $footprintId,
            $cartItems
        );

        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        if (200 === $response->getStatusCode()) {
            $this->logger->info('Products data successfully added.');
        }

        return $response;
    }

    /**
     * @param string $productExternalId
     * @param string $productName
     * @param null|string $emissionExternalId
     *
     * @throws Exception
     *
     * @return ResponseInterface
     */
    public function createProductReference(
        $productExternalId,
        $productName,
        $emissionExternalId = null
    ) {
        $this->logger->info("Create product reference with id '{$productExternalId}'.");

        $request = (new ProductRequest($this->requestFactory, $this->environment))->getCreateProductReferenceRequest(
            $productExternalId,
            $productName,
            $emissionExternalId
        );

        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        if (201 === $response->getStatusCode()) {
            $this->logger->info('Product reference successfully created.');
        }

        return $response;
    }

    /**
     * @param string $footprintId
     *
     * @throws Exception
     *
     * @return ResponseInterface
     */
    public function removeDeliveryData($footprintId)
    {
        $this->logger->info("Remove delivery data on footprint with id '{$footprintId}'.");

        $request = (new FootprintRequest($this->requestFactory, $this->environment))->getDeleteDeliveryDataRequest(
            $footprintId
        );

        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        if (204 === $response->getStatusCode()) {
            $this->logger->info('Delivery data successfully removed.');
        }

        return $response;
    }

    /**
     * @param string $footprintId
     * @param null|string $productExternalReference
     *
     * @throws Exception
     *
     * @return ResponseInterface
     */
    public function removeProductData($footprintId, $productExternalReference = null)
    {
        $this->logger->info("Remove product data on footprint with id '{$footprintId}'.");

        $request = (new ProductRequest($this->requestFactory, $this->environment))->getDeleteProductDataRequest(
            $footprintId,
            $productExternalReference
        );

        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        if (204 === $response->getStatusCode()) {
            $this->logger->info('Product data successfully removed.');
        }

        return $response;
    }

    /**
     * @param string $filepath
     *
     * @throws Exception
     *
     * @return ResponseInterface
     */
    public function exportProductCatalog($filepath)
    {
        $this->logger->info("Export product catalog.");

        $request = (new ProductRequest($this->requestFactory, $this->environment))->getExportProductCatalogRequest(
            $filepath
        );

        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        if (200 === $response->getStatusCode()) {
            $this->logger->info('Product catalog successfully exported.');
        }

        return $response;
    }

    /**
     * @param string $footprintId
     *
     * @throws Exception
     *
     * @return ResponseInterface
     */
    public function getTokenFootprint($footprintId)
    {
        $this->logger->info("Get token for footprint with id '{$footprintId}'.");

        $request = (new TokenRequest($this->requestFactory, $this->environment))->getGetRequest($footprintId);

        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        if (200 === $response->getStatusCode()) {
            $this->logger->info('Token footprint successfully retrieved.');
        }

        return $response;
    }

    public function getStatisticReport()
    {
        $this->logger->info("Get statistic report.");

        $request = (new StatisticRequest($this->requestFactory, $this->environment))->getGetRequest();

        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        if (200 === $response->getStatusCode()) {
            $this->logger->info('Statistic report successfully retrieved.');
        }

        return $response;
    }

    /**
     * @param $footprintId
     *
     * @throws Exception
     *
     * @return ResponseInterface
     */
    public function reserveCarbon($footprintId)
    {
        $this->logger->info("Reserve carbon for footprint '{$footprintId}'.");

        $request = (new FootprintRequest($this->requestFactory, $this->environment))->getReserveCarbonRequest($footprintId);

        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        if (201 === $response->getStatusCode()) {
            $this->logger->info('Carbon successfully reserved.');
        }

        return $response;
    }

    /**
     * @param int $page Defines which page to query
     * @param int $limit Defines how many elements to retrieve
     * @param string|null $search Works as a case-sensitive search engine
     * @param int|null $emissionType Limit results to a type of emission like digital (1), transportation(2), products(4), etc.
     * @param int|null $category Limit results to emission factors that belongs to a specific Monetary Ratio.
     *
     * @throws Exception
     *
     * @return ResponseInterface
     */
    public function listEmissionFactor(
        $page = 1,
        $limit = 25,
        $search = null,
        $emissionType = null,
        $category  = null
    ) {
        $this->logger->info("List emission factors.");

        $request = (new EmissionFactorRequest($this->requestFactory, $this->environment))->getListRequest(
            $page,
            $limit,
            $search,
            $emissionType,
            $category
        );

        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        if (200 === $response->getStatusCode()) {
            $this->logger->info('Emission factors successfully retrieved.');
        }

        return $response;
    }

    /**
     * @param string $emissionFactorId
     *
     * @throws Exception
     *
     * @return ResponseInterface
     */
    public function getEmissionFactor($emissionFactorId)
    {
        $this->logger->info("Get emission factor '$emissionFactorId'.");

        $request = (new EmissionFactorRequest($this->requestFactory, $this->environment))->getGetRequest($emissionFactorId);

        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        if (200 === $response->getStatusCode()) {
            $this->logger->info("Emission factor '$emissionFactorId' successfully retrieved.");
        }

        return $response;
    }
}