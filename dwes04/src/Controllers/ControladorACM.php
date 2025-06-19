<?php

namespace DWES04\Controllers;

use DWES04\Models\Libro;
use DWES04\Models\Libros;
use DWES04\Peticion;
use \Smarty;
use \PDO;

class ControladorACM{
    /* Controlador por defecto */
    public static function controladorDefecto(Smarty $smarty, PDO $conn, Peticion $p){
        if ($p->isPost() && $p->has('orden')) {//comprobamos que es de tipo Post y que contiene 'orden'
            if ($p->getString('orden')=='true') {//Si orden en post es true, sacamos la lista ordenada por fecha de creacion, si no lo sacamos por fecha de actualizacion
                $libros = Libros::listarACM($conn);
                $smarty->assign('libros',$libros);
                $smarty->display('listado-libros.tpl');
            }else{
                $libros = Libros::listarACM($conn);
                $smarty->assign('libros',$libros);
                $smarty->assign('error','Error, valor incorrecto');
                $smarty->display('listado-libros.tpl');
            }
        }else{//si no existe 'orden' se saca ordenada por fecha de actualizacion
            $libros = Libros::listarACM($conn, false);
            $smarty->assign('libros',$libros);
            $smarty->display('listado-libros.tpl');
        }
    }

    /* Controlador para sacar el formulario para imprimir un libro nuevo */
    public static function controladorFormularioLibro(Smarty $smarty){
        $smarty->display('form-libro-nuevo.tpl');
    }

    /* Controlador para procesar la introduccion de un libro nuevo */
    public static function controladorLibroNuevo(Smarty $smarty, PDO $conn, Peticion $p){
        $errors=[];//Creamos el array donde se guardaran los errores
        $libro = new Libro;//Creamos un libro
        if($p->isPost()){//Comprobamos que es tipo post, si no añadimos un error

            //Comprobamos que existe titulo y no esta vacio
            if ($p->has('titulo') && $p->getString('titulo')!='') {
                $libro->setTitulo($p->getString('titulo'));
            }else{
                $errors[]='Debes introducir el nombre del libro';
            }

            //Hacemos igual con el autor
            if ($p->has('autor') && $p->getString('autor')!='') {
                $libro->setAutor($p->getString('autor'));
            }else{
                $errors[]='Debes introducir el autor del libro';
            }

            //Comprobamos que existe el isbn y que tiene un tamaño de 13 caracteres
            if ($p->has('isbn') && strlen($p->getString('isbn'))==13) {
                try {//Intentamos pasarlo a un int y si salta exepcion lo guardamos en errores
                    $libro->setIsbn($p->getInt('isbn'));
                } catch (\Exception $e) {
                    $errors[]='El '.$e->getMessage();
                }
            }else{
                $errors[]='El ISBN debe ser un número de 13 digitos';
            }

            //Comprobamos que existe paginas y que no esta vacio
            if ($p->has('paginas') && $p->getString('paginas')!='') {
                try {//Intentamos pasarlo a un int y si salta exepcion lo guardamos en errores
                    $paginas = $p->getInt('paginas');
                    if ($paginas > 0) {//Comprobamos que paginas es un numero positivo si no lo guardamos en errores
                        $libro->setPaginas($paginas);
                    }else{
                        $errors[]='Las paginas deben ser un numero positivo';
                    }

                } catch (\Exception $e) {
                    $errors[]='El '.$e->getMessage();
                }
            }else{
                $errors[]='Debes introducir un numero de paginas';
            }

            //Comprobamos que existe anio y que no esta vacio
            if ($p->has('anio') && $p->getString('anio')!='') {
                try {//Intentamos pasarlo a un int y si salta exepcion lo guardamos en errores
                    $anio = $p->getInt('anio');
                    if ($anio <= date('Y')) {//Comprobamos que la fecha introducida no sea mayor al año actual si no lo guardamos en errores
                        $libro->setAnioPublicacion($anio);
                    }else{
                        $errors[]='No puedes poner un año superior a '.date('Y');
                    }

                } catch (\Exception $e) {
                    $errors[]='Las '.$e->getMessage().' positivo';
                }
            }else{
                $errors[]='Debes introducir un año de publicacion del libro';
            }

            //Comprobamos que existe ejemplares y que no esta vacio
            if ($p->has('ejemplares') && $p->getString('ejemplares')!='') {
                try {//Intentamos pasarlo a un int y si salta exepcion lo guardamos en errores
                    $ejemplares = $p->getInt('ejemplares');
                    if ($ejemplares > 0) {//Comprobamos que ejemplares es un numero positivo si no lo guardamos en errores
                        $libro->setEjemplaresDisponibles($ejemplares);
                    }else{
                        $errors[]='Los ejemplares deben ser un numero positivo';
                    }

                } catch (\Exception $e) {
                    $errors[]='Los '.$e->getMessage().' positivo';
                }
            }else{
                $errors[]='Debes introducir un numero de ejemplares del libro';
            }

        }else{
            $errors[]='Error en el tipo de peticion, debe ser tipo POST';
        }

        //Si no hay errores, guardamos el libro
        if (count($errors)==0) {
            $resultado=$libro->guardar($conn);
            if($resultado==-1){//Si guardar devuelve -1 es porque ha ocurrido un error
                $errors[]='Error al intentar insertar el libro en la base de datos';
            }elseif ($resultado == 1) {//Si devuelve 1 es porque se ha guardado correctamente, asi que sacamos la id del libro insertado y lo asignamos a un parametro de smarty
                $smarty->assign('id_insertado',$libro->getId());
            }else{//Si devuelve otra cosa es porque ha habido un error en la base de datos
                $errors[]='No se ha podido guardar el libro en la base de datos';
            }
        }

        //Asigansmo los errores a la variable errores y cargamos el tpl
        $smarty->assign('errors',$errors);
        $smarty->display('libro-insertado.tpl');
    }


    /* Controlador para borrar un libro */
    public static function controladorBorrarLibro(Smarty $smarty, PDO $conn, Peticion $p){
        if ($p->isPost()) {
            //Si tiene 'aceptar' y 'id_borrar' borra el libro, si solo tiene 'id_borrar' vuelve a sacar el formulario
            if ($p->has('aceptar', 'id_borrar') && ($p->getString('aceptar')=='1')) {
                $resultado = Libro::borrar($conn, $p->getString('id_borrar'));//Borramos el libro
                if ($resultado>0) {//Si devuelve un numero superior a 0 es que ha podido borrar el libro y sacamos el id del libro con smarty
                    $smarty->assign('borrado',true);
                    $smarty->assign('id_borrado',$p->getString('id_borrar'));
                }else{//Si no devuelve un numero superior a 0 o false entonces se manda para que saque que el libro con ese id no existe en la base de datos
                    $smarty->assign('borrado',false);
                    $smarty->assign('id_borrado',$p->getString('id_borrar'));
                }
                $smarty->display('libro-borrar.tpl');
            }else{
                $smarty->assign('id_borrar',$p->getString('id_borrar'));
                $smarty->display('libro-borrar.tpl');
            }
        }
    }
}
