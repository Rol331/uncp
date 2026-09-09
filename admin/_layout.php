<?php
// Cabecera y pie comunes del panel (barra + menú lateral).
require_once __DIR__ . '/_lib.php';
require_once __DIR__ . '/_carreras.php';

function cabecera(string $activo, string $titulo = 'Datos de Admisión', string $slugActivo = ''): void {
    $secciones = require __DIR__ . '/campos.php';
    ?><!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Panel · <?= htmlspecialchars($titulo) ?></title>
  <link rel="stylesheet" href="estilo.css?v=7">
</head>
<body>
  <header class="barra">
    <div class="marca">
      <span class="marca-ic">🎓</span>
      <div class="marca-tx">
        <strong>Panel de administración</strong>
        <small>Admisión UNCP</small>
      </div>
    </div>
    <nav>
      <a href="../" target="_blank" rel="noopener">↗ Ver sitio</a>
      <a href="logout.php" class="salir">Salir</a>
    </nav>
  </header>

  <div class="disposicion">
    <aside class="menu">
      <p class="menu-titulo">Secciones</p>
      <?php foreach ($secciones as $clave => $s): ?>
        <a href="index.php?seccion=<?= urlencode($clave) ?>" class="<?= $activo === $clave ? 'activo' : '' ?>">
          <span class="mi-ic"><?= $s['icono'] ?? '•' ?></span>
          <span class="mi-tx"><?= htmlspecialchars($s['menu']) ?></span>
        </a>
      <?php endforeach; ?>
      <a href="carreras.php" class="<?= $activo === 'carreras' ? 'activo' : '' ?>">
        <span class="mi-ic">🎓</span>
        <span class="mi-tx">Carreras · Imágenes</span>
      </a>
      <?php if ($activo === 'carreras'):
          $lista = carreras_lista(); asort($lista, SORT_NATURAL | SORT_FLAG_CASE); ?>
        <div class="submenu">
          <?php foreach ($lista as $slug => $nombre): ?>
            <a href="carrera-editar.php?slug=<?= urlencode($slug) ?>" class="sub <?= $slug === $slugActivo ? 'activo' : '' ?>">
              <?= htmlspecialchars($nombre) ?>
            </a>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </aside>

    <main class="contenido">
<?php }

function pie(): void { ?>
    </main>
  </div>
</body>
</html>
<?php }
