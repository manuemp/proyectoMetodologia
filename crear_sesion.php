<?php 
    session_start();
    $_SESSION['id'] = $data['id'];
    $_SESSION['nombre'] = $data['nombre'];
    $_SESSION['apellido'] = $data['apellido'];
    $_SESSION['email'] = $data['email'];
    $_SESSION['faltas'] = $data['faltas'];
    $_SESSION['racha'] = $data['racha'];
    $_SESSION['rol'] = $data['rol'];
    $_SESSION['saldo_a_favor'] = $data['saldo_a_favor'];
    $_SESSION['telefono'] = $data['telefono'];
    $_SESSION['dni'] = $data['dni'];
?>