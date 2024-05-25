<?php session_start(); ?>
<?php

    if(!isset($_POST["cancha_id"]))
    {
        header("Location:index.php");
    }
    
    $cancha = intval($_POST["cancha_id"]);
    $email = $_SESSION["email"];
    $beneficio;
    
    include("./conexion.php");
    
    $reservas = mysqli_query($conexion, "SELECT COUNT(1) AS 'contador' 
                                         FROM reservas R
                                         JOIN usuarios U on U.id = R.usuario_id
                                         WHERE U.email = '$email'");
    $fila = mysqli_fetch_assoc($reservas);

    //FIJARSE SI ES DE NOCHE, AUMENTAR EL PRECIO DE LA CANCHA EN UN 20%

    if(intval($fila["contador"]) >= 60)
    {
        $beneficio = 0.85;
    }
    else if(intval($fila["contador"]) >= 25)
    {
        $beneficio = 0.9;
    }
    else
    {
        $beneficio = 1;
    }

    $consulta = mysqli_query($conexion, "SELECT precio FROM canchas WHERE id = $cancha");
    $fila = mysqli_fetch_assoc($consulta);

    //Como la función que va a formatear a moneda el resultado está en el front,
    //tengo que separar el string en dos partes, una con el precio y otra con el descuento
    //porque si devolviera todo en un único string sería imposible formatear.
    //La función de formateo de php está deprecada, por eso uso la de JS.
    $respuesta = new stdClass();
    $respuesta->precio = intval($fila["precio"]) * $beneficio;
    if($beneficio == 0.85)
        $respuesta->beneficio = "15% off";
    else if($beneficio == 0.9)
        $respuesta->beneficio = "10% off";
    else
        $respuesta->beneficio = "";

    mysqli_free_result($consulta);
    mysqli_close($conexion);

    echo json_encode($respuesta);
    

?>