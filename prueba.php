<?php
    session_start();

    if(!(isset($_SESSION["Nombre"]) && isset($_POST["select_dia"]) && isset($_POST["select_cancha"]) && isset($_POST["select_hora"])))
    {
        header("Location:index.php");
    }

    $dia = $_POST["select_dia"];
    $cancha = $_POST["select_cancha"];
    $hora = $_POST["select_hora"];
    $nombre = $_SESSION["Nombre"];
    $apellido = $_SESSION["Apellido"];
    $email = $_SESSION["Email"];

    include("./conexion.php");

    // $consulta_reservas = mysqli_query($conexion, "SELECT * FROM Reservas WHERE Dia = '$dia', Hora = '$hora', Cancha = '$cancha'");
    // $resultado_reservas = mysqli_num_rows($consulta_reservas);

    $consulta_usuario = mysqli_query($conexion, "SELECT * FROM Reservas WHERE Dia = '$dia' AND Hora = '$hora' AND Email = '$email'");

    echo mysqli_num_rows($consulta_usuario);

    //que olor a leche
?>
