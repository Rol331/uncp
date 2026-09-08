<?php
// Utilidades comunes del panel: sesión, configuración, CSRF y acceso al JSON.

const RUTA_DATOS   = __DIR__ . '/../datos-admision.json';
const RUTA_EJEMPLO = __DIR__ . '/../datos-admision.sample.json';
const RUTA_DOCS    = __DIR__ . '/../documentos';
const URL_DOCS     = 'documentos'; // ruta relativa desde la raíz del sitio

function iniciar_sesion(): void {
    if (session_status() === PHP_SESSION_ACTIVE) return;
    session_set_cookie_params([
        'httponly' => true,
        'secure'   => (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'),
        'samesite' => 'Lax',
    ]);
    session_name('uncp_admin');
    session_start();
}

function config(): ?array {
    $cfg = @include __DIR__ . '/config.php';
    return is_array($cfg) ? $cfg : null;
}

function esta_autenticado(): bool {
    return !empty($_SESSION['auth']);
}

function exigir_login(): void {
    iniciar_sesion();
    if (!esta_autenticado()) {
        header('Location: login.php');
        exit;
    }
}

function token_csrf(): string {
    iniciar_sesion();
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf'];
}

function csrf_valido(?string $t): bool {
    return is_string($t) && !empty($_SESSION['csrf']) && hash_equals($_SESSION['csrf'], $t);
}

function leer_datos(): array {
    // Base: los valores de ejemplo (semilla). Sobre ellos se superponen los
    // datos vivos, así una sección/campo aún no guardado muestra su valor base
    // en vez de salir vacío.
    $base = [];
    if (is_file(RUTA_EJEMPLO)) {
        $d = json_decode((string) file_get_contents(RUTA_EJEMPLO), true);
        if (is_array($d)) $base = $d;
    }
    if (is_file(RUTA_DATOS)) {
        $d = json_decode((string) file_get_contents(RUTA_DATOS), true);
        if (is_array($d)) {
            foreach ($d as $sec => $vals) {
                if (is_array($vals) && isset($base[$sec]) && is_array($base[$sec])) {
                    $base[$sec] = array_merge($base[$sec], $vals);
                } else {
                    $base[$sec] = $vals;
                }
            }
        }
    }
    return $base ?: ['documentos' => []];
}

function guardar_datos(array $datos): bool {
    $json = json_encode(
        $datos,
        JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
    );
    if ($json === false) return false;
    // Escritura atómica: primero a un temporal y luego rename.
    $tmp = RUTA_DATOS . '.tmp';
    if (file_put_contents($tmp, $json, LOCK_EX) === false) return false;
    return rename($tmp, RUTA_DATOS);
}
