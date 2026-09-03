<?php
// ─────────────────────────────────────────────────────────────────────────
//  CONFIGURACIÓN DEL PANEL — NO se sube a git.
//  En el SERVIDOR copia este archivo como config.php y pega el hash de tu
//  contraseña. Genera el hash con este comando (en la Terminal de cPanel):
//
//     php -r 'echo password_hash("TU-CONTRASENA", PASSWORD_DEFAULT), "\n";'
//
//  Pega lo que imprima (empieza con $2y$...) en 'password_hash'.
// ─────────────────────────────────────────────────────────────────────────
return [
    'password_hash' => 'PEGA-AQUI-EL-HASH',
];
