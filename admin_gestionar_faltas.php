<?php session_start(); ?>
<?php 
    if(intval($_SESSION["Administrador"]) != 1)
        header("Location:index.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="./jquery.js"></script>
    <title>TorinoFútbol: Admin - Usuarios</title>
    <style>
        body, html
        {
            height: 100%;
            font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
        }

        .nav_admin
        {
            height: 55px;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 2px solid #8650fe;
        }

        main
        {
            display: flex;
            justify-content: center;
            align-content: center;
            flex-wrap: wrap;
            height: 60vh;
        }

        .logo
        {
            width: 120px;
            margin-left: 10px;
            cursor: pointer;
        }

        .opcion
        {
            cursor: pointer;
            color: #8650fe;
            font-size: 20px;
            font-weight: bold;
            padding: 14px;
            margin-right: 15px;
            border-radius: 10px;
        }

        a
        {
            text-decoration: none;
        }

        #admin_links
        {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 500px;
        }

        .admin_btn
        {
            background-color: white;
            width: 130px;
            border-radius: 0;
            border: 2px solid #8650fe;
            cursor: pointer;
            text-align: center;
            transition: 1s;
        }

        .admin_btn:hover
        {
            background-color: #d0bbff;
        }

        h1
        {
            color:#8650fe;
            font-size: 2.5rem;
        }

        .item_historial
        {
            width: 100%;
            height: 60px;
            background-color: whitesmoke;
            color: #8650fe;
            display: flex;
            justify-content: space-around;
            border-radius: 10px;
            margin-bottom: 5px;
            transition: 1s;
        }

        .item_historial:hover
        {
            background-color: #702eff;
            color: white;
        }

        #tabla
        {
            width: 60%;
            height: 200px;
            margin: auto;
        }

        thead, th
        {
            position: sticky;
            top: 0;
            /* font-size: 1.5rem; */
        }

        .td_historial
        {
            width: 10%;
            /* margin-left: 10px; */
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content:left;
            /* text-align: left; */
            font-size: 1rem;
        }

        #th_historial
        {
            background-color: #333;
            color: white;
            border-radius: 20px 20px 0 0;
        }

        #filtros_historial
        {
            margin-top: 8px;
            color: white;
            height: 70px;
            background: linear-gradient(45deg, #481f9e, #8650fe 80%);
        }

        #container_filtro
        {
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-left: 20px;
            padding-right: 20px;
        }

        select, button
        {
            width: 180px;
            height: 35px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-family: inherit;
            text-align: center;
            font-weight: bold;
            /* font-size: 1rem; */
        }


        .id, .faltas, .reservas, .nivel{
            width: 10%;
            justify-content: center;
        }

        .nombre, .apellido{
            width: 15%;
        }

        .email{
            width: 25%;
        }


        #form_faltas{
            width: 60%;
            display: block;
            margin: 80px auto 50px auto;
            text-align: center;
        }

        #titulo_faltas{
            font-size: 3rem;
            color:#702eff;
            font-weight: bold;
        }

        #filtro_faltas{
            padding: 20px;
            box-sizing: border-box;
            display: block;
            margin: 30px auto;
            width: 250px;
            border-radius: 10px;
            border: 2px solid #8650fe;
            font-family: inherit;
            /* background-color:#d0bbff; */
        }

        #btn_buscador_faltas{
            display: block;
            margin: auto;
            padding: 15px;
            width: 125px;
            border: none;
            height: 50px;
            border-radius: 10px;
            background-color: greenyellow;
            font-weight: bold;
            cursor: pointer;
        }

        #btn_aplicar_falta{
            position: relative;
            top: -19px;
            width: 120px;
            height: 42px;
            background-color: red;
            border-radius: 0px 0px 10px 10px;
            font-family: inherit;
            color: white;
            transition: 1s;
            border: none;
            cursor: pointer;
        }

        #btn_aplicar_falta:hover
        {
            background-color:crimson;
        }

        #td_btn_falta{
            text-align: right;
        }

        @media(max-width: 650px){
            #tabla, #filtro_faltas{
                width: 100%;
            }

            .td_historial{
                font-size: 0.7rem;
            }

            #titulo_faltas{
                font-size: 2rem;
            }
        }


    </style>
