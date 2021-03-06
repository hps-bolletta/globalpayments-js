<!DOCTYPE html>
<?php $deviceId = '88700000322602'; ?>
<?php $createManifest = require('create-manifest.php'); ?>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=no">
    <title>TransIT Examples</title>
  </head>
  <body>
    <h1>Examples</h1>

    <h2>Credit Card Form</h2>

    <form id="form" action="/charge" method="get">
      <div id="cardNumber"></div>
      <div id="cardCvv"></div>
      <div id="cardExpiration"></div>
      <div id="cardHolder"></div>
      <div id="cardSubmit"></div>
    </form>

    <h2>PaymentRequest API</h2>

    <div>
      <button type="button" id="paymentRequestPlainButton" style="display: none">Pay</button>
    </div>

    <script src="/dist/globalpayments.js"></script>
    <script>
      GlobalPayments.configure({
        deviceId: '<?= $deviceId ?>',
        manifest: '<?= $createManifest() ?>',
        env: 'sandbox',
      });

      GlobalPayments.on("error", function (error) {
        console.error(error);
      });

      var cardForm = GlobalPayments.ui.form({
        fields: {
          "card-number": {
            placeholder: "•••• •••• •••• ••••",
            target: "#cardNumber"
          },
          "card-expiration": {
            placeholder: "MM / YYYY",
            target: "#cardExpiration"
          },
          "card-cvv": {
            placeholder: "•••",
            target: "#cardCvv"
          },
          "submit": {
            value: "Submit",
            target: "#cardSubmit"
          }
        }
      });

      cardForm.on("card-number", "token-success", function (resp) { console.log(resp); });
      cardForm.on("card-number", "token-error", function (resp) { console.log(resp); });

      var paymentRequestForm = GlobalPayments.paymentRequest.setup("#paymentRequestPlainButton", {
        total: {
          label: "Total",
          amount: { value: 10, currency: "USD" }
        }
      });

      paymentRequestForm.on("token-success", function (resp) {
        console.log(resp);
        GlobalPayments.paymentRequest.complete("success");
      });
      paymentRequestForm.on("token-error", function (resp) { console.log(resp); });
      paymentRequestForm.on("error", function (resp) { console.log(resp); });
    </script>
  </body>
</html>
