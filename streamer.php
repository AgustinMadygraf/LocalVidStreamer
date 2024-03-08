<?php
require 'config.php';

// Simulación de una entrada del usuario (debería provenir de alguna solicitud HTTP)
$userRequestedVideo = "Simpson.mp4"; // Ejemplo, reemplazar con la entrada real del usuario

// Validación de la entrada contra la lista blanca
if (in_array($userRequestedVideo, $allowedVideos)) {
    $videoPath = $basePath . $userRequestedVideo;

    if (file_exists($videoPath)) {
        header('Content-Type: video/mp4');
        $fp = fopen($videoPath, 'rb');


    $size = filesize($videoPath); // Tamaño del archivo
    $length = $size; // Contenido restante por enviar
    $start = 0; // Punto de inicio de la transmisión
    $end = $size - 1; // Punto final de la transmisión

    header("Accept-Ranges: 0-$length");
    if (isset($_SERVER['HTTP_RANGE'])) {
        $c_start = $start;
        $c_end = $end;

        list(, $range) = explode('=', $_SERVER['HTTP_RANGE'], 2);
        if (strpos($range, ',') !== false) {
            header('HTTP/1.1 416 Requested Range Not Satisfiable');
            header("Content-Range: bytes $start-$end/$size");
            exit;
        }
        if ($range == '-') {
            $c_start = $size - substr($range, 1);
        } else {
            $range = explode('-', $range);
            $c_start = $range[0];
            $c_end = (isset($range[1]) && is_numeric($range[1])) ? $range[1] : $c_end;
        }
        $c_end = ($c_end > $end) ? $end : $c_end;
        if ($c_start > $c_end || $c_start > $size - 1 || $c_end >= $size) {
            header('HTTP/1.1 416 Requested Range Not Satisfiable');
            header("Content-Range: bytes $start-$end/$size");
            exit;
        }
        $start = $c_start;
        $end = $c_end;
        $length = $end - $start + 1; // Ajusta el tamaño del contenido basado en el rango solicitado
        fseek($fp, $start);
        header('HTTP/1.1 206 Partial Content');
        header("Content-Range: bytes $start-$end/$size");
    }
    header("Content-Length: ".$length);
    $buffer = 1024 * 8;
    while (!feof($fp) && ($p = ftell($fp)) <= $end) {
        if ($p + $buffer > $end) {
            $buffer = $end - $p + 1;
        }
        set_time_limit(0); // Desactiva el límite de tiempo de ejecución
        echo fread($fp, $buffer);
        flush(); // Vacía el sistema de escritura de salida
    }

    fclose($fp);
} else {
    // El archivo existe en la lista blanca pero no se encontró en el servidor
    echo "El video solicitado no se encuentra disponible.";
}
} else {
// El video solicitado no está en la lista blanca
echo "Acceso denegado.";
}
