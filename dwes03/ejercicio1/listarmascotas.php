<?php

require_once __DIR__.'/../etc/config.php';
require_once __DIR__.'/../funciones/funciones.php';
require_once __DIR__.'/../funciones/dbconn.php';

//Por defecto, las mascotas preferidas son todas
$mascotaspreferidas=require __DIR__.'/tarea/procesarpreferencias.php';

$con=conectar();

$mascotas=obtenerMascotasPorTipo($con,$mascotaspreferidas);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de mascotas según preferencias</title>
    <link rel="stylesheet" href="../codeparts/estilo.css">
</head>
<body>
<?php readfile(__DIR__.'/../codeparts/nav.html');?>
<h1>Listamos las mascotas públicas según preferencias de usuario</h1>
<p>El usuario seleccionará las categorías de las mascotas a mostrar y estas 
    se almacenarán en una cookie para que, cuando vuelva a acceder,
    se muestren las que ya había seleccionado previamente.  </p>
<?php include __DIR__.'/../codeparts/msgs.php'; ?>
<br>
<form method="POST" action="listarmascotas.php">
        <B>Elige los tipos de mascotas preferidas:</B>
        <?php foreach (TIPOS_DE_MASCOTAS as $tipomascota): ?>        
            <label>
                <input type="checkbox" name="tipos[]" 
                    value="<?=htmlentities($tipomascota)?>"
                    <?=in_array($tipomascota,$mascotaspreferidas)?'checked':''?>
                    ><?=htmlentities($tipomascota)?> 
            </label>
        <?php endforeach;?>        
        <button type="submit">Seleccionar!</button>
</form>
<BR><BR>
<form method="POST" action="listarmascotas.php">
    <button type="submit" name="restablecer" value="restablecer">¡Restablecer preferencias (borrar cookies)!</button>
</form>
<BR><BR>
<a href="listarmascotas.php"> Haz clic para volver a acceder a este script sin enviar formulario </a>
<BR><BR>
<?php if (is_array($mascotas) && !empty ($mascotas)):?>

<h1>Listado de mascotas:</h1>

<table border="1">    
    <tr>        
        <th>ID de Mascota</th>
        <th>Nombre Mascota</th>
        <th>Tipo Mascota</th>        
    </tr>
    <?php foreach($mascotas as $mascota): ?>
        <tr>
    
            <td><?=$mascota['id']?></td>
            <td><?=$mascota['nombre']?></td>
            <td><?=$mascota['tipo']?></td>
        </tr>
    <?php endforeach; ?>
</table>
<?php elseif ($mascotas===-1):?>
    <h2>No hay mascotas con las preferencias seleccionadas.</h2>
<?php elseif ($mascotas===-2):?>
    <h2>Se ha producido una excepción en la base de datos.</h2>
<?php endif;?>

</body>
</html>
