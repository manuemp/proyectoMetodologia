<?php 

   if(!(isset($_POST["email"]) && isset($_POST["id_reserva"])))
   {
      header("Location:index.php");
   }

   $email = $_POST["email"];
   $id = $_POST["id_reserva"];

   include("./conexion.php");

   //Le sumo la falta al usuario
   $consulta = mysqli_query($conexion, "UPDATE Usuarios SET Faltas = Faltas + 1, Racha = Racha - 1 WHERE Email = '$email'");
   //Cambio la reserva a no asistida, para que no aparezca más en el panel del administrador
   $consulta = mysqli_query($conexion, "UPDATE Reservas SET Asistio = 0 WHERE ID = $id");
   //Cuento las faltas del usuario
   $consulta_faltas = mysqli_query($conexion, "SELECT Faltas FROM Usuarios WHERE Email = '$email'");

   $consulta_asistencias = mysqli_query($conexion, "SELECT Racha FROM Usuarios WHERE Email = '$email'");
   $resultado_asistencias = intval(mysqli_fetch_assoc($consulta_asistencias)["Racha"]);

   $resultado = intval(mysqli_fetch_assoc($consulta_faltas)["Faltas"]);
   if($resultado > 3)
   {
      //Para evitar números negativos en contador de racha de asistencias
      if($resultado_asistencias > 15){
         $consulta = mysqli_query($conexion, "UPDATE Usuarios SET Faltas = 0, Racha = Racha - 15 WHERE Email = '$email'");
      }
      else{
         $consulta = mysqli_query($conexion, "UPDATE Usuarios SET Faltas = 0, Racha = 0 WHERE Email = '$email'");
      }
   }

   mysqli_free_result($consulta);
   mysqli_close($conexion);
?>