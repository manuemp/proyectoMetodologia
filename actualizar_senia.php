<?php session_start(); ?>
<?php 

    $id = intval($_POST["id"]);
    $senia = intval($_POST["senia"]);

    include("./conexion.php");

    $consulta = mysqli_query($conexion, "UPDATE Reservas SET Adelanto = $senia WHERE ID = $id");

    mysqli_free_result($consulta);
    mysqli_close($conexion);
?>