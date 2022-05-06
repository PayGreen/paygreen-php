<?php

namespace Paygreen\Sdk\Charity\V2;

use Exception;
use Paygreen\Sdk\Charity\V2\Model\Donation;
use Paygreen\Sdk\Charity\V2\Request\DonationRequest;
use Paygreen\Sdk\Charity\V2\Request\LoginRequest;
use Paygreen\Sdk\Charity\V2\Request\AccountRequest;
use Paygreen\Sdk\Charity\V2\Request\PartnershipRequest;
use Paygreen\Sdk\Charity\V2\Request\UserRequest;
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
     *
     * @throws Exception
     *
     * @return ResponseInterface
     */
    public function getPartnershipGroups()
    {
        $this->logger->info("Get all partnership groups.");

        $request = (new PartnershipRequest($this->requestFactory, $this->environment))->getGroupsRequest();

        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        if (200 === $response->getStatusCode()) {
            $this->logger->info('Partnership groups successfully retrieved.');
        }

        return $response;
    }

    /**
     * @param string $externalId
     *
     * @throws Exception
     *
     * @return ResponseInterface
     */
    public function getPartnershipGroup($externalId)
    {
        $this->logger->info("Get partnership group named '{$externalId}'.");

        $request = (new PartnershipRequest($this->requestFactory, $this->environment))->getGroupRequest($externalId);

        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        if (200 === $response->getStatusCode()) {
            $this->logger->info("Partnership group named '{$externalId}' successfully retrieved.");
        }

        return $response;
    }

    /**

     * @throws Exception
     *
     * @return ResponseInterface
     */
    public function getDefaultPartnershipGroup()
    {
        $this->logger->info('Get default partnership group.');

        $request = (new PartnershipRequest($this->requestFactory, $this->environment))->getDefaultGroup();

        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        if (200 === $response->getStatusCode()) {
            $this->logger->info("Default partnership group successfully retrieved.");
        }

        return $response;
    }

    /**
     * @param Donation $donation
     *
     * @throws Exception
     *
     * @return ResponseInterface
     */
    public function createDonation($donation)
    {
        $this->logger->info("Create donation.");

        $request = (new DonationRequest($this->requestFactory, $this->environment))->getCreateRequest($donation);

        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        if (200 === $response->getStatusCode()) {
            $this->logger->info("Donation successfully created.");
        }

        return $response;
    }

    /**
     * @param integer $donationId
     *
     * @throws Exception
     *
     * @return ResponseInterface
     */
    public function getDonation($donationId)
    {
        $this->logger->info("Get donation {$donationId}.");

        $request = (new DonationRequest($this->requestFactory, $this->environment))->getGetRequest($donationId);

        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        if (200 === $response->getStatusCode()) {
            $this->logger->info("Donation {$donationId} successfully retrieved.");
        }

        return $response;
    }
}
