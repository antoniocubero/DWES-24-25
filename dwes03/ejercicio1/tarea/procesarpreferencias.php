<?php
/*
 En este script tienes que realizar el ejercicio 1.

 - Si se recibe el dato POST de restablecer preferencias, borra las cookies (tiempo negativo) 
   y retorna todos los tipos de mascotas.
 - Si se reciben datos POST, recoge dichos datos, analiza si son correctos  y si son correctos: envía 
   las cookies y retorna los tipos de mascotas seleccionados. La duración máxima de la cookie: 10 minutos.
 - Si no se reciben datos POST, se analizan las cookies, y si son correctas se retornan los tipos de 
   mascotas almacenados en la cookie.
 - Si no se recibe ni datos POST ni COOKIES, se retornan todos los tipos de mascotas (valor por defecto)
 
 IMPORTANTE:

 - Recuerda que todos los tipos de mascotas están almacenados en la constante TIPOS_DE_MASCOTAS
 - No debe usarse echo ni print ni nada similar en este script.
 - Añade a $errors[] cualquier texto que quieras mostrar como error (se mostrará a través de msgs.php, 
    incluido en listarmascotas.php)
 - Añade a $notifs[] cualquier mensaje a mostrar al usuario (se mostrará a través de msgs.php, incluido
    en listarmascotas.php)
 */

 //Comprobamos que se ha enviado restablecer y que tiene un valor correcto
if (isset($_POST['restablecer']) && $_POST['restablecer']==='restablecer') {
  //Hacemos un foreach y para cada cookie le damos un valor negativo al tiempo, asi se borran
  foreach ($_COOKIE as $key => $value) {
    setcookie($key,$value,time()-10000);
  }
  //Devolvemos todas las mascotas
  return TIPOS_DE_MASCOTAS;
}

//Comprobamos que $_POST['tipos'] esta relleno y que es un array
if (isset($_POST['tipos']) && is_array($_POST['tipos'])) {
  //Comprobamos que contiene valores correctos
  if (empty(array_diff($_POST['tipos'], TIPOS_DE_MASCOTAS))) {
    //Creamos la cookie con los datos serializados
    setcookie('tipo_mascotas_ACM', serialize($_POST['tipos']), time()+600);
    //Creamos la cookie de verificacion con hash y SALTEADO, y le ponemos que tenga unos 10 min de caducidad con time()+600, 600seg son 10 minutos
    setcookie('hash_tipo_mascotas_ACM', hash('sha256',serialize($_POST['tipos']).SALTEADO), time()+600);
    //Devolvemos los tipos de animales que se han enviado
    return $_POST['tipos'];
  }else{
    //Si los valores no fuesen validas lo indicariamos con $errors
    $errors[]='Tipos de mascotas no validas';
  }
}

//Comprobamos que existen las cookies
if(isset($_COOKIE['tipo_mascotas_ACM']) && isset($_COOKIE['hash_tipo_mascotas_ACM'])){
  //Comprobamos que no se han modificado haciendole hash con la misma configuracion a la cookie sin codificar
  if(hash('sha256',serialize($_COOKIE['tipo_mascotas_ACM']).SALTEADO)===$_COOKIE['hash_tipo_mascotas_ACM']) {
    //Si cumple el if deserializamos la cookie
    $mascotas=unserialize($_COOKIE['tipo_mascotas_ACM']);

    //Comprobamos que es array y que contiene valores validos
    if (is_array($mascotas) && empty(array_diff($mascotas, TIPOS_DE_MASCOTAS))) {
      //Devolvemos las mascotas que tiene la cookie
      return $mascotas;
    }else{
      //Si no fuese array o contuviese otros valores significaria que se ha modificado asi que lo sacamos por errores
      $errors[]='Cookies modificadas';
    }
  }else{
    //Si la cookie con el hash no coincidiese con la cookie de verificacion significaria que la han modificado tambien
    $errors[]='Cookies modificadas';
  }
}

//Devolvemos todas las mascotas si no hay ni cookies ni datos en post
return TIPOS_DE_MASCOTAS;
