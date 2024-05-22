<?php 
    if(!isset($_SESSION["Nombre"]))
    {
        header("Location:index.php");
    }

    try
    {
        $email = $_SESSION["Email"];

        include("./conexion.php");

        $consulta = mysqli_query($conexion, "SELECT * FROM Usuarios WHERE Email = '$email'");
    
        $fila = $consulta->fetch_assoc();
        $_SESSION["Faltas"] = $fila["Faltas"];
        $_SESSION["Racha"] = $fila["Racha"];

        mysqli_free_result($consulta);
        mysqli_close($conexion);
    }
    catch(Exception $e)
    {
        echo "Hubo un problema con la consulta a la Base de Datos";
    }
?>