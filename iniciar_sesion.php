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

    $consulta = mysqli_query($conexion, "SELECT U.id, U.nombre, U.apellido, U.email, C.faltas, C.racha, U.rol, C.saldo_a_favor, C.dni FROM usuarios U
                                        INNER JOIN clientes C ON U.email='$email' AND U.pass='$pass'");

    $resultado = mysqli_num_rows($consulta);
    $data = mysqli_fetch_array($consulta);

    if($resultado == 0)
    {
        echo "<span id='modal_background' style='display:block';></span>";
        include("./modal_fail.php");
        include("./index.php");
    }
    else
    {
        session_start();
        $_SESSION['id'] = $data['id'];
        $_SESSION['nombre'] = $data['nombre'];
        $_SESSION['apellido'] = $data['apellido'];
        $_SESSION['email'] = $data['email'];
        $_SESSION['faltas'] = $data['faltas'];
        $_SESSION['racha'] = $data['racha'];
        $_SESSION['rol'] = $data['rol'];
        $_SESSION['saldo_a_favor'] = $data['saldo_a_favor'];
        $_SESSION['dni'] = $data['dni'];
        $_SESSION['penalizacion'] = $data['penalizacion'];

        mysqli_free_result($consulta);
        mysqli_close($conexion);

        if(intval($_SESSION['rol']) == 1)
        {
            header("Location:admin_reservas.php");
            exit;
        }
        else
        {
            header("Location:index.php");
        }

    }   

?>