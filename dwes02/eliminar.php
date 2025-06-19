<?php

include_once('etc/conf.php');
include_once('funciones/removedb.php');

//Creamos un array para ir guardando los datos correctos
$okData=[];

//Aplicamos el filtro de INT a el id que se nos pasa
$id = filter_input(INPUT_POST,'id',FILTER_VALIDATE_INT);
if ($id) {//Si pasa el filtro se crea el valor en el array okData
    $okData['id'] = intval($_POST['id']);
}else{//Si el id no es correcto se informa por pantalla
    echo 'Id de producto no valido';
}

//Comprobamos que existen los datos en okData y si existen usamos la funcion removedb
if (isset($okData['id'])) {
    $remove = removedb($conn, $okData['id']);
    if ($remove) {//Comprobamos que la funcion devuelve true e informamos de que se ha eliminado
        echo 'Producto eliminado correctamente';
    }else{
        //Si la funcion devuelve false significa que no existe un producto con el id indicado
        echo 'No se ha eliminado el producto porque no se ha encontrado un producto con un id: '.$okData['id'];
    }
}