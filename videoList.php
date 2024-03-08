<?php
require 'config.php'; // Importa la configuración.

// Función para obtener la ruta de la miniatura del video.
function getThumbnailPath($video) {
    global $basePath;
    $thumbnailBasePath = $basePath . 'thumbnails/'; // Asegúrate de que existe este directorio y tiene imágenes.
    $thumbnailFile = $thumbnailBasePath . pathinfo($video, PATHINFO_FILENAME) . '.jpg'; // Suponiendo que las miniaturas son JPG.

    // Comprobar si existe una miniatura personalizada para el video, si no, usar una predeterminada.
    if (file_exists($thumbnailFile)) {
        return $thumbnailFile;
    } else {
        return 'path/to/default/thumbnail.jpg'; // Asegúrate de que esta miniatura predeterminada exista.
    }
}

// Función para obtener una lista de videos con sus rutas de miniaturas correspondientes.
function getVideoListWithThumbnails() {
    global $allowedVideos;

    $thumbnails = [];
    foreach ($allowedVideos as $video) {
        $thumbnails[$video] = getThumbnailPath($video); // Obtener la ruta de la miniatura.
    }

    return $thumbnails;
}
