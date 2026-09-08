<?php
require_once __DIR__ . '/_guard.php';
require_once __DIR__ . '/_layout.php';
require_once __DIR__ . '/_carreras.php';

$lista = carreras_lista();
$slug  = $_GET['slug'] ?? '';
if (!isset($lista[$slug])) { header('Location: carreras.php'); exit; }

$nombre = $lista[$slug];
$m      = medios_leer();
$slots  = galeria_slots($m, $slug);
$csrf   = token_csrf();
$ok     = isset($_GET['ok']);
$err    = $_GET['err'] ?? '';

function bloque_imagen(string $titulo, string $tam, ?string $urlActual, string $campo): void { ?>
  <fieldset class="doc">
    <legend><?= htmlspecialchars($titulo) ?></legend>
    <p class="actual">Tamaño en el sitio: <?= htmlspecialchars($tam) ?>. Se ajusta automáticamente al subirla.</p>
    <?php if ($urlActual): ?>
      <div class="preview" style="background-image:url('<?= htmlspecialchars($urlActual) ?>')"></div>
    <?php else: ?>
      <div class="preview vacia">Sin imagen</div>
    <?php endif; ?>
    <label class="campo">Subir imagen nueva <span class="opc">(JPG o PNG, opcional)</span>
      <input type="file" name="<?= htmlspecialchars($campo) ?>" accept="image/jpeg,image/png">
    </label>
  </fieldset>
<?php }

cabecera('carreras', $nombre, $slug);
?>
      <p class="miga"><a href="carreras.php">← Todas las carreras</a></p>
      <h2><?= htmlspecialchars($nombre) ?></h2>
      <p class="ayuda">Sube una foto para reemplazar la actual. Los demás campos se dejan vacíos si no vas a cambiarlos.</p>

      <?php if ($ok): ?><div class="aviso ok">✓ Imágenes actualizadas. Míralas en la página de la carrera (recarga con Ctrl+Shift+R).</div><?php endif; ?>
      <?php if ($err): ?><div class="aviso error"><?= htmlspecialchars($err) ?></div><?php endif; ?>

      <form method="post" action="carrera-guardar.php" enctype="multipart/form-data">
        <input type="hidden" name="slug" value="<?= htmlspecialchars($slug) ?>">

        <?php
          bloque_imagen('Banner (cabecera)', '1600 × 900', img_actual($m, 'banner', $slug), 'file_banner');
          bloque_imagen('Tarjeta (portada)', '600 × 400', img_actual($m, 'tarjetas', $slug), 'file_tarjeta');
        ?>

        <?php if ($slots > 0): ?>
          <h3 class="sub-galeria">Galería (<?= $slots ?> foto<?= $slots === 1 ? '' : 's' ?>)</h3>
          <?php for ($n = 1; $n <= $slots; $n++):
              bloque_imagen("Foto de galería $n", '800 × 600', img_actual($m, 'galeria', $slug, $n), "file_galeria_$n");
          endfor; ?>
        <?php else: ?>
          <p class="ayuda">Esta carrera no tiene galería.</p>
        <?php endif; ?>

        <input type="hidden" name="csrf" value="<?= htmlspecialchars($csrf) ?>">
        <div class="acciones"><button type="submit">Guardar imágenes</button></div>
      </form>
<?php pie(); ?>
