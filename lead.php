<?php
// Recibe el formulario de "Déjanos tu información" de la portada, guarda el lead
// en leads/leads.csv (carpeta protegida) y avisa por correo (best-effort).
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['ok' => false, 'error' => 'Método no permitido']);
    exit;
}

// Anti-spam: campo trampa oculto. Si viene lleno, es un bot → fingimos éxito.
if (!empty($_POST['website'])) {
    echo json_encode(['ok' => true]);
    exit;
}

$lim = function ($s) {
    return str_replace(["\r", "\n", "\t"], ' ', mb_substr(trim((string) $s), 0, 200));
};

$nombre   = $lim($_POST['nombre']   ?? '');
$correo   = trim((string) ($_POST['correo'] ?? ''));
$telefono = $lim($_POST['telefono'] ?? '');
$interes  = $lim($_POST['interes']  ?? '');

if ($nombre === '' || !filter_var($correo, FILTER_VALIDATE_EMAIL) || $telefono === '') {
    http_response_code(422);
    echo json_encode(['ok' => false, 'error' => 'Datos incompletos']);
    exit;
}
$correo = $lim($correo);

// Guardar en CSV (con bloqueo).
$dir = __DIR__ . '/leads';
if (!is_dir($dir)) @mkdir($dir, 0755, true);
$csv   = $dir . '/leads.csv';
$nuevo = !is_file($csv);
$fh = @fopen($csv, 'a');
if ($fh) {
    if (flock($fh, LOCK_EX)) {
        if ($nuevo) {
            fwrite($fh, "\xEF\xBB\xBF"); // BOM: tildes correctas en Excel
            fputcsv($fh, ['Fecha', 'Nombre', 'Correo', 'Teléfono', 'Programa de interés', 'IP']);
        }
        fputcsv($fh, [date('Y-m-d H:i:s'), $nombre, $correo, $telefono, $interes, $_SERVER['REMOTE_ADDR'] ?? '']);
        flock($fh, LOCK_UN);
    }
    fclose($fh);
}

// Aviso por correo (best-effort; el CSV es la fuente confiable).
$para = 'informesadmision@uncp.edu.pe';
$dj = @json_decode(@file_get_contents(__DIR__ . '/datos-admision.json'), true);
if (is_array($dj) && !empty($dj['portada']['contacto_correo'])
    && filter_var($dj['portada']['contacto_correo'], FILTER_VALIDATE_EMAIL)) {
    $para = $dj['portada']['contacto_correo'];
}
$cuerpo = "Nueva solicitud de información:\n\n"
        . "Nombre: $nombre\nCorreo: $correo\nTeléfono: $telefono\n"
        . "Programa de interés: $interes\nFecha: " . date('Y-m-d H:i:s') . "\n";
$host = $_SERVER['HTTP_HOST'] ?? 'uncpadmision.edu.pe';
@mail($para, 'Nueva solicitud de información - Admisión UNCP', $cuerpo,
      "From: web@$host\r\nReply-To: $correo\r\nContent-Type: text/plain; charset=utf-8");

echo json_encode(['ok' => true]);
