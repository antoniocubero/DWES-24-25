<?php
/*

Deberá retornarse:
- Array vacío si no hay datos del usuario autenticado en la sesión.
- Array con nombre de usuario (key "login"), último acceso ("ultimo_acceso") y tiempo transcurido desde el último acceso ("tiempo_trascurrido") 
en caso de que haya información almacenada en la sesión del usuario y no haya superado el tiempo de inactividad (10 minutos)

IMPORTANTE:

Este script es responsable de controlar el tiempo de inactividad (10 minutos). La información de la sesión "ultimo_acceso"
debe incorporarse como medida para controlar el tiempo de inactividad. 
- Si la inactividad es menor de 10 minutos: se renueva el tiempo de acceso.
- Si la inactividad es mayor de 10 minutos: se elimina la información de usuario (respetando el resto de información que pudiera existir)

Nota:
- No debe usarse "echo" ni "print" en este script.
- Añade a $errors[] cualquier texto que quieras mostrar como error (se mostrará a través de msgs.php)
- Añade a $notifs[] cualquier mensaje a mostrar al usuario (se mostrará a través de msgs.php)

*/

session_start();

//Comprobamos que existe la variable usuario en la sesion
if (isset($_SESSION['usuario'])) {

    //Si no existe la variable ultimo_acceso dentro del usuario la creamos con time()
    if (!isset($_SESSION['usuario']['ultimo_acceso'])) {
        $_SESSION['usuario']['ultimo_acceso'] = time();
    }

    //Calculamos el tiempo transcurrido en segundos con time() restandole el tiempo del ultimo acceso
    $tiempo_trascurrido = time()-$_SESSION['usuario']['ultimo_acceso'];

    //Comprobamos que el tiempo transcurrido es mayor de 600 segundos que son 10 minutos
    if ($tiempo_trascurrido>600) {
        //Si es mayor a 10 minutos borramos los datos de la sesion del usuario con unset como en el proceso de logout, para solo borrar esa variable
        unset($_SESSION['usuario']);
        //Creamos el error de que ha pasado mas de 10 minutos y le indicamos que vuelva a iniciar sesion y devolvemos un array vacio
        $errors[]='El tiempo de inactividad es mas de 10 minutos, vuelva a iniciar sesion';
        return [];
    }else{
        //Si el tiempo transcurrido no es mayor a 10, volcemos a asignar el ultimo acceso con time() de nuevo
        $_SESSION['usuario']['ultimo_acceso'] = time();
        
        //Devolvemos el array con los datos que se nos van a pedir
        return [
            'id_usuario'=>intval($_SESSION['usuario']['id_usuario']),//Se que en el enunciado no lo pone pero en el archivo zonaprivada.php se pedia que tuviese otro dato en el array asociativo con el id_usuario por lo que lo he creado tambien
            'login'=>$_SESSION['usuario']['login'],
            'ultimo_acceso'=>$_SESSION['usuario']['ultimo_acceso'],
            'tiempo_trascurrido'=>$tiempo_trascurrido];
    }
}else{
    //Si no existe la variable usuario en la sesion devolvemos un array vacio
    return [];
}