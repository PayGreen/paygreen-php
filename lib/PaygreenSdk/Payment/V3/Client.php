<?php

namespace Paygreen\Sdk\Payment\V3;

use Exception;
use Paygreen\Sdk\Core\Factory\RequestFactory;
use Paygreen\Sdk\Payment\V3\Model\BuyerInterface;
use Paygreen\Sdk\Payment\V3\Model\Instrument;
use Paygreen\Sdk\Payment\V3\Model\ListenerInterface;
use Paygreen\Sdk\Payment\V3\Model\PaymentOrder;
use Paygreen\Sdk\Payment\V3\Model\SellingContractInterface;
use Paygreen\Sdk\Payment\V3\Request\Authentication\AuthenticationRequest;
use Paygreen\Sdk\Payment\V3\Request\Buyer\BuyerRequest;
use Paygreen\Sdk\Payment\V3\Request\Event\EventRequest;
use Paygreen\Sdk\Payment\V3\Request\Instrument\InstrumentRequest;
use Paygreen\Sdk\Payment\V3\Request\Notification\ListenerRequest;
use Paygreen\Sdk\Payment\V3\Request\Notification\NotificationRequest;
use Paygreen\Sdk\Payment\V3\Request\PaymentConfig\PaymentConfigRequest;
use Paygreen\Sdk\Payment\V3\Request\PaymentOrder\OrderRequest;
use Paygreen\Sdk\Payment\V3\Request\PublicKey\PublicKeyRequest;
use Paygreen\Sdk\Payment\V3\Request\SellingContract\SellingContractRequest;
use Paygreen\Sdk\Payment\V3\Request\Shop\ShopRequest;
use Paygreen\Sdk\Payment\V3\Request\Transaction\TransactionRequest;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;

class Client extends \Paygreen\Sdk\Core\Client
{
    /** @var RequestFactory */
    protected $requestFactory;

    /** @var Environment */
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
     * @return Environment
     */
    public function getEnvironment()
    {
        return $this->environment;
    }

    /**
     * @throws Exception
     *
     * @return ResponseInterface
     */
    public function authenticate()
    {
        $request = (new AuthenticationRequest($this->requestFactory, $this->environment))->getRequest();
        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        return $response;
    }

    /**
     * @param string|null $shopId If not specified, the shop id of the environment will be used
     *
     * @throws Exception
     *
     * @return ResponseInterface
     */
    public function listPaymentConfig($shopId = null)
    {
        $request = (new PaymentConfigRequest($this->requestFactory, $this->environment))->getGetRequest($shopId);
        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        return $response;
    }

    /**
     * @link https://developers.paygreen.fr/reference/post_create_payment_config
     *
     * @param string $platform
     * @param string $currency
     * @param string[] $config
     * @param string|null $sellingContractId
     * @param string|null $shopId If not specified, the shop id of the environment will be used
     *
     * @throws Exception
     *
     * @return ResponseInterface
     */
    public function createPaymentConfig(
        $platform,
        $currency,
        array $config,
        $sellingContractId = null,
        $shopId = null
    ) {
        $request = (new PaymentConfigRequest($this->requestFactory, $this->environment))->getCreateRequest(
            $platform,
            $currency,
            $config,
            $sellingContractId,
            $shopId
        );
        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        return $response;
    }

    /**
     * @throws Exception
     *
     *@return ResponseInterface
     */
    public function getPublicKey($publicKey)
    {
        $request = (new PublicKeyRequest($this->requestFactory, $this->environment))->getGetRequest($publicKey);
        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        return $response;
    }

    /**
     * @param BuyerInterface $buyer
     * @param string|null $shopId If not specified, the shop id of the environment will be used
     *
     * @throws Exception
     *
     * @return ResponseInterface
     */
    public function createBuyer(BuyerInterface $buyer, $shopId = null)
    {
        $request = (new BuyerRequest($this->requestFactory, $this->environment))->getCreateRequest($buyer, $shopId);
        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        return $response;
    }

    /**
     * @param string $buyerId
     * @param string|null $shopId If not specified, the shop id of the environment will be used
     *
     * @throws Exception
     *
     * @return ResponseInterface
     */
    public function getBuyer($buyerId, $shopId = null)
    {
        $request = (new BuyerRequest($this->requestFactory, $this->environment))->getGetRequest($buyerId, $shopId);
        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        return $response;
    }

    /**
     * @param string|null $shopId If not specified, the shop id of the environment will be used
     *
     * @throws Exception
     *
     * @return ResponseInterface
     */
    public function listBuyer($shopId = null)
    {
        $request = (new BuyerRequest($this->requestFactory, $this->environment))->getListRequest($shopId);
        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        return $response;
    }

