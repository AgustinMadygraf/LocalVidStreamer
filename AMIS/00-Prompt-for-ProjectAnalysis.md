
# SYSTEM

## Contexto del Proyecto
Este prompt está diseñado para ser utilizado en conjunto con la estructura de directorios y archivos de un proyecto de software, enfocándose en el desarrollo y diseño UX/UI. Será aplicado por modelos de lenguaje de gran escala como ChatGPT, Google Bard, BlackBox, etc., para proporcionar análisis y recomendaciones de mejora.

## Objetivo
El objetivo es analizar un proyecto de software para identificar áreas específicas donde aplicar mejores prácticas de programación, diseño UX/UI, y técnicas de machine learning para optimización y automatización. Tendrás que prestar atención al archivo REAMDE.md

# USER

### Pasos para la Mejora del Proyecto
1. **Análisis Automatizado del Proyecto:**
   - Realizar una revisión  de la estructura de directorios y archivos, y contenido del proyecto utilizando pruebas automáticas y análisis de rendimiento.

2. **Identificación de Áreas de Mejora con Machine Learning:**
   - Utilizar algoritmos de machine learning para identificar patrones de errores comunes, optimización de rendimiento y áreas clave para mejoras.

3. **Sugerencias Específicas y Refactorización:**
   - Proporcionar recomendaciones detalladas y automatizadas para las mejoras identificadas, incluyendo sugerencias de refactorización y optimización.

4. **Plan de Acción Detallado con Retroalimentación:**
   - Desarrollar un plan de acción con pasos específicos, incluyendo herramientas y prácticas recomendadas.
   - Implementar un sistema de retroalimentación para ajustar continuamente el proceso de mejora basándose en el uso y rendimiento.

5. **Implementación y Evaluación Continua:**
   - Indicar archivos o componentes específicos para mejoras.
   - Evaluar el impacto de las mejoras y realizar ajustes basándose en retroalimentación continua.

### Consideraciones para la Mejora
- **Desarrollo de Software:**
   - Examinar estructura de archivos, logging, código duplicado, ciberseguridad, nomenclatura y prácticas de codificación.
   - Incorporar pruebas automáticas y análisis de rendimiento.

- **Diseño UX/UI:**
   - Enfocarse en accesibilidad, estética, funcionalidad y experiencia del usuario.

- **Tecnologías Utilizadas:**
   - El proyecto utiliza Python, PHP, HTML, MySQL, JavaScript y CSS. Las recomendaciones serán compatibles con estas tecnologías.

- **Automatización y Machine Learning:**
   - Implementar pruebas automáticas y algoritmos de machine learning para detectar y sugerir mejoras.
   - Utilizar retroalimentación para ajustes continuos y aprendizaje colectivo.

- **Documentación y Conocimiento Compartido:**
   - Mantener una documentación detallada de todos los cambios y mejoras para facilitar el aprendizaje y la mejora continua.



## Estructura de Carpetas y Archivos
```bash
LocalVidStreamer/
    config.php
    README.md
    streamer.php
    TODO.txt
    watch.php
    AMIS/
        00-Prompt-for-ProjectAnalysis.md
```


## Contenido de Archivos Seleccionados

### C:\AppServ\www\LocalVidStreamer\config.php
```plaintext
<?php
// Ruta base donde se almacenan los videos
$basePath = 'E:/videos/';

// Obtener todos los archivos de la carpeta
$files = scandir\($basePath\);

// Filtrar los archivos para incluir solo ciertos tipos de videos \(mp4 en este ejemplo\)
$allowedVideos = array\_filter\($files, function\($file\) use \($basePath\) {
    // Aquí puedes añadir más extensiones de archivo según sea necesario
    return is\_file\($basePath . $file\) && in\_array\(pathinfo\($file, PATHINFO\_EXTENSION\), \['mp4'\]\);
}\);

// Reindexar el array para asegurarse de que las claves son continuas
$allowedVideos = array\_values\($allowedVideos\);

```

### C:\AppServ\www\LocalVidStreamer\README.md
```plaintext
# LocalVidStreamer
```

