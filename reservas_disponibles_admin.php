<?php 
    //Prohibo acceso si no se envió el form
    if(!(isset($_POST["filtro_cancha"]) && isset($_POST["filtro_dia"]) && isset($_POST["filtro_email"])  )){
        header("Location:index.php");
    }

    include("./conexion.php");

    include("./generar_cancha.php");

    date_default_timezone_set("America/Argentina/Buenos_Aires");
    $hoy = date('Y-m-d');

    $cancha = $_POST["filtro_cancha"];
    $dia = $_POST["filtro_dia"];
    $email = $_POST["filtro_email"];

    $resultado = mysqli_query($conexion, "SELECT id, dia, hora, cancha, nombre, apellido, email, asistio, precio, monto_seniado, dia_de_reserva FROM reservas WHERE dia >= '$hoy' AND cancha LIKE '%$cancha%' AND email LIKE '%$email%' AND dia LIKE '%$dia%' AND asistio = 1 ORDER BY dia, hora");
    $contador = mysqli_num_rows($resultado);
    
    $arr = [];
    while($fila = $resultado->fetch_assoc())
    {
        $obj = new stdClass();
        $obj->id = $fila["id"];
        $obj->dia = date("d/m/Y", strtotime($fila['dia']));
        $obj->hora = $fila['hora'];
        $obj->cancha = generarCancha($fila['cancha']);
        $obj->nombre = $fila['nombre'];
        $obj->apellido = $fila['apellido'];
        $obj->email = $fila['email'];
        $obj->precio = $fila['precio'];
        $obj->adelanto = $fila['monto_seniado'];
        $obj->dia_pedido = date("d/m/Y", strtotime($fila['dia_de_reserva']));
        array_push($arr, $obj);
    }

    mysqli_close($conexion);
    
    echo json_encode($arr);
?>