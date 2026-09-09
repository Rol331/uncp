<?php
require_once __DIR__ . '/_guard.php';
require_once __DIR__ . '/_layout.php';
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

cabecera($sel);
?>
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

        <?php elseif (isset($sec['grupos'])): /* textos agrupados */ ?>
          <?php $multi = !empty($sec['multilinea']); ?>
          <?php foreach ($sec['grupos'] as $grupo => $items): ?>
            <h3 class="sub-galeria"><?= htmlspecialchars($grupo) ?></h3>
            <?php foreach ($items as $k => $label):
                $raw = $datos[$sel][$k] ?? '';
                $display = is_array($raw) ? implode("\n", $raw) : (string) $raw; ?>
              <fieldset class="doc">
                <legend><?= htmlspecialchars($label) ?></legend>
                <label class="campo">Texto
                  <?php if ($multi): ?>
                    <textarea name="txt_<?= htmlspecialchars($k) ?>" rows="3"><?= htmlspecialchars($display) ?></textarea>
                  <?php else: ?>
                    <input type="text" name="txt_<?= htmlspecialchars($k) ?>" value="<?= htmlspecialchars($display) ?>">
                  <?php endif; ?>
                </label>
              </fieldset>
            <?php endforeach; ?>
          <?php endforeach; ?>

        <?php else: /* tipo textos simple */ ?>
          <?php foreach ($sec['items'] as $k => $label): $actual = valor($datos, $sel, $k); ?>
            <fieldset class="doc">
              <legend><?= htmlspecialchars($label) ?></legend>
              <label class="campo">Texto
                <input type="text" name="txt_<?= htmlspecialchars($k) ?>" value="<?= htmlspecialchars($actual) ?>">
              </label>
            </fieldset>
          <?php endforeach; ?>
        <?php endif; ?>

        <?php if ($sel === 'portada'):
            $m = medios_leer();
            $accesoOrig = [
                1 => 'imagenes/portada/slide-1.jpg',
                2 => 'imagenes/portada/slide-2.jpg',
                3 => 'imagenes/portada/slide-3.jpg',
                4 => 'imagenes/tarjetas/ingenieria-de-sistemas.jpg',
            ];
            $accesoLbl = [1 => 'Información 2026-II', 2 => 'Prospecto de admisión', 3 => 'Inscripción en línea', 4 => 'Resultados'];
            $urlSlide  = function ($m, $n) { return isset($m['portada']['slide' . $n]) ? '../' . $m['portada']['slide' . $n] : '../imagenes/portada/slide-' . $n . '.jpg'; };
            $urlAcceso = function ($m, $n, $orig) { return isset($m['portada']['acceso' . $n]) ? '../' . $m['portada']['acceso' . $n] : '../' . $orig; };
        ?>
          <h3 class="sub-galeria">Imágenes del carrusel</h3>
          <?php for ($n = 1; $n <= 3; $n++): $u = $urlSlide($m, $n); ?>
            <fieldset class="doc">
              <legend>Slide <?= $n ?></legend>
              <p class="actual">1600 × 900 · se ajusta sola al subirla.</p>
              <div class="preview" style="background-image:url('<?= htmlspecialchars($u) ?>')"></div>
              <label class="campo">Subir imagen nueva <span class="opc">(JPG o PNG, opcional)</span>
                <input type="file" name="file_slide<?= $n ?>" accept="image/jpeg,image/png">
              </label>
            </fieldset>
          <?php endfor; ?>

          <h3 class="sub-galeria">Tarjetas de acceso</h3>
          <?php for ($n = 1; $n <= 4; $n++): $u = $urlAcceso($m, $n, $accesoOrig[$n]); ?>
            <fieldset class="doc">
              <legend><?= htmlspecialchars($accesoLbl[$n]) ?></legend>
              <p class="actual">Se ajusta sola al subirla.</p>
              <div class="preview" style="background-image:url('<?= htmlspecialchars($u) ?>')"></div>
              <label class="campo">Subir imagen nueva <span class="opc">(JPG o PNG, opcional)</span>
                <input type="file" name="file_acceso<?= $n ?>" accept="image/jpeg,image/png">
              </label>
            </fieldset>
          <?php endfor; ?>
        <?php endif; ?>

        <input type="hidden" name="csrf" value="<?= htmlspecialchars($csrf) ?>">
        <div class="acciones"><button type="submit">Guardar cambios</button></div>
      </form>
<?php pie(); ?>
