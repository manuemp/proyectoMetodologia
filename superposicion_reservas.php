<?php session_start(); ?>
<?php
    if(!isset($_SESSION["Nombre"]))
        {
            header("Location:index.php");
        }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./estilos/general.css">
    <link rel="stylesheet" href="./estilos/error.css">
    <title>¡Exceso de reservas!</title>
    <style>
    </style>
</head>
<body>
    <?php include("./nav_online.php") ?>
    <main>
        <p style="font-size: 5rem">Cuidado...</p>
        <p>¡Ya tenés otra reserva en el mismo día y hora!</p>
        <p>¡Intentá con otro horario!</p>
        <button class="boton_aceptar" id="volver">Volver</button>
    </main>
    <?php include("./footer.php"); ?>
</body>
</html>
<script>
    document.getElementById("volver").addEventListener('click', ()=>{
        location.href = "./reservar.php";
    });
</script>