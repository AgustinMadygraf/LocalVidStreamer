<?php
require 'config.php'; // Asegúrate de que esta ruta es correcta

// Comprobar si se ha proporcionado el parámetro 'v' en la URL
if (isset($_GET['v']) && in_array($_GET['v'], $allowedVideos)) {
    // Sanitizar el nombre del archivo para prevenir vulnerabilidades
    $videoName = htmlspecialchars($_GET['v']);
    
    // Construir la ruta al video
    $videoPath = $basePath . $videoName;

    // Verificar si el archivo existe y es accesible
    if (file_exists($videoPath)) {
        // Aquí podrías redirigir al usuario a una página de reproducción
        // o incrustar directamente el reproductor de video.
        echo "<video controls width='100%'>";
        echo "<source src='streamer.php?v=" . urlencode($videoName) . "' type='video/mp4'>";
        echo "Tu navegador no soporta el elemento <code>video</code>.";
        echo "</video>";
    } else {
        echo "El video solicitado no está disponible.";
    }
} else {
    // Si 'v' no está establecido o el video no está en la lista blanca, mostrar la lista de videos disponibles
    echo "<h2>Lista de Videos Disponibles</h2>";
    echo "<ul>";
    foreach ($allowedVideos as $video) {
        echo "<li><a href='?v=" . urlencode($video) . "'>" . htmlspecialchars($video) . "</a></li>";
    }
    echo "</ul>";
}
