<?php
if(!(isset($_POST["id"])))
   {
      header("Location:index.php");
   }

   $id_usuario = $_POST["id"];

   include("./conexion.php");
   

   $consulta = mysqli_query($conexion, "UPDATE clientes set faltas = faltas - 1 where id_usuario = '$id_usuario' AND faltas > 0");

   mysqli_close($conexion);

?>