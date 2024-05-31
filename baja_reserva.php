<?php 

    if(!isset($_POST["id_reserva"]))
    {
        header("Location:index.php");
    }

    include("./conexion.php");

    $id = intval($_POST["id_reserva"]);
    $email = $_POST["email"];

    $consulta = mysqli_query($conexion, "DELETE FROM reservas WHERE id = $id");
    $consulta = mysqli_query($conexion, "UPDATE usuarios SET racha = racha - 1 WHERE email = '$email'");

    mysqli_free_result($consulta);
    mysqli_close($conexion);
?>