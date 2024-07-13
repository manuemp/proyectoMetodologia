<?php 
    //Cierro la sesión y redirecciono al index
    session_start();
    session_destroy();
    header("Location:index.php");
?>