<?php
require_once __DIR__ . '/_guard.php';
$csv = __DIR__ . '/../leads/leads.csv';

// Descarga del CSV completo.
if (isset($_GET['descargar'])) {
    if (is_file($csv)) {
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="leads-uncp.csv"');
        readfile($csv);
    }
    exit;
}

require_once __DIR__ . '/_layout.php';

// Leer filas (las más nuevas primero).
$filas = [];
if (is_file($csv) && ($fh = fopen($csv, 'r'))) {
    while (($r = fgetcsv($fh)) !== false) $filas[] = $r;
    fclose($fh);
}
if ($filas) {
    // quitar BOM de la primera celda de la cabecera
    $filas[0][0] = preg_replace('/^\xEF\xBB\xBF/', '', $filas[0][0]);
    $cabecera = array_shift($filas);
    $filas = array_reverse($filas);
} else {
    $cabecera = [];
}

cabecera('leads', 'Solicitudes');
?>
      <h2>Solicitudes de información</h2>
      <p class="ayuda">Los datos que dejan los postulantes en el formulario de la portada.
        <?php if ($filas): ?><strong><?= count($filas) ?></strong> en total.<?php endif; ?></p>

      <?php if (!$filas): ?>
        <div class="aviso ok">Aún no hay solicitudes.</div>
      <?php else: ?>
        <p><a class="btn-descarga" href="leads.php?descargar=1">⬇ Descargar todo (CSV)</a></p>
        <div class="tabla-scroll">
          <table class="tabla-leads">
            <thead><tr><?php foreach ($cabecera as $c): ?><th><?= htmlspecialchars($c) ?></th><?php endforeach; ?></tr></thead>
            <tbody>
              <?php foreach ($filas as $r): ?>
                <tr><?php foreach ($r as $celda): ?><td><?= htmlspecialchars($celda) ?></td><?php endforeach; ?></tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php endif; ?>
<?php pie(); ?>
