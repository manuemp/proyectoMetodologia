<?php session_start(); ?>
<?php 

    //Prohibir acceso si no se enviaron las variables del formulario
    if(!(isset($_POST["nombre"]) && isset($_POST["apellido"]) && isset($_POST["pass"]) && isset($_POST["email"])))
    {
        header("Location:index.php");
    }

    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $pass = sha1($_POST['pass']);
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $dni = $_POST['dni'];

    include("./conexion.php");
    

    $consulta = mysqli_query($conexion, "INSERT INTO usuarios (nombre, apellido, email, pass, faltas, racha, rol, saldo_a_favor, telefono, dni) VALUES ('$nombre', '$apellido', '$email', '$pass', 0, 0, 0, 0, $telefono, $dni)");
    $consulta = mysqli_query($conexion, "SELECT nombre, apellido, email, faltas, racha, rol, saldo_a_favor, telefono, dni FROM usuarios WHERE email='$email'");
    $data = mysqli_fetch_assoc($consulta);
    
    //Asigno los valores a la sesion
    $_SESSION['nombre'] = $data['nombre'];
    $_SESSION['apellido'] = $data['apellido'];
    $_SESSION['email'] = $data['email'];
    $_SESSION['faltas'] = $data['faltas'];
    $_SESSION['racha'] = $data['racha'];
    $_SESSION['rol'] = $data['rol'];
    $_SESSION['saldo_a_favor'] = $data['saldo_a_favor'];
    $_SESSION['telefono'] = $data['telefono'];
    $_SESSION['dni'] = $data['dni'];

    mysqli_free_result($consulta);
    mysqli_close($conexion);
?>