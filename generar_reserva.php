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
    $dni = intval($_SESSION["dni"]);
    $hoy = date('Y/m/d');
    $usuario_id = intval($_SESSION["id"]);
    //Sirve para contar la cantidad de reservas que faltan para volver
    //a aplicar los beneficios
    $faltas = $_SESSION["penalizacion"];

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
        header("Location:index.php?superposicion_reservas");
    }
    else
    {
        //Volver a chequear si ya no se hizo la reserva en cuestión. Quizás en el tiempo que se
        //tardó en elegir ya la hizo otro usuario, en ese caso redirecciono a página de error
        if($resultado_reservas == 0)
        {
            //SOLAMENTE SI LA RESERVA SE PUEDE HACER, ACTUALIZO EL SALDO
            $saldo = intval($_SESSION['saldo_a_favor']) - intval($_POST["precio_original"]);
            //PREVENIR SALDOS NEGATIVOS
            if($saldo < 0) $saldo = 0;
            $_SESSION["saldo_a_favor"] = strval($saldo);

            $query_actualizar_saldo = mysqli_query($conexion, "UPDATE clientes SET saldo_a_favor = $saldo WHERE id_usuario = $usuario_id");
            $consulta_reservas = mysqli_query($conexion, "INSERT INTO reservas (asistio, dia, dia_de_reserva, hora, cancha_id, usuario_id, precio, monto_seniado) 
                                                VALUES ('1','$dia', '$hoy', '$hora', '$cancha', '$usuario_id', '$precio','$precio')");

                                           
            
            /*VER ESTO PARA BAJAR LA PENALIZACION */
            $consulta_penalizacion = mysqli_query($conexion, "SELECT penalizacion from clientes where dni = '$dni'");
            $penalizaciones = mysqli_fetch_assoc($consulta_penalizacion)["penalizacion"];

            if($consulta_reservas && intval($penalizaciones) == 0)
            {
                $consulta_id = mysqli_query($conexion, "SELECT MAX(id) AS id FROM reservas");
                $id = mysqli_fetch_assoc($consulta_id)["id"];
            
                $consulta_reservas = mysqli_query($conexion, "UPDATE clientes SET racha = racha + 1 WHERE dni = '$dni'");

                mysqli_free_result($consulta_usuario);
                mysqli_close($conexion);

                header("Location:index.php?reserva_confirmada");
                // header("Location:reserva_confirmada.php?cancha=$cancha&dia=$dia&hora=$hora&id_reserva=$id&precio=$precio");
            }
            else if($consulta_reservas && intval($penalizaciones) != 0)
            {
                /*SACAR LA PENALIZACION */
                $penalizacion_retirada = mysqli_query($conexion, "UPDATE clientes SET penalizacion = penalizacion - 1 WHERE dni = $dni");

                $consulta_id = mysqli_query($conexion, "SELECT MAX(id) AS id FROM reservas");
                $id = mysqli_fetch_assoc($consulta_id)["id"];

                mysqli_free_result($consulta_usuario);
                mysqli_close($conexion);

                header("Location:index.php?reserva_confirmada");
            }
        }
        else
        {
            header("Location:index.php?reserva_no_disponible");
        }
    }


?>