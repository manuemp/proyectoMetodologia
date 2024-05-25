<?php 
    include("./conexion.php");

    //Con este script busco todas las reservas ocupadas para evitar mostrar horarios que fueron
    //reservados en la página de reserva. Los select irán variando según la información que obtenga
    //con este script.
    $resultado = mysqli_query($conexion, "SELECT asistio, dia, hora, cancha_id, usuario_id, precio, monto_seniado FROM reservas");
    $contador = mysqli_num_rows($resultado);
    
    $arr = [];
    while($fila = $resultado->fetch_assoc())
    {
        $obj = new stdClass();
        //$obj->id = $fila['id'];
        $obj->dia = $fila['dia'];
        //$obj->dia_de_reserva = $fila['dia_de_reserva'];
        $obj->hora = $fila['hora'];
        $obj->cancha = $fila['cancha_id'];
        $obj->usuario = $fila['usuario_id'];
        $obj->asistio = $fila['asistio'];
        $obj->precio = $fila['precio'];
        $obj->monto_seniado = $fila['monto_seniado'];
        array_push($arr, $obj);
    }

    mysqli_free_result($resultado);
    mysqli_close($conexion);
    
    echo json_encode($arr);
?>