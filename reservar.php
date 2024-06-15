<?php session_start(); ?>
<?php 

    if(!isset($_SESSION["nombre"]))
    {
        header("Location:index.php");
    }

    include("./conexion.php");

    //Si el nombre del nivel no es socio, entonces empiezo a hacer preguntas
    //Busco el id del nivel siguiente al que estoy ahora
    //Obtengo la cantidad de reservas de ese nivel siguiente
    //Resto esa cantidad a la cantidad actual (mi racha)
    //Obtengo la cantidad de reservas que me faltan.

    //Si el nombre del nivel es socio, ni aparece la cuenta regresiva
    $racha = intval($_SESSION["racha"]);
    $nivel = $_SESSION["nivel"];
    $reservas_proximo_nivel;
    $nombre_proximo_nivel;

    //Pido el ID del nivel actual
    $consulta_id_nivel = mysqli_query($conexion, "SELECT id FROM niveles WHERE nombre = '$nivel'");
    $datos_nivel = mysqli_fetch_assoc($consulta_id_nivel);
    $id_nivel = $datos_nivel["id"];
    //Me fijo si hay un nivel más adelante
    $consulta_proximo_nivel = mysqli_query($conexion, "SELECT * FROM niveles WHERE id = $id_nivel + 1");
    $existe_nivel = mysqli_num_rows($consulta_proximo_nivel);
    //Si el nivel existe, guardo los datos
    if($existe_nivel == 1){
        $proximo_nivel = mysqli_fetch_assoc($consulta_proximo_nivel);
        $reservas_proximo_nivel = intval($proximo_nivel["cantidad_reservas"]);
        $nombre_proximo_nivel = $proximo_nivel["nombre"];
        $reservas_faltantes = $reservas_proximo_nivel - $racha;
    }

    mysqli_free_result($consulta_id_nivel);
    mysqli_free_result($consulta_proximo_nivel);

    $email = $_SESSION["email"];

    date_default_timezone_set("America/Argentina/Buenos_Aires");
    $hora = date('H:i');
    $hoy = date('Y-m-d');
    $contador = 0;

    $consulta = mysqli_query($conexion, "SELECT * FROM reservas R 
                                         JOIN usuarios U on U.id = R.usuario_id
                                         WHERE U.email = '$email' 
                                         AND DATEDIFF(R.dia, CURRENT_DATE()) >= 0");

    // Las reservas que son del mismo día pero de una hora que ya pasó no se van a 
    // contabilizar para la restricción de 3 reservas, ya que no son más reservas pendientes
    while($fila = $consulta->fetch_assoc())
    {
        if($fila["dia"] == $hoy)
        {
            if(strtotime($hora) < strtotime($fila["hora"]))
                $contador += 1;
        }
        else
        {
            $contador += 1;
        }
    }

    if($contador >= 3)
    {
        header("Location:index.php?exceso_reservas");
    }
    
    //Indices de i para el bucle del select del día para reservar
    $dia_inicio = 0;
    $dia_limite = 7;

    //Si ya pasaron las 21.30, se empiezan a reservar las canchas del día siguiente
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
    <script src="./jquery.js"></script>
    <link rel="stylesheet" href="./estilos/general.css">
    <link rel="stylesheet" href="./estilos/index.css">
    <link rel="stylesheet" href="./estilos/modal.css">
    <title>Reservas</title>
    <style>
        
        body
        {
            width: 100%;
            min-height: 100vh;
            height: 100%;
            background-repeat: no-repeat;
            background-size: cover;
        }

        main{
            /* background-image: url("./imgs/fondo_inicio3.jpeg"); */
            background-repeat: no-repeat;
            background-size: cover;
        }

        #reservas
        {
            margin: auto;
            width: 100%;
            height: 100%;
            background-color: white;
            padding: 55px 30px 0px 40px;
            box-sizing: border-box;
            overflow: scroll;
            /* display: flex; */
            /* justify-content: center; */
            /* align-items: center; */
        }

        .titulo_reserva
        {
            /* color: #8650fe;
            position: absolute;
            left: 70px;
            font-size: 3.5rem;
            font-weight: bold;
            text-align: center;
            margin-bottom: 10px; */

            color: #8650fe;
            position: absolute;
            left: 3%;
            font-size: 3rem;
            font-weight: bold;
            /* width: 100%; */
            text-align: center;
            margin-bottom: 10px;
        }

        .select_reserva
        {
            width: 390px;
            display: block;
            margin: 6px auto;
            height: 40px;
            font-size: 1.5rem;
            font-weight: bold;
            box-sizing: border-box;
            border-radius: 10px;
            text-align: center;
            border: 2px solid rgb(238, 236, 236);
            cursor: pointer;
        }


        .container_reserva
        {
            display: flex;
            flex-wrap: wrap;
            width: 390px;
            justify-content: space-between;
            align-items: center;
            margin: auto;
        }

        #reservar
        {
            box-shadow: 2px 2px 7px 1px lightblue;
            border: none;
            width: 100%;
            background-color: #25d366;
            color: white;
            cursor: pointer;
            margin: 0;
        }

        #precio{
            /* width: 100%;
            text-align: center;
            font-weight: bold;
            font-size: 2.2rem;
            height: 60px;
            padding: 15px;
            box-sizing: border-box;
            color: #8650fe;
            margin-top: 10px; */

            width: 100%;
            text-align: center;
            font-weight: bold;
            font-size: 2rem;
            height: 48px;
            padding: 10px;
            box-sizing: border-box;
            color: #8650fe;
            margin-top: 10px;
        }

        #beneficio{
            padding: 5px;
            color: palegreen;
            display: none;
            border-radius: 6px;
            background: green;
            margin: 10px auto;
            width: 160px;
            text-align: center;
            font-size: 1.7rem;
        }

        main{
            height: 68vh;
        }

        form{
            height: auto;
            /* padding: 10px */
        }

        #arrow{
            position: absolute;
            height: 50px;
            filter: opacity(0.5);
        }

        .progress-container {
            width: 390px;
            background-color: #f3f3f3;
            border-radius: 12px;
            margin: 0px auto 30px;
            overflow: hidden;
            position: relative;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .progress-bar {
            height: 25px;
            background-color: #25d366;
            width: 0;
            border-radius: 25px;
            text-align: center;
            line-height: 35px;
            color: white;
            font-weight: bold;
            font-size: 1.2rem;
            transition: width 0.8s ease;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .progress-text {
            position: absolute;
            width: 100%;
            text-align: center;
            font-size: 1.2rem;
            color: darkslategrey;
            font-weight: bold;
            top: 0;
            padding-top: 4px;
            /* line-height: 32px; */
        }

        .progress-additional-text {
            font-size: 1.5rem;
            color: #8650fe;
            text-align: center;
            font-weight: bold;
            margin-top: 2px;
        }

        @media(max-height: 600px)
        {
            main{
                height: 100vh;
            }
        }

        @media(max-width: 1000px){
            #reservar{
                width: 390px;
            }

            .container_reserva{
                justify-content: center;
                width: 100%;
            }

            #precio{
                text-align: center;
                font-size: 2rem;
                width: 100%;
            }
        }

        @media(max-width: 1100px){
            /* .container_reserva, .select_reserva{
                width: 72%;
            } */
            form{
                padding-top: 60px;
            }

            .titulo_reserva{
                width: 100%;
                left: 0%;
            }
        }

        @media (max-width: 900px){
            .select_reserva{
                height: 50px;
                font-size: 1.6rem;
            }
            .titulo_reserva{
                font-size: 2.8rem;
            }
        }

        @media(max-width: 750px){
            main{
                height: 75vh;
            }

            .titulo_reserva, #precio{
                margin-top: 30px;
                font-size: 2rem;
            }

            .select_reserva{
                width: 100%;
                margin-bottom: 10px;
                height: 40px;
            }

            #arrow{
                height: 30px;
            }

            #reservar{
                width: 100%;
            }

            .progress-container{
                width:100%;
            }

            #reservas{
                border-radius: 10px;
                margin: auto;
                position: relative;
                top: 0%;
                /* width: 70%; */
                height: 100%;
            }

            #beneficio{
                margin: 0;
            }

            #precio{
                margin-top: 0;
                font-size: 1.5rem;
            }
        }

        @media(max-width: 450px){

            .select_reserva{
                width: 100%;
                font-size: 1.2rem;
            }

            #beneficio{
                width: 100px;
            }
        }
        





    </style>
