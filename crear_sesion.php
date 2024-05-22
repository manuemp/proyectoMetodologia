<?php 
    session_start();
    $_SESSION['Nombre'] = $data['Nombre'];
    $_SESSION['Apellido'] = $data['Apellido'];
    $_SESSION['Email'] = $data['Email'];
    $_SESSION['Faltas'] = $data['Faltas'];
    $_SESSION['Nivel'] = $data['Nivel'];
?>