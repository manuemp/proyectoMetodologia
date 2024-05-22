<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./estilos/general.css">
    <link rel="stylesheet" href="./estilos/index.css">
    <link rel="stylesheet" href="./estilos/modal.css">
    <link rel="stylesheet" href="./estilos/contacto.css">
    <title>TorinoFútbol: Contacto</title>
    <style>
        @media(max-width: 650px){
            #contacto{
                width: 95%;
                margin-top: 60px;
            }

            #whatsapp_contacto{
                font-size: 1.2rem;
                width: 95%;
            }
        }
    </style>
</head>
<body>

    <?php 
    
        $respuesta_mail = "";

        if($_SERVER["REQUEST_METHOD"] == "POST")
        {
            $nombre = $_POST["nombre_contacto"];
            $email = $_POST["email_contacto"];
            $mensaje = $_POST["mensaje"];
            $asunto = "TorinoFútbol: Consulta de " . $nombre;
            $destino = "manuel.em.pedro@gmail.com";

            $header = "From: " . $nombre . "<" . $email . ">";

            $enviado = mail($destino, $asunto, $mensaje, $header);

            if($enviado)
            {
                $respuesta_mail = "<span id='mail_enviado'>¡Mail enviado correctamente!</span>";
            }
            else
            {
                $respuesta_mail = "<span id='error_mail'>¡Hubo un problema al enviar el mail! Por favor, intenta nuevamente</span>";
            }
        }
    
    ?>

    <span id="modal_background"></span>
    <!-- <nav class="nav1"></nav> -->
    <?php 
        if(isset($_SESSION["Nombre"]))
            include("./nav_online.php");
        else
            include("./nav_offline.php");
    ?>
    <?php echo $respuesta_mail  ?>
    <main>
        <a href="./index.php"><img src="./imgs/left_arrow2.png" alt="Volver" id="arrow"></a>
        <!-- MODAL -->
        <div id="modal_inicio_sesion">
            <div class="modal_nav">
                <span class="modal_cerrar">X</span>
            </div>
            <div class="modal_main" style="margin: auto;">
                <p class="modal_titulo">¡Ingresá en Torino Fútbol!</p><br>
                <span style="font-size: 1rem; color: gray; display: block; margin-top: -15px">admin: admintorino@gmail.com - pass: 12345678</span>
                <form action="./iniciar_sesion.php" method="post">
                    <div class="form_opcion">
                        <label for="email">Correo Electrónico</label>
                        <input class="modal_input" type="email" name="email" required autocomplete="off">
                    </div>
                    <div class="form_opcion">
                        <label for="pass">Contraseña</label>
                        <input class="modal_input" type="password" name="pass" required autocomplete="off">
                    </div>
                    <div class="form_opcion">
                        <input class="modal_enviar modal_input" type="submit" value="Iniciar Sesión">
                    </div>
                </form>
            </div>
        </div>
        <article id="contacto">
            <div id="header_contacto">
                <h1>Contacto TorinoFútbol</h1>
                <p style="color: white; font-weight: bold">¿Tenés alguna consulta? ¡No dudes en escribirnos!</p>
            </div>
            <div id="body_contacto">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <label for="nombre">Nombre y Apellido</label>
                    <input class="input_contacto" type="text" name="nombre_contacto" id="nombre_contacto" autocomplete="off" required>
                    <label for="email">Email</label>
                    <input class="input_contacto" type="email" name="email_contacto" id="email_contacto" autocomplete="off" required>
                    <label for="consulta">Mensaje</label>
                    <textarea name="mensaje" id="mensaje" cols="30" rows="10"></textarea>
                    <input type="submit" id="enviar_contacto">
                </form>
            </div>
        </article>
        <article id="whatsapp_contacto">
            ¡Recordá que también podés comunicarte con nosotros vía Whatsapp al <a href="https://wa.me/1159807762/?text=Hola!%20Quiero%20hacer%20una%20consulta%20sobre%20TorinoFutbol" target="_blank">1159807762</a>!
        </article>
    </main>
    <?php include("./footer.php"); ?>
</body>
</html>

<?php include("./nav_desplegable.php") ?>
<script>
    var iniciar_sesion_desplegable = document.getElementById("iniciar_sesion_desplegable");
    var iniciar_sesion = document.getElementById("iniciar_sesion");
    var modal = document.getElementById("modal_inicio_sesion");
    var cerrar_modal = document.querySelectorAll(".modal_cerrar");
    var modal_background = document.getElementById("modal_background");

    //Codigo para evitar que me reenvíe el formulario y nunca desaparezca el mensaje de 
    //'mail enviado correctamente'
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }

    iniciar_sesion.addEventListener('click', ()=>
    {
        modal_background.style.display = "block";
        modal.style.display = "block";
    });

    iniciar_sesion_desplegable.addEventListener('click', ()=>
    {
        modal_background.style.display = "block";
        modal.style.display = "block";
    });

    cerrar_modal.forEach(cerrar =>{
        cerrar.addEventListener('click', ()=>
        {
            modal_background.style.display = "none";
            modal.style.display = "none";
            modal_fail.style.display = "none";
        });
    })

</script>
