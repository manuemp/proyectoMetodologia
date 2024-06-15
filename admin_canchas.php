<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="estilos/modal.css">
    <link rel="stylesheet" href="estilos/admin.css">
    <script src="./jquery.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
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
            margin-bottom: 20px;
            padding: 10px;
            border-bottom: 1px solid lightgray;
            display: flex;
            justify-content: space-between;
        }

        .habilitada{
            background: #25d366;
            color: white;
        }

        .inhabilitada{
            background: red;
            color: white;
        }

        .boton{
            /* background: #25d366; */
            color: white;
            border-radius: 5px;
            width: 155px;
            cursor: pointer;
        }

        @media(max-width: 650px){
            #panel_canchas{
                width: 98%;
            }
        }
    </style>
</head>
<body>
    <?php include("nav_admin.php") ?>
    <div id="titulo_canchas">
       <h1>Administrar Canchas</h1> 
    </div>
    <div id="panel_canchas">
        <div class="fila_panel_cancha">
            <div class="cancha">
                F5 A
            </div>
            <div class="estado_cancha">
                <div class="boton habilitada">
                    HABILITADA
                </div>
            </div>
        </div>
        <div class="fila_panel_cancha">
            <div class="cancha">
                F5 B
            </div>
            <div class="estado_cancha">
            <div class="boton inhabilitada">
                    INHABILITADA
                </div>
            </div>
        </div>
        <div class="fila_panel_cancha">
            <div class="cancha">
                F7 A
            </div>
            <div class="estado_cancha">
            <div class="boton habilitada">
                    HABILITADA
                </div>
            </div>
        </div>
        <div class="fila_panel_cancha">
            <div class="cancha">
                F7 B
            </div>
            <div class="estado_cancha">
            <div class="boton habilitada">
                    HABILITADA
                </div>
            </div>
        </div>
        <div class="fila_panel_cancha">
            <div class="cancha">
                F8 A
            </div>
            <div class="estado_cancha">
            <div class="boton habilitada">
                    HABILITADA
                </div>
            </div>
        </div>
        <div class="fila_panel_cancha">
            <div class="cancha">
                F8 B
            </div>
            <div class="estado_cancha">
            <div class="boton habilitada">
                    HABILITADA
                </div>
            </div>
        </div>
    </div>
</body>
</html>