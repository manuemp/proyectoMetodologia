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

        table
        {
            width: 100%;
            height: 100%;
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
    </style>
</head>
<body>
    <?php include("./nav_admin.php") ?>
    <h1>Usuarios</h1>
    <article id="filtros_historial" class="item_historial">
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
                    </form>
                </article>
                <table id="tabla">
                    <thead>
                        <tr id="th_historial" class="item_historial">
                            <th class="id td_historial">ID</th>
                            <th class="nombre td_historial">Nombre</th>
                            <th class="apellido td_historial">Apellido</th>
                            <th class="email td_historial">Email</th>
                            <th class="faltas td_historial">Racha</th>
                            <!-- <th class="reservas td_historial">Reservas</th> -->
                            <th class="faltas td_historial">Faltas</th>
                            <!-- <th class="nivel td_historial">Nivel</th> -->
                        </tr>
                    </thead>
                    <tbody id="body_tabla">
                    </tbody>
                </table>
            </article>
</body>
</html>
<script>

    $.ajax({
        url: './listar_usuarios.php',
        method: 'get',
        success: function(res)
        {
            let datos = JSON.parse(res);
            generar_tabla(datos);
        }
    })


    function generar_tabla(data)
    {
        data.forEach((elemento) =>{            
            let tr_filtro = document.createElement("tr");
            let td_id = document.createElement("td");
            let td_nombre = document.createElement("td");
            let td_apellido = document.createElement("td");
            let td_email = document.createElement("td");
            // let td_reservas = document.createElement("td");
            let td_faltas = document.createElement("td");
            let td_racha = document.createElement("td");
            // let td_nivel = document.createElement("td");

            tr_filtro.className = "item_historial";

            td_id.innerHTML = elemento["id"];
            td_id.className = "id td_historial";
            td_nombre.innerHTML = elemento["nombre"];
            td_nombre.className = "nombre td_historial";
            td_apellido.innerHTML = elemento["apellido"];
            td_apellido.className = "apellido td_historial";
            td_email.innerHTML = elemento["email"];
            td_email.className = "email td_historial";
            // td_reservas.innerHTML = elemento["reservas"];
            // td_reservas.className = "reservas td_historial";
            td_faltas.innerHTML = elemento["faltas"];
            td_faltas.className = "faltas td_historial";
            td_racha.innerHTML = elemento["racha"];
            td_racha.className = "faltas td_historial";
            // td_nivel.innerHTML = elemento["nivel"];
            // td_nivel.className = "nivel td_historial";

            tr_filtro.appendChild(td_id);
            tr_filtro.appendChild(td_nombre);
            tr_filtro.appendChild(td_apellido);
            tr_filtro.appendChild(td_email);
            // tr_filtro.appendChild(td_reservas);
            tr_filtro.appendChild(td_faltas);
            tr_filtro.appendChild(td_racha);
            // tr_filtro.appendChild(td_nivel);

            body_tabla.appendChild(tr_filtro);
        });
    }

</script>