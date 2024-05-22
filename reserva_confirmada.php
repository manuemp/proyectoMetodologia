<?php session_start(); ?>
<?php 
    if(!isset($_SESSION["Nombre"]))
    {
        header("Location:index.php");
    }

    include("./generar_cancha.php");

    $dia = date("d/m/Y", strtotime($_GET["dia"]));

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./estilos/general.css">
    <link rel="stylesheet" href="./estilos/index.css">
    <title>TorinoFútbol: Reserva Confirmada</title>
    <style>
        body, html{
            min-height: 100%;
            min-width: 100%;
            width: 100%;
            height: auto;
            background-image: url("./imgs/fondo_inicio3.jpeg");
            background-repeat: no-repeat;
            background-size: cover;
        }

        main{
            height: 80vh;
        }

        a{
            color: #23d366;
        }

        #container_reserva{
            position: relative;
            top: 40px;
            width: 480px;
            background-color: white;
            border: 2px solid lightgray;
            padding: 20px 45px;
            box-sizing: border-box;
            border-radius: 10px;
            margin: auto;
            font-size: 2rem;
            font-weight: bold;
            color: #333;
        }

        #titulo_reserva{
            color: #8650fe;
            text-align: center;
            margin: 0;
        }

        .info_reserva{
            padding: 10px 10px 10px 10px;
            box-sizing: border-box;
        }

        #contactate{
            font-size: 1.8rem;
        }

        @media(max-width: 550px){
            #container_reserva{
                width: 320px;
                padding: 20px 30px;
                font-size: 1.5rem;
            }

            #titulo_reserva{
                text-align: left;
            }

            #contactate{
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>

    <?php include("./nav_online.php") ?>
    <main>
        <div id="container_reserva">
            <h3 id="titulo_reserva">¡Reserva exitosa!</h3>
            <br>
            <div class="info_reserva"><?php echo generarCancha($_GET["cancha"]); ?></div>
            <div class="info_reserva"><?php echo $dia ?></div>
            <div class="info_reserva"><?php echo $_GET["hora"] ?>hs</div>
            <div class="info_reserva"><span style="color:darkviolet">N°</span> <?php echo $_GET["id_reserva"] ?></div>
            <div class="info_reserva" id="precio"><span style="color:darkviolet"></span></div>
            <br>
            <div id="contactate">Contactate para efectuar la seña:</div><br>
            <div class="info_reserva"><span style="color:darkviolet">Tel:</span> <a href="https://wa.me/1159807762/?text=Hola!%20Me%20comunico%20para%20avisar%20mi%20seña!" target="_blank">1159807762</a></div><br>
            <button class="boton_aceptar" id="volver">Volver al inicio</button>
        </div>
    </main>

    <?php include("./footer.php"); ?>

</body>
</html>

<script>
    window.onbeforeunload = history.pushState(null, null, "index.php");
    
    document.getElementById("volver").addEventListener("click", ()=>{
        location.href = "./index.php";
    });

    const formatter = new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'USD'
            });
    
    document.getElementById("precio").innerHTML = `<span style="color:darkviolet">${formatter.format(<?php echo $_GET['precio'] ?>)}</span>`;
        
</script>