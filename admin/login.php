<?php
require_once __DIR__ . '/_lib.php';
iniciar_sesion();

if (esta_autenticado()) { header('Location: index.php'); exit; }

$error = '';
$cfg = config();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_valido($_POST['csrf'] ?? null)) {
        $error = 'La sesión expiró, vuelve a intentar.';
    } elseif ($cfg === null || empty($cfg['password_hash']) || $cfg['password_hash'] === 'PEGA-AQUI-EL-HASH') {
        $error = 'El panel aún no está configurado (falta config.php en el servidor).';
    } elseif (password_verify($_POST['password'] ?? '', $cfg['password_hash'])) {
        session_regenerate_id(true);
        $_SESSION['auth'] = true;
        header('Location: index.php'); exit;
    } else {
        usleep(600000); // pequeño retardo contra fuerza bruta
        $error = 'Contraseña incorrecta.';
    }
}
$csrf = token_csrf();
?><!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Panel · Ingresar</title>
  <link rel="stylesheet" href="estilo.css">
</head>
<body class="login">
  <form method="post" class="tarjeta" autocomplete="on">
    <h1>Panel de administración</h1>
    <p class="sub">Universidad Nacional del Centro del Perú</p>
    <?php if ($error): ?><div class="aviso error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
    <label>Contraseña
      <input type="password" name="password" required autofocus autocomplete="current-password">
    </label>
    <input type="hidden" name="csrf" value="<?= htmlspecialchars($csrf) ?>">
    <button type="submit">Ingresar</button>
  </form>
</body>
</html>
