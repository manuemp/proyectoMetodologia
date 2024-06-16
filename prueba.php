<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>
<script>

    async function logMovies() {
        const response = await fetch("http://localhost:8082/proyectoCancha/proyecto/pruebafetch.php");
        const movies = await response.json();
        console.log(movies);
    }

    logMovies();



</script>

<?php
  // session_start();

  // if(isset($_POST['payment_method_id'])){
  //   header("Location:index.php");
  // }

  // echo "POST\n";
  // foreach ($_POST as $key => $value) {
  //   echo "Field ".htmlspecialchars($key)." is ".htmlspecialchars($value)."<br>";
  // }
  

  

  require_once 'vendor/autoload.php';

  use MercadoPago\Client\Common\RequestOptions;
  use MercadoPago\Client\Payment\PaymentClient;
  use MercadoPago\Exceptions\MPApiException;
  use MercadoPago\MercadoPagoConfig;

  // Step 2: Set production or sandbox access token
  MercadoPagoConfig::setAccessToken("APP_USR-2454211397602545-012810-f4969b3234161813c5c29e657c0ccfac-115251485");
  // Step 2.1 (optional - default is SERVER): Set your runtime enviroment from MercadoPagoConfig::RUNTIME_ENVIROMENTS
  // In case you want to test in your local machine first, set runtime enviroment to LOCAL
  // MercadoPagoConfig::setRuntimeEnviroment(MercadoPagoConfig::LOCAL);

  // Step 3: Initialize the API client
  $client = new PaymentClient();

  // echo "DEBUG\n";
  $array = json_decode(file_get_contents('php://input'));
  //echo '<pre>'.print_r($array, true).'</pre>';
  //echo $array;
  // var_dump($array);
  //echo $array->token;
  // echo $array->payment_method_id;
  // echo "\n\n";
  try {

      // Step 4: Create the request array
      $request = [
          "transaction_amount" => 100,
          "token" => $array->token,
          "description" => "Seña de cancha en TorinoFutbol",
          "installments" => 1,
          "payment_method_id" => $array->payment_method_id,
          "payer" => [
              "email" => $array->payer->email,
          ]
      ];

      // Step 5: Create the request options, setting X-Idempotency-Key
      $request_options = new RequestOptions();
      $request_options->setCustomHeaders(["X-Idempotency-Key: <SOME_UNIQUE_VALUE>"]);

      // Step 6: Make the request
      $payment = $client->create($request, $request_options);
      echo $payment->id;

  // Step 7: Handle exceptions
  } catch (MPApiException $e) {
      echo "Status code: " . $e->getApiResponse()->getStatusCode() . "\n";
      echo "Content: ";
      var_dump($e->getApiResponse()->getContent());
      echo "\n";
  } catch (\Exception $e) {
      echo $e->getMessage();
  }

  // require_once 'vendor/autoload.php';
  // use MercadoPago\Client\Common\RequestOptions;
  // use MercadoPago\Client\Payment\PaymentClient;
  // use MercadoPago\MercadoPagoConfig;


  // MercadoPagoConfig::setAccessToken("APP_USR-8736495117391111-061611-a56e4fa21163f64f8603ecc6ea392a34-115251485");

  // $client = new PaymentClient();
  // $request_options = new RequestOptions();
  // $request_options->setCustomHeaders(["X-Idempotency-Key: A48hfjce9Sxxs90Lc8879kl0009ksdj"]);

  // $payment = $client->create([
  //   "transaction_amount" => (float) 100,
  //   "token" => $_POST['token'],
  //   "description" => "Reserva de cancha en TorinoFutbol",
  //   "installments" => 1,
  //   "payment_method_id" => $_POST['paymentMethodId'],
  //   "issuer_id" => $_POST['issuerId'],
  //   "payer" => [
  //     "email" => $_POST['cardholderEmail'],
  //     "identification" => [
  //       "type" => $_POST['identificationType'],
  //       "number" => $_POST['identificationNumber']
  //     ]
  //   ]
  // ], $request_options);
  // echo implode($payment);
?>
