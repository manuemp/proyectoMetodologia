<?php
    session_start();

    // if(!(isset($_SESSION["nombre"]) && isset($_POST["select_dia"]) && isset($_POST["select_cancha"]) && isset($_POST["select_hora"])))
    // {
    //     header("Location:index.php");
    // }

    // $dia = $_POST["select_dia"];
    // $cancha = $_POST["select_cancha"];
    // $hora = $_POST["select_hora"];
    $nombre = $_SESSION["nombre"];
    $apellido = $_SESSION["apellido"];
    $email = $_SESSION["email"];
    $dni = $_SESSION["dni"];


    include("./conexion.php");

    // $consulta_reservas = mysqli_query($conexion, "SELECT * FROM Reservas WHERE Dia = '$dia', Hora = '$hora', Cancha = '$cancha'");
    // $resultado_reservas = mysqli_num_rows($consulta_reservas);

    // $consulta_usuario = mysqli_query($conexion, "SELECT * FROM reservas WHERE dia = '$dia' AND hora = '$hora' AND email = '$email'");
    $consulta = mysqli_query($conexion, "UPDATE clientes SET racha = racha + 1 WHERE dni = $dni");
    $consulta = mysqli_query($conexion, "SELECT racha FROM clientes WHERE dni = $dni");
    $resultado = mysqli_fetch_assoc($consulta)["racha"];

    echo $resultado;

    //VAMOS VELEZ
?>
