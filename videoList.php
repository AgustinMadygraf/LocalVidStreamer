<!--videoList.php-->
<?php
require 'config.php'; // Importa la configuración, asegúrate de que la ruta es correcta.

// Supongamos que existe una función para obtener las miniaturas; esto es un placeholder.
function getVideoListWithThumbnails() {
    global $allowedVideos, $basePath;
    $thumbnails = []; // Ejemplo: ['video1.mp4' => 'path/to/thumbnail1.jpg', ...]

    // Lógica para asignar a cada video su miniatura correspondiente
    foreach ($allowedVideos as $video) {
        $thumbnailPath = isset($thumbnails[$video]) ? $thumbnails[$video] : 'path/to/default/thumbnail.jpg';
        $thumbnails[$video] = $thumbnailPath;
    }

    return $thumbnails;
}
