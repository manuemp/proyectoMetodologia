<?php 
    if(!isset($_SESSION["nombre"]))
    {
        header("Location:index.php");
    }
    try
    {
        $dni = $_SESSION["dni"];

        include("./conexion.php");
        $consulta = mysqli_query($conexion, "SELECT * FROM clientes WHERE dni = '$dni'");
    
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