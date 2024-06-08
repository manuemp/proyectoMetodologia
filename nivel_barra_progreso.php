<?php session_start() ?>
<?php 

    include("./conexion.php");
    $racha = intval($_SESSION["racha"]);
    $nivel = $_SESSION["nivel"];
    $reservas_proximo_nivel;
    $nombre_proximo_nivel;
    $objeto_nivel = new stdClass();

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

        $objeto_nivel->nivel = $nivel;
        $objeto_nivel->proximo_nivel = $nombre_proximo_nivel;
        $objeto_nivel->reservas_proximo_nivel = $reservas_proximo_nivel;
        $objeto_nivel->reservas_faltantes = $reservas_faltantes;
        $objeto_nivel->racha = $racha;
    }

    mysqli_free_result($consulta_id_nivel);
    mysqli_free_result($consulta_proximo_nivel);

    echo json_encode($objeto_nivel);
?>