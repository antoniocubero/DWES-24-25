<?php
require_once __DIR__ . '/../etc/config.php';
define('DELETED_FROM_SESSION',100);
define('NOT_IN_SESSION',200);


$resultadoOperacion=require __DIR__.'/tarea/borrarMascotaSesion.php';

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
Resultado de la acción: <B> <?=match($resultadoOperacion) {
         NOT_IN_SESSION => 'La mascota no estaba almacenada en la sesión: no se pudo borrar.',        
         DELETED_FROM_SESSION => 'La mascota se ha eliminado de la sesión.',        
        default => 'Errores: valor retornado no esperado, implementación incorrecta de /tarea/borrarMascotaSesion.php.'
    }?></B>
</H2>
<?php include __DIR__.'/../codeparts/msgs.php'; ?>

</body>
</html>

