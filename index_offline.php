<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./estilos/index.css">
    <link rel="stylesheet" href="./estilos/general.css">
    <link rel="stylesheet" href="./estilos/modal.css">
    <title>Torino Fútbol: Reservá las mejores canchas</title>
    <style>

        @media(max-height: 500px){
            #modal_inicio_sesion, #modal_inicio_sesion_fail{
                padding: 5px 20px;
                position: fixed;
                top: 0;
                width: 100%;
                height: 100vh;
                overflow: scroll;
                font-size: 1.2rem;
                margin: 0;
                left: 0;
                color: #6b27fc;
                box-sizing: border-box;
                position: fixed;
                background-color: white;
                border-radius: 0;
                border: none;
                min-height: 0;
                z-index: 3;
            }
        }

        @media(max-width: 920px){
            #texto_niveles
            {
                font-size: 2rem;
            }
        }

        @media(max-width: 650px){
            #nav1_responsive{
                display: flex;
            }
            .bienvenido
            {
                font-size: 2.5rem;
                background-image: url("./imgs/jugador_pelota7.png");
            }

            .item_nivel{
                height: 200px;
            }

            .item_texto{
                font-size: 1.2rem;
            }

            #container_reservas{
                height: auto;
            }

            .texto_info{
                font-size: 2.7rem;
            }

            .titulo_info{
                font-size: 3.4rem;
            }

            #texto_niveles{
                font-size: 1.2rem;
            }

            #titulo_reservas{
                font-size: 2.4rem;
                text-align: center;
            }

            .reserva{
                font-size: 1.2rem;
                text-align: center;
            }

            .info_titulo{
                font-size: 2.2rem;
            }

            .info_texto{
                font-size: 1.5rem;
            }

            .info_container{
                padding: 45px 12px;
            }

            .titulo_2{
                font-size: 3rem;
            }

            .titulo_4{
                font-size: 1.5rem;
            }
            .item_texto td {
                font-size: 1.2rem;
            }

            .item_nivel{
                width: 90%;
            }
        }

        @media(max-width: 425px){
            #texto_niveles{
                font-size: 1rem;
            }
        }

        @media(max-width: 360px){

            #titulo_reservas{
                font-size: 2rem;
            }

            .reserva{
                font-size: 1rem;
            }
        }

        @media(min-width: 651px){
            .opcion_desplegable
            {
                display:none;
            }
        }
    </style>
</head>
<body>
    <span id="modal_background"></span>
    <main>
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

        <!-- PORTADA -->
        <h1 class="bienvenido">
            Buscá tu Cancha. <br>
            Reservá. <br>
            Jugá.
        </h1>
    
        <div class="info_container">
            <div class="titulo_2 violeta">Alquilá con nosotros, <br>disfrutá de los beneficios</div><br>
            <div class="info_texto">
                En Torino Fútbol premiamos la constancia de nuestros clientes. <br>
                Registrate, acumulá tus reservas y disfrutá de beneficios en precios y gestiones.
            </div>
            <br>
    
            <!-- TARJETAS -->
            <?php include("./niveles.php") ?>
        </div>

        <?php include("./faqs.php") ?>

        <div class="info_container">
            <div class="titulo_2 violeta" style="text-align: center;">Canchas que hacen la diferencia</div><br>
            <div class="info_texto" style="text-align: center;">Césped sintético profesional<br>Sistemas de drenaje anti-inundación</div>
        </div>
        
        <div id="sintetico">
        </div>

    </main>

    <?php include("./footer.php") ?>
</body>
</html>
<?php include("./nav_desplegable.php") ?>
<script>

    var iniciar_sesion_desplegable = document.getElementById("iniciar_sesion_desplegable");
    var iniciar_sesion = document.getElementById("iniciar_sesion");
    var modal = document.getElementById("modal_inicio_sesion");
    var modal_fail = document.getElementById("modal_inicio_sesion_fail");
    var cerrar_modal = document.querySelectorAll(".modal_cerrar");
    var modal_background = document.getElementById("modal_background");
    
    window.onbeforeunload = history.pushState(null, null, "index.php");
    
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
