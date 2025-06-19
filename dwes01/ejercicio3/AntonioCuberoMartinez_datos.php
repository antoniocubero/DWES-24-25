<style>
    table, th, td{
        border: 1px solid black
    }
</style>
<?php

#Aqui tenemos el array multidimensional con los datos
$cars =[['marca'=>'BMW', 'modelo'=>'M3', 'precio'=>55000, 'potencia'=>238, 'anyo'=>1986, 'clase'=>'deportivo'],
        ['marca'=>'BMW', 'modelo'=>'Serie 1', 'precio'=>30000, 'potencia'=>140, 'anyo'=>2011, 'clase'=>'compacto'],
        ['marca'=>'Audi', 'modelo'=>'Q3', 'precio'=>30000, 'potencia'=>110, 'anyo'=>2015, 'clase'=>'SUV'],
        ['marca'=>'Nissan', 'modelo'=>'GTR', 'precio'=>45000, 'potencia'=>280, 'anyo'=>1993, 'clase'=>'deportivo'],
        ['marca'=>'Nissan', 'modelo'=>'Patrol', 'precio'=>16000, 'potencia'=>160, 'anyo'=>2005, 'clase'=>'todoterreno'],
        ['marca'=>'Mitsubishi', 'modelo'=>'Evolution', 'precio'=>30000, 'potencia'=>286, 'anyo'=>2005, 'clase'=>'deportivo'],
        ['marca'=>'Volkswagen', 'modelo'=>'Golf', 'precio'=>25000, 'potencia'=>110, 'anyo'=>2018, 'clase'=>'compacto'],
        ['marca'=>'Mercedes', 'modelo'=>'Clase G', 'precio'=>120000, 'potencia'=>367, 'anyo'=>2024, 'clase'=>'todoterreno'],
        ['marca'=>'Mercedes', 'modelo'=>'CLA', 'precio'=>30000, 'potencia'=>218, 'anyo'=>2021, 'clase'=>'berlina'],
        ['marca'=>'Lexus', 'modelo'=>'ES', 'precio'=>56000, 'potencia'=>218, 'anyo'=>2023, 'clase'=>'berlina'],
        ['marca'=>'Hyundai', 'modelo'=>'Tucson', 'precio'=>35000, 'potencia'=>150, 'anyo'=>2022, 'clase'=>'SUV']];
$results = [];


$errors=[];
$okData=[];

$class_valid=['berlina','SUV','compacto','deportivo','todoterreno'];

#Comprobamos que el valor entrado desde el input price sea numerico, si no se creara el error y se le asignara el valor 0
if (is_numeric($_POST['price']??null)) {
    $price = intval($_POST['price']);
    if ($price >= 0) {#Aqui comprobamos que sea un numero positivo, si es negativo se le pondra el valor 0 tambien
        $okData['price']=$price;
    }else{
        $errors[]="Se ha introducido un número negativo, se tomará el valor 0";
        $okData['price']=0;
    }
} else {
    $errors[]="El valor introducido no es correcto, se tomará el valor 0";
    $okData['price']=0;
}

#Comprobacion de que las clases recibidas estan dentro de los valores validos
if(isset($_POST['class']) && is_array($_POST['class'])){
    if(empty(array_diff($_POST['class'], $class_valid))) {
        #Checkboxes correctos
        $okData['class']=$_POST['class'];
    }else{
        #Clase de coche no permitida
        $errors[]="Tipo de coche no valido, se mostrarán todos los tipos";
    }
}else{
    $errors[]="Ningun tipo de vehiculo seleccionado, se mostrarán todos los tipos";
}



#Sacamos los errores por pantalla si los hubiese, lo comprobamos con empty y si hubiese los sacamos con un foreach
if (!empty($errors)) {
    echo "<h1>Errores detectados:</h1><ul>";
    foreach ($errors as $value) {
        echo "<li>$value</li>";
    }
    echo "</ul>";
}


#Filtramos aquellas entradas del array que cumplan con el precio, si el valor no es valido, tendra valor 0, por eso esto siempre se ejecuta
$results = array_filter($cars, function($v) use ($okData){
    if ($v['precio']>=$okData['price']) {
        return $v;
    }
});

#Mostramos los resultados de filtro
echo "<h1>Resultados: </h1><ul>";
echo "<li>Se mostraran los coches con un precio superior a ".$okData['price']."€</li>";

#Comprobamos que existan tipos de vehiculos guardados y si existen filtramos el array results con los que contengan esos tipos de vehiculos
if (!empty($okData['class'])) {
    $results = array_filter($results, function($v) use ($okData){
        if(in_array($v['clase'], $okData['class'])){
            return $v;
        }
    });
    echo "<li>Se mostraran los coches de tipo ".implode(", ", $okData['class'])."</li>";# Mostramos los tipos de vehiculos que hemos filtrado
}
echo "</ul>";

#Imprimimos la tabla por pantalla
echo "<table>
        <tr>
            <th>Marca</th>
            <th>Modelo</th>
            <th>Precio</th>
            <th>Potencia (CV)</th>
            <th>Año</th>
            <th>Clase</th>
        </tr>";
foreach ($results as $key => $value) {
    echo "
        <tr>
            <td>{$value['marca']}</td>
            <td>{$value['modelo']}</td>
            <td>{$value['precio']}€</td>
            <td>{$value['potencia']}</td>
            <td>{$value['anyo']}</td>
            <td>{$value['clase']}</td>
        </tr>";
}
echo "</table>";