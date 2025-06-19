<?php

function getProducts($conn, $cat=null){//Ponemos un parametro cat tipo null por si no fuese establecido el parametro categoria
    //Comprobamos que la conexion ha sido creada
    if ($conn) {
        try {
            $query = "SELECT * FROM productos WHERE categoria = :cat OR :cat IS NULL"; //Creamos la query
            $stmt = $conn->prepare($query);//Preparamos la query
            $stmt->bindParam(':cat', $cat);//Unimos los parametros
            $stmt->execute();//Ejecutamos la query, aqui se puede añadir [':cat'=>$cat] y no escribir la linea de arriba el bindParam BORRAR --------------
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);//uso FETCH_ASSOC para que cree un array asociativo
            return $results;//Devolvemos los resultados del SELECT
        } catch (PDOException $e) {
            // Handle exception
            return false;//Devolvemos false si ocurre algun fallo con la query
        }
    }else{
        //Si la conexion no se ha creado bien lo mostramos por pantalla
        echo 'La conexion no es valida';
    }
}