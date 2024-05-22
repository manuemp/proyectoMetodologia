<?php session_start(); ?>
<?php 
    if(!isset($_POST["filtro_cancha"])){
        header("Location:index.php");
    }

    include("./generar_cancha.php");
    include("./conexion.php");

    $email = $_SESSION["Email"];
    $cancha = $_POST["filtro_cancha"];
    
    if($cancha != "")
        $resultado = mysqli_query($conexion, "SELECT Dia, Hora, Cancha, Asistio FROM Reservas WHERE Email = '$email' AND Cancha = $cancha ORDER BY Dia DESC");
    else
        $resultado = mysqli_query($conexion, "SELECT Dia, Hora, Cancha, Asistio FROM Reservas WHERE Email = '$email' ORDER BY Dia DESC");

    $arr = [];
    while($fila = $resultado->fetch_assoc())
    {
        $subarray = [];
        $subarray["Dia"] = date("d/m/Y", strtotime($fila["Dia"]));
        $subarray["Hora"] = $fila["Hora"];
        $subarray["Cancha"] = generarCancha($fila["Cancha"]);
        $subarray["Asistio"] = $fila["Asistio"];
        array_push($arr, $subarray);
    }

    //Codifico el array en JSON para poder enviarlo al server
    $array = json_encode($arr);

    mysqli_free_result($resultado);
    mysqli_close($conexion);

    echo $array;

?>