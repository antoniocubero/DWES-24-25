<?php

/*
Autenticamos al usuario si no esta ya previamente autenticado:

Deberá retornarse:
- LOGOUT_OK (100): Se ha cerrado la sesión de usuario (borrando solo los datos del usuario y respetando otros)
- LOGOUT_ERR (200): No se ha podido autenticar al usuario (usuario no está en la sesión)
Nota:
- Las constantes ya están creadas en el script "logout.php"
- No debe usarse "echo" ni "print" en este script.
- Añade a $errors[] cualquier texto que quieras mostrar como error (se mostrará a través de msgs.php)
- Añade a $notifs[] cualquier mensaje a mostrar al usuario (se mostrará a través de msgs.php)
MUY IMPORTANTE:
- Será un error grave borrar toda la información de la sesión de forma indiscriminada.
*/

session_start();

//Comprobamos que existe la variable usuario en la sesion
if (isset($_SESSION['usuario'])) {
    //Si existe la borramos con unset, solo esa variable
    unset($_SESSION['usuario']);
    //Creamos la notificacion de que se ha cerrado correctamente y devolvemos LOGOUT_OK
    $notifs[]='Sesion cerrada correctamente';
    return LOGOUT_OK;
}else{
    //Si no hay ninguna sesion iniciada o ocurre algun error creariamos el error y devolveriamos LOGOUT_ERR
    $errors[]='No es posible cerrar sesion';
    return LOGOUT_ERR;
}