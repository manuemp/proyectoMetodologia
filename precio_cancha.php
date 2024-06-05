<?php session_start(); ?>
<?php
    if(!isset($_POST["cancha_id"]))
    {
        header("Location:index.php");
    }
    
    $cancha = intval($_POST["cancha_id"]);
    $email = $_SESSION["email"];
    //Sirve para contar la cantidad de reservas que faltan para volver
    //a aplicar los beneficios
    $beneficio;

    //Hora para verificar el horario de la noche y así aumentar el precio
    $hora = $_POST["hora"];
    
    include("./conexion.php");
    

    /*COMENTAR LA LINEA DE ABAJO DE ESTA PARA REALIZAR PRUEBAS CON LA RACHA Y DESCOMENTAR ESTA
    $reservas = mysqli_query($conexion, "SELECT racha, penalizacion
                            FROM clientes C");*/

    $reservas = mysqli_query($conexion, "SELECT COUNT(*) racha, penalizacion
                            FROM clientes C
                            JOIN reservas R on C.id_usuario = R.usuario_id");
    $fila = mysqli_fetch_assoc($reservas);

    //FIJARSE SI ES DE NOCHE, AUMENTAR EL PRECIO DE LA CANCHA EN UN 20%    

    if(intval($fila["penalizacion"]) != 0){
        $beneficio = 1;
        //ACTUALIZAR EL CAMPO QUE SIRVE COMO CONTADOR RESTANDOLE 1
    }
    else if(intval($fila["racha"]) >= 20)
    {
        $beneficio = 0.85;
    }
    else if(intval($fila["racha"]) >= 10)
    {
        $beneficio = 0.9;
    }
    else
    {
        $beneficio = 1;
    }

    $beneficio_temp = $beneficio;

    //Verificar el tema del beneficio, no da el precio justo pero da uno cercano a la hora de tener un horario a la noche con beneficio
    if($hora == "20:00:00" || $hora == "21:00:00" || $hora == "22:00:00"){
        $beneficio = $beneficio + 0.2;
    }
    else{
        $beneficio = $beneficio_temp;
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