<?php

    if(!(isset($_POST["email"]) && isset($_POST["pass"])))
    {
        header("Location:index.php");
    }
    
    $email = $_POST['email'];
    $pass = sha1($_POST['pass']);

    include("./conexion.php");

    $consulta = mysqli_query($conexion, "SELECT Nombre, Apellido, Email, Faltas, Racha, Administrador 
                                         FROM Usuarios WHERE Email='$email' AND Pass='$pass'");

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
        $_SESSION['Nombre'] = $data['Nombre'];
        $_SESSION['Apellido'] = $data['Apellido'];
        $_SESSION['Email'] = $data['Email'];
        $_SESSION['Faltas'] = $data['Faltas'];
        $_SESSION['Racha'] = $data['Racha'];
        $_SESSION['Administrador'] = $data['Administrador'];

        mysqli_free_result($consulta);
        mysqli_close($conexion);

        if(intval($_SESSION['Administrador']) == 1)
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