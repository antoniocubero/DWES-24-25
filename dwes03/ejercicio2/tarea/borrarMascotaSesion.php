<?php

/*
Deberá retornarse:
 - DELETED_FROM_SESSION (100): Si los datos de la mascota fueron eliminados exitosamente de la sesión.
 - NOT_IN_SESSION (200): Si no hay datos de la mascota almacenados en la sesión.
Nota:
 - Las constantes ya están creadas en el script "borrarmascota.php"
 - No debe usarse "echo" ni "print" en este script.
 - Añade a $errors[] cualquier texto que quieras mostrar como error (se mostrará a través de msgs.php)
 - Añade a $notifs[] cualquier mensaje a mostrar al usuario (se mostrará a través de msgs.php)
*/

//Iniciamos la sesion
session_start();

//Comprobamos que existe la variable mascota
if (isset($_SESSION['mascota'])) {
    //la borramos con unset si existe
    unset($_SESSION['mascota']);
    return DELETED_FROM_SESSION;//Devolvemos los valores especificados
}else{
    return NOT_IN_SESSION;//Devolvemos NOT_IN_SESSION si no existe la variable
}
