<?php
function readCSV(&$array, $file){
    //Con el if comprobamos que ha podido abrir el archivo, ya que fopen devuelve true si ha completado la operacion con exito y false si ha producido algun error
    if($handle = fopen($file, "r")){
        //Lo ejecutamos una vez para eliminar la cabecera
        fgetcsv($handle);
        
        #Vamos recorriendo el archivo y lo vamos metiendo en el array que recibimos por parametros hasta que se quede vacio
        while (($data=fgetcsv($handle, 1000, ","))!== FALSE){
            #Lo añadimos como array asociativo
            $array[]=["Año"=>$data[0],"Jugador"=>$data[1],"Porcentaje"=>$data[2],"Puntuacion"=>$data[3]];
        };
        #Cerramos el archivo
        fclose($handle);
        return true;
    }else{
        return false;
    }
}