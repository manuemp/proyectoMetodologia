<?php
include("./conexion.php");

$email = $_POST['email'];
$query = "SELECT COUNT(*) as reservas FROM reservas R JOIN usuarios U on U.id = R.usuario_id WHERE U.email = '$email'";
$result = mysqli_query($conexion, $query);
$row = mysqli_fetch_assoc($result);

echo $row['reservas'];
?>