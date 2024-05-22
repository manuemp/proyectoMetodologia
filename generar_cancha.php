<?php

function generarCancha($cancha)
{
    switch ($cancha)
    {
        case "1":
            return "Fútbol 5 (A)";
        case "2":
            return "Fútbol 5 (B)";
        case "3":
            return "Fútbol 7 (A)";
        case "4":
            return "Fútbol 7 (B)";
        case "5":
            return "Fútbol 8 (A)";
        case "6":
            return "Fútbol 8 (B)";
    }
}

?>