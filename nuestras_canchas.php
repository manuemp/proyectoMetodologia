<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilos/general.css">
    <link rel="stylesheet" href="estilos/index.css">
    <link rel="stylesheet" href="./estilos/modal.css">
    <style>

        body{
            background: linear-gradient(45deg, white 70%, lavender);
        }

        h1{
            font-size: 4rem;
        }

        .container_cancha{
            width: 95%;
            margin: auto;
            border-radius: 20px;
            overflow: hidden;
            margin-top: 20px;
            display: flex;
            box-shadow: 8px 7px 7px 3px lightgray;
        }
        .img_cancha{
            width: 70%;
        }
        .descripcion_cancha{
            color: #8650fe;
            width:30%;
            font-size: 4rem;
            color: white;
            background: linear-gradient(45deg, #4114a2, #8650fe);
            display: flex;
            justify-content: center;
            align-items: center;
            font-weight: bold;
        }

        #arrow{
            height: 70px;
        }

        @media(max-width: 650px){
            h1{
                font-size: 3rem;
            }
            .titulo_4{
                font-size: 1.8rem;
            }
            .texto_1{
                font-size: 1.2rem;
            }

            .img_cancha{
                width: 75%;
            }

            .descripcion_cancha{
                font-size: 2rem;
            }

            .info_container{
                padding: 25px;
            }

            #arrow{
                height: 50px;
            }
        }
    </style>
    <title>Nuestras Canchas</title>
</head>
<body>
    <?php include("nav_offline.php") ?>

    <div id="modal_background"></div>
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
        <a href="./index.php"><img src="./imgs/left_arrow2.png" alt="Volver" id="arrow"></a>
            <img src="./imgs/torinoLogoBlanco_2.png" class="logo" alt="logoTorino">
        </div>

    <div class="info_container">
        <h1 class="violeta_oscuro">Nuestras Canchas</h1>
        <div class="titulo_4 violeta">
            En TorinoFutbol las mejores canchas te esperan
        </div><br>
        <div class="violeta_oscuro texto_1 " style="font-weight: bold;">
            Contamos con 6 canchas para que vivas de una experiencia de primera calidad y disfrutes jugando.
            ¡Sumate a jugar en nuestro predio!
        </div>
    </div>

    <div class="container_cancha">
        <img src="./imgs/canchas/f51.jpg" alt="cancha de 8" class="img_cancha">
        <div class="descripcion_cancha">F5 A</div>
    </div>

    <div class="container_cancha">
        <div class="descripcion_cancha">F5 B</div>
        <img src="./imgs/canchas/futbol5 2.jpg" alt="cancha de 8" class="img_cancha">
    </div>

    <div class="container_cancha">
        <img src="./imgs/canchas/7.jpeg" alt="cancha de 8" class="img_cancha">
        <div class="descripcion_cancha">F7 A</div>
    </div>

    <div class="container_cancha">
        <div class="descripcion_cancha">F7 B</div>
        <img src="./imgs/canchas/f7 b.jpeg" alt="cancha de 8" class="img_cancha">
    </div>

    <div class="container_cancha">
        <img src="./imgs/canchas/f8 2.jpg" alt="cancha de 8" class="img_cancha">
        <div class="descripcion_cancha">F8 A</div>
    </div>

    <div class="container_cancha">
        <div class="descripcion_cancha">F8 B</div>
        <img src="./imgs/canchas/f8 3.jpg" alt="cancha de 8" class="img_cancha">
    </div>

    <br><br><br>

    <?php include("footer.php") ?>

</body>
</html>
<?php include("nav_desplegable.php") ?>

<script>
    var iniciar_sesion_desplegable = document.getElementById("iniciar_sesion_desplegable");
    var iniciar_sesion = document.getElementById("iniciar_sesion");
    var modal = document.getElementById("modal_inicio_sesion");
    var modal_fail = document.getElementById("modal_inicio_sesion_fail");
    var cerrar_modal = document.querySelectorAll(".modal_cerrar");
    var modal_background = document.getElementById("modal_background");
    
    // window.onbeforeunload = history.pushState(null, null, "index.php");
    
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