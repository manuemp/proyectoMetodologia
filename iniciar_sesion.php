<?php

    if(!(isset($_POST["email"]) && isset($_POST["pass"])))
    {
        header("Location:index.php");
    }
    
    $email = $_POST['email'];
    $pass = sha1($_POST['pass']);

    include("./conexion.php");

    $consulta = mysqli_query($conexion, "SELECT id, nombre, apellido, email, faltas, racha, rol, saldo_a_favor, telefono, dni FROM usuarios WHERE email='$email' AND pass='$pass'");

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
        $_SESSION['telefono'] = $data['telefono'];
        $_SESSION['dni'] = $data['dni'];

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