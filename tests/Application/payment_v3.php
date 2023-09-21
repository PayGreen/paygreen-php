<?php

use Http\Client\Curl\Client;
use Paygreen\Sdk\Payment\V3\Enum\IntegrationModeEnum;
use Paygreen\Sdk\Payment\V3\Enum\PaymentModeEnum;
use Paygreen\Sdk\Payment\V3\Environment;
use Paygreen\Sdk\Payment\V3\Model\Address;
use Paygreen\Sdk\Payment\V3\Model\Buyer;
use Paygreen\Sdk\Payment\V3\Model\Instrument;
use Paygreen\Sdk\Payment\V3\Model\Listener;
use Paygreen\Sdk\Payment\V3\Model\PaymentOrder;

$curl = new Client();

$environment = new Environment(
    getenv('PG_PAYMENT_SHOP_ID'), //PG_PAYMENT_SHOP_ID SHOP_ID_MARKETPLACE
    getenv('PG_PAYMENT_SECRET_KEY'), //PG_PAYMENT_SECRET_KEY SECRET_KEY_MARKETPLACE
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

die();

//LIST AND UPDATE PC
//$response = $client->listPaymentConfig('shop_id');
//$pcs = json_decode($response->getBody()->getContents());
//
//if(count($pcs->data) > 0) {
//    foreach ($pcs->data as $pc) {
//        $updatePc = new \Paygreen\Sdk\Payment\V3\Model\PaymentConfig();
////    $updatePc->setStatus('enabled');
//        $updatePc->setConfig(['reuse_card_proposal' => true]);
//
//        $resp = $client->updatePaymentConfig($pc->id, $updatePc);
//        dump($resp->getStatusCode(), $resp->getBody()->getContents());
//    }
//}
//
//die();

//UPDATE SHOP
//$response = $client->updateShop(
//    $environment->getShopId(),
//    (new \Paygreen\Sdk\Payment\V3\Model\Shop())->setName('Nouveau Nom')
//);
//
//$jsonResponse = json_decode($response->getBody()->getContents());
//$data = $jsonResponse->data;
//
//dump($data); die();


// List Payment Order
//$filters = [
//    'reference' => 'Lorem ipsum'
//];
//$pagination = [
//    'max_per_page' => 19,
//    'page' => 2
//];
//
//$response = $client->listPaymentOrder(null, null, $filters, $pagination);
//
//$jsonResponse = json_decode($response->getBody()->getContents());
//$data = $jsonResponse->data;
//$pagination = $jsonResponse->pagination;
//
//
//dump($data,$pagination); die();

// List Buyer
//$filters = [
//    'email' => 'test@test.frsssqsq'
//];
//
//// pagination settings
//$pagination = [
//    'max_per_page' => 10,
//    'page' => 1
//];
//
//// call
//$response = $client->listBuyer($filters, $pagination);
//
//// response
//$jsonResponse = json_decode($response->getBody()->getContents());
//$data = $jsonResponse->data;
//$pagination = $jsonResponse->pagination;
//
//dump("count buyer:" . count($data));
//
//foreach ($data as $index => $buyer) {
//    $responsePC = $client->getBuyer($buyer->id);
//    dump($responsePC);
//    $jsonResponsePC = json_decode($responsePC->getBody()->getContents());
//    $dataPC = $jsonResponsePC->data;
//    dump($dataPC);
//    die();
//}
//die();

/*$response = $client->listTransaction();
dump($response);

$data = json_decode($response->getBody()->getContents())->data;
dump($data);*/


/*$response = $client->listPaymentOrder(null,"");
$data = json_decode($response->getBody()->getContents())->data;
dump($data);*/

//$listener = new Listener();
//$listener->setType('webhook');
//$listener->setEvents(["payment_order.authorized", "transaction.authorized"]);
//$listener->setUrl('http://localhost:80');
//
//
//$response = $client->createListener($listener);
//$data = json_decode($response->getBody()->getContents())->data;
//dump($response);

//$buyer = new Buyer();
//$buyer->setId(uniqid());
//$buyer->setFirstName('John');
//$buyer->setLastName('Doe');
//$buyer->setEmail('romain@paygreen.fr');
//$buyer->setCountryCode('FR');
//
//$address = new Address();
//$address->setStreetLineOne("107 allée Francois Mitterand");
//$address->setPostalCode("76100");
//$address->setState("Normandie");
//$address->setCity("Rouen");
//$address->setCountryCode("FR");
//
//$buyer->setBillingAddress($address);
//
//$response = $client->createBuyer($buyer);
//$data = json_decode($response->getBody()->getContents())->data;
//
//$buyer->setReference($data->id);
//try {
//    $response = $client->getBuyer($buyer);
//} catch (Exception $exeption) {
//    dump($exeption);
//}
//
//$data = json_decode($response->getBody()->getContents())->data;
////dump($data);
//
//$buyer->setFirstName('Jerry');
//$buyer->setLastName('Cane');
//$buyer->setEmail('dev-module@paygreen.fr');
//$buyer->setCountryCode('US');
//
//try {
//    $response = $client->updateBuyer($buyer);
//} catch (Exception $exeption) {
//    dump($exeption);
//}
//$data = json_decode($response->getBody()->getContents())->data;
////dump($data);
//
//$buyerNoreference = new Buyer();
//$buyerNoreference->setId(uniqid());
//$buyerNoreference->setFirstName('Will');
//$buyerNoreference->setLastName('Jackson');
//$buyerNoreference->setEmail('romain@paygreen.fr');
//$buyerNoreference->setCountryCode('FR');
//$buyerNoreference->setBillingAddress($address);
//
//$order = new Order();
//$order->setBuyer($buyerNoreference);
//$order->setReference('SDK-ORDER-123');
//$order->setAmount(407);
//$order->setCurrency('eur');
//$order->setShippingAddress($address);
//
//$paymentOrder = new PaymentOrder();
//$paymentOrder->setPaymentMode(ModeEnum::INSTANT);
//$paymentOrder->setIntegrationMode(IntegrationModeEnum::DIRECT);
//$paymentOrder->setOrder($order);
//$paymentOrder->setAutoCapture(true);
//$paymentOrder->setPlatforms(["bank_card"]);
//$paymentOrder->setMetadata(array('cart_id' => 'cart_1'));

// Order avec un buyer no reference
// $response = $client->createPaymentOrder($paymentOrder);
// $data = json_decode($response->getBody()->getContents())->data;
// dump($data);

// Order avec un buyer reference
/*$order->setBuyer($buyer);
$response = $client->createPaymentOrder($paymentOrder);
$data = json_decode($response->getBody()->getContents())->data;
dump($data);*/

//$order->setReference($data->id);
//$paymentOrder->setObjectSecret($data->object_secret);
//
//$poReference = $paymentOrder->getOrder()->getReference();
//$objectSecret = $paymentOrder->getObjectSecret();
//
//$response = $client->getPaymentOrder($poReference);
//$data = json_decode($response->getBody()->getContents())->data;
//dump($data);

/*$paymentOrder->setPartialAllowed(true);
$response = $client->updatePaymentOrder($paymentOrder);
$data = json_decode($response->getBody()->getContents())->data;
dump($data);*/

/*$instrument = new Instrument();
$instrument->setReference("ins_4961c47e6666497fb17d4e5af6268ac2");
$response = $client->deleteInstrument($instrument->getReference());
$data = json_decode($response->getBody()->getContents())->data;
dump($data);*/

/*$response = $client->capturePaymentOrder($poReference);
$data = json_decode($response->getBody()->getContents())->data;
dump($data);

$response = $client->getPaymentOrder($poReference);
$data = json_decode($response->getBody()->getContents())->data;
dump($data);


$response = $client->refundPaymentOrder("po_546db30ae2ec47769ef6de982c87b7b2");
$data = json_decode($response->getBody()->getContents())->data;
dump($data);*/


$body = '<html lang="fr">
  <head>
		 <title>MonMagasin - Paiement</title>
		 <script defer type="text/javascript" src="https://rc-pgjs.paygreen.dev/latest/paygreen.min.js"></script>
		 <link href="https://sb-pgjs.paygreen.fr/0.4/paygreen.min.css" type="text/css" rel="stylesheet" />
	</head>
  <body>
    <div class="container">
			<h1>Finaliser le paiement</h1>
			<span>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</span>
      
			<div id="paygreen-container"></div>
			<div id="paygreen-methods-container"></div>
			<div id="yourCustomDiv">
			  <div id="paygreen-pan-frame"></div>
			  <div id="paygreen-cvv-frame"></div>
			  <div id="paygreen-exp-frame"></div>
				<div id="paygreen-button-container"></div>
			</div>
    </div>
  </body>
	<script type="text/javascript">
    window.addEventListener("load", function () {
      paygreenjs.attachEventListener(
		    paygreenjs.Events.FULL_PAYMENT_DONE,
		    (event) => console.log("Payment success"),
		  );

      paygreenjs.attachEventListener(
		    paygreenjs.Events.REUSABLE_ALLOWED_CHANGE,
		    (event) => console.log(event.detail.reusable_allowed),
		  );
      paygreenjs.attachEventListener(
		    paygreenjs.Events.ERROR,
		    (event) => console.log(event.detail),
		  );
            ';
$body .= "paygreenjs.init({paymentOrderID: '{$poReference}',objectSecret: '{$objectSecret}',publicKey: 'pk_209242bedfcd40febc1c9ec8808ee3f4',mode: 'payment',});";
$body .= '});
  </script>
</html>';












echo $body;
