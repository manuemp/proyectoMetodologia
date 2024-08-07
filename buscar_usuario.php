<?php 
    include("./conexion.php");
    
    $email = $_POST["email"];


    $resultado = mysqli_query($conexion, "SELECT U.id, U.nombre, U.apellido, U.email, C.faltas, C.racha 
                                          FROM usuarios U
                                          JOIN clientes C ON C.id_usuario = U.id
                                          WHERE U.email = '$email'");

    //Genero el JSON con los datos del usuario
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