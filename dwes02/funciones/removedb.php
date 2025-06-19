<?php

function removedb($conn, $id){//Creamos la funcion con los dos parametros
    //Ejecutamos el bloque dentro de un try-catch
    try {
        $stmt = $conn->prepare('DELETE FROM productos WHERE id = :id');//Aqui me salto el paso de guardar la query dentro de una variable y la creo dentro de prepare
        $stmt->bindParam(':id', $id);//Enlazamos el parametro id con la variable $id
        $stmt->execute();//Ejecutamos la query
        $rows = $stmt->rowCount();//Contamos las filas que han sido afectadas por la query
        if ($rows>0) {//Comprobamos que hay filas afectadas y devolvemos true si es asi
            return true;
        }else{
            //Devolvemos false si no se han modificado filas
            return false;
        }
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}