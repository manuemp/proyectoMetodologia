<?php session_start(); ?>
<?php
    //Prohibir acceder a este script si no está activada la sesión, y si no se mandó por POST
    //tanto el día, como la cancha y la hora de la reserva.
    if(!(isset($_SESSION["nombre"]) && isset($_POST["select_dia"]) && isset($_POST["select_cancha"]) && isset($_POST["select_hora"])))
    {
        header("Location:index.php");
    }
    
    $dia = $_POST["select_dia"];
    $cancha = $_POST["select_cancha"];
    $hora = $_POST["select_hora"];
    $precio = $_POST["precio_hidden"];
    $nombre = $_SESSION["nombre"];
    $apellido = $_SESSION["apellido"];
    $email = $_SESSION["email"];
    $hoy = date('Y/m/d');
    $id_usuario = $_SESSION["id"];

    include("./conexion.php");

    $consulta_reservas = mysqli_query($conexion, "SELECT * FROM reservas WHERE dia = '$dia' AND hora = '$hora' AND cancha_id = '$cancha' AND asistio = 1");
    $resultado_reservas = mysqli_num_rows($consulta_reservas);

    //Chequear que el usuario no tenga una reserva el mismo día y hora en una cancha diferente
    $consulta_usuario = mysqli_query($conexion, "SELECT * FROM reservas R
                                                JOIN usuarios U on U.id = R.usuario_id
                                                WHERE dia = '$dia' AND hora = '$hora' AND U.email = '$email'");
    $resultado_usuario = mysqli_num_rows($consulta_usuario);

    //Si tiene una reserva ese día y hora en otra cancha, redirecciono a página de error
    if($resultado_usuario > 0)
    {
        mysqli_free_result($consulta_reservas);
        mysqli_free_result($consulta_usuario);
        mysqli_close($conexion);
        header("Location:superposicion_reservas.php");
    }
    else
    {
        //Volver a chequear si ya no se hizo la reserva en cuestión. Quizás en el tiempo que se
        //tardó en elegir ya la hizo otro usuario, en ese caso redirecciono a página de error
        if($resultado_reservas == 0)
        {
            $consulta_reservas = mysqli_query($conexion, "INSERT INTO reservas (asistio, dia, dia_de_reserva, hora, cancha_id, usuario_id, precio, monto_seniado) 
                                                VALUES (1,'$dia', '$hoy', '$hora', '$cancha', '$usuario_id', '$precio', 0)");
            
            if($consulta_reservas)
            {
                $consulta_id = mysqli_query($conexion, "SELECT MAX(id) AS id FROM reservas");
                $id = mysqli_fetch_assoc($consulta_id)["id"];
            
                $consulta_reservas = mysqli_query($conexion, "UPDATE usuarios SET racha = racha + 1 WHERE email = '$email'");

                mysqli_free_result($consulta_usuario);
                mysqli_close($conexion);

                header("Location:reserva_confirmada.php?cancha=$cancha&dia=$dia&hora=$hora&id_reserva=$id&precio=$precio");
            }
        }
        else
        {
            header("Location:reserva_no_disponible.php");
        }
    }


?>