<?php 
    include("./conexion.php");
    // $resultado = mysqli_query($conexion, "SELECT ID, Nombre, Apellido, Email, Reservas, Faltas, Nivel FROM Usuarios ORDER BY Nombre");
    
    $email = $_POST["email"];
    $resultado = mysqli_query($conexion, "SELECT id, nombre, apellido, email, faltas, racha FROM usuarios WHERE email = '$email'");

    $arr = [];
    while($fila = $resultado->fetch_assoc())
    {
        $obj = new stdClass();
        $obj->id = $fila['id'];
        $obj->nombre = $fila['nombre'];
        $obj->apellido = $fila['apellido'];
        $obj->email = $fila['email'];
        $obj->faltas = $fila['faltas'];
        $obj->racha = $fila['racha'];
        array_push($arr, $obj);
    }

    mysqli_free_result($resultado);
    mysqli_close($conexion);
    
    echo json_encode($arr);
?>