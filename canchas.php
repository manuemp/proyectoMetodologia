<?php session_start(); ?>
<?php
    if(intval($_SESSION["rol"]) != 1)
    {
        header("Location:index.php");
    }

    date_default_timezone_set("America/Argentina/Buenos_Aires");
        
    //Indices de i para el bucle del select del día para reservar
    $dia_inicio = 0;
    $dia_limite = 7;

    //Si ya pasaron las 21.30, se empiezan a reservar las canchas del día siguiente,
    //por eso variará el valor de $dia_inicio, porque en un loop, por cada vuelta, voy a sumar
    //el valor de la variable para generar los días posibles de reservar en un select.
    //Solo se pueden hacer reservas en un rango de 7 días, arrancando por el actual.
    if(strtotime(date("H:i")) > strtotime("21:30:00"))
    {
        $dia_inicio = 1;
        $dia_limite = 8;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilos/modal.css">
    <link rel="stylesheet" href="estilos/admin.css">
    <script src="./jquery.js"></script>
    <title>TorinoFútbol: Admin - Canchas</title>
    <style>

    @media(max-height: 500px){
        #modal_estados, #modal_admin, #modal_falta, #modal_baja{
            height: 100vh;
            width: 100%;
            top: 0;
            left: 0;
            margin-left: 0;
            box-sizing: border-box;
            border: none;
            border-radius: 0;
            margin-top: 0;
        }

        .campo_admin{
            margin-bottom: 0;
        }

        #modal_falta, #modal_baja, .botones_admin{
            text-align: center;
        }

    }

    @media(max-width: 1070px){
        .btn_falta{
            width: 50px;
            height: 50%;
        }
    }

    @media(max-width: 950px){
        .td_historial{
            font-size: 0.8rem;
        }

        h1{
            text-align: center;
        }

        .hora{
            width: 14%;
        }

        .boton{
            width: 16%;
        }

        #container_filtro{
            justify-content: start;
        }
    }

    @media(max-width: 750px){
        .opcion{
            font-size: 15px;
        }

        .boton{
            display: none;
        }

        .item_responsive{
            display: block;
        }

        .email{
            width: 40%;
        }
        
        .nombre, .apellido{
            display: none;
        }

        .cancha, .dia, .hora{
            width: 20%;
        }

        .item_responsive td{
            width: 125px;
        }

        #filtros_historial{
            height: 40px;
        }

        select, input{
            width: 120px;
            font-size: 0.6rem;
            border: 2px solid #7643e5;
            border-radius: 5px;
            box-sizing: border-box;
            margin-right: 5px;
        }

        .icono_eliminar{
            height: 15px;
        }

        #input_senia{
            border-left: none;
            border-top: none;
            border-right:none;
        }

        .mensaje{
            top: -14px;
        }

        #ayuda{
            padding: 6px;
            font-size: 0.8rem;
        }
    }

    @media(max-width: 650px){
        #img_estados{
            display: none;
        }
        #img_estados_responsive{
            display: block;
        }
        #modal_estados{
            width: 400px;
            margin-left: -200px;
            left: 50%;
            top: 0;
            height: 100vh;
        }
    }

    @media(max-width: 500px){
        .cancha{
            display: none;
        }

        .email{
            width: 55%;
        }

        select, input{
            width: 115px;
        }

        .item_historial{
            height: 40px;
        }

        .td_historial{
            font-size: 0.55rem;
        }

        #filtro_dia{
            display: none;
        }

        .btn_falta{
            font-size: 0.6rem;
        }

        .icono_eliminar{
            height: 12px;
        }

        .item_responsive td{
            height: 40px;
        }

        h1{
            font-size: 1.6rem;
        }

        #modal_admin, #modal_falta, #modal_baja{
            width: 100%;
            margin-left: 0px;
            left: 0;
            padding: 20px 10px;
            height: 100vh;
            top: 0;
            margin-top: 0;
            border: 0;
        }

        .botones_admin{
            position: relative;
        }

        .campo_admin, #input_senia{
            font-size: 0.9rem;
        }

        #input_senia{
            width: 65px;
        }

        #ayuda{
            padding: 0px;
            font-size: 0.6rem;
            height: 33px;
            width: 38px;
        }

        #modal_estados{
            width: 100%;
            margin-left: 0;
            left: 0;
            top: 0;
            height: 100vh;
            border: none;
            border-radius: 0;
            box-sizing: border-box;
        }

        #img_estados_responsive{
            margin: auto;
            width: 300px;
        }
    }
    </style>
