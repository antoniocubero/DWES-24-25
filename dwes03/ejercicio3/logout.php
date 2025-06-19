<?php

require_once __DIR__.'/../etc/config.php';
require_once __DIR__.'/../funciones/funciones.php';
require_once __DIR__.'/../funciones/dbconn.php';
require_once __DIR__.'/tarea/funcionlogin.php';

define ('LOGOUT_OK',100);
define ('LOGOUT_ERR',200);

$resultadoLogout=require __DIR__.'/tarea/procesarlogout.php';
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
Resultado del logout: <em>
<?=match ($resultadoLogout) {
    LOGOUT_OK => "Se ha cerrado sesión de usuario correctamente.",    
    LOGOUT_ERR => "No hay usuario autenticado, no se ha podido cerrar sesión de usuario.",    
    default => "Estado desconocido, ¿has implementado /tarea/procesarlogout.php?"
};?>
</em>
</H2>
<?php include __DIR__.'/../codeparts/msgs.php'; ?>

</body>
</html>