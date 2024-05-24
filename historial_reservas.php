<?php session_start(); ?>
<?php 
    if(!isset($_SESSION["nombre"]))
    {
        header("Location:index.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <script src="./jquery.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./estilos/general.css">
    <link rel="stylesheet" href="./estilos/index.css">
    <link rel="stylesheet" href="./estilos/historial.css">
    <title>TorinoFútbol: Tu Historial de Reservas</title>
    <style>
        @media(max-width: 960px){
            .td_historial{
                font-size: 1.3rem;
            }
        }

        @media(max-width: 650px){
            .item_historial{
                margin-bottom: 10px;
            }

            .historial{
                padding: 0px 25px 25px 25px;
                height: 100%;
            }

            #arrow{
                height: 35px;
            }
        }

        @media (max-width: 480px){

            .historial{
                width: 100%;
            }

            .td_historial{
                font-size: 1rem;
            }

            select{
                width: 80%;
                height: 30px;
                font-size: 1rem;
            }

            .item_historial{
                margin-bottom: 5px;
            }

            #filtros_historial{
                height: 52px;
            }
        }

    </style>
</head>
<body>
    
        <?php include("./nav_online.php") ?>

        <main>
        <a href="./index.php"><img src="./imgs/left_arrow2.png" alt="Volver" id="arrow"></a>
            <article class="historial">
                <article id="filtros_historial" class="header_historial">
                    <form id="container_filtro" method="post" enctype="multipart/form-data">
                        <select name="filtro_cancha" id="filtro_cancha">
                            <option value="" selected>Todas las Canchas</option>
                            <option value="1">F5 (A)</option>
                            <option value="2">F5 (B)</option>
                            <option value="3">F7 (A)</option>
                            <option value="4">F7 (B)</option>
                            <option value="5">F8 (A)</option>
                            <option value="6">F8 (B)</option>
                        </select>
                        <!-- <button>Buscar</button> -->
                        <input type="checkbox" id="check">
                        <span style="font-size: 1.2rem;">Faltas</span>
                    </form>
                </article>
                <table id="tabla">
                    <thead>
                        <tr id="th_historial" class="header_historial">
                            <th class="td_historial">Día</th>
                            <th class="td_historial">Cancha</th>
                            <th class="td_historial">Hora</th>
                        </tr>
                    </thead>
                    <tbody id="body_tabla">
                    </tbody>
                </table>
            </article>
    </main>
    <?php include("./footer.php"); ?>
</body>
</html>

<?php include("./nav_desplegable.php") ?>

<script>

    const html = new DOMParser();
    let filtro = document.getElementById("filtro_cancha");
    let body_tabla = document.getElementById("body_tabla");
    let check = document.getElementById("check");
    var checkflag = false;
    
    filtrar_reservas();


    check.addEventListener('change', ()=>{
        mostrar_ocultar_faltas();
    })

    filtro.addEventListener('change', ()=>{
        filtrar_reservas();
    });

    //FUNCIONES

    function filtrar_reservas()
    {
        let formulario = new FormData(document.getElementById("container_filtro"));
        $("#body_tabla").empty();
        $.ajax({
            url: './filtrar_reservas.php',
            type: 'post',
            method: 'post',
            enctype: 'multipart/form-data',
            processData: false,
            contentType: false,
            cache: false,
            data: formulario,
            success: function (datos)
            {
                let respuesta = JSON.parse(datos);
                generar_tabla(respuesta);
                if(body_tabla.childNodes.length == 0)
                {
                    body_tabla.innerHTML = "<tr class='item_historial'><td class='td_historial'>No hay reservas...</td></tr>";
                }
            }
        });
    }

    function generar_tabla(data)
    {
        var fila = "";
        data.forEach((registro) =>{   
            if(parseInt(registro["asistio"]) == 0){
                fila += `
                <tr class='item_historial_falta'>\
                <td class='td_historial'>${registro["dia"]}</td>\
                <td class='td_historial'>${registro["cancha"]}</td>\
                <td class='td_historial'>${registro["hora"]}</td>\
                </tr>\
                `
            }
            else
            {
                fila += `
                <tr class='item_historial'>\
                <td class='td_historial'>${registro["dia"]}</td>\
                <td class='td_historial'>${registro["cancha"]}</td>\
                <td class='td_historial'>${registro["hora"]}</td>\
                </tr>\
                `
            }
        });

        body_tabla.innerHTML = fila;
    }

    function mostrar_ocultar_faltas()
    {
        let sin_falta = document.querySelectorAll(".item_historial");
        checkflag = !checkflag;
        if(checkflag == true)
        {
            sin_falta.forEach((item)=>{
                item.style.display = "none";
            })
        }
        else
        {
            sin_falta.forEach((item)=>{
                item.style.display = "flex";
            })
        }
    }

</script>