    /**
     * @param BuyerInterface $buyer
     *
     * @throws Exception
     *
     * @return ResponseInterface
     */
    public function updateBuyer(BuyerInterface $buyer)
    {
        $request = (new BuyerRequest($this->requestFactory, $this->environment))->getUpdateRequest($buyer);
        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        return $response;
    }

    /**
     * @throws Exception
     *
     * @return ResponseInterface
     */
    public function createPaymentOrder(PaymentOrder $paymentOrder)
    {
        $request = (new OrderRequest($this->requestFactory, $this->environment))->getCreateRequest($paymentOrder);
        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        return $response;
    }

    /**
     * @param string $paymentOrderId A payment order id (format: po_0000)
     * @throws Exception
     *
     * @return ResponseInterface
     */
    public function getPaymentOrder($paymentOrderId)
    {
        $request = (new OrderRequest($this->requestFactory, $this->environment))->getGetRequest($paymentOrderId);
        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        return $response;
    }

    /**
     * @link https://developers.paygreen.fr/reference/get_list_payment_orders
     *
     * @param string|null $reference
     * @param string|null $shopId If not specified, the shop id of the environment will be used
     *
     * @throws Exception
     *
     * @return ResponseInterface
     */
    public function listPaymentOrder($reference = null, $shopId = null)
    {
        $request = (new OrderRequest($this->requestFactory, $this->environment))->getListRequest($reference, $shopId);
        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        return $response;
    }

    /**
     * @throws Exception
     *
     * @return ResponseInterface
     */
    public function updatePaymentOrder(PaymentOrder $paymentOrder)
    {
        $request = (new OrderRequest($this->requestFactory, $this->environment))->getUpdateRequest($paymentOrder);
        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        return $response;
    }

    /**
     * @param string $paymentOrderId
     * @throws Exception
     *
     * @return ResponseInterface
     */
    public function capturePaymentOrder($paymentOrderId)
    {
        $request = (new OrderRequest($this->requestFactory, $this->environment))->getCaptureRequest($paymentOrderId);
        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        return $response;
    }

    /**
     * @param string $paymentOrderId
     * @throws Exception
     *
     * @return ResponseInterface
     */
    public function refundPaymentOrder($paymentOrderId)
    {
        $request = (new OrderRequest($this->requestFactory, $this->environment))->getRefundRequest($paymentOrderId);
        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        return $response;
    }

    /**
     * @param string $instrumentId
     * @throws Exception
     *
     * @return ResponseInterface
     */
    public function deleteInstrument($instrumentId)
    {
        $request = (new InstrumentRequest($this->requestFactory, $this->environment))->getDeleteRequest($instrumentId);
        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        return $response;
    }

    /**
     * @param Instrument $instrument
     * @throws Exception
     *
     * @return ResponseInterface
     */
    public function createInstrument(Instrument $instrument)
    {
        $request = (new InstrumentRequest($this->requestFactory, $this->environment))->getCreateRequest($instrument);
        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        return $response;
    }

    /**
     * @param Instrument $instrument
     * @throws Exception
     *
     * @return ResponseInterface
     */
    public function updateInstrument(Instrument $instrument)
    {
        $request = (new InstrumentRequest($this->requestFactory, $this->environment))->getUpdateRequest($instrument);
        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        return $response;
    }

    /**
     * @param string $instrumentId
     * @throws Exception
     *
     * @return ResponseInterface
     */
    public function getInstrument($instrumentId)
    {
        $request = (new InstrumentRequest($this->requestFactory, $this->environment))->getGetRequest($instrumentId);
        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        return $response;
    }

    /**
     * @link https://developers.paygreen.fr/reference/get_list_instruments
     *
     * @param string|null $buyerId
     * @throws Exception
     *
     * @return ResponseInterface
     */
    public function listInstrument($buyerId = null)
    {
        $request = (new InstrumentRequest($this->requestFactory, $this->environment))->getListRequest($buyerId);
        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        return $response;
    }

    /**
     * @param ListenerInterface $listener
     * @param string|null $shopId If not specified, the shop id of the environment will be used
     *
     * @throws Exception
     *
     * @return ResponseInterface
     */
    public function createListener(ListenerInterface $listener, $shopId = null)
    {
        $request = (new ListenerRequest($this->requestFactory, $this->environment))->getCreateRequest($listener, $shopId);
        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        return $response;
    }

    /**
     * @param string $listenerId
     * @param string $url
     * @throws Exception
     *
     * @return ResponseInterface
     */
    public function updateListener($listenerId, $url)
    {
        $request = (new ListenerRequest($this->requestFactory, $this->environment))->getUpdateRequest($listenerId, $url);
        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        return $response;
    }

    /**
     * @param string $listenerId
     * @throws Exception
     *
     * @return ResponseInterface
     */
    public function getListener($listenerId)
    {
        $request = (new ListenerRequest($this->requestFactory, $this->environment))->getGetRequest($listenerId);
        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        return $response;
    }

