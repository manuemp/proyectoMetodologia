<?php
  // session_start();

  require_once 'vendor/autoload.php';

    use MercadoPago\Client\Common\RequestOptions;
    use MercadoPago\Client\Payment\PaymentClient;
    use MercadoPago\Exceptions\MPApiException;
    use MercadoPago\MercadoPagoConfig;

    $respuesta = new StdClass();

    // Paso 2: Token de producción
    MercadoPagoConfig::setAccessToken("APP_USR-8736495117391111-061611-a56e4fa21163f64f8603ecc6ea392a34-115251485");
    // Paso 2.1 (opcional): setear el entorno con MercadoPagoConfig::RUNTIME_ENVIROMENTS. El default es SERVER
    // MercadoPagoConfig::setRuntimeEnviroment(MercadoPagoConfig::LOCAL);

    $array = json_decode(file_get_contents('php://input'));

    // Paso 3: Inicializar la API
    $client = new PaymentClient();

    try {
        // Paso 4: Crear el array del request
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
        // Paso 5: Crear las opciones del request, fijar el X-Idempotency-Key
        $request_options = new RequestOptions();
        $request_options->setCustomHeaders(["X-Idempotency-Key: <SOME_UNIQUE_VALUE>"]);

        // Paso 6: Hacer el request
        $payment = $client->create($request, $request_options);
        echo "ACEPTADO";

    // Paso 7: Manejar Excepciones
    } catch (MPApiException $e) {
      echo "RECHAZADO";
    } catch (\Exception $e) {
      echo "RECHAZADO";
    }
?>



