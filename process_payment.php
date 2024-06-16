<?php
  // session_start();

  require_once 'vendor/autoload.php';

    use MercadoPago\Client\Common\RequestOptions;
    use MercadoPago\Client\Payment\PaymentClient;
    use MercadoPago\Exceptions\MPApiException;
    use MercadoPago\MercadoPagoConfig;

    $respuesta = new StdClass();

    // Step 2: Set production or sandbox access token
    MercadoPagoConfig::setAccessToken("APP_USR-8736495117391111-061611-a56e4fa21163f64f8603ecc6ea392a34-115251485");
    // Step 2.1 (optional - default is SERVER): Set your runtime enviroment from MercadoPagoConfig::RUNTIME_ENVIROMENTS
    // In case you want to test in your local machine first, set runtime enviroment to LOCAL
    // MercadoPagoConfig::setRuntimeEnviroment(MercadoPagoConfig::LOCAL);

    $array = json_decode(file_get_contents('php://input'));
    //echo '<pre>'.print_r($array, true).'</pre>';
    // var_dump($array);
    // echo $array->token;
    // echo "\n";
    // echo $array->payment_method_id;
    // echo "\n";
    // echo $array->payer->identification->type;
    // echo "\n";
    // echo $array->payer->identification->number;
    // echo "\n\n";

    // Step 3: Initialize the API client
    $client = new PaymentClient();

    try {
        // Step 4: Create the request array
        $request = [
            "transaction_amount" => 100.00,
            "token" => $array->token,
            "description" => "Seña de cancha en TorinoFutbol",
            "installments" => 1,
            "issuer_id" => $array->issuer_id,
            "payment_method_id" => $array->payment_method_id,
            "payer" => [
                "email" => $array->payer->email,
                "identification" => [
                  "type" => $array->payer->identification->type,
                  "number" => $array->payer->identification->number
              ]
            ]
        ];
        // Step 5: Create the request options, setting X-Idempotency-Key
        $request_options = new RequestOptions();
        $request_options->setCustomHeaders(["X-Idempotency-Key: <SOME_UNIQUE_VALUE>"]);

        // Step 6: Make the request
        $payment = $client->create($request, $request_options);
        // $respuesta->estado = "ACEPTADO";
        // echo json_encode($res);
        echo "ACEPTADO";
        // echo $payment->id;

    // Step 7: Handle exceptions
    } catch (MPApiException $e) {
      echo "RECHAZADO";
      // $respuesta->estado = "RECHAZADO";
      // echo json_encode($res);
        // echo "Status code: " . $e->getApiResponse()->getStatusCode() . "\n";
        // echo "Content: ";
        // var_dump($e->getApiResponse()->getContent());
        // echo "\n";
    } catch (\Exception $e) {
      echo "RECHAZADO";
      // $respuesta->estado = "RECHAZADO";
      // echo json_encode($res);
        // echo $e->getMessage();
    }
?>



