<?php
require_once __DIR__ . '/_guard.php';
$campos = require __DIR__ . '/campos.php';

function volver(string $err = ''): void {
    header('Location: index.php' . ($err ? '?err=' . rawurlencode($err) : '?ok=1'));
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !csrf_valido($_POST['csrf'] ?? null)) {
    volver('Solicitud no válida. Vuelve a intentar.');
}

$datos = leer_datos();
if (!isset($datos['documentos']) || !is_array($datos['documentos'])) {
    $datos['documentos'] = [];
}

if (!is_dir(RUTA_DOCS)) { @mkdir(RUTA_DOCS, 0755, true); }

$MAX   = 25 * 1024 * 1024; // 25 MB
$finfo = function_exists('finfo_open') ? finfo_open(FILEINFO_MIME_TYPE) : null;

foreach ($campos['documentos']['items'] as $k => $label) {
    $file = $_FILES['file_' . $k] ?? null;

    // 1) ¿Subieron un archivo?
    if ($file && ($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_OK && ($file['size'] ?? 0) > 0) {
        if ($file['size'] > $MAX) {
            if ($finfo) finfo_close($finfo);
            volver('El archivo de "' . $label . '" supera el máximo de 25 MB.');
        }
        $ext  = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $mime = $finfo ? finfo_file($finfo, $file['tmp_name']) : 'application/pdf';
        if ($ext !== 'pdf' || $mime !== 'application/pdf') {
            if ($finfo) finfo_close($finfo);
            volver('El documento "' . $label . '" debe ser un archivo PDF.');
        }
        $nombre  = $k . '-' . date('Ymd-His') . '.pdf';
        $destino = RUTA_DOCS . '/' . $nombre;
        if (!move_uploaded_file($file['tmp_name'], $destino)) {
            if ($finfo) finfo_close($finfo);
            volver('No se pudo guardar el archivo de "' . $label . '".');
        }
        @chmod($destino, 0644);
        $datos['documentos'][$k] = URL_DOCS . '/' . $nombre;
        continue;
    }

    // 2) Si no, usar el enlace escrito (si viene).
    $url = trim((string) ($_POST['url_' . $k] ?? ''));
    if ($url !== '') {
        // http(s) o ruta interna sencilla (p. ej. prospecto.html).
        if (preg_match('#^https?://#i', $url) || preg_match('#^[\w./?=&%-]+$#', $url)) {
            $datos['documentos'][$k] = $url;
        } else {
            if ($finfo) finfo_close($finfo);
            volver('El enlace de "' . $label . '" no es válido.');
        }
    }
    // 3) Si no hay archivo ni enlace, se conserva el valor anterior.
}

if ($finfo) finfo_close($finfo);

if (!guardar_datos($datos)) {
    volver('No se pudieron guardar los cambios (revisa permisos de escritura).');
}
volver();
