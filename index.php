<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Videos - LocalVidStreamer</title>
    <!-- Incluir CSS de Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.0/css/bootstrap.min.css">
    <style>
        .video-thumbnail {
            width: 100px; /* Ajusta según necesidad */
            height: auto;
            float: left;
            margin-right: 15px;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4 text-center">Selecciona un Video para Ver</h2>
    <input class="form-control mb-4" id="videoSearch" type="text" placeholder="Buscar video...">
    <div class="list-group" id="videoList">
        <?php
        require 'config.php'; // Importa la configuración, asegúrate de que la ruta es correcta.

        // Suponiendo que tienes una forma de generar o almacenar miniaturas para cada video.
        // La siguiente línea es solo un placeholder; deberás adaptarlo a tu implementación real.
        $thumbnails = []; // Ejemplo: ['video1.mp4' => 'path/to/thumbnail1.jpg', ...];

        foreach ($allowedVideos as $video) {
            $videoSanitized = htmlspecialchars($video); // Sanitiza para prevenir vulnerabilidades XSS.
            $thumbnailPath = isset($thumbnails[$video]) ? $thumbnails[$video] : 'path/to/default/thumbnail.jpg'; // Asegúrate de tener una miniatura predeterminada.
            echo "<a href='watch.php?v=" . urlencode($video) . "' class='list-group-item list-group-item-action'>";
            echo "<img src='" . htmlspecialchars($thumbnailPath) . "' alt='Miniatura' class='video-thumbnail'>";
            echo $videoSanitized;
            echo "</a>";
        }
        ?>
    </div>
</div>

<!-- Scripts de Bootstrap y filtrado -->
<script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.0/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
        $("#videoSearch").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#videoList a").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>
</body>
</html>
