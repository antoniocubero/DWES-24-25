<?php 

//He creado una clase para manejar la conexion a la base de datos
class Conection{
    private static $conn = null;//Declaramos la conexion como null
    public static function conectar(){//Con este metodo obtenemos la conexion, si no existiese la creariamos y la devolveriamos
        $dbdsn = DB_DSN;
        $dbuser = DB_USER;
        $dbpass = DB_PASSWD;
        if (is_null(Conection::$conn)) {
            Conection::$conn=new PDO($dbdsn,$dbuser,$dbpass);
            Conection::$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        }
        return Conection::$conn;
    }
}
