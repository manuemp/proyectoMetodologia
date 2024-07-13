<?php 
    include("./conexion.php");

    //Si la petición es GET, es porque se pidieron los datos
    if($_SERVER["REQUEST_METHOD"] === "GET"){
        $consulta = mysqli_query($conexion, "SELECT nombre, estado, precio FROM canchas");
        //Creo el objeto canchas donde voy a ingresar todos los datos de cada cancha
        class Canchas {
            public $array_nombres = array();
            public $array_estados = array();
            public $array_precios = array();
        }
        
        $objJson = new Canchas();
        //Agrego a cada campo del objeto (que son arrays) el nombre, precio y estado de la cancha.
        while($resultado = mysqli_fetch_assoc($consulta)){
            $objJson->array_nombres[] = $resultado["nombre"];
            $objJson->array_estados[] = $resultado["estado"];
            $objJson->array_precios[] = $resultado["precio"];
        }
        echo json_encode($objJson);
    }
    //Si la petición es POST:
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

            if($estado_cancha == 0){
                $agarrar_cancha= mysqli_query($conexion, "SELECT id, nombre FROM canchas where nombre = '$nombre_cancha'");
                $resultado = mysqli_fetch_assoc($agarrar_cancha);
                
                $id = $resultado["id"];
                
                $cambiar_reservas = mysqli_query($conexion, "UPDATE reservas SET asistio = 0 WHERE cancha_id = '$id'");
            
            }else{
                $agarrar_cancha= mysqli_query($conexion, "SELECT id, nombre FROM canchas where nombre = '$nombre_cancha'");
                $resultado = mysqli_fetch_assoc($agarrar_cancha);
                
                $id = $resultado["id"];
                
                $cambiar_reservas = mysqli_query($conexion, "UPDATE reservas SET asistio = 1 WHERE cancha_id = '$id'");
            }

        }
    }

    mysqli_close($conexion);
?>