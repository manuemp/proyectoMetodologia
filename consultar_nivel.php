<?php
    $query_nivel_usuario = mysqli_query($conexion, "SELECT DISTINCT N.id, N.cantidad_reservas, N.descuento, N.nombre 
                                                    FROM niveles N, niveles M 
                                                    WHERE M.cantidad_reservas >= N.cantidad_reservas 
                                                    AND $racha  BETWEEN N.cantidad_reservas 
                                                    AND M.cantidad_reservas + N.cantidad_reservas 
                                                    ORDER BY N.id DESC 
                                                    LIMIT 1");

    $nivel = mysqli_fetch_assoc($query_nivel_usuario);
?>