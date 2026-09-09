<?php
require_once __DIR__ . '/_guard.php';
require_once __DIR__ . '/_carreras.php';
require_once __DIR__ . '/_imagen.php';

function volver(string $err = ''): void {
    header('Location: imagenes-inicio.php' . ($err ? '?err=' . rawurlencode($err) : '?ok=1'));
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !csrf_valido($_POST['csrf'] ?? null)) {
    volver('Solicitud no válida. Vuelve a intentar.');
}
if (!imagen_soportada()) {
    volver('El servidor no tiene la librería de imágenes (GD). Avisa al desarrollador.');
}

$m = medios_leer();
$ts = date('YmdHis');

for ($n = 1; $n <= 3; $n++) {
    $file = $_FILES['file_slide' . $n] ?? null;
    if (!$file || ($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK || ($file['size'] ?? 0) <= 0) {
        continue; // este slide no se cambió
    }
    if ($file['size'] > 30 * 1024 * 1024) volver('Una imagen supera el máximo de 30 MB.');

    $rel  = URL_MEDIOS . "/portada/slide$n-$ts.jpg";
    $dest = __DIR__ . '/../' . $rel;
    [$okImg, $msg] = procesar_imagen($file['tmp_name'], $dest, TAM_BANNER[0], TAM_BANNER[1]);
    if (!$okImg) volver($msg);

    borrar_override($m['portada']['slide' . $n] ?? null);
    $m['portada']['slide' . $n] = $rel;
}

if (!medios_guardar($m)) {
    volver('No se pudieron guardar los cambios (permisos de escritura).');
}
volver();
