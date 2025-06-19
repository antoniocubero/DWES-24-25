<?php

//creamos la funcion como se indica en la tarea
function modifydb($conn, $id, $units){
    //ejecutamos la query dentro de un try-catch
    try {
        //Creamos la query directamnte
        $stmt = $conn->prepare('UPDATE productos SET unidades = unidades + :unidades WHERE id = :id');
        $stmt->execute([':unidades'=>$units, ':id'=>$id]);//Ejecutamos la query asignando los parametros a traves del execute directamente, sin usar bindParam
        $rows = $stmt->rowCount();//Contamos las filas que se han modificado
        if ($rows>0) {//Si las filas son 1 o mas significa que se ha modificado correctamente
            return true;
        }else{
            //Si $rows es 0, significa que el id no ha sido encontrado y por lo tanto ninguna fila se ha modificado, y devolvemos -1
            return -1;
        }
    } catch (PDOException $e) {//Si la modificacion diese como resultado un numero menor o igual a 0, saltaria un error por el CHECK que se hizo al crear la base de datos, por lo que capturariamos ese error y devolveriamos false
        return false;
    }
}