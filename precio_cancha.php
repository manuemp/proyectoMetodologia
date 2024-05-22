<?php session_start(); ?>
<?php

    if(!isset($_POST["id_cancha"]))
    {
        header("Location:index.php");
    }
    
    $cancha = intval($_POST["id_cancha"]);
    $email = $_SESSION["Email"];
    $beneficio;
    
    include("./conexion.php");
    
    $reservas = mysqli_query($conexion, "SELECT COUNT(1) AS 'Contador' FROM Reservas WHERE Email = '$email'");
    $fila = mysqli_fetch_assoc($reservas);

    if(intval($fila["Contador"]) >= 60)
    {
        $beneficio = 0.85;
    }
    else if(intval($fila["Contador"]) >= 25)
    {
        $beneficio = 0.9;
    }
    else
    {
        $beneficio = 1;
    }

    $consulta = mysqli_query($conexion, "SELECT Precio FROM Canchas WHERE ID = $cancha");
    $fila = mysqli_fetch_assoc($consulta);

    //Como la función que va a formatear a moneda el resultado está en el front,
    //tengo que separar el string en dos partes, una con el precio y otra con el descuento
    //porque si devolviera todo en un único string sería imposible formatear.
    //La función de formateo de php está deprecada, por eso uso la de JS.
    $respuesta = new stdClass();
    $respuesta->precio = intval($fila["Precio"]) * $beneficio;
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