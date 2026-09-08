<?php
require_once __DIR__ . '/_guard.php';
require_once __DIR__ . '/_carreras.php';
require_once __DIR__ . '/_imagen.php';

$lista = carreras_lista();
$slug  = $_POST['slug'] ?? '';

function volver(string $slug, string $err = ''): void {
    $q = 'carrera-editar.php?slug=' . urlencode($slug) . ($err ? '&err=' . rawurlencode($err) : '&ok=1');
    header('Location: ' . $q);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !csrf_valido($_POST['csrf'] ?? null) || !isset($lista[$slug])) {
    volver($slug ?: '', 'Solicitud no válida. Vuelve a intentar.');
}
if (!imagen_soportada()) {
    volver($slug, 'El servidor no tiene la librería de imágenes (GD). Avisa al desarrollador.');
}

$m = medios_leer();
$ts = date('YmdHis');

/** Procesa un campo de archivo si vino; devuelve la ruta relativa o null. */
function subir(string $campo, string $subcarpeta, string $nombreBase, array $tam): ?array {
    $file = $_FILES[$campo] ?? null;
    if (!$file || ($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK || ($file['size'] ?? 0) <= 0) {
        return null; // no subieron nada en este campo
    }
    if ($file['size'] > 30 * 1024 * 1024) {
        return [false, 'Una imagen supera el máximo de 30 MB.'];
    }
    $rel  = URL_MEDIOS . "/$subcarpeta/$nombreBase.jpg";
    $dest = __DIR__ . '/../' . $rel;
    [$ok, $msg] = procesar_imagen($file['tmp_name'], $dest, $tam[0], $tam[1]);
    if (!$ok) return [false, $msg];
    return [true, $rel];
}

// Banner
$r = subir('file_banner', 'banner', "$slug-$ts", TAM_BANNER);
if (is_array($r) && $r[0] === false) volver($slug, $r[1]);
if (is_array($r)) { borrar_override($m['banner'][$slug] ?? null); $m['banner'][$slug] = $r[1]; }

// Tarjeta
$r = subir('file_tarjeta', 'tarjetas', "$slug-$ts", TAM_TARJETA);
if (is_array($r) && $r[0] === false) volver($slug, $r[1]);
if (is_array($r)) { borrar_override($m['tarjetas'][$slug] ?? null); $m['tarjetas'][$slug] = $r[1]; }

// Galería (por slot)
$slots = galeria_slots($m, $slug);
for ($n = 1; $n <= $slots; $n++) {
    $r = subir("file_galeria_$n", 'galeria', "$slug-$n-$ts", TAM_GALERIA);
    if (is_array($r) && $r[0] === false) volver($slug, $r[1]);
    if (is_array($r)) {
        borrar_override($m['galeria'][$slug][(string) $n] ?? null);
        $m['galeria'][$slug][(string) $n] = $r[1];
    }
}

if (!medios_guardar($m)) {
    volver($slug, 'No se pudieron guardar los cambios (permisos de escritura).');
}
volver($slug);
