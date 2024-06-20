<?php session_start(); ?>
<?php 
    //SI EL USUARIO REDIRECCIONADO ES ADMIN, VUELVO A REDIRECCIONAR
    if(isset($_SESSION["rol"]))
    {
        if(intval($_SESSION["rol"]) == 1){
            header("Location:admin_reservas.php");
        }

    }
?>

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

    #sintetico
    {
        width: 100%;
        height: 300px;
        background-image: url("./imgs/sinteticoHD.jpeg");
        background-size: cover;
        background-repeat: no-repeat;
    }

    .bienvenido
    {
        font-size: 5rem;
        color: yellow;
        font-weight: bold;
        width: 100%;
        text-shadow: 1px 1px 30px black;
        padding: 70px 40px 70px 30px;
        margin: auto;
        background-image: url("./imgs/jugador_pelota2.jpeg");
        background-repeat: no-repeat;
        background-size:cover;
        box-sizing: border-box;
        border-bottom: 6px solid crimson;
        cursor:default;
    }


    </style>
</head>
<body>
    <span id="modal_background"></span>

    <!-- NAV -->
    <?php 
        //SI EN LA SESION NO ESTÁ EL ATRIBUTO NOMBRE, ENTONCES EL USUARIO NO SE LOGUEÓ
        if(!isset($_SESSION['nombre']))
        {
            include("./nav_offline.php");
            include("./index_offline.php");
        }
        else
        {
            include("./nav_online.php");
            include("./index_online.php");
        }
    ?>
</body>
</html>

<script>
    let preguntas = document.querySelectorAll(".pregunta");

    preguntas.forEach((pregunta)=>{
        pregunta.addEventListener('click', ()=>{
            let respuesta = pregunta.nextElementSibling;

            

            if(respuesta.style.maxHeight == "0px" || respuesta.style.maxHeight == 0)
            {
                pregunta.firstElementChild.style.transform = "rotate(180deg)";
                respuesta.children[0].style.color = "#3e139c";
                respuesta.children[0].style.display = "block";
                respuesta.style.maxHeight = "500px";
            }
            else{
                pregunta.firstElementChild.style.transform = "rotate(0deg)";
                respuesta.children[0].style.color = "white";
                respuesta.style.transition = "max-height 0.3s ease-out"
                respuesta.style.maxHeight = "0px";   
                setTimeout(()=>{
                    respuesta.children[0].style.display = "none";
                }, 300)
                // respuesta.children[0].style.display = "none";
            }
        });
    })
</script>

