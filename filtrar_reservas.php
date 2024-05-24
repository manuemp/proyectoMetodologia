<?php session_start(); ?>
<?php 
    if(!isset($_POST["filtro_cancha"])){
        header("Location:index.php");
    }

    include("./generar_cancha.php");
    include("./conexion.php");

    $email = $_SESSION["email"];
    $cancha = $_POST["filtro_cancha"];
    
    if($cancha != "")
        $resultado = mysqli_query($conexion, "SELECT dia, hora, cancha, asistio FROM reservas WHERE email = '$email' AND cancha = $cancha ORDER BY dia DESC");
    else
        $resultado = mysqli_query($conexion, "SELECT dia, hora, cancha, asistio FROM reservas WHERE email = '$email' ORDER BY dia DESC");

    $arr = [];
    while($fila = $resultado->fetch_assoc())
    {
        $subarray = [];
        $subarray["dia"] = date("d/m/Y", strtotime($fila["dia"]));
        $subarray["hora"] = $fila["hora"];
        $subarray["cancha"] = generarCancha($fila["cancha"]);
        $subarray["asistio"] = $fila["asistio"];
        array_push($arr, $subarray);
    }

    //Codifico el array en JSON para poder enviarlo al server
    $array = json_encode($arr);

    mysqli_free_result($resultado);
    mysqli_close($conexion);

    echo $array;

?>