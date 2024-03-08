<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Video - LocalVidStreamer</title>
    <!-- Incluir CSS de Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.0/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <?php
    require 'config.php'; // Asegúrate de que esta ruta es correcta.

    if (isset($_GET['v']) && in_array($_GET['v'], $allowedVideos)) {
        $videoName = htmlspecialchars($_GET['v']);
        $videoPath = $basePath . $videoName;
        
        if (file_exists($videoPath)) {
            echo "<div class='row'>";
            echo "<div class='col-md-8 offset-md-2'>";
            echo "<video controls width='100%' class='rounded'>";
            echo "<source src='streamer.php?v=" . urlencode($videoName) . "' type='video/mp4'>";
            echo "Tu navegador no soporta el elemento <code>video</code>.";
            echo "</video>";
            echo "</div>";
            echo "</div>";
        } else {
            echo "<p class='text-center'>El video solicitado no está disponible.</p>";
        }
    } else {
        echo "<p class='text-center'>Video no encontrado o acceso denegado.</p>";
    }
    ?>
    <div class="text-center mt-3">
        <a href="index.php" class="btn btn-primary">Volver a la lista de videos</a>
    </div>
</div>

<!-- Scripts de Bootstrap -->
<script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.0/js/bootstrap.min.js"></script>
</body>
</html>
