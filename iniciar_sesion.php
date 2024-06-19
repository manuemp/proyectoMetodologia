<?php

    if(!(isset($_POST["email"]) && isset($_POST["pass"])))
    {
        header("Location:index.php");
    }
    
    $email = $_POST['email'];
    $pass = sha1($_POST['pass']);

    include("./conexion.php");

    //usuarios: id, nombre, apelido, email, pass, rol
    //clientes: dni, id_usuario, faltas, racha, penalizacion, saldo_a_favor

    $consulta_inicio_sesion = mysqli_query($conexion, "SELECT id, nombre, apellido, email, rol FROM usuarios WHERE email='$email' AND pass='$pass'");
    $resultado_inicio_sesion = mysqli_num_rows($consulta_inicio_sesion);
    $datos_generales_usuario = mysqli_fetch_assoc($consulta_inicio_sesion);
    $usuario_id = intval($datos_generales_usuario["id"]);
    $consulta_datos_cliente = mysqli_query($conexion, "SELECT dni, id_usuario, faltas, racha, penalizacion, saldo_a_favor
                                                       FROM clientes WHERE id_usuario = $usuario_id");
    $datos_cliente = mysqli_fetch_array($consulta_datos_cliente);
    $racha = intval($datos_cliente["racha"]);

    if($resultado_inicio_sesion == 0){
        echo "<span id='modal_background' style='display:block';></span>";
        include("./modal_fail.php");
        include("./index.php");
    }
    else
    {
        session_start();
        include("consultar_nivel.php");

        $_SESSION['id'] = $datos_generales_usuario['id'];
        $_SESSION['nombre'] = $datos_generales_usuario['nombre'];
        $_SESSION['apellido'] = $datos_generales_usuario['apellido'];
        $_SESSION['email'] = $datos_generales_usuario['email'];
        $_SESSION['faltas'] = $datos_cliente['faltas'];
        $_SESSION['racha'] = $datos_cliente['racha'];
        $_SESSION['rol'] = $datos_generales_usuario['rol'];
        $_SESSION['saldo_a_favor'] = $datos_cliente['saldo_a_favor'];
        $_SESSION['dni'] = $datos_cliente['dni'];
        $_SESSION['penalizacion'] = $datos_cliente['penalizacion'];
        $_SESSION['nivel'] = $nivel['nombre'];

        mysqli_free_result($consulta_inicio_sesion);
        mysqli_free_result($consulta_datos_cliente);
        mysqli_close($conexion);

        if(intval($_SESSION['rol']) == 1)
        {
            header("Location:admin_canchas.php");
            exit;
        }
        else if (intval($_SESSION['rol']) == 2){
            header("Location:admin_reservas.php");
            exit;
        }
        else
        {
            header("Location:index.php");
        }

    }   

?>