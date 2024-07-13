<?php session_start(); ?>
<?php 

    $id = intval($_POST["id"]);
    $senia = intval($_POST["senia"]);

    include("./conexion.php");

    $consulta = mysqli_query($conexion, "UPDATE reservas SET monto_seniado = $senia WHERE id = $id");

    mysqli_free_result($consulta);
    mysqli_close($conexion);
?>