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
    <title>Zona autenticada</title>
</head>

<body>
    <?php readfile(__DIR__ . '/../codeparts/nav.html'); ?>
    <h1>Zona autenticada</h1>
    <?php include __DIR__ . '/../codeparts/msgs.php'; ?>
    <?php if (!empty($usuario) && isset($usuario['id_usuario'])): ?>
        <H2>Usuario autenticado. Mostrando información privada del usuario.</H2>

        <?php         
        require_once __DIR__.'/../funciones/funciones.php';
        require_once __DIR__.'/../funciones/dbconn.php';

        $con=conectar();

        $mascotas=obtenerMascotasDeUsuario($con,$usuario['id_usuario']);

        ?>

        <H3>LISTADO DE MASCOTAS</H3>
        <?php if ($mascotas === -1): ?>
            <p>No se encontraron mascotas para el usuario.</p>
        <?php elseif ($mascotas === -2): ?>
            <p>Error al consultar la base de datos.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Mascota</th>
                        <th>Tipo</th>
                        <th>Pública</th>
                        <th>Propietario</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($mascotas as $mascota): ?>
                        <tr>
                            <td><?= htmlspecialchars($mascota['mascota_nombre']) ?></td>
                            <td><?= htmlspecialchars($mascota['mascota_tipo']) ?></td>
                            <td><?= htmlspecialchars($mascota['mascota_publica']) ?></td>
                            <td><?= htmlspecialchars($mascota['propietario_login']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>


    <?php else: ?>
        <H2>El usuario no se ha autenticado. Vuelva al formulario de login.</H2>
        <a href="formlogin.php">Ir al formulario de login</a>
    <?php endif; ?>
</body>

</html>