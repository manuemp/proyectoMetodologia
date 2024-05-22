<?php 
    if(!isset($_SESSION["Nombre"]))
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
    $email = $_SESSION["Email"];

    $consulta = mysqli_query($conexion, "SELECT * FROM Reservas WHERE Email = '$email' AND Dia >= '$hoy' ORDER BY Dia");

    if(mysqli_num_rows($consulta) == 0)
    {
        echo "<div class='reserva'>No tenés reservas pendientes...</div>";
    }
    else
    {
        while($fila = $consulta->fetch_assoc())
        {
            if($fila["Dia"] == date("Y-m-d"))
            {
                //Evitar que la reserva de un mismo día aparezca cuando ya pasó la hora
                if(strtotime($fila["Hora"]) > strtotime(date("H:i")))
                    if(intval($fila["Asistio"]) == 1){
                        echo "<div class='reserva'>[id: " .  $fila["ID"] ."] - " . generarCancha($fila["Cancha"]) . " - " . date("d/m/y", strtotime($fila["Dia"])) . " - " . $fila["Hora"] . "hs</div>";
                    }
                    else{
                        echo "<div class='reserva_perdida'>[id: " .  $fila["ID"] ."] - " . generarCancha($fila["Cancha"]) . " - " . date("d/m/y", strtotime($fila["Dia"])) . " - " . $fila["Hora"] . "hs</div>";
                    }
            }
            else
            {
                if(intval($fila["Asistio"]) == 1){
                    echo "<div class='reserva'>[id: " .  $fila["ID"] ."] - " . generarCancha($fila["Cancha"]) . " - " . date("d/m/y", strtotime($fila["Dia"])) . " - " . $fila["Hora"] . "hs</div>";
                }
                else{
                    echo "<div class='reserva_perdida'>[id: " .  $fila["ID"] ."] - " . generarCancha($fila["Cancha"]) . " - " . date("d/m/y", strtotime($fila["Dia"])) . " - " . $fila["Hora"] . "hs</div>";
                }
            }
        }
    }

    mysqli_free_result($consulta);
    mysqli_close($conexion);


?>