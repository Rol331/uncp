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

} else { // tipo 'textos'
    foreach ($sec['items'] as $k => $label) {
        if (array_key_exists('txt_' . $k, $_POST)) {
            $txt = trim((string) $_POST['txt_' . $k]);
            // Texto plano (se muestra con textContent): sin etiquetas HTML.
            $txt = strip_tags($txt);
            if (mb_strlen($txt) > 300) { $txt = mb_substr($txt, 0, 300); }
            $datos[$sel][$k] = $txt;
        }
    }
}

if (!guardar_datos($datos)) {
    volver($sel, 'No se pudieron guardar los cambios (revisa permisos de escritura).');
}
volver($sel);
