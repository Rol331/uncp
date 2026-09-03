<?php
require_once __DIR__ . '/_guard.php';
$campos = require __DIR__ . '/campos.php';
$datos  = leer_datos();
$ok   = isset($_GET['ok']);
$err  = $_GET['err'] ?? '';
$csrf = token_csrf();

function valor_doc(array $datos, string $k): string {
    return isset($datos['documentos'][$k]) ? (string) $datos['documentos'][$k] : '';
}
?><!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Panel · Datos de Admisión</title>
  <link rel="stylesheet" href="estilo.css">
</head>
<body>
  <header class="barra">
    <div><strong>Panel de administración</strong> · Datos de Admisión</div>
    <nav><a href="../" target="_blank" rel="noopener">Ver sitio</a> · <a href="logout.php">Salir</a></nav>
  </header>

  <main class="contenido">
    <?php if ($ok): ?><div class="aviso ok">✓ Cambios guardados. Ya se ven en la página.</div><?php endif; ?>
    <?php if ($err): ?><div class="aviso error"><?= htmlspecialchars($err) ?></div><?php endif; ?>

    <form method="post" action="guardar.php" enctype="multipart/form-data">
      <?php $sec = $campos['documentos']; ?>
      <h2><?= htmlspecialchars($sec['titulo']) ?></h2>
      <p class="ayuda"><?= htmlspecialchars($sec['ayuda']) ?></p>

      <?php foreach ($sec['items'] as $k => $label):
          $actual = valor_doc($datos, $k); ?>
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

      <input type="hidden" name="csrf" value="<?= htmlspecialchars($csrf) ?>">
      <div class="acciones"><button type="submit">Guardar cambios</button></div>
    </form>
  </main>
</body>
</html>
