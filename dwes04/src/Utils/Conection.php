<?php 

namespace DWES04\Utils;

use DWES04\Utils\Config;
use \PDO;

/* He creado una clase para gestionar la conexion a la base de datos como en el ejemplo que viene en el tema */
class Conection{
    private static $conn = null;//Declaramos la conexion como null
    public static function conectar(){//Con este metodo obtenemos la conexion, si no existiese la crearisamos y la devolveriamos
        $host = Config::HOST;
        $dbname = Config::DB;
        $dbuser = Config::USERNAME;
        $dbpass = Config::PASS;
        if (is_null(Conection::$conn)) {
            Conection::$conn=new PDO("mysql:host={$host};dbname={$dbname}",$dbuser,$dbpass);
            Conection::$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        }
        return Conection::$conn;
    }
}
