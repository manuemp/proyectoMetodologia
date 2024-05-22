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

    $resultado = mysqli_query($conexion, "SELECT ID, Dia, Hora, Cancha, Nombre, Apellido, Email, Asistio, Precio, Adelanto, Dia_Pedido FROM Reservas WHERE Dia >= '$hoy' AND Cancha LIKE '%$cancha%' AND Email LIKE '%$email%' AND Dia LIKE '%$dia%' AND Asistio = 1 ORDER BY Dia, Hora");
    $contador = mysqli_num_rows($resultado);
    
    $arr = [];
    while($fila = $resultado->fetch_assoc())
    {
        $obj = new stdClass();
        $obj->id = $fila["ID"];
        $obj->dia = date("d/m/Y", strtotime($fila['Dia']));
        $obj->hora = $fila['Hora'];
        $obj->cancha = generarCancha($fila['Cancha']);
        $obj->nombre = $fila['Nombre'];
        $obj->apellido = $fila['Apellido'];
        $obj->email = $fila['Email'];
        $obj->precio = $fila['Precio'];
        $obj->adelanto = $fila['Adelanto'];
        $obj->dia_pedido = date("d/m/Y", strtotime($fila['Dia_Pedido']));
        array_push($arr, $obj);
    }

    mysqli_close($conexion);
    
    echo json_encode($arr);
?>