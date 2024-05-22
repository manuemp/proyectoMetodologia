<?php 
    include("./conexion.php");
    // $resultado = mysqli_query($conexion, "SELECT ID, Nombre, Apellido, Email, Reservas, Faltas, Nivel FROM Usuarios ORDER BY Nombre");
    
    $email = $_POST["email"];
    $resultado = mysqli_query($conexion, "SELECT ID, Nombre, Apellido, Email, Faltas, Racha FROM Usuarios WHERE Email = '$email'");

    $arr = [];
    while($fila = $resultado->fetch_assoc())
    {
        $obj = new stdClass();
        $obj->id = $fila['ID'];
        $obj->nombre = $fila['Nombre'];
        $obj->apellido = $fila['Apellido'];
        $obj->email = $fila['Email'];
        $obj->faltas = $fila['Faltas'];
        $obj->racha = $fila['Racha'];
        array_push($arr, $obj);
    }

    mysqli_free_result($resultado);
    mysqli_close($conexion);
    
    echo json_encode($arr);
?>