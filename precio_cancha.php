<?php session_start(); ?>
<?php
    if(!isset($_POST["cancha_id"])) header("Location:index.php");

    $cancha_id = intval($_POST["cancha_id"]);
    $email = $_SESSION["email"];
    $beneficio;
    //GUARDO LA HORA PARA VERIFICAR SI ES DE NOCHE Y AUMENTAR EL PRECIO
    $hora = $_POST["hora"];
    $id_usuario = $_SESSION["id"];
    
    include("./conexion.php");

    //BUSCO EL TOTAL DE LAS RACHAS DEL USUARIO PARA DETERMINAR EL BENEFICIO
    //BUSCO TAMBIEN SU PENALIZACION, LA CUAL DE EXISTIR ANULA EL BENEFICIO
    $query_reservas_cliente = mysqli_query($conexion, "SELECT COUNT(*) racha, penalizacion
                            FROM clientes C
                            JOIN reservas R on C.id_usuario = R.usuario_id
                            AND R.usuario_id = $id_usuario");
    $reservas_cliente = mysqli_fetch_assoc($query_reservas_cliente);
    $racha = intval($reservas_cliente["racha"]);

    //ACA BUSCO EL NIVEL DEL USUARIO
    $query_nivel_usuario = mysqli_query($conexion, "SELECT DISTINCT N.id, N.cantidad_reservas, N.descuento, N.nombre FROM niveles N, niveles M 
                                              WHERE M.cantidad_reservas >= N.cantidad_reservas 
                                              AND $racha BETWEEN N.cantidad_reservas AND M.cantidad_reservas + N.cantidad_reservas 
                                              ORDER BY N.id DESC 
                                              LIMIT 1");
    $nivel = mysqli_fetch_assoc($query_nivel_usuario);

    //FIJARSE SI ES DE NOCHE, AUMENTAR EL PRECIO DE LA CANCHA EN UN 20%    
    if(intval($reservas_cliente["penalizacion"]) != 0){
        $beneficio = 0;
        //ACTUALIZAR EL CAMPO QUE SIRVE COMO CONTADOR RESTANDOLE 1
    }
    else $beneficio = floatval($nivel["descuento"]);

    //BUSCO LA CANCHA PARA OBTENER EL PRECIO
    $query_canchas = mysqli_query($conexion, "SELECT precio FROM canchas WHERE id = $cancha_id");
    $cancha = mysqli_fetch_assoc($query_canchas);
    $precio = doubleval($cancha["precio"]);
    //ANALIZO SI ES DE NOCHE
    if($hora == "20:00:00" || $hora == "21:00:00" || $hora == "22:00:00"){
        $precio += $precio * 0.2;
    }

    //APLICO EL BENEFICIO AL PRECIO
    $precio = $precio * (1 - $beneficio);
    //COMPROBAR QUE HAYA UN VALE
    $query_saldo_a_favor = mysqli_query($conexion, "SELECT saldo_a_favor FROM clientes WHERE id_usuario = $id_usuario");
    $cliente = mysqli_fetch_assoc($query_saldo_a_favor);
    $saldo = doubleval($cliente["saldo_a_favor"]);

    if($saldo == $precio || $saldo > $precio){
        $precio_final = 0;
    }else{
        $precio_final = $precio - $saldo;
    }

    //CREO EL OBJETO JSON CON LOS DATOS DE LA RESERVA
    $respuesta = new stdClass();
    $respuesta->precio = $precio;
    if($beneficio == 0.15) $respuesta->beneficio = "15% off";
    else if($beneficio == 0.25) $respuesta->beneficio = "25% off";
    else $respuesta->beneficio = "";
    $respuesta->saldo_a_favor = $_SESSION["saldo_a_favor"];
    $respuesta->precio_final = $precio_final;

    mysqli_free_result($query_canchas);
    mysqli_free_result($query_nivel_usuario);
    mysqli_free_result($query_reservas_cliente);
    mysqli_close($conexion);
    echo json_encode($respuesta);
?>