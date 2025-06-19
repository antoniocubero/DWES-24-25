<?php

require_once __DIR__ . '/../etc/config.php';
define('SAVED_IN_SESSION',100);
define('UPDATED_IN_SESSION',200);
define('ERROR_IN_FORM',400);

$resultadoOperacion=require __DIR__.'/tarea/procesarDatosFormMascota.php';

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
<h2>
    Resultado de la acción: <em>
    <?= match($resultadoOperacion) {
        SAVED_IN_SESSION => 'La mascota se ha guardado en la sesión.',
        UPDATED_IN_SESSION => 'La mascota se ha actualizado en la sesión.',
        ERROR_IN_FORM => 'Errores en el formulario: no se ha podido guardar la mascota en la sesión.',
        default => 'Errores: valor retornado no esperado, implementación incorrecta de /tarea/procesarDatosFormMascota.php.'
    } ?>
    </em>
</h2>

<?php include __DIR__.'/../codeparts/msgs.php'; ?>

<a href="formnuevamascota.php">Vuelve al formulario!</a>
</body>
</html>

