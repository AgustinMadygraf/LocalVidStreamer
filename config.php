<?php
// Ruta base donde se almacenan los videos
$basePath = 'E:/videos/';

// Obtener todos los archivos de la carpeta
$files = scandir($basePath);

// Filtrar los archivos para incluir solo ciertos tipos de videos (mp4 en este ejemplo)
$allowedVideos = array_filter($files, function($file) use ($basePath) {
    // Aquí puedes añadir más extensiones de archivo según sea necesario
    return is_file($basePath . $file) && in_array(pathinfo($file, PATHINFO_EXTENSION), ['mp4']);
});

// Reindexar el array para asegurarse de que las claves son continuas
$allowedVideos = array_values($allowedVideos);
