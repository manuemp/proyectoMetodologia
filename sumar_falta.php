<?php
if(!(isset($_POST["id"])))
   {
      header("Location:index.php");
   }

   $id_usuario = $_POST["id"];

   include("./conexion.php");
   
   $consulta = mysqli_query($conexion, "UPDATE clientes set faltas = faltas + 1 where id_usuario = '$id_usuario'");
   
   $consulta_faltas = mysqli_query($conexion, "SELECT faltas FROM clientes WHERE id_usuario = '$id_usuario'");

   $resultado = intval(mysqli_fetch_assoc($consulta_faltas)["faltas"]);

   if($resultado > 3)
   {
      //Esta variable bloquea los beneficios por 3 reservas
      $consulta = mysqli_query($conexion, "UPDATE clientes SET penalizacion = 3 WHERE id_usuario = '$id_usuario'");

      //Para evitar números negativos en contador de racha de asistencias
      $consulta = mysqli_query($conexion, "UPDATE clientes SET faltas = 0 WHERE id_usuario = '$id_usuario'");
      
   }
   mysqli_close($conexion);

?>