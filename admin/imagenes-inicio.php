<?php
require_once __DIR__ . '/_guard.php';
require_once __DIR__ . '/_layout.php';
require_once __DIR__ . '/_carreras.php';

$m    = medios_leer();
$csrf = token_csrf();
$ok   = isset($_GET['ok']);
$err  = $_GET['err'] ?? '';

// URL actual de un slide: override de medios/ si existe, si no la original.
function slide_actual(array $m, int $n): ?string {
    if (isset($m['portada']['slide' . $n])) return '../' . $m['portada']['slide' . $n];
    $orig = "imagenes/portada/slide-$n.jpg";
    return is_file(__DIR__ . '/../' . $orig) ? '../' . $orig : null;
}

cabecera('inicio_img', 'Imágenes del inicio');
?>
      <h2>Imágenes del inicio</h2>
      <p class="ayuda">Las tres fotos del carrusel del banner de la portada. Se ajustan solas a 1600 × 900.</p>

      <?php if ($ok): ?><div class="aviso ok">✓ Imágenes actualizadas. Míralas en la portada (recarga con Ctrl+Shift+R).</div><?php endif; ?>
      <?php if ($err): ?><div class="aviso error"><?= htmlspecialchars($err) ?></div><?php endif; ?>

      <form method="post" action="imagenes-inicio-guardar.php" enctype="multipart/form-data">
        <?php for ($n = 1; $n <= 3; $n++): $url = slide_actual($m, $n); ?>
          <fieldset class="doc">
            <legend>Slide <?= $n ?> del carrusel</legend>
            <p class="actual">Tamaño en el sitio: 1600 × 900. Se ajusta automáticamente al subirla.</p>
            <?php if ($url): ?>
              <div class="preview" style="background-image:url('<?= htmlspecialchars($url) ?>')"></div>
            <?php else: ?>
              <div class="preview vacia">Sin imagen</div>
            <?php endif; ?>
            <label class="campo">Subir imagen nueva <span class="opc">(JPG o PNG, opcional)</span>
              <input type="file" name="file_slide<?= $n ?>" accept="image/jpeg,image/png">
            </label>
          </fieldset>
        <?php endfor; ?>

        <input type="hidden" name="csrf" value="<?= htmlspecialchars($csrf) ?>">
        <div class="acciones"><button type="submit">Guardar imágenes</button></div>
      </form>
<?php pie(); ?>
