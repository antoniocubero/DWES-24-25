<?php

namespace DWES04\Models;

use DWES04\Models\IGuardableACM;
use DWES04\Conection as Conection;
use \PDO;

/**
 * Clase para la gestion de Libros de la base de datos.
 *
 * Permite añadir, obtener o eliminar libros de la base de datos
 *
 * @author Antonio Cubero Martinez
 */
class Libro implements IGuardableACM{
    /*------------------------Atributos------------------------*/
    private $id = null;
    private $isbn = null;
    private $titulo = null;
    private $autor = null;
    private $anio_publicacion = null;
    private $paginas = null;
    private $ejemplares_disponibles = null;
    private $fecha_creacion = null;
    private $fecha_actualizacion = null;


    /*------------------------Setters y Getters------------------------*/
    /* ----------ID---------- */
    /**
     * Devuelve la ID del libro
     * @return int
     */
    public function getId(){
        return $this->id;
    }

    /* ----------Fecha creacion---------- */
    /**
     * Devuelve la fecha de creacion del libro en la base de datos
     * @return string
     */
    public function getFechaCreacion(){
        return $this->fecha_creacion;
    }

    /* ----------Fecha actualizacion---------- */
    /**
     * Devuelve la fecha en la que se ha actualizado el libro en la base de datos
     * @return string
     */
    public function getFechaActualizacion(){
        return $this->fecha_actualizacion;
    }

    /* ----------ISBN---------- */
    /**
     * Devuelve la el ISBN del libro
     * @return string
     */
    public function getIsbn(){
        return $this->isbn;
    }

    /**
     * Establece el ISBN del libro
     * 
     * @param string $isbn El isbn del libro
     */
    public function setIsbn(string $isbn){
        $this->isbn = $isbn;
    }

    /* ----------Titulo---------- */
    /**
     * Devuelve la el titulo del libro
     * @return string
     */
    public function getTitulo(){
        return $this->titulo;
    }

    /**
     * Establece el titulo del libro
     * 
     * @param string $titulo El titulo del libro
     */
    public function setTitulo(string $titulo){
        $this->titulo = $titulo;
    }

    /* ----------Autor---------- */
    /**
     * Devuelve la el autor del libro
     * @return string
     */
    public function getAutor(){
        return $this->autor;
    }

    /**
     * Establece el autor del libro
     * 
     * @param string $autor El autor del libro
     */
    public function setAutor(string $autor){
        $this->autor = $autor;
    }

    /* ----------Año de publicacion---------- */
    /**
     * Devuelve la el año de publicacion del libro
     * @return int
     */
    public function getAnioPublicacion(){
        return $this->anio_publicacion;
    }

    /**
     * Establece el año de publicacion del libro
     * 
     * @param int $anio El año de publicacion del libro
     */
    public function setAnioPublicacion(string $anio){
        $this->anio_publicacion = $anio;
    }

    /* ----------Paginas---------- */
    /**
     * Devuelve el numero de paginas del libro
     * @return int
     */
    public function getPaginas(){
        return $this->paginas;
    }

    /**
     * Establece el numero de paginas del libro
     * 
     * @param int $paginas Las paginas que tiene el libro
     */
    public function setPaginas(string $paginas){
        $this->paginas = $paginas;
    }

    /* ----------Ejemplares disponibles---------- */
    /**
     * Devuelve el numero de ejemplares disponibles del libro
     * @return int
     */
    public function getEjemplaresDisponibles(){
        return $this->ejemplares_disponibles;
    }

    /**
     * Establece el numero de ejemplares disponibles del libro
     * 
     * @param int $ejemplares Los ejemplares disponibles que hay del libro
     */
    public function setEjemplaresDisponibles(string $ejemplares){
        $this->ejemplares_disponibles = $ejemplares;
    }

