<?php
// Helpers para administrar las imágenes de las carreras.
require_once __DIR__ . '/_lib.php';

const RUTA_MEDIOS     = __DIR__ . '/../medios';       // imágenes subidas (fuera de git)
const URL_MEDIOS      = 'medios';                     // ruta relativa desde la raíz del sitio
const RUTA_MEDIOSJSON = __DIR__ . '/../medios.json';
const RUTA_IMG        = __DIR__ . '/../imagenes';     // originales (solo lectura)

// Tamaños de destino.
const TAM_BANNER  = [1600, 900];
const TAM_TARJETA = [600, 400];
const TAM_GALERIA = [800, 600];

function carreras_lista(): array {
    $j = @file_get_contents(__DIR__ . '/carreras-lista.json');
    $d = $j ? json_decode($j, true) : null;
    return is_array($d) ? $d : [];
}

function medios_leer(): array {
    if (is_file(RUTA_MEDIOSJSON)) {
        $d = json_decode((string) file_get_contents(RUTA_MEDIOSJSON), true);
        if (is_array($d)) {
            $d += ['tarjetas' => [], 'banner' => [], 'galeria' => []];
            return $d;
        }
    }
    return ['tarjetas' => [], 'banner' => [], 'galeria' => []];
}

function medios_guardar(array $m): bool {
    $json = json_encode($m, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    if ($json === false) return false;
    $tmp = RUTA_MEDIOSJSON . '.tmp';
    if (file_put_contents($tmp, $json, LOCK_EX) === false) return false;
    return rename($tmp, RUTA_MEDIOSJSON);
}

/** URL (relativa a /admin) de la imagen actual: override si existe, si no la original. */
function img_actual(array $m, string $tipo, string $slug, ?int $n = null): ?string {
    if ($tipo === 'galeria') {
        if (isset($m['galeria'][$slug][(string) $n])) return '../' . $m['galeria'][$slug][(string) $n];
        $orig = "imagenes/galeria/$slug-$n.jpg";
        return is_file(__DIR__ . '/../' . $orig) ? '../' . $orig : null;
    }
    if (isset($m[$tipo][$slug])) return '../' . $m[$tipo][$slug];
    $carpeta = $tipo === 'tarjetas' ? 'tarjetas' : 'banner';
    $orig = "imagenes/$carpeta/$slug.jpg";
    return is_file(__DIR__ . '/../' . $orig) ? '../' . $orig : null;
}

/** Número de fotos de galería de una carrera (máximo entre originales y overrides). */
function galeria_slots(array $m, string $slug): int {
    $n = 0;
    foreach (glob(RUTA_IMG . "/galeria/$slug-*.jpg") ?: [] as $f) {
        if (preg_match('/-(\d+)\.jpg$/', $f, $mt)) $n = max($n, (int) $mt[1]);
    }
    if (isset($m['galeria'][$slug])) {
        foreach (array_keys($m['galeria'][$slug]) as $k) $n = max($n, (int) $k);
    }
    return $n;
}

/** Borra un archivo de override anterior (dentro de medios/) si existe. */
function borrar_override(?string $rutaRelRaiz): void {
    if (!$rutaRelRaiz) return;
    if (strpos($rutaRelRaiz, URL_MEDIOS . '/') !== 0) return; // solo dentro de medios/
    $abs = __DIR__ . '/../' . $rutaRelRaiz;
    if (is_file($abs)) @unlink($abs);
}
