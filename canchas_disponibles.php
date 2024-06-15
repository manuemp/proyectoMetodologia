<?php
 include("./conexion.php");

 $resultado = mysqli_query($conexion, "SELECT nombre, precio, estado from canchas");
 $contador = mysqli_num_rows($resultado);
 
 $arr = [];
 while($fila = $resultado->fetch_assoc())
 {
     $obj = new stdClass();
     $obj->nombre = $fila["nombre"];
     $obj->precio = $fila['precio'];
     $obj->estado = $fila['estado'];
     array_push($arr, $obj);
 }

 mysqli_close($conexion);
 echo json_encode($arr);



?>