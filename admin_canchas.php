<?php 
    session_start();

    if(intval($_SESSION["rol"]) == 1 || intval($_SESSION["rol"] == 0)){
        header("Location:index.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="estilos/modal.css">
    <link rel="stylesheet" href="estilos/admin.css">
    <link rel="stylesheet" href="./estilos/general.css">
    <script src="./jquery.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Canchas</title>
    <style>
        body, html{
            background: white;
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

        #titulo_canchas{
            color: #8650fe;
            font-size: 2rem;
            text-align: center;
            margin-top: 80px;
        }

        #panel_canchas{
            width: 600px;
            margin: auto;
            border-radius: 8px;
            box-shadow: 2px 2px 7px 0px lightgray;
            padding: 20px;
            box-sizing: border-box;
            font-size: 1.2rem;
            color: #8650fe;
            font-weight: bold;
        }

        .fila_panel_cancha{
            margin-bottom: 10px;
            padding: 10px;
            border-bottom: 1px solid lightgray;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            min-height: 50px;
        }

        .precio_cancha{
            padding: 5px;
            border-radius: 12px;
            width: 30%;
            text-align: center;
            background-color: lavender;
            cursor: pointer;
        }

        .habilitada{
            background: #25d366;
            color: white;
        }

        .inhabilitada{
            background: red;
            color: white;
        }

        .modal_precio{
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

        #precio_modal{
            width: 85%;
            margin: auto;
            display: inline-block;
            color: #8650fe;
        }

        #titulo_modal_precio{
            font-size:1.5rem;
            text-align:center
        }

        .boton{
            color: white;
            border-radius: 5px;
            padding: 5px;
            width: 140px;
            cursor: pointer;
        }

        @media(max-width: 1300px){
            .opcion
            {
                font-size: 12px;
            }
        }

        @media( max-width: 1236px){
            .form_container
            {
                justify-content: center;
            }

            #titulo_registro
            {
                width: fit-content;
                margin: 30px auto;
            }
        }

        @media(max-width: 950px){
            form
            {
                width: 90%;
            }
            #titulo_registro
            {
                font-size: 2.4rem;
            }
        }

        @media(max-width: 700px){
            #panel_canchas{
                width: 95%;
            }
        }

        @media(max-width: 450px){
            .nombre_cancha{
                width: 100%;
                margin-bottom: 10px;
            }
        }
    </style>
</head>
<body>
    <div id="modal_background"></div>
    <?php 
    include("nav_superadmin.php");
    ?>
    <div id="titulo_canchas">
       <h1>Administrar Canchas</h1> 
    </div>
    <!-- MODAL PRECIO -->
    <div class="modal_precio">
        <div class="modal_nav">
            <div>Cambiar precio de cancha</div>
            <div class="modal_cerrar" id="cerrar_modal_precio">X</div>
        </div>
        <br>
        <div id="titulo_modal_precio"></div>
        <br>
        <div style="display:flex;justify-content:space-between;align-items:center">
            $<input type="number" class="precio_cancha" id="precio_modal">
        </div>
        <br><br>
        <div class="botones_admin">
            <div id="boton_modal_precio" class="boton_modal_admin guardar">Aceptar</div>
        </div>
    </div>

    <div id="panel_canchas">
    </div>
</body>
</html>
<?php include("nav_desplegable.php"); ?>
<script>


    let cerrar_modal_precio = document.getElementById("cerrar_modal_precio");
    let panel_canchas = document.getElementById("panel_canchas");
    let modal_precio = document.querySelector(".modal_precio");

    $.ajax({
            url: './estados_canchas.php',
            type: 'get',
            success: function (data) {
                const respuesta = JSON.parse(data); 
                
                for(i in respuesta["array_nombres"]){
                    // console.log("Cancha: " + respuesta["array_nombres"][i] + ", estado: " + respuesta["array_estados"][i]);
                    panel_canchas.innerHTML +=
                    `<div class="fila_panel_cancha" id="${respuesta["array_nombres"][i]}">
                    <div class="nombre_cancha">${respuesta["array_nombres"][i]}</div>
                    <div class="precio_cancha" onclick="modalPrecio(this)">${respuesta["array_precios"][i]}</div>
                    <div class="estado_cancha">
                    <div class="boton ${respuesta["array_estados"][i] == "1" ? "habilitada" : "inhabilitada"}" onclick="cambiarEstado(this)">${respuesta["array_estados"][i] == "1" ? "HABILITADA" : "INHABILITADA"}</div>
                    </div>
                    </div>`;
                }
            }
    });

    function modalPrecio(element){
        modal_precio.style.display = "block";
        document.getElementById("titulo_modal_precio").innerText = `Nuevo precio de ${element.parentNode.id}`;
        document.getElementById("modal_background").style.display = "block";
        document.getElementById("precio_modal").value = element.innerText;

        document.getElementById("boton_modal_precio").setAttribute('onclick', `cambiarPrecio("${element.parentNode.id}")`);

    }

    function cambiarPrecio(id){
        let val = document.getElementById("precio_modal").value
        $.ajax({
            url: './estados_canchas.php',
            type: 'post',
            data: {
                precio: val,
                nombre: id
            },
            success: function(){
                window.location.reload();
            }
        });
    }

    function cambiarEstado(element){
        //Envío el estado invertido para cambiarlo en PHP
        let estado_cancha = element.innerHTML == "HABILITADA" ? 0 : 1;
        let nombre_cancha = element.parentElement.parentElement.id;
        let alerta = confirm(`¿Querés cambiar el estado de la cancha ${nombre_cancha}?`)

        if(alerta){
            $.ajax({
                url: './estados_canchas.php',
                type: 'post',
                data: {
                    estado: estado_cancha,
                    nombre: nombre_cancha
                },
                success: function(){
                    window.location.reload();
                }
            });
        }
    };

    cerrar_modal_precio.addEventListener('click', ()=>{
        modal_precio.style.display = "none";
        document.getElementById("modal_background").style.display = "none";
        document.getElementById("boton_modal_precio").removeAttribute("onclick");
    })
</script>