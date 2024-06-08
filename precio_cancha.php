<?php session_start(); ?>
<?php
    if(!isset($_POST["cancha_id"]))
    {
        header("Location:index.php");
    }
    
    $cancha_id = intval($_POST["cancha_id"]);
    $email = $_SESSION["email"];
    //Sirve para contar la cantidad de reservas que faltan para volver
    //a aplicar los beneficios
    $beneficio;

    //Hora para verificar el horario de la noche y así aumentar el precio
    $hora = $_POST["hora"];
    
    include("./conexion.php");

    $query_reservas_cliente = mysqli_query($conexion, "SELECT COUNT(*) racha, penalizacion
                            FROM clientes C
                            JOIN reservas R on C.id_usuario = R.usuario_id");
    $reservas_cliente = mysqli_fetch_assoc($query_reservas_cliente);
    $racha = intval($reservas_cliente["racha"]);

    //ACA BUSCO EL NIVEL
    $query_nivel_usuario = mysqli_query($conexion, "SELECT DISTINCT N.id, N.cantidad_reservas, N.descuento, N.nombre FROM niveles N, niveles M 
                                              WHERE M.cantidad_reservas >= N.cantidad_reservas 
                                              AND $racha BETWEEN N.cantidad_reservas AND M.cantidad_reservas + N.cantidad_reservas 
                                              ORDER BY N.id DESC 
                                              LIMIT 1");
    $nivel = mysqli_fetch_assoc($query_nivel_usuario);
    
    //Necesito saber si está en el nivel correspondiente. Debe tener más que ese nivel y menos que el siguiente.


    //FIJARSE SI ES DE NOCHE, AUMENTAR EL PRECIO DE LA CANCHA EN UN 20%    
    if(intval($reservas_cliente["penalizacion"]) != 0){
        $beneficio = 0;
        //ACTUALIZAR EL CAMPO QUE SIRVE COMO CONTADOR RESTANDOLE 1
    }
    else{
        $beneficio = floatval($nivel["descuento"]);
    }

    $query_canchas = mysqli_query($conexion, "SELECT precio FROM canchas WHERE id = $cancha_id");
    $cancha = mysqli_fetch_assoc($query_canchas);
    $precio = intval($cancha["precio"]);

    if($hora == "20:00:00" || $hora == "21:00:00" || $hora == "22:00:00"){
        $precio += $precio * 0.2;
    }

    //Como la función que va a formatear a moneda el resultado está en el front,
    //tengo que separar el string en dos partes, una con el precio y otra con el descuento
    //porque si devolviera todo en un único string sería imposible formatear.
    //La función de formateo de php está deprecada, por eso uso la de JS.
    $respuesta = new stdClass();
    $respuesta->precio = $precio * (1 - $beneficio);
    if($beneficio == 0.15)
        $respuesta->beneficio = "15% off";
    else if($beneficio == 0.20)
        $respuesta->beneficio = "20% off";
    else
        $respuesta->beneficio = "";

    mysqli_free_result($query_canchas);
    mysqli_free_result($query_nivel_usuario);
    mysqli_free_result($query_reservas_cliente);
    mysqli_close($conexion);
    echo json_encode($respuesta);
    

?>