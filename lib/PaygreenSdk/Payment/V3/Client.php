<?php

namespace Paygreen\Sdk\Payment\V3;

use Exception;
use Paygreen\Sdk\Core\Factory\RequestFactory;
use Paygreen\Sdk\Payment\V3\Model\Buyer;
use Paygreen\Sdk\Payment\V3\Model\Instrument;
use Paygreen\Sdk\Payment\V3\Model\PaymentOrder;
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
     *@return ResponseInterface
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
     * @throws Exception
     *
     *@return ResponseInterface
     */
    public function listPaymentConfig()
    {
        $request = (new PaymentConfigRequest($this->requestFactory, $this->environment))->getGetRequest();
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
     * @throws Exception
     *
     * @return ResponseInterface
     */
    public function createBuyer(Buyer $buyer)
    {
        $request = (new BuyerRequest($this->requestFactory, $this->environment))->getCreateRequest($buyer);
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
    public function getBuyer(Buyer $buyer)
    {
        $request = (new BuyerRequest($this->requestFactory, $this->environment))->getGetRequest($buyer);
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
    public function updateBuyer(Buyer $buyer)
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
     * @param string $id A payment order id (format: po_0000)
     * @throws Exception
     *
     * @return ResponseInterface
     */
    public function getPaymentOrder($id)
    {
        $request = (new OrderRequest($this->requestFactory, $this->environment))->getGetRequest($id);
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
     * @param string $paymentReference
     * @throws Exception
     *
     * @return ResponseInterface
     */
    public function capturePaymentOrder($paymentReference)
    {
        $request = (new OrderRequest($this->requestFactory, $this->environment))->getCaptureRequest($paymentReference);
        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        return $response;
    }

    /**
     * @param string $paymentReference
     * @throws Exception
     *
     * @return ResponseInterface
     */
    public function refundPaymentOrder($paymentReference)
    {
        $request = (new OrderRequest($this->requestFactory, $this->environment))->getRefundRequest($paymentReference);
        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        return $response;
    }

    /**
     * @param string $reference
     * @throws Exception
     *
     * @return ResponseInterface
     */
    public function deleteInstrument($reference)
    {
        $request = (new InstrumentRequest($this->requestFactory, $this->environment))->getDeleteRequest($reference);
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
    public function createInstrument($instrument)
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
    public function updateInstrument($instrument)
    {
        $request = (new InstrumentRequest($this->requestFactory, $this->environment))->getUpdateRequest($instrument);
        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        return $response;
    }

    /**
     * @param string $reference
     * @throws Exception
     *
     * @return ResponseInterface
     */
    public function getInstrument($reference)
    {
        $request = (new InstrumentRequest($this->requestFactory, $this->environment))->getGetRequest($reference);
        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        return $response;
    }

    /**
     * @param string $type
     * @param array $events
     * @param string $url
     * @throws Exception
     *
     * @return ResponseInterface
     */
    public function createListener($type, $events, $url)
    {
        $request = (new ListenerRequest($this->requestFactory, $this->environment))->getCreateRequest(
            $type,
            $events,
            $url
        );
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
     * @param string $shopId
     * @throws Exception
     *
     * @return ResponseInterface
     */
    public function listListenerByShop($shopId)
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
     * @throws Exception
     *
     * @return ResponseInterface
     */
    public function getNotificationsByListener($listenerId)
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
    public function getSellingContracts($shopId)
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
     * @param string $number The number, or identifier, of the selling contract you have with your bank - check with your bank for more informations
     * @param int $mcc Merchant Category Code (ISO-18245)
     * @param int $maxAmount The maximum amount allowed by your selling contract
     * @param string $type Only 'vads' is supported at the moment
     * @param string|null $shopId If not specified, the shop id of the environment will be used
     *
     * @throws Exception
     *
     * @return ResponseInterface
     */
    public function createSellingContract(
        $number,
        $mcc,
        $maxAmount,
        $type,
        $shopId = null
    ) {
        $request = (new SellingContractRequest($this->requestFactory, $this->environment))->getCreateRequest(
            $number,
            $mcc,
            $maxAmount,
            $type,
            $shopId
        );

        $this->setLastRequest($request);

        $response = $this->sendRequest($request);
        $this->setLastResponse($response);

        return $response;
    }
}
