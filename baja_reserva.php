<?php 

    if(!isset($_POST["id_reserva"]))
    {
        header("Location:index.php");
    }

    include("./conexion.php");

    $id = intval($_POST["id_reserva"]);
    $email = $_POST["email"];

    $conseguir_id = mysqli_query($conexion, "SELECT usuario_id FROM reservas
                                WHERE id = '$id'");

    $consulta = mysqli_fetch_assoc($conseguir_id);
    $id_cliente = $consulta['usuario_id'];

    $consulta = mysqli_query($conexion, "DELETE FROM reservas WHERE id = $id");
    $consulta = mysqli_query($conexion, "UPDATE clientes SET racha = racha - 1 WHERE id_usuario = '$id_cliente'");

    mysqli_free_result($consulta);
    mysqli_close($conexion);
?>