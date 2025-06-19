<?php

//Creamos la funcion como se indica
function insertdb($conn, $datos){
    //Metemos la query dentro de un try-catch para impedir que el codigo se pare de ejecutar si fallase algo
    try {
        //Creamos la query directamente
        $stmt = $conn->prepare('INSERT INTO productos (nombre, codigo_ean, categoria, propiedades, unidades, precio) VALUES (:name, :ean, :cat, :prop, :unit, :price)');
        //Unimos los parametros con las variables correspondientes y ejecutamos la query
        $stmt->execute([
            ':name'=>$datos['name'],
            ':ean'=>$datos['ean'],
            ':cat'=>$datos['cat'],
            ':prop'=>$datos['prop'],
            ':unit'=>$datos['unit'],
            ':price'=>$datos['price']
        ]);
        if ($stmt->rowCount()<=0) {//Comprobamos si no se han insertado filas con rowCount y devolvemos false si no se han insertado filas
            return false;
        }else{
            //En el caso contrario devolveriamos la id del ultimo producto insertado con lastInsertId()
            return $conn->lastInsertId();
        }
    } catch (PDOException $e) {
        //Si ocurriese algun error durante la ejecucion de la query devolveriamos false
        return false;
    }
}