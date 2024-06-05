<?php 
   //Es una variable que sirve para acumular las reservas que quedan para volver 
   //a aplicar los beneficios

   if(!(isset($_POST["email"]) && isset($_POST["id_reserva"])))
   {
      header("Location:index.php");
   }

   $email = $_POST["email"];
   $dni = $_POST["dni"];
   $id = $_POST["id_reserva"];
    //Sirve para contar la cantidad de reservas que faltan para volver
    //a aplicar los beneficios
   $faltas = intval($_SESSION["penalizacion"]);

   include("./conexion.php");

   //Le sumo la falta al usuario
   $consulta = mysqli_query($conexion, "UPDATE clientes SET faltas = faltas + 1, racha = racha - 1 WHERE dni = '$dni'");
   //Cambio la reserva a no asistida, para que no aparezca más en el panel del administrador
   $consulta = mysqli_query($conexion, "UPDATE reservas SET asistio = 0 WHERE id = $id");
   //Cuento las faltas del usuario
   $consulta_faltas = mysqli_query($conexion, "SELECT faltas FROM clientes WHERE dni = '$dni'");

   $consulta_asistencias = mysqli_query($conexion, "SELECT racha FROM clientes WHERE dni = '$dni'");
   $resultado_asistencias = intval(mysqli_fetch_assoc($consulta_asistencias)["racha"]);

   $resultado = intval(mysqli_fetch_assoc($consulta_faltas)["faltas"]);
   if($resultado > 3)
   {
      //Esta variable bloquea los beneficios por 3 reservas
      $faltas = 3;

      //Para evitar números negativos en contador de racha de asistencias
      $consulta = mysqli_query($conexion, "UPDATE clientes SET faltas = 0, racha = 0 WHERE dni = '$dni'");
      
   }

   mysqli_free_result($consulta);
   mysqli_close($conexion);
?>