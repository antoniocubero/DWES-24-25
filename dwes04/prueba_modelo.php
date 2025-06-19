<?php

require __DIR__.'/vendor/autoload.php';

use DWES04\Models\Libro;
use DWES04\Models\Libros;
use DWES04\Utils\Conection;

//Creamos un libro nuevo y le ponemos sus atributos con los setters
$libro = new Libro;
$libro->setAutor('Autor prueba');
$libro->setIsbn('950069122399');
$libro->setTitulo('Titulo prueba');
$libro->setAnioPublicacion(1996);
$libro->setPaginas(423);
$libro->setEjemplaresDisponibles(30);

//Lo guardamos
$resultado_guardar = $libro->guardar(Conection::conectar());
//Esto devolvera 1 si es correcto y false o -1 si ha fallado al guardar el libro
var_dump($resultado_guardar);

//Obtenemos el libro con id 11
$resultado_rescatar = Libro::rescatar(Conection::conectar(), 11);
//Esto sacara el objeto libro si lo ha podido obtener correctamente, o tendra false o -1 si ha fallado al obtener el libro
var_dump($resultado_rescatar);

//Lo borramos y despues no deberia salir
$resultado_borrar = Libro::borrar(Conection::conectar(),11);
//Esto imprimira 1 si se ha borrado correctamente o false o -1 si no se ha podido borrar el libro de la base de datos
var_dump($resultado_borrar);

$libros = Libros::listarACM(Conection::conectar(), true);
//var_dump($libros);
foreach ($libros as $l) {
    echo 'Lista de libros:<br>';
    echo 'ID: '.$l->getId().'; Titulo: '.$l->getTitulo().'; Autor: '.$l->getAutor().'; ISBN: '.$l->getIsbn().'; Año de publicación: '.$l->getAnioPublicacion().'; Paginas: '.$l->getPaginas().'; Ejemplares disponibles: '.$l->getEjemplaresDisponibles().'; Fecha de creacion: '.$l->getFechaCreacion().'; Fecha de actualizacion: '.$l->getFechaActualizacion()."<br>";
}