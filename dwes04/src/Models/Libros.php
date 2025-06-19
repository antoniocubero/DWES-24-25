<?php

namespace DWES04\Models;

use DWES04\Models\Libro;
use \PDO;

/**
 * Clase que añade la funcionabilidad de obtener los libros almacenados en la base de datos como un array de objetos Libro
 *
 * @author Antonio Cubero Martinez
 */
final class Libros{

    /**
    * Devuelve un array de objetos Libro de los libros guardados en la base de datos.
    *
    * @param PDO $conn Conexion a la base de datos.
    * @param bool $bool Si es true devuelve la lista ordenada por fecha de creacion, si es false la devuelve ordenada por fecha de actualizacion.
    * @return array Array de Objetos Libro si la operación fue exitosa.
    * @return bool False si no encontro libros en la base de datos
    * @return int -1 si ocurrio un error con la conexion
    */
    public static function listarACM(PDO $conn, bool $bool=false){
        try {
            if ($bool) {//Preparamos la query segun sea true o false
                $stmt = $conn->prepare('SELECT * FROM libros ORDER BY fecha_creacion desc');
            }else{
                $stmt = $conn->prepare('SELECT * FROM libros ORDER BY fecha_actualizacion desc');
            }
            $stmt->execute();
            if ($stmt->rowCount()>0) {
                $libros=[];
                $ids = $stmt->fetchAll();
                foreach ($ids as $v) {
                    $libros[]=Libro::rescatar($conn, $v['id']);
                }
                return $libros;
            }else{
                return false;
            }
        } catch (PDOException $e) {
            return -1;
        }
    }
}
