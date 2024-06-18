<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .opcionEmail{
            border: 1px solid lightgray;
            padding: 2px;
            width: 150px;
        }

        .opcionEmail:hover{
            background: dodgerblue;
            color:white;
        }
    </style>
</head>
<body>

    <input type="text" name="email" id="busqueda_input">
    <div id="res">
        <!-- crea DIV -->
    </div>
</body>
</html>
<script>

    let arr = [];
    let res = document.getElementById("res");

    


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
                    // div.setAttribute('name', 'email');

                    div.addEventListener('click', ()=> {
                        fetch('./buscar_usuario.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'  // Indicamos que los datos se envían en el formato correcto
                        },
                        body: new URLSearchParams({
                            'email': div.innerText  // Enviar los datos del input en el cuerpo de la petición
                            })
                        })
                        .then(response => response.json())
                        .then(data => console.log(data));
                    })
                    res.appendChild(div);
                })
            })
            .catch(error => {
                console.error('Error:', error);  // Manejar cualquier error
            });
        }

    let busquedaInput = document.getElementById("busqueda_input");
    busquedaInput.addEventListener('keyup', ()=>{
        buscarUsuarios(busquedaInput.value);
    })

    // fetch('./buscar_usuario.php', {
    //             method: 'POST',
    //             headers: {
    //                 'Content-Type': 'application/x-www-form-urlencoded'  // Indicamos que los datos se envían en el formato correcto
    //             },
    //             body: new URLSearchParams({
    //                 'email': val  // Enviar los datos del input en el cuerpo de la petición
    //             })
    //         })
    //         .then(response => response.json())
    //         .then(data => console.log(data));




</script>