</head>
<body>
    <?php include("./nav_admin.php") ?>
    <div id="form_faltas">
            <div id="titulo_faltas">Gestión de Faltas</div>
            <input type="email" name="email" id="filtro_faltas" placeholder="Email usuario..." required autocomplete="off">
            <button id="btn_buscador_faltas" value="Buscar">Buscar</button>
    </div>
    <table id="tabla">
        <thead>
            <tr id="th_historial" class="item_historial">
                <th class="id td_historial">ID</th>
                <th class="nombre td_historial">Nombre</th>
                <th class="apellido td_historial">Apellido</th>
                <th class="reservas td_historial">Racha</th>
                <th class="faltas td_historial">Faltas</th>
            </tr>
        </thead>
        <tbody id="body_tabla">
        </tbody>
    </table>
</body>
</html>
<script>

    let body_tabla = document.getElementById("body_tabla");
    console.log(body_tabla.childNodes.length);
    verificar_tabla_vacia();

    document.getElementById("btn_buscador_faltas").addEventListener('click', ()=>{
        $("#body_tabla").empty();
        $.ajax({
            url: './listar_usuarios.php',
            method: 'post',
            data: {email: $("#filtro_faltas").val()},
            success: function(res)
            {
                let datos = JSON.parse(res);
                generar_tabla(datos);
                verificar_tabla_vacia();
            }
        })
    });

    function generar_tabla(data)
    {
        data.forEach((elemento) =>{           
            let tr_filtro = document.createElement("tr");
            let td_id = document.createElement("td");
            let td_nombre = document.createElement("td");
            let td_apellido = document.createElement("td");
            let td_email = document.createElement("td");
            let td_faltas = document.createElement("td");
            let td_racha = document.createElement("td");

            //Creo tr, td y botón para aplicar falta
            let tr_boton = document.createElement("tr");
            let td_boton = document.createElement("td");
            let boton = document.createElement("input");

            boton.setAttribute("type", "submit");
            boton.value = "Aplicar Falta";

            tr_filtro.className = "item_historial";

            td_id.innerHTML = elemento["id"];
            td_id.className = "id td_historial";
            td_nombre.innerHTML = elemento["nombre"];
            td_nombre.className = "nombre td_historial";
            td_apellido.innerHTML = elemento["apellido"];
            td_apellido.className = "apellido td_historial";
            td_faltas.innerHTML = elemento["faltas"];
            td_faltas.className = "faltas td_historial";
            td_racha.innerHTML = elemento["racha"];
            td_racha.className = "faltas td_historial";

            td_boton.setAttribute("id", "td_btn_falta");
            boton.innerHTML = "Aplicar Falta";
            boton.setAttribute("id", "btn_aplicar_falta");
            
            boton.addEventListener('click', ()=>{
                $.ajax({
                    url: './aplicar_falta.php',
                    method: 'post',
                    data: {email: elemento["email"]},
                    success: function(res)
                    {
                        alert(`La falta ha sido aplicada al usuario ${elemento["nombre"]} ${elemento["apellido"]}`);
                        $("#body_tabla").empty();
                        verificar_tabla_vacia();
                    }
                });
            });

            tr_filtro.appendChild(td_id);
            tr_filtro.appendChild(td_nombre);
            tr_filtro.appendChild(td_apellido);
            tr_filtro.appendChild(td_racha);
            tr_filtro.appendChild(td_faltas);

            tr_boton.appendChild(td_boton);
            td_boton.appendChild(boton);

            body_tabla.appendChild(tr_filtro);
            body_tabla.appendChild(tr_boton);
        });
    }

    function verificar_tabla_vacia(){
        if(body_tabla.childElementCount == 0)
            {
                let tr_filtro = document.createElement("tr");
                let td_vacio = document.createElement("td");

                tr_filtro.className = "item_historial";
                td_vacio.innerHTML = "Vacío...";
                td_vacio.className = "td_historial";
                tr_filtro.appendChild(td_vacio);
                body_tabla.appendChild(tr_filtro);
            }
    }

</script>