<?php
require 'config.php'; // Asegúrate de que esta ruta es correcta.

// Aquí no es necesario validar la entrada del usuario, ya que este script solo muestra los videos disponibles.

echo "<h2>Selecciona un Video para Ver</h2>";
echo "<ul>";

// Iterar sobre la lista de videos permitidos y mostrarlos como enlaces.
foreach ($allowedVideos as $video) {
    $videoSanitized = htmlspecialchars($video); // Sanitiza para prevenir vulnerabilidades XSS.
    echo "<li><a href='watch.php?v=" . urlencode($video) . "'>" . $videoSanitized . "</a></li>";
}

echo "</ul>";
?>
