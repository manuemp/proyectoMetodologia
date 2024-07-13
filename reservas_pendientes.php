<?php 
    if(!isset($_SESSION["nombre"]))
    {
        header("Location: index.php");
    }

    //Como este script se va a usar más de una vez en el index, porque cuando se hace
    //responsive llamo por segunda vez para mostrar en otro formato los datos
    //uso include_once para evitar errores.
    include_once("./generar_cancha.php");

    //Seteo la zona horaria a la de Argentina
    date_default_timezone_set("America/Argentina/Buenos_Aires");
    $hoy = date('Y-m-d');

    include("./conexion.php");
    $email = $_SESSION["email"];
    $usuario_id = $_SESSION["id"];

    $consulta = mysqli_query($conexion, "SELECT * FROM reservas WHERE usuario_id = '$usuario_id' AND dia >= '$hoy' ORDER BY dia");

    if(mysqli_num_rows($consulta) == 0)
    {
        echo "<div class='reserva violeta_claro texto_2'>No tenés reservas pendientes...</div>";
    }
    else
    {
        while($fila = $consulta->fetch_assoc())
        {
            if($fila["dia"] == date("Y-m-d"))
            {
                //Evitar que la reserva de un mismo día aparezca cuando ya pasó la hora
                if(strtotime($fila["hora"]) > strtotime(date("H:i")))
                    if(intval($fila["asistio"]) == 1){
                        echo "<div class='reserva'>[id: " .  $fila["id"] ."] - " . generarCancha($fila["cancha_id"]) . " - " . date("d/m/y", strtotime($fila["dia"])) . " - " . $fila["hora"] . "hs</div>";
                    }
                    else{
                        echo "<div class='reserva_perdida'>[id: " .  $fila["id"] ."] - " . generarCancha($fila["cancha_id"]) . " - " . date("d/m/y", strtotime($fila["dia"])) . " - " . $fila["hora"] . "hs</div>";
                    }
            }
            else
            {
                if(intval($fila["asistio"]) == 1){
                    echo "<div class='reserva'>[id: " .  $fila["id"] ."] - " . generarCancha($fila["cancha_id"]) . " - " . date("d/m/y", strtotime($fila["dia"])) . " - " . $fila["hora"] . "hs</div>";
                }
                else{
                    echo "<div class='reserva_perdida'>[id: " .  $fila["id"] ."] - " . generarCancha($fila["cancha_id"]) . " - " . date("d/m/y", strtotime($fila["dia"])) . " - " . $fila["hora"] . "hs</div>";
                }
            }
        }
    }

    mysqli_free_result($consulta);
    mysqli_close($conexion);
?>