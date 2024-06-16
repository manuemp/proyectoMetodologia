<?php 
    include("./conexion.php");

    if($_SERVER["REQUEST_METHOD"] === "GET"){
        $consulta = mysqli_query($conexion, "SELECT nombre, estado, precio FROM canchas");
    
        class Canchas {
            public $array_nombres = array();
            public $array_estados = array();
            public $array_precios = array();
        }
    
        $objJson = new Canchas();
    
        while($resultado = mysqli_fetch_assoc($consulta)){
            $objJson->array_nombres[] = $resultado["nombre"];
            $objJson->array_estados[] = $resultado["estado"];
            $objJson->array_precios[] = $resultado["precio"];
        }
        echo json_encode($objJson);
    }

    if($_SERVER["REQUEST_METHOD"] === 'POST'){
        $nombre_cancha = $_POST["nombre"];

        //Si en la petición se mandó el precio, es porque se lo quiero cambiar
        if(isset($_POST["precio"])){
            $precio = intval($_POST["precio"]);
            $consulta = mysqli_query($conexion, "UPDATE canchas SET precio = $precio WHERE nombre = '$nombre_cancha'");

        }
        //Sino el único otro caso es que quiera cambiar el estado
        else{
            $estado_cancha = intval($_POST["estado"]);
            $consulta = mysqli_query($conexion, "UPDATE canchas SET estado = $estado_cancha WHERE nombre = '$nombre_cancha'");
        }
    }

    mysqli_close($conexion);
?>