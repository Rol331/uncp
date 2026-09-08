<?php
// Cabecera y pie comunes del panel (barra + menú lateral).
require_once __DIR__ . '/_lib.php';

function cabecera(string $activo, string $titulo = 'Datos de Admisión'): void {
    $secciones = require __DIR__ . '/campos.php';
    ?><!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Panel · <?= htmlspecialchars($titulo) ?></title>
  <link rel="stylesheet" href="estilo.css?v=4">
</head>
<body>
  <header class="barra">
    <div><strong>Panel de administración</strong></div>
    <nav><a href="../" target="_blank" rel="noopener">Ver sitio</a> · <a href="logout.php">Salir</a></nav>
  </header>

  <div class="disposicion">
    <aside class="menu">
      <?php foreach ($secciones as $clave => $s): ?>
        <a href="index.php?seccion=<?= urlencode($clave) ?>" class="<?= $activo === $clave ? 'activo' : '' ?>">
          <?= htmlspecialchars($s['menu']) ?>
        </a>
      <?php endforeach; ?>
      <a href="carreras.php" class="<?= $activo === 'carreras' ? 'activo' : '' ?>">Carreras · Imágenes</a>
    </aside>

    <main class="contenido">
<?php }

function pie(): void { ?>
    </main>
  </div>
</body>
</html>
<?php }
