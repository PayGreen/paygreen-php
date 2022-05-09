## How to integrate a payment frame:

Find the pgjs documentation [here](https://paygreen.notion.site/Paygreen-JS-Documentation-0-5-0-e48d9ef6ca0d468a8a410693f2d854a8).

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <title>MonMagasin - Paiement</title>
    <script defer type="text/javascript" src="https://sb-pgjs.paygreen.fr/latest/paygreen.min.js"></script>
    <link href="https://sb-pgjs.paygreen.fr/latest/paygreen.min.css" type="text/css" rel="stylesheet" />
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

        paygreenjs.init({
            paymentOrderID: "po_xxxxxxxxxxxxxxxxxxx",
            objectSecret: "xxxxxxxxxxxx",
            publicKey: "pk_xxxxxxxxxxx",
            mode: "payment",
        });
    });
</script>
</html>
```