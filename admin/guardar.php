<?php
require_once __DIR__ . '/_guard.php';
$secciones = require __DIR__ . '/campos.php';

$sel = $_POST['seccion'] ?? '';

function volver(string $seccion, string $err = ''): void {
    $q = 'index.php?seccion=' . urlencode($seccion) . ($err ? '&err=' . rawurlencode($err) : '&ok=1');
    header('Location: ' . $q);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !csrf_valido($_POST['csrf'] ?? null) || !isset($secciones[$sel])) {
    volver($sel ?: 'documentos', 'Solicitud no válida. Vuelve a intentar.');
}

$sec   = $secciones[$sel];
$datos = leer_datos();
if (!isset($datos[$sel]) || !is_array($datos[$sel])) {
    $datos[$sel] = [];
}

if ($sec['tipo'] === 'documentos') {
    if (!is_dir(RUTA_DOCS)) { @mkdir(RUTA_DOCS, 0755, true); }
    $MAX   = 25 * 1024 * 1024; // 25 MB
    $finfo = function_exists('finfo_open') ? finfo_open(FILEINFO_MIME_TYPE) : null;

    foreach ($sec['items'] as $k => $label) {
        $file = $_FILES['file_' . $k] ?? null;

        // 1) ¿Subieron un archivo?
        if ($file && ($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_OK && ($file['size'] ?? 0) > 0) {
            if ($file['size'] > $MAX) {
                if ($finfo) finfo_close($finfo);
                volver($sel, 'El archivo de "' . $label . '" supera el máximo de 25 MB.');
            }
            $ext  = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            $mime = $finfo ? finfo_file($finfo, $file['tmp_name']) : 'application/pdf';
            if ($ext !== 'pdf' || $mime !== 'application/pdf') {
                if ($finfo) finfo_close($finfo);
                volver($sel, 'El documento "' . $label . '" debe ser un archivo PDF.');
            }
            $nombre  = $k . '-' . date('Ymd-His') . '.pdf';
            $destino = RUTA_DOCS . '/' . $nombre;
            if (!move_uploaded_file($file['tmp_name'], $destino)) {
                if ($finfo) finfo_close($finfo);
                volver($sel, 'No se pudo guardar el archivo de "' . $label . '".');
            }
            @chmod($destino, 0644);
            $datos[$sel][$k] = URL_DOCS . '/' . $nombre;
            continue;
        }

        // 2) Si no, usar el enlace escrito (si viene).
        $url = trim((string) ($_POST['url_' . $k] ?? ''));
        if ($url !== '') {
            if (preg_match('#^https?://#i', $url) || preg_match('#^[\w./?=&%-]+$#', $url)) {
                $datos[$sel][$k] = $url;
            } else {
                if ($finfo) finfo_close($finfo);
                volver($sel, 'El enlace de "' . $label . '" no es válido.');
            }
        }
        // 3) Sin archivo ni enlace: se conserva el valor anterior.
    }
    if ($finfo) finfo_close($finfo);

} else { // tipo 'textos' (simple o agrupado)
    $items = $sec['items'] ?? [];
    if (isset($sec['grupos'])) {
        $items = [];
        foreach ($sec['grupos'] as $g) { $items += $g; }
    }
    $listas = $sec['listas'] ?? [];
    foreach ($items as $k => $label) {
        if (!array_key_exists('txt_' . $k, $_POST)) continue;
        if (in_array($k, $listas, true)) {
            // Lista: una línea por ítem.
            $arr = [];
            foreach (preg_split('/\r\n|\r|\n/', (string) $_POST['txt_' . $k]) as $ln) {
                $ln = trim(strip_tags($ln));
                if (mb_strlen($ln) > 400) $ln = mb_substr($ln, 0, 400);
                if ($ln !== '') $arr[] = $ln;
            }
            $datos[$sel][$k] = $arr;
        } else {
            $txt = trim(strip_tags((string) $_POST['txt_' . $k]));
            if (mb_strlen($txt) > 600) { $txt = mb_substr($txt, 0, 600); }
            $datos[$sel][$k] = $txt;
        }
    }
}

// Imágenes de la portada (carrusel + tarjetas de acceso) -> medios.json
if ($sel === 'portada') {
    require_once __DIR__ . '/_carreras.php';
    require_once __DIR__ . '/_imagen.php';
    if (imagen_soportada()) {
        $m  = medios_leer();
        $ts = date('YmdHis');
        $subir = [];
        for ($n = 1; $n <= 3; $n++) $subir['slide' . $n]  = ['file_slide' . $n,  TAM_BANNER];
        for ($n = 1; $n <= 4; $n++) $subir['acceso' . $n] = ['file_acceso' . $n, [800, 600]];
        foreach ($subir as $key => $cfg) {
            [$campo, $tam] = $cfg;
            $file = $_FILES[$campo] ?? null;
            if (!$file || ($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK || ($file['size'] ?? 0) <= 0) continue;
            if ($file['size'] > 30 * 1024 * 1024) volver($sel, 'Una imagen supera el máximo de 30 MB.');
            $rel  = URL_MEDIOS . "/portada/$key-$ts.jpg";
            $dest = __DIR__ . '/../' . $rel;
            [$okImg, $msg] = procesar_imagen($file['tmp_name'], $dest, $tam[0], $tam[1]);
            if (!$okImg) volver($sel, $msg);
            borrar_override($m['portada'][$key] ?? null);
            $m['portada'][$key] = $rel;
        }
        medios_guardar($m);
    }
}

if (!guardar_datos($datos)) {
    volver($sel, 'No se pudieron guardar los cambios (revisa permisos de escritura).');
}
volver($sel);