</head>
<body>
    <?php include("./nav_online.php") ?>

    <main>
        <a href="./index.php"><img src="./imgs/left_arrow2.png" alt="Volver" id="arrow"></a>
        <section id="reservas">
            <h1 class="titulo_reserva" style="margin: 0;">Hacé tu reserva</h1><br>
            <form action="./generar_reserva.php" method="post" id="form_reserva">
                <!-- Barra de progreso -->
                <div class="progress-container">
                    <div id="progress-bar" class="progress-bar"></div>
                    <div id="progress-text" class="progress-text"></div>
                    <div id="additional-text" class="progress-additional-text">
                    </div>
                </div>
                

                
                <select name="select_dia" class="select_reserva" id="select_dia">
                    <?php 
                        for($i = $dia_inicio ; $i < $dia_limite ; $i++)
                        {
                           echo "<option value='" .  date('Y-m-d', strtotime(date('Y-m-d') . ' +' . $i . ' day')) . "'>" . date('d/m/y', strtotime(date('Y-m-d') . ' +' . $i . ' day')) . "</option>";
                        }
                    ?>
                </select>
            
                <select name="select_cancha" class="select_reserva" id="select_cancha">
                    <option value="">Seleccionar Cancha</option>
                    <option value="1">F5 A</option>
                    <option value="2">F5 B</option>
                    <option value="3">F7 A</option>
                    <option value="4">F7 B</option>
                    <option value="5">F8 A</option>
                    <option value="6">F8 B</option>
                </select>

                <select name="select_hora" class="select_reserva" id="select_hora" disabled>
                    <option value="">Seleccione Horario</option>
                </select>
                
                <div class="container_reserva">
                    <input type="submit" class="select_reserva" value="Reservar" id="reservar" disabled>
                    <div id="precio">Total: $0.00</input>
                </div>
                <input type="hidden" name="precio_hidden" id="precio_hidden" value="">
                <div id="beneficio"></div>
            </section>
        </form>
        <div>
        <!-- <h2 class="titulo_reserva" style="margin: 0;">Hacé tu reserva</h1><br> -->
        </div>
    </main>

    <?php include("./footer.php") ?>

