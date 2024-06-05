<?php session_start(); ?>
<?php 
    //PARA QUE ESTE ARCHIVO SE ACTIVE SE TIENE QUE CORROBORAR QUE EL ROL DE LA OTRA PERSONA SEA EL DE CLIENTE EN LA TABLA DE USUARIOS
    //Prohibir acceso si no se enviaron las variables del formulario

    $dni = $_SESSION['dni'];
    $id = $_SESSION['id'];
    include("./conexion.php");
    
    //usuarios: id, nombre, apelido, email, pass, rol
    //clientes: dni, id_usuario, faltas, racha, penalizacion, saldo_a_favor

    $consulta = mysqli_query($conexion, "INSERT INTO clientes (dni, id_usuario, faltas, racha, penalizacion, saldo_a_favor) VALUES ('$dni', '$id', 0, 0, 0, 0)");
    /*$consulta = mysqli_query($conexion, "UPDATE clientes c SET c.id_usuario = u.id from clientes 
                                        INNER JOIN usuarios u on c.dni = '$dni'");*/
    $consulta = mysqli_query($conexion, "SELECT dni, id_usuario, faltas, racha, penalizacion, saldo_a_favor FROM clientes WHERE dni='$dni'");
    $data = mysqli_fetch_assoc($consulta);

    //Asigno los valores a la sesion
    $_SESSION['faltas'] = $data['faltas'];
    $_SESSION['racha'] = $data['racha'];
    $_SESSION['penalizacion'] = $data['penalizacion'];
    $_SESSION['saldo_a_favor'] = $data['saldo_a_favor'];


    mysqli_free_result($consulta);
    mysqli_close($conexion);
?>