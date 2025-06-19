<?php
require_once __DIR__ . '/../etc/config.php';
$mascota = require_once __DIR__ . '/tarea/recuperarMascotaAlmacenadaSesion.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../codeparts/estilo.css">

    <title>Formulario de Nueva Mascota</title>    
</head>

<body>
<?php readfile(__DIR__.'/../codeparts/nav.html');?>

    <h1>Formulario de Nueva Mascota</h1>
<H2>
<?php
    $nombre = '';
    $tipo = '';
    $publica = '';
  
    if (isset($mascota) && is_array($mascota)) {
        if (!empty($mascota)) {
            if (array_key_exists('nombre', $mascota) && array_key_exists('tipo', $mascota) && array_key_exists('publica', $mascota)) {
                $nombre = $mascota['nombre'];
                $tipo = $mascota['tipo'];
                $publica = $mascota['publica'];
                echo "Mostrando datos ya almacenados en la sesión";
            } else {
                echo "ERROR IMPLEMENTACIÓN: Archivo ejercicio2/tarea/recuperarMascotaAlmacenadaSesion.php no implementado correctamente: faltan claves necesarias ('nombre', 'tipo' o 'publica') en los datos de la mascota.";
            }
        } else {
            echo "No hay datos almacenados en la sesión";
        }
    } else {
        echo "ERROR IMPLEMENTACIÓN: Archivo ejercicio2/tarea/recuperarMascotaAlmacenadaSesion.php no implementado correctamente, debe retornar array vacío o array con datos de mascotas";
    }
    ?>
</H2>
    <form action="nuevamascotasesion.php" method="POST">

        <label for="nombre">Nombre de la mascota:</label>
        <input type="text" id="nombre" name="nombre" value="<?= $nombre ?>">
        <br><br>

        <label for="tipo">Tipo de mascota:</label>
        <select id="tipo" name="tipo">
            <?php foreach (TIPOS_DE_MASCOTAS as $tipoMascota): ?>
                <option value="<?= htmlspecialchars($tipoMascota) ?>" <?= $tipo == $tipoMascota ? 'selected' : '' ?>>
                    <?= htmlspecialchars($tipoMascota) ?>
                </option>
            <?php endforeach; ?>
            <option value="ERR">VALOR NO VALIDO</option>
        </select>
        <br><br>

        <label>¿Publicar información de la mascota?</label><br>
        <input type="radio" id="publica_si" name="publica" value="si" <?= $publica == 'si' ? 'checked' : '' ?>>
        <label for="publica_si">Sí</label><br>
        <input type="radio" id="publica_no" name="publica" value="no" <?= $publica == 'no' ? 'checked' : '' ?>>
        <label for="publica_no">No</label><br>
        <input type="radio" id="publica_err" name="publica" value="err">
        <label for="publica_err">VALOR NO VALIDO</label><br><br>
        <button type="submit">Guardar Mascota</button>
    </form>
</body>

</html>