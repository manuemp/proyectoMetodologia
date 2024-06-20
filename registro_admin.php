<?php session_start() ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./estilos/general.css">
    <link rel="stylesheet" href="./estilos/registro.css">
    <link rel="stylesheet" href="./estilos/admin.css">
    <style>

        body,html{
            padding: 0;
        }

        #registro_admin{
            background: white;
            color:#8650fe;
            font-weight: bold;
        }

        .nav1{
            background: white;
        }

        .opcion{
            color: #8650fe;
        }

        .opcion:hover{
            background: white;
        }

        .logo{
            position: static;
        }

        .registro_container{
            align-items: start;
        }
        
        form{
            margin: 15% auto;
        }
        
        .img_container_admin
        {
            min-width: 45%;
            min-height: 100vh;
            background: linear-gradient(45deg, lavender, white);
            background-image: url("../proyecto/imgs/fondo_admin2.jpeg");
            background-repeat: no-repeat;
            background-size: cover;
            border-left: 6px solid #8650fe;
        }

        .notificacion{
            min-height: 40px;
            height: auto;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 8px;
            box-sizing: border-box;
            font-weight: bold;
            font-size: 1.5rem;
        }

        .error{
            background: red;
            color: white;
        }

        .exito{
            color: white;
            background: #23d366;
        }


        @media (min-width: 1450px){
            form
            {
                width: 500px;
            }
        }

        @media( max-width: 1236px){
            .form_container
            {
                justify-content: center;
            }

            #titulo_registro
            {
                width: fit-content;
                margin: 30px auto;
            }
        }

        @media(max-width: 950px){
            form
            {
                width: 90%;
            }
            #titulo_registro
            {
                font-size: 2.4rem;
            }
        }

        @media(max-width: 1300px){
            .opcion
            {
                font-size: 12px;
            }
        }

        @media(max-width: 600px){
            /* .img_container
            {
                display: none;
            } */

            form
            {
                width: 70%;
            }

            #titulo_registro {
                font-size: 2rem;
                margin-top: 50px;
            }

            .logo{
                right: 6px;
            }
        }


        @media(max-width: 900px){
            .form_opcion{
                margin: 20px auto;
            }
            .img_container_admin{
                display: none;
            }
            .registro_container{
                width: 100%;
            }
            .form_container{
                flex-direction: column;
            }
        }

    </style>
    <title>Torino Fútbol: Registro</title>
</head>
<body>

    <?php 

    if(intval($_SESSION["rol"]) == 1){
        header("Location:admin_canchas.php");
    }

    if(intval($_SESSION["rol"]) == 0){
        header("Location:index.php");
    }
    
    $nombre_err = $apellido_err = $email_err = $pass_err = "";
    $nombre = $apellido = $email = $pass = "";

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $nombre = $_POST["nombre"];
        if (!preg_match("/^[a-zA-Z ]*$/",$nombre)) {  
            $nombre_err = "<br>Usá solo letras y espacios";  
        } 

        $apellido = $_POST["apellido"];
        if (!preg_match("/^[a-zA-Z ]*$/",$apellido)) {  
            $apellido_err = "<br>Usá solo letras y espacios";  
        } 

        $email = $_POST["email"];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {  
            $email_err = "<br>Formato de mail inválido";  
        }
        else
        {
            include("./conexion.php");
            $consulta_mail = mysqli_query($conexion, "SELECT * FROM usuarios WHERE email = '$email'");
            if(mysqli_num_rows($consulta_mail) > 0)
            {
                $email_err = "<br>Correo electrónico en uso";
            }
        }

        $pass = $_POST["pass"];
    }
    
    ?>
    
    <?php include("./nav_superadmin.php") ?>
    <?php if(isset($_GET["exito"]))
        echo "<div class='notificacion exito'>¡Administrador registrado exitosamente!</div>";
    ?>
    <?php if(isset($_GET["error"]))
        echo "<div class='notificacion error'>Hubo un error en el registro</div>";
    ?>
    <main>
        <div class="registro_container" id="registro_admin">
            <div>
                </div>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 
                    <p id="titulo_registro">Registrar <br>Administrador</p>
                    <div class="form_container">

                    <div class="form_opcion">
                        <label for="nombre">Nombre</label>
                        <input type="text" class="form_input" id="nombre" autocomplete="off" name="nombre" required>
                        <span style="color:red;font-weight:bold;font-style:italic"><?php echo $nombre_err ?></span>
                    </div>
    
                    <div class="form_opcion">
                        <label for="apellido">Apellido</label>
                        <input type="text" class="form_input" id="apellido" autocomplete="off" name="apellido" required>
                        <span style="color:red;font-weight:bold;font-style:italic"><?php echo $apellido_err ?></span>
                    </div>
    
                    <div class="form_opcion">
                        <label for="email">Correo Electrónico</label>
                        <input type="email" class="form_input" id="email" autocomplete="off" name="email" required>
                        <span style="color:red;font-weight:bold;font-style:italic;"><?php echo $email_err ?></span>
                    </div>
    
                    <div class="form_opcion">
                        <label for="pass">Contraseña</label>
                        <input type="password" class="form_input" id="pass" autocomplete="off" name="pass" required>
                    </div>
    
                    <input type="submit" name="enviar" id="enviar" value="Registrar administrador" class="form_input form_opcion">
                </div>
            </form>
        </div>
    
        <div class="img_container_admin">
    
        </div>
    </main>
    <?php include("./footer.php"); ?>
</body>

    <?php
        
        if(isset($_POST["enviar"]))
        {
            if($nombre_err == "" && $apellido_err == "" && $email_err == "" && $pass_err == "")
            {
                include("./registrar_admin.php");
                echo "<script>location.href = './admin_reservas.php'</script>";
            }

        }
    ?>
</html>

<?php include("nav_desplegable.php"); ?>