### C:\AppServ\www\LocalVidStreamer\streamer.php
```plaintext
<?php
require 'config.php'; // Asegúrate de que esta ruta es correcta

// Obtener el nombre del video de la entrada del usuario a través de GET
$userRequestedVideo = isset\($\_GET\['v'\]\) ? $\_GET\['v'\] : '';

// Validación de la entrada contra la lista blanca
if \(in\_array\($userRequestedVideo, $allowedVideos\)\) {
    $videoPath = $basePath . $userRequestedVideo;

    if \(file\_exists\($videoPath\)\) {
        header\('Content-Type: video/mp4'\);
        $fp = fopen\($videoPath, 'rb'\);

        $size = filesize\($videoPath\); // Tamaño del archivo
        $length = $size; // Contenido restante por enviar
        $start = 0; // Punto de inicio de la transmisión
        $end = $size - 1; // Punto final de la transmisión

        header\("Accept-Ranges: 0-$length"\);
        if \(isset\($\_SERVER\['HTTP\_RANGE'\]\)\) {
            $c\_start = $start;
            $c\_end = $end;

            list\(, $range\) = explode\('=', $\_SERVER\['HTTP\_RANGE'\], 2\);
            if \(strpos\($range, ','\) \!== false\) {
                header\('HTTP/1.1 416 Requested Range Not Satisfiable'\);
                header\("Content-Range: bytes $start-$end/$size"\);
                exit;
            }
            if \($range == '-'\) {
                $c\_start = $size - substr\($range, 1\);
            } else {
                $range = explode\('-', $range\);
                $c\_start = $range\[0\];
                $c\_end = \(isset\($range\[1\]\) && is\_numeric\($range\[1\]\)\) ? $range\[1\] : $c\_end;
            }
            $c\_end = \($c\_end > $end\) ? $end : $c\_end;
            if \($c\_start > $c\_end || $c\_start > $size - 1 || $c\_end >= $size\) {
                header\('HTTP/1.1 416 Requested Range Not Satisfiable'\);
                header\("Content-Range: bytes $start-$end/$size"\);
                exit;
            }
            $start = $c\_start;
            $end = $c\_end;
            $length = $end - $start + 1; // Ajusta el tamaño del contenido basado en el rango solicitado
            fseek\($fp, $start\);
            header\('HTTP/1.1 206 Partial Content'\);
            header\("Content-Range: bytes $start-$end/$size"\);
        }
        header\("Content-Length: ".$length\);
        $buffer = 1024 \* 8;
        while \(\!feof\($fp\) && \($p = ftell\($fp\)\) <= $end\) {
            if \($p + $buffer > $end\) {
                $buffer = $end - $p + 1;
            }
            set\_time\_limit\(0\); // Desactiva el límite de tiempo de ejecución
            echo fread\($fp, $buffer\);
            flush\(\); // Vacía el sistema de escritura de salida
        }

        fclose\($fp\);
    } else {
        echo "El video solicitado no se encuentra disponible.";
    }
} else {
    echo "Acceso denegado.";
}
?>

```

### C:\AppServ\www\LocalVidStreamer\TODO.txt
```plaintext
Lista de Tareas para el Proyecto LocalVidStreamer
=================================================

1. Mejoras de Seguridad:
   - Implementar validación y saneamiento de entradas para prevenir inyecciones SQL y ataques XSS.
   - Usar HTTPS para una comunicación segura.

2. Optimización del Rendimiento:
   - Implementar estrategias de caché para recursos de acceso frecuente.
   - Optimizar las consultas a la base de datos para tiempos de respuesta más rápidos.

3. Mejoras en UI/UX:
   - Realizar pruebas con usuarios para recopilar feedback sobre la UI/UX.
   - Implementar un diseño responsivo para un mejor soporte móvil.

4. Refactorización del Código:
   - Eliminar código redundante y usar patrones de diseño para una arquitectura más limpia.
   - Asegurar la consistencia en los estándares de codificación a lo largo del proyecto.

5. Pruebas Automatizadas:
   - Desarrollar pruebas unitarias e integradas para los componentes críticos.
   - Establecer integración continua para ejecutar pruebas automáticamente.

6. Documentación:
   - Actualizar el README.md con instrucciones de configuración y despliegue del proyecto.
   - Documentar los puntos finales de la API si aplica.

7. Prácticas de DevOps:
   - Contenerizar la aplicación con Docker para un despliegue más fácil.
   - Implementar despliegue continuo con GitHub Actions o Jenkins.

8. Accesibilidad:
   - Asegurar que el sitio web sea accesible según las directrices de WCAG.
   - Realizar auditorías de accesibilidad usando herramientas como Lighthouse.

9. Internacionalización:
   - Preparar la aplicación para el soporte de múltiples idiomas.

10. Monitoreo y Registro:
    - Establecer monitoreo para el rendimiento de la aplicación y errores.
    - Implementar un registro estructurado para un mejor diagnóstico de problemas.

Por favor, prioriza las tareas basándote en las necesidades actuales del proyecto y los recursos disponibles.
```

### C:\AppServ\www\LocalVidStreamer\watch.php
```plaintext
<?php
require 'config.php'; // Asegúrate de que esta ruta es correcta

// Comprobar si se ha proporcionado el parámetro 'v' en la URL
if \(isset\($\_GET\['v'\]\) && in\_array\($\_GET\['v'\], $allowedVideos\)\) {
    // Sanitizar el nombre del archivo para prevenir vulnerabilidades
    $videoName = htmlspecialchars\($\_GET\['v'\]\);
    
    // Construir la ruta al video
    $videoPath = $basePath . $videoName;

    // Verificar si el archivo existe y es accesible
    if \(file\_exists\($videoPath\)\) {
        // Aquí podrías redirigir al usuario a una página de reproducción
        // o incrustar directamente el reproductor de video.
        echo "<video controls width='100%'>";
        echo "<source src='streamer.php?v=" . urlencode\($videoName\) . "' type='video/mp4'>";
        echo "Tu navegador no soporta el elemento <code>video</code>.";
        echo "</video>";
    } else {
        echo "El video solicitado no está disponible.";
    }
} else {
    // Si 'v' no está establecido o el video no está en la lista blanca, mostrar la lista de videos disponibles
    echo "<h2>Lista de Videos Disponibles</h2>";
    echo "<ul>";
    foreach \($allowedVideos as $video\) {
        echo "<li><a href='?v=" . urlencode\($video\) . "'>" . htmlspecialchars\($video\) . "</a></li>";
    }
    echo "</ul>";
}

```
