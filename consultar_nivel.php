<?php
    $query_nivel_usuario = mysqli_query($conexion, "SELECT DISTINCT * FROM niveles 
                                                    WHERE $racha >= cantidad_reservas  
                                                    ORDER BY id DESC 
                                                    LIMIT 1");  
    $nivel = mysqli_fetch_assoc($query_nivel_usuario);
?>