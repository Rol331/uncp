<?php
require_once __DIR__ . '/_guard.php';
$secciones = require __DIR__ . '/campos.php';
$datos     = leer_datos();

// Sección seleccionada (por defecto, la primera).
$claves = array_keys($secciones);
$sel = $_GET['seccion'] ?? $claves[0];
if (!isset($secciones[$sel])) { $sel = $claves[0]; }
$sec = $secciones[$sel];

$ok   = isset($_GET['ok']);
$err  = $_GET['err'] ?? '';
$csrf = token_csrf();

function valor(array $datos, string $seccion, string $k): string {
    return isset($datos[$seccion][$k]) ? (string) $datos[$seccion][$k] : '';
}
?><!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Panel · Datos de Admisión</title>
  <link rel="stylesheet" href="estilo.css?v=3">
</head>
<body>
  <header class="barra">
    <div><strong>Panel de administración</strong></div>
    <nav><a href="../" target="_blank" rel="noopener">Ver sitio</a> · <a href="logout.php">Salir</a></nav>
  </header>

  <div class="disposicion">
    <!-- Menú por página -->
    <aside class="menu">
      <?php foreach ($secciones as $clave => $s): ?>
        <a href="?seccion=<?= urlencode($clave) ?>" class="<?= $clave === $sel ? 'activo' : '' ?>">
          <?= htmlspecialchars($s['menu']) ?>
        </a>
      <?php endforeach; ?>
    </aside>

    <main class="contenido">
      <?php if ($ok): ?><div class="aviso ok">✓ Cambios guardados. Ya se ven en la página.</div><?php endif; ?>
      <?php if ($err): ?><div class="aviso error"><?= htmlspecialchars($err) ?></div><?php endif; ?>

      <h2><?= htmlspecialchars($sec['titulo']) ?></h2>
      <p class="ayuda"><?= htmlspecialchars($sec['ayuda']) ?></p>

      <form method="post" action="guardar.php" enctype="multipart/form-data">
        <input type="hidden" name="seccion" value="<?= htmlspecialchars($sel) ?>">

        <?php if ($sec['tipo'] === 'documentos'): ?>
          <?php foreach ($sec['items'] as $k => $label): $actual = valor($datos, $sel, $k); ?>
            <fieldset class="doc">
              <legend><?= htmlspecialchars($label) ?></legend>
              <?php if ($actual !== ''): ?>
                <p class="actual">Enlace actual:
                  <a href="<?= htmlspecialchars($actual) ?>" target="_blank" rel="noopener"><?= htmlspecialchars($actual) ?></a>
                </p>
              <?php endif; ?>
              <label class="campo">Subir PDF nuevo <span class="opc">(opcional)</span>
                <input type="file" name="file_<?= htmlspecialchars($k) ?>" accept="application/pdf">
              </label>
              <label class="campo">O pegar un enlace
                <input type="url" name="url_<?= htmlspecialchars($k) ?>" value="<?= htmlspecialchars($actual) ?>" placeholder="https://...">
              </label>
            </fieldset>
          <?php endforeach; ?>

        <?php else: /* tipo textos */ ?>
          <?php foreach ($sec['items'] as $k => $label): $actual = valor($datos, $sel, $k); ?>
            <fieldset class="doc">
              <legend><?= htmlspecialchars($label) ?></legend>
              <label class="campo">Texto
                <input type="text" name="txt_<?= htmlspecialchars($k) ?>" value="<?= htmlspecialchars($actual) ?>">
              </label>
            </fieldset>
          <?php endforeach; ?>
        <?php endif; ?>

        <input type="hidden" name="csrf" value="<?= htmlspecialchars($csrf) ?>">
        <div class="acciones"><button type="submit">Guardar cambios</button></div>
      </form>
    </main>
  </div>
</body>
</html>
