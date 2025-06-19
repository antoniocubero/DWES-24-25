<?php
/*
Deberá retornarse:
- SAVED_IN_SESSION (100): Si los datos se pudieron guardar por primera vez en la sesión.
- UPDATED_IN_SESSION (200): Si los datos existentes en la sesión fueron actualizados.
- ERROR_IN_FORM (400): Si hay errores en el formulario y no se pudo almacenar o actualizar la mascota en la sesión.
Notas:
 - Las constantes ya están creadas en el script "nuevamascotasesion.php"
 - No debe usarse "echo" ni "print" en este script.
 - Añade a $errors[] cualquier texto que quieras mostrar como error (se mostrará a través de msgs.php)
 - Añade a $notifs[] cualquier mensaje a mostrar al usuario (se mostrará a través de msgs.php)
 
*/
session_start();

//Filtramos el input nombre que se nos pasa y le ponemos el filtro de eliminar caracteres especiales
$nombre = filter_input(INPUT_POST,'nombre', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
//Comprobamos que ha pasado bien el filtro y que no es mas grande de 50 caracteres
if (!$nombre || strlen($nombre)>50) {
    $errors[]='El nombre introducido no es válido';
}

//Usamos filter_input para comprobar el tipo de la mascota
$tipo = filter_input(INPUT_POST,'tipo', FILTER_SANITIZE_SPECIAL_CHARS);
//Comprobamos que sea uno de los valores dentro del array TIPO_DE_MASCOTAS
if (!in_array($tipo,TIPOS_DE_MASCOTAS)) {
    //Si no lo es crea un error
    $errors[]='El tipo de mascota no es válido';
}

//Filtramos el input de si es o no publica
$publica = filter_input(INPUT_POST,'publica', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
//Creamos una array con los valores validos
$publica_valores=['si','no'];
//Comprobamos que sea uno de esos valores
if (!in_array($publica,$publica_valores)){
    //Si no lo es crea un error
    $errors[]='Informacion publica de la mascota incorrecta';
}

//Comprobamos si no existen errores
if (!isset($errors)) {
    //Si no existen pasamos a comprobar si existe la variable mascota en la sesion
    if (!isset($_SESSION['mascota'])) {
        //Si no existe la creamos e informamos mediante notifs de que ha sido añadida y devolvemos SAVED_IN_SESSION
        $_SESSION['mascota']=['nombre'=>$nombre,'tipo'=>$tipo,'publica'=>$publica];
        $notifs[]='Mascota añadida correctamente';
        return SAVED_IN_SESSION;
    }else{
        //Si existe la actualizamos e informamos mediante notifs de que ha sido actualizada y devolvemos UPDATED_IN_SESSION
        $_SESSION['mascota']=['nombre'=>$nombre,'tipo'=>$tipo,'publica'=>$publica];
        $notifs[]='Mascota modificada correctamente';
        return UPDATED_IN_SESSION;
    }
}else{
    //Si existen errores devolvemos el error ERROR_IN_FORM
    return ERROR_IN_FORM;
}