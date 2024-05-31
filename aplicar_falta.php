<?php 

   if(!(isset($_POST["email"]) && isset($_POST["id_reserva"])))
   {
      header("Location:index.php");
   }

   $email = $_POST["email"];
   $id = $_POST["id_reserva"];

   include("./conexion.php");

   //Le sumo la falta al usuario
   $consulta = mysqli_query($conexion, "UPDATE usuarios SET faltas = faltas + 1, racha = racha - 1 WHERE email = '$email'");
   //Cambio la reserva a no asistida, para que no aparezca más en el panel del administrador
   $consulta = mysqli_query($conexion, "UPDATE reservas SET asistio = 0 WHERE id = $id");
   //Cuento las faltas del usuario
   $consulta_faltas = mysqli_query($conexion, "SELECT faltas FROM usuarios WHERE email = '$email'");

   $consulta_asistencias = mysqli_query($conexion, "SELECT racha FROM usuarios WHERE email = '$email'");
   $resultado_asistencias = intval(mysqli_fetch_assoc($consulta_asistencias)["racha"]);

   $resultado = intval(mysqli_fetch_assoc($consulta_faltas)["faltas"]);
   if($resultado > 3)
   {

      //Habria que crear un campo para bloquear los beneficios por 3 reservas
      


      //Para evitar números negativos en contador de racha de asistencias
      $consulta = mysqli_query($conexion, "UPDATE usuarios SET faltas = 0, racha = 0 WHERE email = '$email'");
      
   }

   mysqli_free_result($consulta);
   mysqli_close($conexion);
?>