<?php 
    if(!isset($_SESSION["nombre"]))
    {
        header("Location:index.php");
    }

    try
    {
        $email = $_SESSION["email"];

        include("./conexion.php");

        $consulta = mysqli_query($conexion, "SELECT * FROM usuarios WHERE email = '$email'");
    
        $fila = $consulta->fetch_assoc();
        $_SESSION["faltas"] = $fila["faltas"];
        $_SESSION["racha"] = $fila["racha"];

        mysqli_free_result($consulta);
        mysqli_close($conexion);
    }
    catch(Exception $e)
    {
        echo "Hubo un problema con la consulta a la Base de Datos";
    }
?>