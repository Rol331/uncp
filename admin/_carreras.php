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
            $d += ['tarjetas' => [], 'banner' => [], 'galeria' => [], 'portada' => []];
            return $d;
        }
    }
    return ['tarjetas' => [], 'banner' => [], 'galeria' => [], 'portada' => []];
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

// ── Textos de carreras (Fase B) ──────────────────────────────────────
const RUTA_TEXTOS   = __DIR__ . '/../textos.json';
const RUTA_CARRERAS = __DIR__ . '/../carreras';

function textos_leer(): array {
    if (is_file(RUTA_TEXTOS)) {
        $d = json_decode((string) file_get_contents(RUTA_TEXTOS), true);
        if (is_array($d)) return $d;
    }
    return [];
}

function textos_guardar(array $t): bool {
    $json = json_encode($t, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    if ($json === false) return false;
    $tmp = RUTA_TEXTOS . '.tmp';
    if (file_put_contents($tmp, $json, LOCK_EX) === false) return false;
    return rename($tmp, RUTA_TEXTOS);
}

function limpiar_texto(string $s, int $max): string {
    $s = trim(strip_tags($s));
    if (mb_strlen($s) > $max) $s = mb_substr($s, 0, $max);
    return $s;
}

// Lee el HTML de una carrera (para sacar los textos actuales por defecto).
function carrera_html(string $slug): ?string {
    $f = RUTA_CARRERAS . "/$slug.html";
    return is_file($f) ? (string) file_get_contents($f) : null;
}

function _limpiar_html_a_texto(string $s): string {
    return trim(html_entity_decode(strip_tags($s), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
}

function parse_bajada(?string $h): string {
    if ($h && preg_match('/<p class="bajada">(.*?)<\/p>/s', $h, $m)) return _limpiar_html_a_texto($m[1]);
    return '';
}

function parse_perfil(?string $h): string {
    if ($h && preg_match('/Perfil del egresado.*?<p>(.*?)<\/p>/s', $h, $m)) return _limpiar_html_a_texto($m[1]);
    return '';
}

function parse_campo(?string $h): array {
    $out = [];
    if ($h && preg_match('/Campo ocupacional.*?<ul class="lista-check">(.*?)<\/ul>/s', $h, $m)
        && preg_match_all('/<li>(.*?)<\/li>/s', $m[1], $lis)) {
        foreach ($lis[1] as $li) {
            // El texto va en el <span> sin atributos (el segundo).
            if (preg_match('/<span>(.*?)<\/span>/s', $li, $mm)) $out[] = _limpiar_html_a_texto($mm[1]);
        }
    }
    return $out;
}

function parse_plan(?string $h): array {
    $out = [];
    if (!$h || !preg_match('/<div class="plan">(.*?)<\/div>/s', $h, $m)) return $out;
    if (!preg_match_all('/<details[^>]*>(.*?)<\/details>/s', $m[1], $dets)) return $out;
    foreach ($dets[1] as $det) {
        $titulo = '';
        if (preg_match('/<span class="plan-tit">(.*?)<\/span>/s', $det, $mt)) $titulo = _limpiar_html_a_texto($mt[1]);
        $cursos = [];
        if (preg_match('/<ul>(.*?)<\/ul>/s', $det, $mu) && preg_match_all('/<li>(.*?)<\/li>/s', $mu[1], $lis)) {
            foreach ($lis[1] as $li) $cursos[] = _limpiar_html_a_texto($li);
        }
        $out[] = ['titulo' => $titulo, 'cursos' => $cursos];
    }
    return $out;
}

function parse_labs(?string $h): array {
    $out = [];
    if ($h && preg_match('/Laboratorios de Enseñanza(.*?)(?:<span class="rotulo">|<\/section>)/s', $h, $m)
        && preg_match_all('/<div class="lab[^"]*">.*?<p>(.*?)<\/p>/s', $m[1], $labs)) {
        foreach ($labs[1] as $lab) $out[] = _limpiar_html_a_texto($lab);
    }
    return $out;
}

/** Texto actual: override de textos.json si existe, si no lo del HTML. */
function texto_actual(array $t, string $slug, string $campo, ?string $html) {
    if (isset($t[$slug][$campo])) return $t[$slug][$campo];
    if ($campo === 'bajada') return parse_bajada($html);
    if ($campo === 'perfil') return parse_perfil($html);
    if ($campo === 'campo')  return parse_campo($html);
    if ($campo === 'plan')   return parse_plan($html);
    if ($campo === 'labs')   return parse_labs($html);
    return '';
}
