<?php
 include("./conexion.php");

 $resultado = mysqli_query($conexion, "SELECT id, nombre, precio, estado from canchas where estado != 0");
 $contador = mysqli_num_rows($resultado);
 
 $arr = [];
 while($fila = $resultado->fetch_assoc())
 {
     $obj = new stdClass();
     $obj->id = $fila["id"];
     $obj->nombre = $fila["nombre"];
     $obj->precio = $fila['precio'];
     $obj->estado = $fila['estado'];
     array_push($arr, $obj);
 }

 mysqli_close($conexion);
 echo json_encode($arr);
?>