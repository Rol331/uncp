<?php
// Cabecera y pie comunes del panel (barra + pestañas).
require_once __DIR__ . '/_lib.php';
require_once __DIR__ . '/_carreras.php';

function cabecera(string $activo, string $titulo = 'Datos de Admisión', string $slugActivo = ''): void {
    $secciones = require __DIR__ . '/campos.php';

    // Pestañas superiores (grupos), en orden.
    $grupos = [
        'inicio'      => ['ic' => '🏠', 'tx' => 'Inicio'],
        'admision'    => ['ic' => '📄', 'tx' => 'Admisión'],
        'inscripcion' => ['ic' => '📝', 'tx' => 'Inscripción'],
        'posgrado'    => ['ic' => '🎓', 'tx' => 'Posgrado'],
        'paginas'     => ['ic' => '🖼️', 'tx' => 'Páginas y SEO'],
        'carreras'    => ['ic' => '📸', 'tx' => 'Carreras'],
        'solicitudes' => ['ic' => '📨', 'tx' => 'Solicitudes'],
        'respaldo'    => ['ic' => '💾', 'tx' => 'Respaldo'],
    ];

    // Sub-pestañas de cada grupo. Primero las secciones de campos.php
    // (conservan su orden), luego se insertan las páginas especiales.
    $tabs = [];
    foreach ($grupos as $g => $_) { $tabs[$g] = []; }
    foreach ($secciones as $clave => $s) {
        $g = $s['grupo'] ?? 'paginas';
        $tabs[$g][] = [
            'url' => 'index.php?seccion=' . urlencode($clave),
            'key' => $clave,
            'tx'  => $s['menu'],
            'ic'  => $s['icono'] ?? '•',
        ];
    }
    array_unshift($tabs['carreras'], [
        'url' => 'carreras.php', 'key' => 'carreras',
        'tx'  => 'Imágenes y textos', 'ic' => '📸',
    ]);
    $tabs['solicitudes'][] = ['url' => 'leads.php',    'key' => 'leads',    'tx' => 'Solicitudes', 'ic' => '📨'];
    $tabs['respaldo'][]    = ['url' => 'respaldo.php', 'key' => 'respaldo', 'tx' => 'Respaldo',    'ic' => '💾'];

    // Grupo activo según la sección/página activa.
    $grupoActivo = 'inicio';
    foreach ($tabs as $g => $lista) {
        foreach ($lista as $t) {
            if ($t['key'] === $activo) { $grupoActivo = $g; break 2; }
        }
    }
    ?><!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Panel · <?= htmlspecialchars($titulo) ?></title>
  <link rel="stylesheet" href="estilo.css?v=10">
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

  <!-- Pestañas principales -->
  <nav class="pestanas" aria-label="Secciones">
    <div class="pestanas-in">
      <?php foreach ($grupos as $g => $info):
          $destino = $tabs[$g][0]['url'] ?? '#'; ?>
        <a href="<?= htmlspecialchars($destino) ?>" class="pest <?= $g === $grupoActivo ? 'activa' : '' ?>">
          <span class="pest-ic"><?= $info['ic'] ?></span>
          <span class="pest-tx"><?= htmlspecialchars($info['tx']) ?></span>
        </a>
      <?php endforeach; ?>
    </div>
  </nav>

  <?php $subtabs = $tabs[$grupoActivo] ?? []; ?>
  <?php if (count($subtabs) > 1 || $grupoActivo === 'carreras'): ?>
  <!-- Sub-pestañas del grupo activo -->
  <nav class="subpestanas" aria-label="<?= htmlspecialchars($grupos[$grupoActivo]['tx']) ?>">
    <div class="subpestanas-in">
      <?php foreach ($subtabs as $t): ?>
        <a href="<?= htmlspecialchars($t['url']) ?>" class="subpest <?= $t['key'] === $activo && !($grupoActivo === 'carreras' && $slugActivo !== '' && $t['key'] === 'carreras') ? 'activa' : '' ?>">
          <span class="subpest-ic"><?= $t['ic'] ?></span>
          <?= htmlspecialchars($t['tx']) ?>
        </a>
      <?php endforeach; ?>
      <?php if ($grupoActivo === 'carreras'):
          $lista = carreras_lista(); asort($lista, SORT_NATURAL | SORT_FLAG_CASE); ?>
        <label class="selector-carrera">
          <span>Carrera:</span>
          <select onchange="if(this.value)location.href='carrera-editar.php?slug='+encodeURIComponent(this.value)">
            <option value="">— elige una carrera —</option>
            <?php foreach ($lista as $slug => $nombre): ?>
              <option value="<?= htmlspecialchars($slug) ?>" <?= $slug === $slugActivo ? 'selected' : '' ?>><?= htmlspecialchars($nombre) ?></option>
            <?php endforeach; ?>
          </select>
        </label>
      <?php endif; ?>
    </div>
  </nav>
  <?php endif; ?>

  <main class="contenido">
<?php }

function pie(): void { ?>
  </main>
</body>
</html>
<?php }
