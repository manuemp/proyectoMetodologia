<?php
    session_start();

    // if(!(isset($_SESSION["nombre"]) && isset($_POST["select_dia"]) && isset($_POST["select_cancha"]) && isset($_POST["select_hora"])))
    // {
    //     header("Location:index.php");
    // }

    // $dia = $_POST["select_dia"];
    // $cancha = $_POST["select_cancha"];
    // $hora = $_POST["select_hora"];


    include("./conexion.php");
    $consulta = mysqli_query($conexion, "SELECT nombre, estado FROM canchas");
    $resultado = mysqli_fetch_assoc($consulta);

    $arr_nombres = [];
    $arr_estados = [];

    $objetoJson->nombres = $arr_nombres;
    $objetoJson->estados = $arr_estados;


    while($arr_nombres)

    foreach($resultado as $res){
        array_push($arr_nombres, $res["nombre"]);
        array_push($arr_estados, $res["estado"]);
    }

    // $objetoJson = new stdClass();


    echo json_encode($objetoJson);
?>
