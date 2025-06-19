<?php

include_once('etc/conf.php');
include_once('funciones/modifydb.php');

//Creamos un array para ir guardando los datos correctos
$okData=[];

//Aplicamos el filtro de INT a el id que se nos pasa
$id = filter_input(INPUT_POST,'id',FILTER_VALIDATE_INT);
if ($id) {//Si pasa el filtro se crea el valor en el array okData
    $okData['id'] = intval($_POST['id']);
}else{//Si el id no es correcto se informa por pantalla
    echo 'Id de producto no valido';
}

//Aplicamos el filtro de INT para la cantidad que se nos pasa (amount) igual que con id
$amount = filter_input(INPUT_POST, 'amount', FILTER_VALIDATE_INT);
if ($amount) {
    //Una vez pasado el filtro usamos intval para comprobar que no sea 0 y si es asi lo guardamos en okData
    if(intval($_POST['amount'])!=0){
        $okData['amount']=$_POST['amount'];
    }else{
        echo 'No puedes introducir 0 para modificar la cantidad';
    };
}else{
    echo 'Debes introducir un número positivo o negativo para modificar la cantidad';
}

//Comprobamos que existen los datos en okData y si existen usamos la funcion modifydb
if(isset($okData['id'])&&isset($okData['amount'])){
    $update = modifydb($conn, $okData['id'], $okData['amount']);
    if($update){//Comprobamos que la funcion devuelve true o tiene valor
        if ($update === -1) {//Si el valor es -1 es porque no existe el producto y lo sacamos por pantalla
            echo 'Incremento o decremento de unidades no realizado porque el producto no existe';
        }else{
            //Si no sacamos que se ha aplicado la modificacion correctamente
            echo 'Incremento o decremento de unidades realizado';
        }
    }else{
        //si la funcion devuelve false significa que el resultado ha dado un fallo y el fallo que ha dado es que daba un valor igual o menor a 0
        echo 'Incremento o decremento de unidades no realizado porque el número de unidades resultante es negativo o cero';
    };
}