    /**
     * @param string|null $shopId If not specified, the shop id of the environment will be used
     *
     * @throws Exception
     *
     * @return ResponseInterface
     */
    public function listListener($shopId = null)
    {
        $request = (new ListenerRequest($this->requestFactory, $this->environment))->getListByShopRequest($shopId);
        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        return $response;
    }

    /**
     * @param string $listenerId
     * @throws Exception
     *
     * @return ResponseInterface
     */
    public function deleteListener($listenerId)
    {
        $request = (new ListenerRequest($this->requestFactory, $this->environment))->getDeleteRequest($listenerId);
        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        return $response;
    }

    /**
     * @param string $listenerId
     *
     * @throws Exception
     *
     * @return ResponseInterface
     */
    public function listNotification($listenerId)
    {
        $request = (new NotificationRequest($this->requestFactory, $this->environment))->getGetByListenerRequest($listenerId);
        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        return $response;
    }

    /**
     * @param string $notificationId
     * @throws Exception
     *
     * @return ResponseInterface
     */
    public function replayNotification($notificationId)
    {
        $request = (new NotificationRequest($this->requestFactory, $this->environment))->getReplayRequest($notificationId);
        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        return $response;
    }

    /**
     * @param string $type
     * @param string|array $content
     *
     * @throws Exception
     *
     * @return ResponseInterface
     */
    public function createEvent($type, $content)
    {
        $request = (new EventRequest($this->requestFactory, $this->environment))->getCreateRequest($type, $content);

        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        return $response;
    }

    /**
     * @link https://developers.paygreen.fr/reference/get_list_selling_contracts
     *
     * @param string|null $shopId If not specified, the shop id of the environment will be used
     *
     * @throws Exception
     *
     * @return ResponseInterface
     */
    public function getSellingContracts($shopId = null)
    {
        $request = (new SellingContractRequest($this->requestFactory, $this->environment))->getListRequest($shopId);

        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        return $response;
    }

    /**
     * @link https://developers.paygreen.fr/reference/post_create_selling_contract
     *
     * @param SellingContractInterface $sellingContract
     * @param string|null $shopId If not specified, the shop id of the environment will be used
     *
     * @throws Exception
     *
     * @return ResponseInterface
     */
    public function createSellingContract(SellingContractInterface $sellingContract, $shopId = null)
    {
        $request = (new SellingContractRequest($this->requestFactory, $this->environment))->getCreateRequest(
            $sellingContract,
            $shopId
        );

        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        return $response;
    }

    /**
     * @link https://developers.paygreen.fr/reference/get_get_transaction
     *
     * @param string $transactionId
     *
     * @throws Exception
     *
     * @return ResponseInterface
     */
    public function getTransaction($transactionId)
    {
        $request = (new TransactionRequest($this->requestFactory, $this->environment))->getGetRequest($transactionId);

        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        return $response;
    }

    /**
     * @link https://developers.paygreen.fr/reference/get_list_transactions
     *
     * @param string|null $requesterShopId If not specified, the shop id of the environment will be used
     * @param string|null $beneficiaryShopId
     * @param int $maxPerPage
     * @param int $page
     *
     * @throws Exception
     *
     * @return ResponseInterface
     */
    public function listTransaction(
        $requesterShopId = null,
        $beneficiaryShopId = null,
        $maxPerPage = 10,
        $page = 1
    ) {
        $request = (new TransactionRequest($this->requestFactory, $this->environment))->getListRequest(
            $requesterShopId,
            $beneficiaryShopId,
            $maxPerPage,
            $page
        );

        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        return $response;
    }

    /**
     * @link https://developers.paygreen.fr/reference/get_get_shop
     *
     * @param string|null $shopId If not specified, the shop id of the environment will be used
     *
     * @throws Exception
     *
     * @return ResponseInterface
     */
    public function getShop($shopId = null)
    {
        $request = (new ShopRequest($this->requestFactory, $this->environment))->getGetRequest($shopId);

        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        return $response;
    }

    /**
     * @link https://developers.paygreen.fr/reference/get_list_shops
     *
     * @throws Exception
     *
     * @return ResponseInterface
     */
    public function listShop()
    {
        $request = (new ShopRequest($this->requestFactory, $this->environment))->getListRequest();

        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        return $response;
    }

    /**
     * @link https://developers.paygreen.fr/reference/post_create_shop
     *
     * @param string $name
     * @param string $nationalId
     *
     * @throws Exception
     *
     * @return ResponseInterface
     */
    public function createShop($name, $nationalId)
    {
        $request = (new ShopRequest($this->requestFactory, $this->environment))->getCreateRequest($name, $nationalId);

        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        return $response;
    }
}