</head>
<div id="modal_background"></div>
<body>
    <?php include("./nav_admin.php") ?>
    <main>
        <h1>Canchas</h1>
 
    
        <table id="tabla">
            <thead>
                <tr id="th_historial" class="item_historial">
                    <th class="nombre td_historial">Nombre</th>
                    <th class="precio td_historial">Precio</th>
                    <th class="estado td_historial">Estado</th>
            </thead>
    
            <tbody id="body_tabla">
            </tbody>
        </table>
    </main>
    
    <?php include("./footer.php"); ?>
</body>
</html>
<script>    

    let filtro_cancha = document.getElementById("filtro_cancha");
    let filtro_dia = document.getElementById("filtro_dia");
    let filtro_email = document.getElementById("filtro_email");
    let ayuda = document.getElementById("ayuda");
    var modal_estados = document.getElementById("modal_estados");
    var modal_admin = document.getElementById("modal_admin");
    var modal_background = document.getElementById("modal_background");
    var flag_btn = false;
    
    //Formatter para el total en el modal (signo, coma y punto para el monto)
    const formatter = new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'USD'
            });
    
    //Traer datos automáticamente antes de cargar la página
    traer_datos();

    ayuda.addEventListener('click', ()=>{
        modal_estados.style.display = "block";
        modal_background.style.display = "block";
    })

    document.querySelectorAll(".cerrar").forEach((cerrar)=>{
        cerrar.addEventListener('click', ()=>{
            modal_estados.style.display = "none";
            modal_admin.style.display = "none";
            document.getElementById("modal_baja").style.display = "none";
            document.getElementById("modal_falta").style.display = "none";
            modal_background.style.display = "none";
        })
    })

    
   
    function traer_datos(){
        $.ajax({
            url: './canchas_disponibles.php',
            method: 'post',
            success: function(res)
            {
                $("#body_tabla").empty();
                let datos = JSON.parse(res);
                generar_tabla(datos);
            }
        })
    }

    function generar_tabla(data)
    {
        let fila;
        let cont = 0;
        data.forEach((registro) =>{  
            let td_boton = document.createElement("td");
            let td_boton_responsive = document.createElement("td");
            let boton = document.createElement("button");
            let boton_falta = document.createElement("button");
            let boton_responsive = document.createElement("button");
            let boton_falta_responsive = document.createElement("button");
            

            tr_filtro.className = "item_historial";
            tr_filtro_responsive.className = "item_responsive";
            td_boton.className = "boton";
            boton.className = "btn_falta";
            boton.innerHTML = "<img src='./imgs/eliminar.png' class='icono_eliminar'>";
            boton_falta.className = "btn_falta";
            boton_falta.innerHTML = "INHABLITAR";
            boton_responsive.className = "btn_falta";
            boton_responsive.innerHTML = "<img src='./imgs/eliminar.png' class='icono_eliminar'>";
            boton_falta_responsive.innerHTML = "INHABLITAR";
            boton_falta_responsive.className = "btn_falta";

            tr_filtro.innerHTML = `
                <td class='nombre td_historial'>${registro["nombre"]}</td>
                <td class='precio td_historial'>${registro["precio"]}</td>
                <td class='estado td_historial'>${registro["estado"]}</td>`;

            td_boton.appendChild(boton_falta);
            td_boton.appendChild(boton);

            tr_filtro.appendChild(td_boton);

            td_boton_responsive.appendChild(boton_responsive);
            td_boton_responsive.appendChild(boton_falta_responsive);

            tr_filtro_responsive.appendChild(td_boton_responsive);

        });
    }

</script>