<?php session_start(); ?>
<?php 
        if(intval($_SESSION["rol"]) == 1){
            header("Location:admin_canchas.php");
        }
    
        if(intval($_SESSION["rol"]) == 0){
            header("Location:index.php");
        }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilos/modal.css">
    <link rel="stylesheet" href="estilos/general.css">
    <link rel="stylesheet" href="estilos/admin.css">
    <script src="./jquery.js"></script>
    <title>TorinoFútbol: Admin - Usuarios</title>
    <style>
        body, html
        {
            height: 100%;
            background: white;
            /* font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif; */
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

        .nav1{
            background: white;
        }

        .opcion{
            color: #8650fe;
        }

        .opcion:hover{
            background: white;
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
            margin-bottom: 0px;
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
            border-radius: 10px 10px 0 0;
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
            margin: 50px auto 0px auto;
            width: 250px;
            border-radius: 8px;
            border: 2px solid #8650fe;
            font-family: inherit;
            color:#8650fe;
            /* background-color:#d0bbff; */
        }

        #btn_buscador_faltas{
            display: block;
            margin: 50px auto;
            padding: 15px;
            width: 125px;
            border: none;
            height: 50px;
            border-radius: 8px;
            background-color: #25d366;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }

        #btn_aplicar_falta{
            background-color: red;
            margin-left: -120px;
            color: white;
        }

        #btn_aplicar_vale{
            background-color: #8650fe;
            color: white;
            margin-left: -260px;
        }

        #btn_quitar_falta{
            background-color: dodgerblue;
            color: white;
            margin-left: -260px;
        }

        .btn{
            position: relative;
            width: 120px;
            height: 42px;
            left: 100%;
            border-radius: 0px 0px 10px 10px;
            font-family: inherit;
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

        .opcionEmail{
            border: 1px solid lightgray;
            padding: 10px;
            width: 250px;
            box-sizing: border-box;
        }

        #res{
            width: 250px;
            margin: auto;
            max-height: 112px;
            overflow: scroll;
        }

        .opcionEmail:hover{
            background: dodgerblue;
            color:white;
        }

        .modal_vale{
            display: none;
            z-index:2;
            width: 350px;
            background: white;
            height: auto;
            border-radius: 10px;
            padding: 10px;
            box-sizing: border-box;
            border: 2px solid #8650fe;
            color: #8650fe;
            position: fixed;
            left: 50%;
            top: 50%;
            margin-top: -150px;
            margin-left: -175px;
            font-weight: bold;
        }

        #monto_vale_modal{
            width: 85%;
            margin: auto;
            display: inline-block;
            color: #8650fe;
        }

        #titulo_modal_vale{
            font-size:1.5rem;
            text-align:center
        }

        .precio_cancha{
            padding: 5px;
            border-radius: 12px;
            width: 30%;
            text-align: center;
            background-color: lavender;
            cursor: pointer;
        }

        @media(max-width: 1300px){
            .opcion
            {
                font-size: 12px;
            }
        }

        @media(max-width: 650px){
            #tabla, #filtro_faltas, #res{
                width: 100%;
            }

            .td_historial{
                font-size: 0.7rem;
            }

            #titulo_faltas{
                font-size: 2rem;
            }

            .modal_vale{
                width: 97%;
                margin-left: 0;
                left: 0;
            }
        }
    </style>