    /*------------------------Metodos------------------------*/
    /**
    * Guarda el libro en la base de datos.
    *
    * @param PDO $conn Conexion a la base de datos.
    * @return int Cantidad de entradas añadidas a la base de datos
    * @return bool False si no se añadio el libro a la base de datos
    * @return int -1 si ocurrio un error con la conexion
    */
    public function guardar(PDO $conn){
        try {
            $stmt = $conn->prepare('INSERT INTO libros (isbn, titulo, autor, anio_publicacion, paginas, ejemplares_disponibles) VALUES (:isbn, :titulo, :autor, :anio_publicacion, :paginas, :ejemplares_disponibles)');

            $isbn = $this->getIsbn();
            $titulo = $this->getTitulo();
            $autor = $this->getAutor();
            $anio_publicacion = $this->getAnioPublicacion();
            $paginas = $this->getPaginas();
            $ejemplares_disponibles = $this->getEjemplaresDisponibles();

            $stmt->bindParam(':isbn', $isbn);
            $stmt->bindParam(':titulo', $titulo);
            $stmt->bindParam(':autor', $autor);
            $stmt->bindParam(':anio_publicacion', $anio_publicacion);
            $stmt->bindParam(':paginas', $paginas);
            $stmt->bindParam(':ejemplares_disponibles', $ejemplares_disponibles);

            $stmt->execute();
            $filas = $stmt->rowCount();
            if ($filas>0) {
                $id_obtenido = $conn->lastInsertId();
                
                $stmt2 = $conn->prepare('SELECT id, fecha_creacion, fecha_actualizacion FROM libros WHERE id = :id');
                $stmt2->bindParam(':id', $id_obtenido);
                $stmt2->execute();
                $resultado = $stmt2->fetch(PDO::FETCH_ASSOC);

                $this->id = $resultado['id'];
                $this->fecha_creacion = $resultado['fecha_creacion'];
                $this->fecha_actualizacion = $resultado['fecha_actualizacion'];

                return $filas;
            }else{
                return false;
            }
        } catch (\PDOException $e) {
            return -1;
        }
    }

    /**
    * Devuelve un objeto Libro con el ID indicado.
    *
    * @param PDO $conn Conexion a la base de datos.
    * @param int $id ID del libro a devolver
    * @return Libro Libro si la operación fue exitosa.
    * @return bool False si no encontro el libro en la base de datos
    * @return int -1 si ocurrio un error con la conexion
    */
    public static function rescatar(PDO $conn, int $id){
        try {
            $stmt = $conn->prepare('SELECT * FROM libros WHERE id = :id');
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($resultado) {
                $libro = new Libro;
                $libro->id=$resultado['id'];
                $libro->fecha_creacion = $resultado['fecha_creacion'];
                $libro->fecha_actualizacion = $resultado['fecha_actualizacion'];
                $libro->setAutor($resultado['autor']);
                $libro->setIsbn($resultado['isbn']);
                $libro->setTitulo($resultado['titulo']);
                $libro->setAnioPublicacion($resultado['anio_publicacion']);
                $libro->setPaginas($resultado['paginas']);
                $libro->setEjemplaresDisponibles($resultado['ejemplares_disponibles']);

                return $libro;
            } else {
                return false;
            }
        } catch (\PDOException $e) {
            return -1;
        }
    }


    /**
    * Elimina un Libro con el ID indicado de la base de datos.
    *
    * @param PDO $conn Conexion a la base de datos.
    * @param int $id ID del libro a eliminar.
    * @return int Cantidad de entradas eliminiadas de la base de datos.
    * @return bool False si no encontro el libro en la base de datos.
    * @return int -1 si ocurrio un error con la conexion.
    */
    public static function borrar(PDO $conn, int $id){
        try {
            $stmt = $conn->prepare('DELETE FROM libros WHERE id = :id');
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            if ($stmt->rowCount()>0) {
                return $stmt->rowCount()>0;
            } else {
                return false;
            }
        } catch (\PDOException $e) {
            return -1;
        }
    }
}
