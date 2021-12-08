<?php

use Http\Client\Curl\Client;
use Paygreen\Sdk\Payment\V3\Enum\IntegrationModeEnum;
use Paygreen\Sdk\Payment\V3\Enum\ModeEnum;
use Paygreen\Sdk\Payment\V3\Model\Address;
use Paygreen\Sdk\Payment\V3\Model\Buyer;
use Paygreen\Sdk\Payment\V3\Model\Order;
use Paygreen\Sdk\Payment\V3\Model\PaymentOrder;

$curl = new Client();

$environment = new \Paygreen\Sdk\Payment\V3\Environment(
    getenv('PG_PAYMENT_PUBLIC_KEY'),
    getenv('PG_PAYMENT_PRIVATE_KEY'),
    getenv('PG_PAYMENT_API_SERVER'),
    getenv('PG_PAYMENT_API_VERSION')
);
$environment->setApplicationName("sdk");
$environment->setApplicationVersion("1.0.0");

$client = new \Paygreen\Sdk\Payment\V3\Client($curl, $environment);

$response = $client->authenticate();
$data = json_decode($response->getBody()->getContents())->data;

$bearer = $data->token;

$client->setBearer($bearer);

$buyer = new Buyer();
$buyer->setId(uniqid());
$buyer->setFirstname('John');
$buyer->setLastname('Doe');
$buyer->setEmail('romain@paygreen.fr');
$buyer->setCountryCode('FR');

$address = new Address();
$address->setStreetLineOne("107 allée Francois Mitterand");
$address->setPostalCode("76100");
$address->setCity("Rouen");
$address->setCountryCode("FR");

$buyer->setBillingAddress($address);

$response = $client->createBuyer($buyer);
$data = json_decode($response->getBody()->getContents())->data;
//dump($data);
$buyer->setReference($data->id);
try {
    $response = $client->getBuyer($buyer);
} catch (Exception $exeption) {
    dump($exeption);
}

//$data = json_decode($response->getBody()->getContents())->data;
//dump($data);
$buyer->setFirstname('Jerry');
$buyer->setLastname('Cane');
$buyer->setEmail('dev-module@paygreen.fr');
$buyer->setCountryCode('US');

try {
    $response = $client->updateBuyer($buyer);
} catch (Exception $exeption) {
    dump($exeption);
}
//$data = json_decode($response->getBody()->getContents())->data;
//dump($data);

$buyerNoreference = new Buyer();
$buyerNoreference->setId(uniqid());
$buyerNoreference->setFirstname('Will');
$buyerNoreference->setLastname('Jackson');
$buyerNoreference->setEmail('romain@paygreen.fr');
$buyerNoreference->setCountryCode('FR');
$buyerNoreference->setBillingAddress($address);

$order = new Order();
$order->setBuyer($buyerNoreference);
$order->setReference('SDK-ORDER-123');
$order->setAmount(407);
$order->setCurrency('eur');
$order->setShippingAddress($address);

$paymentOrder = new PaymentOrder();
$paymentOrder->setPaymentMode(ModeEnum::INSTANT);
$paymentOrder->setIntegrationMode(IntegrationModeEnum::DIRECT);
$paymentOrder->setOrder($order);

/*$response = $client->createOrder($paymentOrder);
$data = json_decode($response->getBody()->getContents())->data;
dump($data);*/

$order->setBuyer($buyer);
$response = $client->createOrder($paymentOrder);
$data = json_decode($response->getBody()->getContents())->data;
dump($data);

$order->setReference($data->id);
$paymentOrder->setObjectSecret($data->object_secret);

$poReference = $paymentOrder->getOrder()->getReference();
$objectSecret = $paymentOrder->getObjectSecret();


/*$response = $client->getOrder($paymentOrder->getOrder()->getReference());
$data = json_decode($response->getBody()->getContents())->data;
dump($data);*/

/*$paymentOrder->setPartialAllowed(true);
$response = $client->updateOrder($paymentOrder);
$data = json_decode($response->getBody()->getContents())->data;
dump($data);*/

/*$instrument = new Instrument();
$instrument->setReference("ins_4961c47e6666497fb17d4e5af6268ac2");
$response = $client->deleteInstrument($instrument->getReference());
$data = json_decode($response->getBody()->getContents())->data;
dump($data);*/

/*$response = $client->captureOrder("po_83b64a6891d04c60b8d372da4a1df37e");
$data = json_decode($response->getBody()->getContents())->data;
dump($data);*/

/*$response = $client->refundOrder("po_546db30ae2ec47769ef6de982c87b7b2");
$data = json_decode($response->getBody()->getContents())->data;
dump($data);*/


$body = '<!DOCTYPE html>
<html lang="fr">
  <head>
		<title>MonMagasin - Paiement</title>
	</head>
  <body>
    <div class="container">
            <h1>Finaliser le paiement</h1>
            <span>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</span>
            
            <div id="paygreen-methods-container"></div>

            <div id="paygreen-payment-container">
                <div id="paygreen-pan-frame"></div>
                    <div id="paygreen-exp-frame"></div>
                <div id="paygreen-cvv-frame"></div>
                <div id="paygreen-pay-btn-frame"></div>
            </div>
    </div>
        <script type="text/javascript" src="https://rc-pgjs.paygreen.fr/latest/"></script>
        <script>
            const onDone = () => {
                console.log("Paiement terminé");
            }
            
            const onError = () => {
                console.error("Une erreur est survenue dans le flux de paiement");
            }
            ';
$body .= "paygreenjs.init({paymentOrderID: '{$poReference}',objectSecret: '{$objectSecret}',publicKey: 'pk_e8cf780bb80942889c100751454caac9',onDone,onError,paymentMethod: 'svad_1'});";
$body .= '</script>
    <style>
      .pay-button:hover {
        background-color: #5e1313;
      }
    </style>
  </body>
</html>';

echo $body;