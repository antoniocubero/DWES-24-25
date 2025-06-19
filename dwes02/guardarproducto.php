<?php

include_once('etc/conf.php');
include_once('funciones/insertdb.php');

//Creamos los arrays errors y okData para ir guardando los datos segun vayan siendo
$errors=[];
$okData=[];


//Comprobamos que name esta establecida y que no esta vacia
if(isset($_POST['name']) && $_POST['name']!=''){
    if(strlen($_POST['name'])>30){//Comprobamos que la longitud no es mayor a 30 y si lo es creamos un error
        $errors[]='El campo nombre solo puede tener 30 caracteres máximo de longitud';
    }else{
        //Si no lo es, le eliminamos los espacios delante y detras con trim, despues lo pasamos todo a minusculas con strtolower, y le ponemos la primera letra en mayusculas con ucfirst, esta ultima no esta puesta en la tarea pero como todos los productos se estaban poniendo asi he decidido hacerlo igual, y con todos los cambios hechos lo guardamos en okData
        $okData['name']=ucfirst(strtolower(trim($_POST['name'])));
    }
}else{
    //Si el campo no existiese creariamos un error
    $errors[]='El campo nombre es obligatorio';
}

//Comprobamos que ean esta establecida y que no esta vacia
if (isset($_POST['ean']) && $_POST['ean']!='') {
    if ((strlen($_POST['ean'])<=13 && strlen($_POST['ean'])>=8) && is_numeric($_POST['ean'])) {//Comprobamos que tiene una longitud entre 13 y 8 y que es un dato numero con is_numeric
        //Hacemos una consulta para comprobar si existe el codigo EAN
        $stmt = $conn->prepare('SELECT COUNT(*) FROM productos WHERE codigo_ean = :ean');
        $stmt->bindParam(':ean', $_POST['ean']);//unimos los parametros
        $stmt->execute();//ejecutamso la consulta

        $count = $stmt->fetchColumn();//usamos fetchColumn para que nos devuelva la unica fila que existe en la consulta
        if ($count > 0) {//Si devuelve un numero mayor a cero significa que existe el codigo ean en la base de datos y creamos un error
            $errors[]='El codigo EAN introducido ya existe en la base de datos';
        }else{
            //Si no significa que esta todod correcto y lo guardamos en okData
            $okData['ean']=$_POST['ean'];
        }
    }else{
        //Creariamos un error si no tuviese la longitud establecida o si no fuese un numero
        $errors[]='El codígo EAN debe ser un numero de entre 8 y 13 de dígitos';
    }
}else {
    //Si el campo no existiese creariamos un error
    $errors[]='El código EAN es obligatorio';
}

//Comprobamos que unit esta creada y que no esta vacia
if (isset($_POST['unit']) && is_numeric($_POST['unit'])) {
    $unit = intval($_POST['unit']);//obtenemos el valor int de las unidades pasadas
    if ($unit>0) {//Comprobamos que el valor es un numero positivo y mayor que 0 y lo guardamos en okData
        $okData['unit']=$unit;
    }else{
        //Si no es porque tiene un valor igual o menor a 0
        $errors[]='Debes introducir un numero positivo y mayor que 0';
    }

}else {
    //Si el campo no existiese creariamos un error
    $errors[]='Debes introducir las unidades del producto';
}

//Comprobamos que price esta creada y que no esta vacia
if (isset($_POST['price']) && is_numeric($_POST['price'])) {
    $price = floatval($_POST['price']);//Guardamos su valor float
    if ($price>=0) {//Havemos la misma comprobacion y la misma operacion que con las unidades
        $okData['price']=$price;
    }else{
        $errors[]='Debes introducir un numero positivo y mayor o igual a 0';
    }
}else {
    //Si el campo no existiese creariamos un error
    $errors[]='Debes introducir el precio del producto';
}

//Comprobamos que se han pasado categorias y que son categorias validas con in_array, y usamos VALID_CATEGORIES que hemos creado en conf.php
if (isset($_POST['cat']) && in_array($_POST['cat'], VALID_CATEGORIES)) {
    //Si es correcto lo guardamos en okData
    $okData['cat']=$_POST['cat'];
}else {
    //Si el campo no existiese creariamos un error
    $errors[]='Debes seleccionar una categoria';
}

//Comprobamos que se han pasado propiedades y que es un array
if (isset($_POST['prop']) && is_array($_POST['prop'])) {
    if(empty(array_diff($_POST['prop'], VALID_PROPERTIES))) {//Mediante un array_diff con VALID_PROPERTIES que hemos creado en conf.php obtenemos un array que estaria vacio si todas las categorias pasadas estan dentro de VALID_PROPERTIES, asi que comprobamos que esta vacio con empty
        //Si la comprobacion es buena, mediante implode creamos un string separando los valores del array con una coma y lo guardamos en okData
        $okData['prop']=implode(',',$_POST['prop']);
    }else{
        //Si una propiedad no fuese valida no pasaria por el if anterior y guardariamos un error
        $errors[]="Propiedades no validas";
    }
} else {
    //Si no se marcase ninguna de las propiedades guardariamos el valor como null
    $okData['prop']=null;
}


if ($errors) {//Comprobamos si existen errores o no, si existen, los sacamos por pantalla y volvemos al formulario
    echo '<h2>Errores:</h2><ul>';
    foreach ($errors as $value) {
        echo "<li>$value</li>";
    }
    echo '</ul><br>';
    include ('nuevoproducto.php');//Con esto volvemos a cargar el formulario
}else{
    //Si no hubiese errores ejecutamos la funcion
    $result = insertdb($conn, $okData);
    echo "Producto {$okData['name']} añadido, con id:$result";
}