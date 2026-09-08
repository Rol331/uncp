<?php
require_once __DIR__ . '/_guard.php';
require_once __DIR__ . '/_layout.php';
require_once __DIR__ . '/_carreras.php';

$lista  = carreras_lista();
$m      = medios_leer();
asort($lista, SORT_NATURAL | SORT_FLAG_CASE);

cabecera('carreras', 'Carreras · Imágenes');
?>
      <h2>Carreras · Imágenes</h2>
      <p class="ayuda">Elige una carrera para cambiar su banner, su tarjeta de portada y las fotos de su galería.</p>

      <div class="rejilla-carreras">
        <?php foreach ($lista as $slug => $nombre):
            $tarjeta = img_actual($m, 'tarjetas', $slug); ?>
          <a class="carrera-item" href="carrera-editar.php?slug=<?= urlencode($slug) ?>">
            <div class="miniatura" style="background-image:url('<?= htmlspecialchars($tarjeta ?? '') ?>')"></div>
            <span><?= htmlspecialchars($nombre) ?></span>
          </a>
        <?php endforeach; ?>
      </div>
<?php pie(); ?>
