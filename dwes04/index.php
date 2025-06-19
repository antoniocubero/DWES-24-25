<?php

require __DIR__.'/vendor/autoload.php';

use DWES04\Models\Libro;
use DWES04\Models\Libros;
use DWES04\Utils\Conection;
use DWES04\Controllers\ControladorACM;
use DWES04\Peticion;

/* Creamos la peticion */
$peticion = new Peticion();

/* Creamos el objeto smarty y le asignamos las carpetas */
$smarty = new Smarty();
$smarty->template_dir=__DIR__ . '/smarty/templates/';
$smarty->compile_dir=__DIR__ . '/smarty/templates_c/';
$smarty->cache_dir=__DIR__ . '/smarty/cache/';


/* Creamos la conexion */
$conn = Conection::conectar();

/* Obtenemos la peticion */
$accion = $_GET['accion'] ?? '';

/* Dependiendo de lo que obtengamos en la peticion ejecutamos un ontrolador u otro */
switch ($accion) {
    case 'nuevo_libro_form_ACM':
        ControladorACM::controladorFormularioLibro($smarty);
        break;

    case 'crear_libro_ACM':
        ControladorACM::controladorLibroNuevo($smarty, $conn, $peticion);
        break;
    
    case 'borrar_libro_ACM':
        ControladorACM::controladorBorrarLibro($smarty, $conn, $peticion);
        break;

    default:
        ControladorACM::controladorDefecto($smarty, $conn, $peticion);
        break;
}