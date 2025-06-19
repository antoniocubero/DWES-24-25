<?php

require_once __DIR__.'/../etc/config.php';
require_once __DIR__.'/../funciones/funciones.php';
require_once __DIR__.'/../funciones/dbconn.php';
require_once __DIR__.'/tarea/funcionlogin.php';

define ('LOGIN_OK',100);
define ('LOGIN_PREV',150);
define ('LOGIN_ERR',200);
define ('LOGIN_FAIL_DB',400);

$resultadoLogin=require __DIR__.'/tarea/procesarlogin.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado inserción</title>
    <link rel="stylesheet" href="../codeparts/estilo.css">
</head>
<body>
<?php readfile(__DIR__.'/../codeparts/nav.html');?>
<H2>
Resultado del login: <em>
<?=match ($resultadoLogin) {
    LOGIN_OK => "Usuario autenticado correctamente. Acceda a zona privada.",
    LOGIN_PREV => "El usuario ya está autenticado. Acceda a zona privada.",
    LOGIN_ERR => "Usuario o contraseña incorrectos o no se han proporcionado.",
    LOGIN_FAIL_DB => "Error en la base de datos o configuración.",
    default => "Estado desconocido, ¿has implementado /tarea/procesarlogin.php?"
};?>
</em>
</H2>
<?php include __DIR__.'/../codeparts/msgs.php'; ?>
<?php if ($resultadoLogin==LOGIN_OK || $resultadoLogin==LOGIN_PREV): ?>
    <a href="zonaprivada.php"> Ir a zona privada </a>
<?php endif; ?>
</body>
</html>