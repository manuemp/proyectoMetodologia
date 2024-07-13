<?php 
   if(!(isset($_POST["email"]) && isset($_POST["id_reserva"])))
   {
      header("Location:index.php");
   }

   $email = $_POST["email"];
   $id = $_POST["id_reserva"];

   include("./conexion.php");

   $conseguir_id = mysqli_query($conexion, "SELECT usuario_id FROM reservas
                                 WHERE id = '$id'");

   $consulta = mysqli_fetch_assoc($conseguir_id);
   $id_cliente = $consulta['usuario_id'];

   //Le sumo la falta al usuario
   $consulta = mysqli_query($conexion, "UPDATE clientes SET faltas = faltas + 1, racha = racha - 1 WHERE id_usuario = '$id_cliente'");
   //Cambio la reserva a no asistida, para que no aparezca más en el panel del administrador
   $consulta = mysqli_query($conexion, "UPDATE reservas SET asistio = 0 WHERE id = $id");
   //Cuento las faltas del usuario
   $consulta_faltas = mysqli_query($conexion, "SELECT faltas FROM clientes WHERE id_usuario = '$id_cliente'");

   $consulta_asistencias = mysqli_query($conexion, "SELECT racha FROM clientes WHERE id_usuario = '$id_cliente'");
   $resultado_asistencias = intval(mysqli_fetch_assoc($consulta_asistencias)["racha"]);

   $resultado = intval(mysqli_fetch_assoc($consulta_faltas)["faltas"]);
   if($resultado > 3)
   {
      //Esta variable bloquea los beneficios por 3 reservas
      $consulta = mysqli_query($conexion, "UPDATE clientes SET penalizacion = 3 WHERE id_usuario = '$id_cliente'");
      //Para evitar números negativos en contador de racha de asistencias
      $consulta = mysqli_query($conexion, "UPDATE clientes SET faltas = 0 WHERE id_usuario = '$id_cliente'");

   }

   // mysqli_free_result($consulta);
   mysqli_close($conexion);
?>