</body>
</html>

<?php include("./nav_desplegable.php") ?>

<script>

    let select_hora = document.getElementById("select_hora");
    let select_dia = document.getElementById("select_dia");
    let select_cancha = document.getElementById("select_cancha");
    let btn_reserva = document.getElementById("reservar");
    let precio = document.getElementById("precio");

    let dia;
    let cancha;
    const date = new Date();
    hoy = date.toLocaleDateString('en-CA');
    let horarios = ["10:00:00", "11:00:00", "12:00:00", "13:00:00", "14:00:00", "15:00:00",
                    "16:00:00", "17:00:00", "18:00:00", "19:00:00", "20:00:00", "21:00:00", "22:00:00"];
    
    
    //Si no hay ningún horario disponible, no se podrá reservar la cancha
    btn_reserva.addEventListener('click', (ev)=>{
        ev.preventDefault();
        if(select_hora.value != "")
        {
            document.getElementById("form_reserva").submit();
        }
    })

    //Cada vez que cambie el día, vuelvo a filtrar los horarios disponibles
    select_dia.addEventListener('change', filtrar_horarios);

    //Habilito o inhabilito el boton de reservar en caso de que haya o no 
    //cancha seleccionada
    select_cancha.addEventListener('change', ()=>{
        if(select_cancha.value == "") 
        {
            //Si no hay cancha seleccionada, no se va a poder seleccionar horario,
            //ya que los horarios disponibles dependen de la cancha y el día.
            select_hora.setAttribute("disabled", "");
            btn_reserva.setAttribute("disabled", "");
            precio.innerHTML = "Total: $0,00";
        }
        else
        {
            select_hora.removeAttribute("disabled");
            btn_reserva.removeAttribute("disabled");
            filtrar_horarios();
            dar_precio();
        }
    });

     //CAMBIO NECESITO QUE CADA VEZ QUE CAMBIE LA HORA CAMBIE EL PRECIO SI ES A LA NOCHE O NO
     select_hora.addEventListener('change', ()=>{
        if(select_hora.value == "") 
        {
            //Si no hay cancha seleccionada, no se va a poder seleccionar horario,
            //ya que los horarios disponibles dependen de la cancha y el día.
            btn_reserva.setAttribute("disabled", "");
            precio.innerHTML = "Total: $0,00";
        }
        else
        {
            btn_reserva.removeAttribute("disabled");
            dar_precio();
        }
    });

    function dar_precio()
    {
        let beneficio = document.getElementById("beneficio");
        $.ajax({
            url: './precio_cancha.php',
            type: 'post',
            data: {
                cancha_id: $("#select_cancha").val(),
                hora: $("#select_hora").val()
            },
            success: function (data) {
                const respuesta = JSON.parse(data); 

                //Uso un formateador de JavaScript para pasar a moneda el total obtenido
                //de la base de datos.
                const formatter = new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'USD'
                });

                precio.innerHTML = `Total: ${formatter.format(respuesta["precio"])}`;
                document.getElementById("precio_hidden").value = respuesta["precio"];

                console.log("Beneficio " + respuesta["beneficio"]);
                if(respuesta["beneficio"] != "")
                {
                    beneficio.style.display = "block";
                    beneficio.innerHTML = respuesta["beneficio"];
                }
            }
        });
    }

    function filtrar_horarios()
    {
        dia = select_dia.value;
        cancha = select_cancha.value;

        //Busco todas las reservas hechas hasta el momento y las coloco en un array
        $.ajax({
            url: './reservas_disponibles.php',
            type: 'get',
            success: function (data) {
                const respuesta = JSON.parse(data); 
                $(select_hora).empty();
                let arr = [];
                
                //Agrego las horas ocupadas a un array
                respuesta.forEach(rta =>{
                    if(rta['dia'] == dia && rta['cancha'] == cancha && parseInt(rta['asistio']) == 1)
                    {
                        console.log(rta);
                        arr.push(rta['hora']);
                    }
                })
                
                horarios.forEach(horario =>{
                    //Por cada horario posible (10 a 22) averiguo que el horario
                    //que se está iterando sea mayor que la hora actual, ya que no puedo
                    //reservar una hora que ya pasó.
                    //También chequeo que esa hora no esté entre las horas que ya fueron
                    //reservadas para la cancha y el día indicados.
                    if(hoy == dia)
                    {
                        if(parseInt(horario) > parseInt(date.getHours()) && !arr.includes(horario))
                        {
                            let opcion = document.createElement("option");
                            opcion.value = horario;
                            opcion.innerHTML = horario;
                            select_hora.append(opcion);
                        }
                    }
                    else
                    {
                        //Para los días que no sean hoy, no dependo de la hora que sea
                        //para reservar, solamente de los horarios disponibles
                        if(!arr.includes(horario))
                        {
                            let opcion = document.createElement("option");
                            opcion.value = horario;
                            opcion.innerHTML = horario;
                            select_hora.append(opcion);
                        }
                    }
                })
            }
        });
    }


    function actualizarBarraProgreso() {
    $.ajax({
        url: './nivel_barra_progreso.php',
        type: 'get',
        success: function (data) {
            //const reservas = parseInt(data);
            const respuesta = JSON.parse(data);
            console.log(respuesta);
            let racha = parseInt(respuesta["racha"]);
            let nivel = respuesta["nivel"];
            let faltan = respuesta["reservas_faltantes"];
            let porcentaje =  (racha / parseInt(respuesta["reservas_proximo_nivel"])) * 100;

            $('#progress-bar').css('width', `${porcentaje}%`);
            console.log(porcentaje);

             // Actualizar el texto dentro del elemento con el ID 'progress-text'
            $('#progress-text').text(`${nivel} (${racha} reservas)`);

             // Actualizar el texto adicional
            $('#additional-text').text(`${faltan} Reservas más para ser ${respuesta["proximo_nivel"]} ⚽️`);
        }
    });
    }


    
    // Llamamos a la función para actualizar la barra de progreso al cargar la página
    actualizarBarraProgreso();
</script>




