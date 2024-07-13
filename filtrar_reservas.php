<?php session_start(); ?>
<?php 
    if(!isset($_POST["filtro_cancha"])){
        header("Location:index.php");
    }

    include("./generar_cancha.php");
    include("./conexion.php");

    $email = $_SESSION["email"];
    $cancha = $_POST["filtro_cancha"];
    $usuario_id = $_SESSION["id"];
    
    //Si el filtro está vacío muestro todas
    if($cancha != "")
        $resultado = mysqli_query($conexion, "SELECT dia, hora, cancha_id, asistio, precio FROM reservas WHERE usuario_id = '$usuario_id' AND cancha_id = $cancha ORDER BY dia DESC");
    else
        $resultado = mysqli_query($conexion, "SELECT dia, hora, cancha_id, asistio, precio FROM reservas WHERE usuario_id = '$usuario_id' ORDER BY dia DESC");

    //Creo un array y lo lleno con todas las reservas
    $arr = [];
    while($fila = $resultado->fetch_assoc())
    {
        $subarray = [];
        $subarray["dia"] = date("d/m/Y", strtotime($fila["dia"]));
        $subarray["hora"] = $fila["hora"];
        $subarray["cancha"] = generarCancha($fila["cancha_id"]);
        $subarray["asistio"] = $fila["asistio"];
        $subarray["precio"] = $fila["precio"];
        array_push($arr, $subarray);
    }

    //Codifico el array en JSON para poder enviarlo al server
    $array = json_encode($arr);

    mysqli_free_result($resultado);
    mysqli_close($conexion);

    echo $array;

?>