</head>
<body>
    <div id="modal_background"></div>
    <?php include("./nav_superadmin.php") ?>

    <!-- MODAL -->
    <div class="modal_vale">
        <div class="modal_nav">
            <div>Generar Vale</div>
            <div class="modal_cerrar" id="cerrar_modal_vale">X</div>
        </div>
        <br>
        <div id="titulo_modal_vale"></div>
        <br>
        <div style="display:flex;justify-content:space-between;align-items:center">
            $<input type="number" class="precio_cancha" id="monto_vale_modal" placeholder="Ingrese monto del vale...">
        </div>
        <br><br>
        <div class="botones_admin">
            <div id="boton_modal_vale" class="boton_modal_admin guardar"  type="submit">Aceptar</div>
        </div>
    </div>


    <div id="form_faltas">
            <div id="titulo_faltas">Gestión de Faltas</div>
            <input type="email" name="email" id="filtro_faltas" placeholder="Email usuario..." required autocomplete="off">
            <div id="res"></div>
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
<?php include("nav_desplegable.php"); ?>
<script>

    let body_tabla = document.getElementById("body_tabla");
    let res = document.getElementById("res");

    document.getElementById("cerrar_modal_vale").addEventListener('click', ()=>{
        document.getElementById("modal_background").style.display = "none";
        document.querySelector(".modal_vale").style.display = "none";
    });


    let busquedaInput = document.getElementById("filtro_faltas");
        busquedaInput.addEventListener('keyup', ()=>{
        if(busquedaInput.value == "") res.innerHTML = "";
        else buscarUsuarios(busquedaInput.value);
    })


    verificar_tabla_vacia();

    document.getElementById("btn_buscador_faltas").addEventListener('click', ()=>{
        $("#body_tabla").empty();
        $.ajax({
            url: './buscar_usuario.php',
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

    async function buscarUsuarios(val) {

    fetch('./listar_usuarios.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'  // Indicamos que los datos se envían en el formato correcto
            },
            body: new URLSearchParams({
                'email': val  // Enviar los datos del input en el cuerpo de la petición
            })
        })
        .then(response => response.json())  // Asumimos que la respuesta es JSON
        .then(data => {
            res.innerHTML = "";
            data.forEach((elem) => {
                let div = document.createElement("div");
                div.className = "opcionEmail";
                div.innerText = elem["email"];
                div.addEventListener('click', ()=> {
                    document.getElementById("filtro_faltas").value = div.innerText;
                    res.innerHTML = "";
                })
                res.appendChild(div);
            })
        })
        .catch(error => {
            console.error('Error:', error);  // Manejar cualquier error
        });
    }

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

            //botones
            let boton_aplicar_falta = document.createElement("input");
            let boton_quitar_falta = document.createElement("input");
            let boton_vale = document.createElement("input");

            boton_vale.setAttribute("type", "submit");
            boton_vale.setAttribute("id", "btn_aplicar_vale");
            boton_vale.value = "Aplicar Vale";
            boton_vale.innerHTML = "Aplicar Vale";
            boton_vale.className = "btn";

            boton_aplicar_falta.setAttribute("type", "submit");
            boton_aplicar_falta.setAttribute("id", "btn_aplicar_falta");
            boton_aplicar_falta.value = "Falta + 1";
            boton_aplicar_falta.innerHTML = "Falta + 1";
            boton_aplicar_falta.className = "btn";

            boton_quitar_falta.setAttribute("type", "submit");
            boton_quitar_falta.setAttribute("id", "btn_quitar_falta");
            boton_quitar_falta.value = "Falta - 1";
            boton_quitar_falta.innerHTML = "Falta - 1";
            boton_quitar_falta.className = "btn";
            
            tr_filtro.className = "item_historial";

            td_id.innerHTML = elemento["id"];
            td_id.className = "id td_historial";
            td_id.setAttribute("id", "id_usuario");
            td_nombre.innerHTML = elemento["nombre"];
            td_nombre.className = "nombre td_historial";
            td_apellido.innerHTML = elemento["apellido"];
            td_apellido.className = "apellido td_historial";
            td_faltas.innerHTML = elemento["faltas"];
            td_faltas.className = "faltas td_historial";
            td_racha.innerHTML = elemento["racha"];
            td_racha.className = "faltas td_historial";

            boton_aplicar_falta.addEventListener('click', ()=>{
                $.ajax({
                    url: './sumar_falta.php',
                    method: 'post',
                    data: {id: elemento["id"]},
                    success: function(res)
                    {
                        alert(`La falta ha sido aplicada al usuario ${elemento["nombre"]} ${elemento["apellido"]}`);
                        $("#body_tabla").empty();
                        verificar_tabla_vacia();
                    }
                });
            });

            boton_quitar_falta.addEventListener('click', ()=>{
                $.ajax({
                    url: './quitar_falta.php',
                    method: 'post',
                    data: {id: elemento["id"]},
                    success: function(res)
                    {
                        alert(`La falta se le ha retirado al usuario ${elemento["nombre"]} ${elemento["apellido"]}`);
                        $("#body_tabla").empty();
                        verificar_tabla_vacia();
                    }
                });
            });


            boton_vale.addEventListener('click', ()=>{
                document.getElementById("modal_background").style.display = "block";
                document.querySelector(".modal_vale").style.display = "block";
            })

            //Esto debería ir en otro lado, una vez que ya se indicó el vale!

            // boton_vale.addEventListener('click', ()=>{
            //     $.ajax({
            //         url: './aplicar_vale.php',
            //         method: 'post',
            //         data: {email: elemento["email"]},
            //         success: function(res)
            //         {
            //             alert(`El vale ha sido aplicado al usuario ${elemento["nombre"]} ${elemento["apellido"]}`);
            //             $("#body_tabla").empty();
            //             verificar_tabla_vacia();
            //         }
            //     });
            // });

            tr_filtro.appendChild(td_id);
            tr_filtro.appendChild(td_nombre);
            tr_filtro.appendChild(td_apellido);
            tr_filtro.appendChild(td_racha);
            tr_filtro.appendChild(td_faltas);

            body_tabla.appendChild(tr_filtro);
            body_tabla.appendChild(boton_aplicar_falta);
            body_tabla.appendChild(boton_quitar_falta);
            body_tabla.appendChild(boton_vale);
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

    function limpiar_modal(){
        document.getElementById("monto_vale_modal").empty;
    }

    document.getElementById("boton_modal_vale").addEventListener('click', ()=>{
                $.ajax({
                    url: './aplicar_vale.php',
                    method: 'post',
                    data: {monto: document.getElementById("monto_modal_vale").value,
                            id_usuario:document.getElementById("id_usuario").innerHTML},
                    success: function(res)
                    {
                        alert(`Se le ha aplicado el vale al usuario ${elemento["nombre"]} ${elemento["apellido"]}`);
                        $("#body_tabla").empty();
                        verificar_tabla_vacia();
                        limpiar_modal();
                    }
                });
            });


</script>