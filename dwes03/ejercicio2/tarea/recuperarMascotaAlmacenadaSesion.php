<?php
/*
Deberá retornarse:
- Array vacío si no hay datos en la sesión.
- Array con datos de la mascota si ya está almacenada en la sesión. Fíjate en el script "formnuevamascota.php" y verás que el formato de array esperado es:
        $mascota['nombre']=...
        $mascota['tipo']=...
        $mascota['publica']=...
IMPORTANTE:
 - No debe usarse echo ni print ni nada similar en este script.
 - Añade a $errors[] cualquier texto que quieras mostrar como error (se mostrará a través de msgs.php)
 - Añade a $notifs[] cualquier mensaje a mostrar al usuario (se mostrará a través de msgs.php)
 */

session_start();

//Comprobamos que existe la variable mascota en la sesion
if (isset($_SESSION['mascota'])) {
        //Si existe devolvemos esa variable
        return $_SESSION['mascota'];
}else{
        //Si no existe devolvemos un array vacio
        return [];
}