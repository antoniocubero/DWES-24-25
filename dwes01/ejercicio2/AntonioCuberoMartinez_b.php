<?php
#incluimos el archivo para importar la funcion
require_once('AntonioCuberoMartinez_a.php');

function filterArray($percentage=0){#Ponemos un valor por defecto a el parametro
    #Array vacio donde vamos a guardar los valores
    $array=[];

    #Nombre de los archivos en un array para recorrerlo con un foreach, esto se podria reutilizar en un futuro si fuesen mas archivos
    $files=['AntonioCuberoMartinez_datos1.csv','AntonioCuberoMartinez_datos2.csv'];
    foreach($files as $file) {
        readCSV($array, $file);
    }
    return array_filter($array, fn($player)=> $player["Porcentaje"] >= $percentage);
}