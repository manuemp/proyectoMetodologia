<?php session_start(); ?>
<?php
    if(intval($_SESSION["Administrador"]) != 1)
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
    <title>TorinoFútbol: Admin - Reservas</title>
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
        <h1>Administrar Reservas</h1>
    
        <!-- MODAL RESERVA ESPECIFICA USUARIO -->
        <section id="modal_admin">
            <input type="hidden" id="modal_hidden">
            <div class="campo_admin" id="modal_numero_reserva" style="border-bottom: 2px solid red;">Reserva n° 117</div>
            <div class="campo_admin" id="modal_nombre"></div>
            <div class="campo_admin" id="modal_dia"></div>
            <div class="campo_admin" id="modal_cancha"></div>
            <div class="campo_admin" id="modal_mail"></div>
            <div class="campo_admin" id="modal_senia">Seña: $<input type="text" id="input_senia"><span style="color:lightgray" id="debe">Debe: </span></div>
            <div class="campo_admin" id="modal_precio">Total: <span style="color: crimson">$22.000,00</span></div>
            <div class="botones_admin"><button id="modal_adm_salir" class="boton_modal_admin cerrar">Salir</button><button id="modal_adm_guardar" class="boton_modal_admin guardar">Guardar</button></div>
        </section>
    
        <!-- MODAL ESTADOS RESERVA -->
        <section id="modal_estados">
            <div id="nav_modal_estados">
                <div style="font-weight: bold;">Estados de reserva</div>
                <div class="modal_cerrar cerrar" id="modal_estado_salir">X</div>
            </div>
            <img src="./imgs/estado_reservas.png" alt="estados" id="img_estados">
            <img src="./imgs/estado_reservas_responsive.png" alt="estados" id="img_estados_responsive">
        </section>
    
        <!-- MODAL FALTA -->
        <section id="modal_falta" style="line-height: 2">
            <div>
                <div style="font-weight: bold; color: crimson">Aplicar Falta a usuario</div>
            </div>
            <div class="titulo_modal_falta" style="color: #8560fe;font-weight: bold;">¿Desea aplicar una falta al usuario?</div>
            <div class="contenido_modal_falta">
                    <div><span id="nombre_falta"></span> <span id="apellido_falta"></div>
                    <div><span id="mail_falta"></span></div>
                    <div><span id="dia_falta"></span> <span id="hora_falta"></div>
                    <div><span id="cancha_falta"></span></div>
            </div>
            <div class="botones_admin"><button class="boton_modal_admin cerrar">Salir</button><button class="boton_modal_admin guardar" id="falta_reserva">Falta</button></div>
        </section>
    
        <!-- MODAL BORRAR RESERVA -->
        <section id="modal_baja" style="line-height: 2">
            <div>
                <div style="font-weight: bold; color: crimson">Borrar reserva del usuario</div>
            </div>
            <div class="titulo_modal_falta" style="color: #8560fe;font-weight: bold;">¿Desea borrar la reserva?</div>
            <div class="contenido_modal_falta">
                    <div><span id="nombre_baja"></span> <span id="apellido_falta"></div>
                    <div><span id="mail_baja"></span></div>
                    <div><span id="dia_baja"></span> <span id="hora_falta"></div>
                    <div><span id="cancha_baja"></span></div>
            </div>
            <div class="botones_admin"><button class="boton_modal_admin cerrar">Salir</button><button class="boton_modal_admin guardar" id="baja_reserva">Baja</button></div>
        </section>
    
    
        <table id="tabla">
            <thead>
                <tr>
                    <th id="filtros_historial" class="item_historial" style="margin-top: -3px; margin-bottom: 2px;">
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
                            <select name="filtro_dia" id="filtro_dia">
                                <option value="" selected>Cualquier Día</option>
                                <?php 
                                    for($i = $dia_inicio ; $i < $dia_limite ; $i++)
                                    {
                                        echo "<option value='" .  date('Y-m-d', strtotime(date('Y-m-d') . ' +' . $i . ' day')) . "'>" . date('d/m/y', strtotime(date('Y-m-d') . ' +' . $i . ' day')) . "</option>";
                                    }
                                ?>
                            </select>
                            <input type="text" placeholder="Filtrar por email" id="filtro_email">
                            <span id="ayuda">Ayuda</span>
                        </form>
                    </th>
                </tr>
                <tr id="th_historial" class="item_historial">
                    <th class="nombre td_historial">Nombre</th>
                    <th class="apellido td_historial">Apellido</th>
                    <th class="email td_historial">Email</th>
                    <th class="cancha td_historial">Cancha</th>
                    <th class="dia td_historial">Día</th>
                    <th class="hora td_historial">Hora</th>
                    <th class="boton td_historial"></th>
                </tr>
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

    document.getElementById("modal_adm_guardar").addEventListener('click', ()=>{
        modal_admin.style.display = "none";
        console.log(document.getElementById("modal_hidden").value);
        $.ajax({
            url: './actualizar_senia.php',
            method: 'post',
            data: {
                id: $("#modal_hidden").val(),
                senia: $("#input_senia").val()
            },
            success: function(res)
            {
                traer_datos();
            }
        })
        modal_background.style.display = "none";
    })


    filtro_cancha.addEventListener('change', ()=> {
        traer_datos();
    });

    filtro_dia.addEventListener('change', ()=>{
        traer_datos();
    })

    filtro_email.addEventListener('keyup', ()=>{
        traer_datos();
    })

    function traer_datos(){
        $.ajax({
            url: './reservas_disponibles_admin.php',
            method: 'post',
            data: {
                filtro_cancha: $("#filtro_cancha").val(),
                filtro_dia: $("#filtro_dia").val(),
                filtro_email: $("#filtro_email").val()
            },
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
            let tr_filtro = document.createElement("tr");
            let tr_filtro_responsive = document.createElement("tr");
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
            boton_falta.innerHTML = "FALTA";
            boton_responsive.className = "btn_falta";
            boton_responsive.innerHTML = "<img src='./imgs/eliminar.png' class='icono_eliminar'>";
            boton_falta_responsive.innerHTML = "FALTA";
            boton_falta_responsive.className = "btn_falta";

            tr_filtro.innerHTML = `
                <td class='nombre td_historial'>${registro["nombre"]}</td>
                <td class='apellido td_historial'>${registro["apellido"]}</td>
                <td class='email td_historial'>${registro["email"]}</td>
                <td class='cancha td_historial'>${registro["cancha"]}</td>
                <td class='dia td_historial'>${registro["dia"]}</td>
                <td class='hora td_historial'>${registro["hora"]}</td>`;

            td_boton.appendChild(boton_falta);
            td_boton.appendChild(boton);

            tr_filtro.appendChild(td_boton);

            td_boton_responsive.appendChild(boton_responsive);
            td_boton_responsive.appendChild(boton_falta_responsive);

            tr_filtro_responsive.appendChild(td_boton_responsive);

            boton.addEventListener('click', ()=>{
                baja_reserva(registro["id"], registro["email"], registro["nombre"], 
                             registro["apellido"], registro["hora"], registro["cancha"], registro["dia"]);
                flag_btn = true;
            })

            boton_falta.addEventListener('click', ()=>{
                aplicar_falta(registro["id"], registro["email"], registro["nombre"], 
                             registro["apellido"], registro["hora"], registro["cancha"], registro["dia"]);
                flag_btn = true;
            })

            boton_responsive.addEventListener('click', ()=>{
                baja_reserva(registro["id"], registro["email"], registro["nombre"], 
                             registro["apellido"], registro["hora"], registro["cancha"], registro["dia"]);
            })

            boton_falta_responsive.addEventListener('click', ()=>{
                aplicar_falta(registro["id"], registro["email"], registro["nombre"], 
                             registro["apellido"], registro["hora"], registro["cancha"], registro["dia"]);
            })

            //Lleno el modal cuando se haga click en el registro creado
            tr_filtro.addEventListener('click', ()=>{
                if(!flag_btn)
                {
                    modal_admin.style.display = "block";
                    modal_background.style.display = "block";
                    document.getElementById("modal_hidden").value = registro["id"];
                    document.getElementById("modal_numero_reserva").innerHTML = `Reserva n° ${registro["id"]}`;
                    document.getElementById("modal_nombre").innerHTML = `${registro["nombre"]} ${registro["apellido"]}`;
                    document.getElementById("modal_dia").innerHTML = registro["dia"];
                    document.getElementById("modal_cancha").innerHTML = `${registro["cancha"]} -  ${registro["hora"]}hs`;
                    document.getElementById("modal_mail").innerHTML = registro["email"];
                    document.getElementById("debe").innerHTML = `Debe: ${formatter.format(parseInt(registro["precio"]) - parseInt(registro["adelanto"]))}`
                    document.getElementById("modal_precio").innerHTML = `Total: <span style="color:crimson">${formatter.format(registro["precio"])}</span>`;
                    document.getElementById("input_senia").value = registro["adelanto"];
                }
                flag_btn = false;
            });
            
            //Por ultimo, veo si la reserva es de hoy y todavía no se jugó,
            //si es de hoy y ya pasó el horario, o si no es de hoy.
            
            //Agrego ceros a las horas, minutos y segundos del objeto Date para que sea compatible
            //con lo obtenido en la base de datos.
            function addZero(i) {
                if (i < 10) {i = "0" + i}
                return i;
            }

            const d = new Date();
            let hora = `${addZero(d.getHours())}:${addZero(d.getMinutes())}:${addZero(d.getSeconds())}`;
            let hoy = `${addZero(d.getDate())}/${addZero(d.getMonth() + 1)}/${addZero(d.getFullYear())}`

            if(hoy == registro["dia"])
            {
                if(Date.parse(`1/1/2023 ${hora}`) < Date.parse(`1/1/2023 ${registro["hora"]}`))
                {
                    tr_filtro.className = "item_historial hoy";
                    tr_filtro_responsive.style.backgroundColor = "lavender";
                    tr_filtro_responsive.className = "item_responsive hoy";
                }
                else
                {
                    tr_filtro.className = "item_historial hoy_pasado";
                    tr_filtro_responsive.style.backgroundColor = "lightgray";
                    tr_filtro_responsive.className = "item_responsive hoy_pasado";
                }
            }

            if(registro["adelanto"] == registro["precio"]){
                tr_filtro.style.borderLeft = "12px solid #3aea00";
            }
            else if(registro["adelanto"] != "0"){
                tr_filtro.style.borderLeft = "12px solid orange";
            }
            else{
                tr_filtro.style.borderLeft = "12px solid red";
            }

            if(registro["dia_pedido"] != hoy && registro["dia"] != hoy && registro["adelanto"] == "0")
            {
                tr_filtro.className = "item_historial adeuda";
                tr_filtro_responsive.style.backgroundColor = "crimson";
                tr_filtro_responsive.className = "item_responsive adeuda";
            }

            body_tabla.appendChild(tr_filtro);
            body_tabla.appendChild(tr_filtro_responsive);
            
        });
    }

    function baja_reserva(id, email_user, nombre, apellido, hora, cancha, dia){

        let confirmar = confirm(`¿Desea eliminar la reserva del usuario?\n
                                ${nombre} ${apellido}\n
                                ${email_user}\n
                                ${dia}, ${hora}hs\n
                                ${cancha}`
                        );
        if(confirmar)
        {
            $.ajax({
                url: './baja_reserva.php',
                method: 'post',
                data: { 
                        id_reserva : id,
                        email: email_user 
                    },
                success: function(){
                    document.getElementById("modal_baja").style.display = "none";
                    modal_background.style.display = "none";
                    alert("La reserva fue dada de baja");
                    traer_datos();
                }
            });
        }

        //Este código de abajo no sirve, con un modal hecho a mano se guardan los llamados a función
        //porque nunca retorno nada. Lo que esta pasando es que si hago aparecer el modal y lo cancelo,
        //y repito lo mismo x cantidad de veces, se van a almacenar los llamados a función,
        //y a la primera que doy a aceptar, se aceptan todos los anteriores juntos y aplica multiples faltas.
        // modal_background.style.display = "block";
        // document.getElementById("modal_baja").style.display = "block";
        // document.getElementById("nombre_baja").innerHTML = `${nombre} ${apellido}`;
        // document.getElementById("mail_baja").innerHTML = email_user;
        // document.getElementById("dia_baja").innerHTML = `${dia}, ${hora}`;
        // document.getElementById("cancha_baja").innerHTML = cancha;

        // document.getElementById("baja_reserva").addEventListener('click', ()=>{
        //     $.ajax({
        //         url: './baja_reserva.php',
        //         method: 'post',
        //         data: { 
        //                 id_reserva : id,
        //                 email: email_user 
        //             },
        //         success: function(){
        //             document.getElementById("modal_baja").style.display = "none";
        //             modal_background.style.display = "none";
        //             alert("La reserva fue dada de baja");
        //             traer_datos();
        //         }
        //     });
        // });

    }

    function aplicar_falta(id, email_user, nombre, apellido, hora, cancha, dia){

        let confirmar = confirm(`¿Desea aplicar una falta al usuario?\n
                                ${nombre} ${apellido}\n
                                ${email_user}\n
                                ${dia}, ${hora}hs\n
                                ${cancha}`
                        );
        if(confirmar)
        {
            $.ajax({
                url: './aplicar_falta.php',
                method: 'post',
                data: { 
                        id_reserva : id,
                        email: email_user 
                    },
                success: function(){
                    document.getElementById("modal_falta").style.display = "none";
                    modal_background.style.display = "none";
                    alert(`Se aplicó la falta a ${nombre} ${apellido}`);
                    traer_datos();
                }
            });
        }

        //Este código de abajo no sirve, con un modal hecho a mano se guardan los llamados a función
        //porque nunca retorno nada. Lo que esta pasando es que si hago aparecer el modal y lo cancelo,
        //y repito lo mismo x cantidad de veces, se van a almacenar los llamados a función,
        //y a la primera que doy a aceptar, se aceptan todos los anteriores juntos y aplica multiples faltas.

        // modal_background.style.display = "block";
        // document.getElementById("modal_falta").style.display = "block";
        // document.getElementById("nombre_falta").innerHTML = `${nombre} ${apellido}`;
        // document.getElementById("mail_falta").innerHTML = email_user;
        // document.getElementById("dia_falta").innerHTML = `${dia}, ${hora}`;
        // document.getElementById("cancha_falta").innerHTML = cancha;

        // document.getElementById("falta_reserva").addEventListener('click', ()=>{
        //     $.ajax({
        //         url: './aplicar_falta.php',
        //         method: 'post',
        //         data: { 
        //                 id_reserva : id,
        //                 email: email_user 
        //             },
        //         success: function(){
        //             document.getElementById("modal_falta").style.display = "none";
        //             modal_background.style.display = "none";
        //             alert(`Se aplicó la falta a ${nombre} ${apellido}`);
        //             traer_datos();
        //         }
        //     });
        // });
    }

</script>