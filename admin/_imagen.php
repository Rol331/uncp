<?php
// Procesa una imagen subida: corrige orientación, recorta "cover" y la deja
// del tamaño exacto. Re-codifica con GD (eso también limpia el archivo).

function imagen_soportada(): bool {
    return function_exists('imagecreatetruecolor') && function_exists('imagejpeg');
}

/** Devuelve [true, ''] o [false, 'mensaje de error']. */
function procesar_imagen(string $tmp, string $dest, int $w, int $h): array {
    if (!imagen_soportada()) {
        return [false, 'El servidor no tiene la librería de imágenes (GD).'];
    }
    $info = @getimagesize($tmp);
    if (!$info) return [false, 'El archivo no es una imagen válida.'];

    switch ($info[2]) {
        case IMAGETYPE_JPEG: $src = @imagecreatefromjpeg($tmp); break;
        case IMAGETYPE_PNG:  $src = @imagecreatefrompng($tmp);  break;
        case IMAGETYPE_WEBP: $src = function_exists('imagecreatefromwebp') ? @imagecreatefromwebp($tmp) : false; break;
        default: return [false, 'Formato no soportado. Usa JPG o PNG.'];
    }
    if (!$src) return [false, 'No se pudo leer la imagen.'];

    // Orientación EXIF (solo JPEG).
    if ($info[2] === IMAGETYPE_JPEG && function_exists('exif_read_data')) {
        $exif = @exif_read_data($tmp);
        if (!empty($exif['Orientation'])) {
            if ($exif['Orientation'] == 3) $src = imagerotate($src, 180, 0);
            elseif ($exif['Orientation'] == 6) $src = imagerotate($src, -90, 0);
            elseif ($exif['Orientation'] == 8) $src = imagerotate($src, 90, 0);
        }
    }

    $sw = imagesx($src); $sh = imagesy($src);
    // Recorte "cover": escala para cubrir w×h y recorta el sobrante, centrado.
    $escala = max($w / $sw, $h / $sh);
    $nw = (int) ceil($sw * $escala);
    $nh = (int) ceil($sh * $escala);
    $ox = (int) (($nw - $w) / 2);
    $oy = (int) (($nh - $h) / 2);

    $escalada = imagecreatetruecolor($nw, $nh);
    imagecopyresampled($escalada, $src, 0, 0, 0, 0, $nw, $nh, $sw, $sh);
    imagedestroy($src);

    $out = imagecreatetruecolor($w, $h);
    imagecopy($out, $escalada, 0, 0, $ox, $oy, $w, $h);
    imagedestroy($escalada);

    $dir = dirname($dest);
    if (!is_dir($dir)) @mkdir($dir, 0755, true);
    $ok = imagejpeg($out, $dest, 82);
    imagedestroy($out);

    if (!$ok) return [false, 'No se pudo guardar la imagen procesada.'];
    @chmod($dest, 0644);
    return [true, ''];
}
