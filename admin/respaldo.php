<?php
require_once __DIR__ . '/_guard.php';
$raiz = realpath(__DIR__ . '/..');

if (isset($_GET['descargar'])) {
    if (!class_exists('ZipArchive')) {
        require_once __DIR__ . '/_layout.php';
        cabecera('respaldo', 'Respaldo');
        echo '<div class="aviso error">El servidor no tiene la extensión ZipArchive. Avisa al desarrollador.</div>';
        pie();
        exit;
    }
    $tmp = tempnam(sys_get_temp_dir(), 'bak');
    $zip = new ZipArchive();
    $zip->open($tmp, ZipArchive::OVERWRITE);

    foreach (['datos-admision.json', 'textos.json', 'medios.json'] as $f) {
        if (is_file("$raiz/$f")) $zip->addFile("$raiz/$f", $f);
    }
    foreach (['medios', 'documentos', 'leads'] as $d) {
        $base = "$raiz/$d";
        if (!is_dir($base)) continue;
        $it = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($base, FilesystemIterator::SKIP_DOTS)
        );
        foreach ($it as $file) {
            if ($file->isFile()) {
                $rel = $d . '/' . substr($file->getPathname(), strlen($base) + 1);
                $zip->addFile($file->getPathname(), $rel);
            }
        }
    }
    $zip->close();

    header('Content-Type: application/zip');
    header('Content-Disposition: attachment; filename="respaldo-uncp-' . date('Ymd-His') . '.zip"');
    header('Content-Length: ' . filesize($tmp));
    readfile($tmp);
    @unlink($tmp);
    exit;
}

require_once __DIR__ . '/_layout.php';
cabecera('respaldo', 'Respaldo');
?>
      <h2>Respaldo de los datos</h2>
      <p class="ayuda">Descarga un ZIP con todo lo que el panel ha editado: textos, enlaces,
        imágenes subidas, documentos y las solicitudes. Conviene guardarlo cada cierto tiempo.</p>
      <p><a class="btn-descarga" href="respaldo.php?descargar=1">⬇ Descargar respaldo (ZIP)</a></p>
      <p class="ayuda">Incluye <code>datos-admision.json</code>, <code>textos.json</code>,
        <code>medios.json</code> y las carpetas <code>medios/</code>, <code>documentos/</code> y
        <code>leads/</code>.</p>
<?php pie(); ?>
