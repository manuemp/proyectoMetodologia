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
    
    //usuarios: id, nombre, apelido, email, pass, rol
    //clientes: dni, id_usuario, faltas, racha, penalizacion, saldo_a_favor

    $consulta = mysqli_query($conexion, "INSERT INTO usuarios (nombre, apellido, email, pass, rol) VALUES ('$nombre', '$apellido', '$email', '$pass', 1)");
    $consulta = mysqli_query($conexion, "SELECT id, nombre, apellido, email, rol FROM usuarios WHERE email='$email'");
    
    $data = mysqli_fetch_assoc($consulta);
    
    //Asigno los valores a la sesion
    $_SESSION['id'] = $data['id'];
    $_SESSION['nombre'] = $data['nombre'];
    $_SESSION['apellido'] = $data['apellido'];
    $_SESSION['email'] = $data['email'];
    $_SESSION['rol'] = $data['rol'];

    mysqli_free_result($consulta);
    mysqli_close($conexion);
?>