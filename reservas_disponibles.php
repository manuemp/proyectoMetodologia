<?php 
    include("./conexion.php");

    //Con este script busco todas las reservas ocupadas para evitar mostrar horarios que fueron
    //reservados en la página de reserva. Los select irán variando según la información que obtenga
    //con este script.
    $resultado = mysqli_query($conexion, "SELECT dia, hora, cancha, nombre, apellido, email, asistio, precio, monto_seniado FROM reservas");
    $contador = mysqli_num_rows($resultado);
    
    $arr = [];
    while($fila = $resultado->fetch_assoc())
    {
        $obj = new stdClass();
        $obj->dia = $fila['dia'];
        $obj->hora = $fila['hora'];
        $obj->cancha = $fila['cancha'];
        $obj->nombre = $fila['nombre'];
        $obj->apellido = $fila['apellido'];
        $obj->email = $fila['email'];
        $obj->asistio = $fila['asistio'];
        $obj->precio = $fila['precio'];
        $obj->adelanto = $fila['monto_seniado'];
        array_push($arr, $obj);
    }

    mysqli_free_result($resultado);
    mysqli_close($conexion);
    
    echo json_encode($arr);
?>