<?php

/*
Autenticamos al usuario si no esta ya previamente autenticado:

Deberá retornarse:
- LOGIN_OK (100): El usuario se ha autenticado correctgamente y se guarda id y login en la sesión.
- LOGIN_PREV (150): El usuario ya está autenticado (ya ha información en la sesión del usuario)
- LOGIN_ERR (200): No se ha podido autenticar al usuario (usuario y/o contraseña incorrectos)
- LOGIN_FAIL_DB (400): Ha fallado la conexión a la base de datos o se ha producido cualquier otra excepción.
Nota:
- Las constantes ya están creadas en el script "login.php"
- No debe usarse "echo" ni "print" en este script.
- Añade a $errors[] cualquier texto que quieras mostrar como error (se mostrará a través de msgs.php)
- Añade a $notifs[] cualquier mensaje a mostrar al usuario (se mostrará a través de msgs.php)
MUY IMPORTANTE:
- Debes usar la función que has implementado en funcionlogin.php de forma adecuada.
- Será un error EXTREMADAMENTE grave guardar la contraseña de usuario en la sesión.
- Será un error MUY grave guardar el login de usuario en la sesión antes de haberlo autenticado.
- Será un error grave autenticar al usuario cuando su información ya está en la sesión.
*/

session_start();

//Comprobamos si existe el usuario y si existe devolvemos LOGIN_PREV
if (isset($_SESSION['usuario'])) {
    return LOGIN_PREV;
}


//Filtramos los input pero a contraseña no le aplicamos el filtro de FILTER_SANITIZE_FULL_SPECIAL_CHARS para que no borre caracteres que podria tener la contraseña
$login = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$pass = filter_input(INPUT_POST, 'contraseña');

//Comrpobamos que no esten vacios y que sean tipo string
if ( $login=='' || $pass=='' || !is_string($login) || !is_string($pass)) {
    //Si no lo son creamos un error y devolvemos LOGIN_ERR
    $errors[]='Debes introducir un nombre de usuario y una contraseña';
    return LOGIN_ERR;
}else{
    //Si son correctos creamos una conexion a la base de datos
    $conn = conectar();
    
    //Usamos la funcion creada antes
    $id = login($conn, $login, $pass);

    //Comprobamos que $id sea mayor que 0 ya que los usuarios tienen un id que es un numero positivo
    if($id>0) {
        //Creamos las variables en usuario como un array asociativo
        $_SESSION['usuario']['id_usuario']=$id; 
        $_SESSION['usuario']['login']=$login;
        //lo notificamos con notifcs y devolvemos LOGIN_OK para que se sepa que el login fue correcto
        $notifs[]='Login realizado correctamente';
        return LOGIN_OK;
    }elseif ($id==-1) {//Si el $id es igual a -1 significa que no ha encontrado ningun usuario con esos datos por lo que no existe
        //Cremaos el error de que los datos no son correctos y devolvemos LOGIN_ERR
        $errors[]='Usuario o contraseña incorrectos';
        return LOGIN_ERR;
    }else {//Por ultimo si ocurre otro error devuelve false pero es el otro tipo de dato que puede devolver por lo que creamos el error y devolvemos LOGIN_FAIL_DB
        $errors[]='Ha ocurrido un error en la base de datos';
        return LOGIN_FAIL_DB;
    }
}

