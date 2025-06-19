<?php
require_once __DIR__ . '/../etc/config.php';
$usuario = require_once __DIR__ . '/tarea/verificarautenticado.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../codeparts/estilo.css">
    <title>Formulario de Login</title>
</head>
<body>
    <?php readfile(__DIR__ . '/../codeparts/nav.html'); ?>
    <h1>Formulario de Login</h1>
    <?php include __DIR__.'/../codeparts/msgs.php'; ?>
    <?php if (!empty($usuario) && isset($usuario['login']) && isset($usuario['ultimo_acceso'])): ?>
        <p>Usuario <?= htmlspecialchars($usuario['login']) ?> ya autenticado.</p>
        <p>Tiempo desde el login: <?= $usuario['tiempo_trascurrido']??"[[desconocido]]" ?> segundos.</p>
    <?php else: ?>
        <H2>Usuario no autenticado, por favor, inicie sesión:</H2>
        <form action="login.php" method="POST">
            <div>
                <label for="login">Usuario</label>
                <input type="text" id="login" name="login">
            </div>
            <div>
                <label for="contraseña">Contraseña</label>
                <input type="password" id="contraseña" name="contraseña">
            </div>
            <button type="submit">Entrar</button>
        </form>
    <?php endif; ?>
</body>

</html>