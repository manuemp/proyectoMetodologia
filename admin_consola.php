<?php session_start(); ?>
<?php
    
    if(intval($_SESSION["rol"]) != 1)
    {
        header("Location:index.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TorinoFútbol: Admin</title>
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

        @media(max-width: 400px){
            .admin_btn{
                width: 80px;
            }
        }
        
    </style>
</head>
<body>
    <?php include("./nav_admin.php") ?>
    <main>
            <h1>Administrador</h1>
            <section id="admin_links">
                <a class="admin_btn opcion" href="./admin_reservas.php">Reservas</a>
                <a class="admin_btn opcion" href="./admin_gestionar_faltas.php">Faltas</a>
            </section>
    </main>
</body>
</html>
