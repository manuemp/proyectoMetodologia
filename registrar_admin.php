<?php session_start(); ?>
<?php 

    //Prohibir acceso si no se enviaron las variables del formulario
    if(!(isset($_POST["nombre"]) && isset($_POST["apellido"]) && isset($_POST["pass"]) && isset($_POST["email"])))
    {
        header("Location:registro_admin.php");
    }

    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $pass = sha1($_POST['pass']);
    $email = $_POST['email'];

    include("./conexion.php");

    $consulta = mysqli_query($conexion, "INSERT INTO usuarios (nombre, apellido, email, pass, rol) VALUES ('$nombre', '$apellido', '$email', '$pass', 1)");
    $consulta_admin = mysqli_query($conexion, "SELECT id, nombre, apellido, email, rol FROM usuarios WHERE email='$email'");

    mysqli_close($conexion);
?>