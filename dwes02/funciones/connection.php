<?php

function connection(){
    //Creacion del DSN
    define("DSN", "mysql:host=" . HOST . ";dbname=" . DB);

    try {//Lo metemos en un try-catch para que no se pare el script si falla la conexion
        $conn = new PDO(DSN,USERNAME,PASS);//Creamos el objeto PDO
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);//Le ponemos los atributos
        return $conn;//Devolvemos la conexion
    } catch (PDOException $e) {
        echo "Error: $e";
        return false;//Devolvemos false si falla la conexion
    }
}

