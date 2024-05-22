<?php 

    if(!isset($_POST["id_reserva"]))
    {
        header("Location:index.php");
    }

    include("./conexion.php");

    $id = intval($_POST["id_reserva"]);
    $email = $_POST["email"];

    $consulta = mysqli_query($conexion, "DELETE FROM Reservas WHERE ID = $id");
    $consulta = mysqli_query($conexion, "UPDATE Usuarios SET Racha = Racha - 1 WHERE Email = '$email'");

    mysqli_free_result($consulta);
    mysqli_close($conexion);
?>