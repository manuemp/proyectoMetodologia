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

    //SELECCIONO LOS DATOS DEL CLIENTE Y EL ESTADO DE LA CANCHA DE SU RESERVA
    $resultado = mysqli_query($conexion, "SELECT R.id, R.dia, R.hora, R.cancha_id, 
                            U.nombre, U.apellido, U.email, 
                            R.asistio, R.precio, R.monto_seniado, R.dia_de_reserva,
                            C.estado
                            FROM reservas R 
                            JOIN usuarios U ON U.id = R.usuario_id
                            JOIN canchas C ON R.cancha_id = C.id
                            WHERE R.dia >= '$hoy' 
                            AND R.cancha_id LIKE '%$cancha%' 
                            AND U.email LIKE '%$email%' 
                            AND R.dia LIKE '%$dia%' 
                            ORDER BY R.dia, R.hora");
    $contador = mysqli_num_rows($resultado);

    $arr = [];
    while($fila = $resultado->fetch_assoc())
    {
        $obj = new stdClass();
        $obj->id = $fila["id"];
        $obj->dia = date("d/m/Y", strtotime($fila['dia']));
        $obj->hora = $fila['hora'];
        $obj->cancha = generarCancha($fila['cancha_id']);
        $obj->nombre = $fila['nombre'];
        $obj->apellido = $fila['apellido'];
        $obj->email = $fila['email'];
        $obj->precio = $fila['precio'];
        $obj->adelanto = $fila['monto_seniado'];
        $obj->dia_pedido = date("d/m/Y", strtotime($fila['dia_de_reserva']));
        $obj->estado_cancha = $fila["estado"];
        array_push($arr, $obj);
    }

    mysqli_close($conexion);
    echo json_encode($arr);
?>