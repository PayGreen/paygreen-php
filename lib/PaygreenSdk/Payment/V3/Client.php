<?php

namespace Paygreen\Sdk\Payment\V3;

use Exception;
use Paygreen\Sdk\Core\Factory\RequestFactory;
use Paygreen\Sdk\Payment\V3\Model\BuyerInterface;
use Paygreen\Sdk\Payment\V3\Model\Instrument;
use Paygreen\Sdk\Payment\V3\Model\ListenerInterface;
use Paygreen\Sdk\Payment\V3\Model\Operation;
use Paygreen\Sdk\Payment\V3\Model\PaymentConfig;
use Paygreen\Sdk\Payment\V3\Model\PaymentConfigInterface;
use Paygreen\Sdk\Payment\V3\Model\PaymentOrder;
use Paygreen\Sdk\Payment\V3\Model\Shop;
use Paygreen\Sdk\Payment\V3\Request\Authentication\AuthenticationRequest;
use Paygreen\Sdk\Payment\V3\Request\Buyer\BuyerRequest;
use Paygreen\Sdk\Payment\V3\Request\Event\EventRequest;
use Paygreen\Sdk\Payment\V3\Request\Instrument\InstrumentRequest;
use Paygreen\Sdk\Payment\V3\Request\Notification\ListenerRequest;
use Paygreen\Sdk\Payment\V3\Request\Notification\NotificationRequest;
use Paygreen\Sdk\Payment\V3\Request\Operation\OperationRequest;
use Paygreen\Sdk\Payment\V3\Request\PaymentConfig\PaymentConfigRequest;
use Paygreen\Sdk\Payment\V3\Request\PaymentOrder\PaymentOrderRequest;
use Paygreen\Sdk\Payment\V3\Request\PublicKey\PublicKeyRequest;
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
     * @return ResponseInterface
     * @throws Exception
     *
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
     * @return ResponseInterface
     * @throws Exception
     *
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
     * @param string $paymentConfigId
     *
     * @return ResponseInterface
     * @throws Exception
     */
    public function getPaymentConfig($paymentConfigId)
    {
        $request = (new PaymentConfigRequest($this->requestFactory, $this->environment))
            ->getGetRequest($paymentConfigId);

        $this->setLastRequest($request);
        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        return $response;
    }

    /**
     * @return ResponseInterface
     * @throws Exception
     *
     */
    public function listPaymentConfig($shopId = null, $filters = [], $pagination = [])
    {
        if (!isset($filters['shop_id']) || $shopId !== null) {
            $filters['shop_id'] = $shopId;
        } else {
            $filters['shop_id'] = $this->environment->getShopId();
        }

        $request = (new PaymentConfigRequest($this->requestFactory, $this->environment))
            ->getListRequest($filters, $pagination);
        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        return $response;
    }

    /**
     * @link https://developers.paygreen.fr/reference/post_create_payment_config
     *
     * @param PaymentConfigInterface $paymentConfig
     * @param string|null $shopId If not specified, the shop id of the environment will be used
     *
     * @throws Exception
     *
     * @return ResponseInterface
     */
    public function createPaymentConfig(PaymentConfigInterface $paymentConfig, $shopId = null)
    {
        $request = (new PaymentConfigRequest($this->requestFactory, $this->environment))->getCreateRequest(
            $paymentConfig,
            $shopId
        );
        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        return $response;
    }

    /**
     * @link https://developers.paygreen.fr/reference/post_update_payment_config
     *
     * @param string $shopId
     * @param PaymentConfig $shop
     *
     * @return ResponseInterface
     * @throws Exception
     *
     */
    public function updatePaymentConfig($paymentConfigId, PaymentConfigInterface $paymentConfig)
    {
        $request = (new PaymentConfigRequest($this->requestFactory, $this->environment))
            ->getUpdateRequest($paymentConfigId, $paymentConfig);
        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        return $response;
    }

    /**
     * @param BuyerInterface $buyer
     * @param string|null $shopId If not specified, the shop id of the environment will be used
     *
     * @return ResponseInterface
     * @throws Exception
     *
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
     *
     * @return ResponseInterface
     * @throws Exception
     */
    public function getBuyer($buyerId)
    {
        $request = (new BuyerRequest($this->requestFactory, $this->environment))->getGetRequest($buyerId);
        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        return $response;
    }

    /**
     * @return ResponseInterface
     * @throws Exception
     */
    public function listBuyer($shopId = null, $filters = [], $pagination = [])
    {
        if (!isset($filters['shop_id']) || $shopId !== null) {
            $filters['shop_id'] = $shopId;
        } else {
            $filters['shop_id'] = $this->environment->getShopId();
        }

        $request = (new BuyerRequest($this->requestFactory, $this->environment))
            ->getListRequest($filters, $pagination);
        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        return $response;
    }

    /**
     * @param BuyerInterface $buyer
     *
     * @return ResponseInterface
     * @throws Exception
     *
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
     * @return ResponseInterface
     * @throws Exception
     *
     */
    public function createPaymentOrder(PaymentOrder $paymentOrder)
    {
        $request = (new PaymentOrderRequest($this->requestFactory, $this->environment))->getCreateRequest($paymentOrder);
        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        return $response;
    }

    /**
     * @param string $paymentOrderId A payment order id (format: po_0000)
     * @return ResponseInterface
     * @throws Exception
     *
     */
    public function getPaymentOrder($paymentOrderId)
    {
        $request = (new PaymentOrderRequest($this->requestFactory, $this->environment))->getGetRequest($paymentOrderId);
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
    public function listPaymentOrder($reference = null, $shopId = null, $filters = [], $pagination = [])
    {
        if (!isset($filters['shop_id']) || $shopId !== null) {
            $filters['shop_id'] = $shopId;
        } else {
            $filters['shop_id'] = $this->environment->getShopId();
        }

        if (null !== $reference && empty($filters['reference'])) {
            $filters['reference'] = $reference;
        }

        $request = (new PaymentOrderRequest($this->requestFactory, $this->environment))->getListRequest($filters, $pagination);
        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        return $response;
    }

    /**
     * @return ResponseInterface
     * @throws Exception
     *
     */
    public function updatePaymentOrder(PaymentOrder $paymentOrder)
    {
        $request = (new PaymentOrderRequest($this->requestFactory, $this->environment))->getUpdateRequest($paymentOrder);
        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        return $response;
    }

    /**
     * @param string $paymentOrderId
     * @return ResponseInterface
     * @throws Exception
     *
     */
    public function capturePaymentOrder($paymentOrderId)
    {
        $request = (new PaymentOrderRequest($this->requestFactory, $this->environment))->getCaptureRequest($paymentOrderId);
        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        return $response;
    }

    /**
     * @param string $paymentOrderId
     * @param ?string $operationId
     * @param ?int $amount
     * @return ResponseInterface
     * @throws Exception
     *
     */
    public function refundPaymentOrder($paymentOrderId, $operationId = null, $amount = null)
    {
        $request = (new PaymentOrderRequest($this->requestFactory, $this->environment))->getRefundRequest(
            $paymentOrderId,
            $operationId,
            $amount
        );
        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        return $response;
    }

    /**
     * @param string $paymentOrderId
     * @return ResponseInterface
     * @throws Exception
     *
     */
    public function cancelPaymentOrder($paymentOrderId)
    {
        $request = (new PaymentOrderRequest($this->requestFactory, $this->environment))->getCancelRequest($paymentOrderId);
        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        return $response;
    }

    /**
     * @param string $instrumentId
     * @return ResponseInterface
     * @throws Exception
     *
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
     * @return ResponseInterface
     * @throws Exception
     *
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
     * @return ResponseInterface
     * @throws Exception
     *
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
     * @return ResponseInterface
     * @throws Exception
     *
     */
    public function getInstrument($instrumentId)
    {
        $request = (new InstrumentRequest($this->requestFactory, $this->environment))
            ->getGetRequest($instrumentId);

        $this->setLastRequest($request);
        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        return $response;
    }

    /**
     * @link https://developers.paygreen.fr/reference/get_list_instruments
     *
     * @param $buyerId
     * @param $filters
     * @param $pagination
     * @return ResponseInterface
     * @throws Exception
     */
    public function listInstrument($buyerId = null, $filters = [], $pagination = [])
    {
        if (null !== $buyerId) {
            $filters['buyer_id'] = $buyerId;
        }

        $request = (new InstrumentRequest($this->requestFactory, $this->environment))->getListRequest($filters, $pagination);
        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        return $response;
    }

    /**
     * @param ListenerInterface $listener
     * @param string|null $shopId If not specified, the shop id of the environment will be used
     *
     * @return ResponseInterface
     * @throws Exception
     *
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
     * @param string|null $url
     * @param array $params
     * @return ResponseInterface
     * @throws Exception
     *
     */
    public function updateListener($listenerId, $url = null, $params = [])
    {
        if ($url !== null) {
            $params['url'] = $url;
        }

        $request = (new ListenerRequest($this->requestFactory, $this->environment))->getUpdateRequest($listenerId, $params);
        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        return $response;
    }

    /**
     * @param string $listenerId
     * @return ResponseInterface
     * @throws Exception
     *
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
     * @return ResponseInterface
     * @throws Exception
     *
     */
    public function listListener( $shopId = null, $filters = [], $pagination = [])
    {
        if (!isset($filters['shop_id']) || $shopId !== null) {
            $filters['shop_id'] = $shopId;
        } else {
            $filters['shop_id'] = $this->environment->getShopId();
        }

        $request = (new ListenerRequest($this->requestFactory, $this->environment))->getListRequest($filters, $pagination);
        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        return $response;
    }

    /**
     * @param string $listenerId
     * @return ResponseInterface
     * @throws Exception
     *
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
     * @return ResponseInterface
     * @throws Exception
     *
     */
    public function listNotification($listenerId = null, $filters = [], $pagination = [])
    {
        if ($listenerId !== null) {
            $filters['listener_id'] = $listenerId;
        }

        $request = (new NotificationRequest($this->requestFactory, $this->environment))->getGetByListenerRequest($filters, $pagination);
        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        return $response;
    }

    /**
     * @param string $notificationId
     * @return ResponseInterface
     * @throws Exception
     *
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
     * @return ResponseInterface
     * @throws Exception
     *
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
     * @param $filters
     * @param $pagination
     *
     * @throws Exception
     *
     * @return ResponseInterface
     */
    public function listShop($filters = [], $pagination = [])
    {
        $request = (new ShopRequest($this->requestFactory, $this->environment))
            ->getListRequest($filters, $pagination);

        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        return $response;
    }

    /**
     * @link https://developers.paygreen.fr/reference/post_create_shop
     *
     * @deprecated @param string $name
     * @deprecated @param string $nationalId
     * @param Shop $shop
     *
     * @throws Exception
     *
     * @return ResponseInterface
     */
    public function createShop($name = null, $nationalId = null, $shop = null)
    {
        $request = (new ShopRequest($this->requestFactory, $this->environment))->getCreateRequest($name, $nationalId, $shop);

        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        return $response;
    }

    /**
     * @link https://developers.paygreen.fr/reference/post_update_shop
     *
     * @param string $shopId
     * @param Shop $shop
     *
     * @throws Exception
     *
     * @return ResponseInterface
     */
    public function updateShop($shopId, Shop $shop)
    {
        $request = (new ShopRequest($this->requestFactory, $this->environment))->getUpdateRequest($shopId, $shop);

        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        return $response;
    }

    /***
     * @param string $operationId
     *
     * @throws Exception
     *
     * @return ResponseInterface
     */
    public function getOperation($operationId)
    {
        $request = (new OperationRequest($this->requestFactory, $this->environment))->getGetRequest($operationId);

        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        return $response;
    }

    /**
     * @param array $filters
     * @param array $pagination
     *
     * @throws Exception
     *
     * @return ResponseInterface
     */
    public function listOperation($filters = [], $pagination = [])
    {
        $request = (new OperationRequest($this->requestFactory, $this->environment))->getListRequest(
            $filters,
            $pagination
        );

        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        return $response;
    }

    /**
     * @param string $operationId
     * @param Operation $operation
     *
     * @throws Exception
     *
     * @return ResponseInterface
     */
    public function updateOperation($operationId, Operation $operation)
    {
        $request = (new OperationRequest($this->requestFactory, $this->environment))->getUpdateRequest(
            $operationId,
            $operation
        );

        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        return $response;
    }
}
