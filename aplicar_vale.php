<?php

$monto = floatval($_POST["monto"]); 
$id_usuario = intval($_POST["id_usuario"]); 

include("./conexion.php");

$actualizar_monto = mysqli_query($conexion, "UPDATE clientes SET saldo_a_favor = saldo_a_favor + $monto where id_usuario = $id_usuario");

mysqli_close($conexion);

?>