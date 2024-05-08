<?php
function e($s)//usar al recoger datos que introduzca el usuario
{
    return htmlspecialchars($s, ENT_QUOTES);
}

function formateaFecha($fecha)
{
    // Intenta crear un objeto DateTime a partir de la cadena de fecha
    $dt = DateTime::createFromFormat("Y-m-d H:i:s", $fecha);
    
    // Verifica si se pudo crear el objeto DateTime correctamente
    if ($dt !== false) {
        // Formatea la fecha utilizando el formato deseado
        $formattedDate = $dt->format("j F Y, H:i"); // Cambia "F" por "M" si prefieres la abreviatura del mes
        
        // Devuelve la fecha formateada
        return $formattedDate;
    } else {
        // Devuelve una cadena vacía si no se pudo crear el objeto DateTime
        return "";
    }
}