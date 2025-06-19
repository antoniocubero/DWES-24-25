<?php

/*
Implementar aquí la función que realiza la autenticación de usuario (solo debe haber una función).
La función debe:
- Recibir por parámetro la conexión a la base de datos (no debe crearse una nueva conexión en su interior)
- Recibir por parámetro el nombre de usuario
- Recibir por parámetro la contraseña
- Retornar el id de usuario (entero  mayor de cero) en caso de autenticación correcta. 
- En caso de autenticación no correcta, retornar un valor que permita saber que ha ocurrido.
IMPORTANTISIMO: Bajo ningún concepto debe usarse en el interior de la función $_POST, ni $_SESSION.
*/

/**
 * Funcion para hacer login en la base de datos
 * 
 * @param PDO $conn Conexion a la base de datos
 * @param string $nombre Nombre del usuario
 * @param string $pass Contraseña del usuario
 * 
 * @return int Id del usuario
 * @return int -1 Si no se encontro el usuario
 * @return bool False si hubo un error con la conexion
 */
function login($conn, $nombre, $pass){
    //Creamos la query para la conexion a la base de datos que nos devolvera el id del usuario si lo encuentra
    $query = "SELECT id FROM usuarios WHERE login=:nombre AND hash_contraseña=:pass";
    //Preparamos un bloque try-catch para la conexion
    try {
        //Preparamos la query
        $resultado = $conn->prepare($query);

        //Unimos los parametros a los valores dentro de la query
        $resultado->bindValue(':nombre', $nombre);
        //Para la pass hacemos los mismos cambios que se le hicieron en la base de datos, usamos hash con el sha256, y creamos un string que contiene la contraseña al reves con strrev, le añadimos la palabra TEST y le añadimos el Salteado establecido en config
        $resultado->bindValue(':pass', hash('sha256', strrev($pass).'TEST'.SALTEADO));

        //Ejecutamos la consulta y comprobamos que se ha hecho
        if($resultado->execute()){
            //Si se ha hecho comprobamos con rowCount cuantas filas se han obtenido, y al ser un usuario unico deberia ser 1
            if($resultado->rowCount()==1){
                //Si devuelve un usuario volcamos los resultados en una variable y devolvemos el id devuelto
                $usuario = $resultado->fetch(PDO::FETCH_ASSOC);
                return $usuario['id'];
            }else{
                //Si el rowCount diese un numero distino de 1 significaria que la consulta no ha encontrado el usuario y devolveriamos -1
                return -1;
            }
        };
    //Si hubiese un error en la conexion, lo atrapariamos en el catch y devolveriamos false
    } catch (PDOException $e) {
        return false;
    }
}