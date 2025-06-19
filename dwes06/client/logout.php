<?php

require __DIR__.'/vendor/autoload.php';

session_start();

//Creamos el cliente de guzzle
$guzzleClient=new GuzzleHttp\Client(['http_errors'=>false]);

//Creamos unos headers vacios
$headers=[];

//Si existe el token en la sesion se lo añadimos al header
if (isset($_SESSION['token'])) {
    $headers = ['Authorization'=>'Bearer '.$_SESSION['token']];
}

//Obtenemos la respuesta de la peticion
$response=$guzzleClient->post('http://127.0.0.1:8080/api/logout',[
            'headers'=>$headers
    ]);

$code=$response->getStatusCode(); //Obtener el código de respuesta HTTP
$data=json_decode($response->getBody(), true); //Obtener el cuerpo del mensaje, al añadirle un true al final del metodo nos lo devolvera en forma de array

//Si recibimos el codigo 200 y el codigo 1 en el cuerpo de la respuesta significa que se ha deslogeado correctamente
if($code==200 && $data['codigo']==1){
    session_unset();//Limpiamos todos los datos de la sesion
    session_destroy();//Con el session_destroy() conseguimos que no se pueda reutilizar el token al destruir la sesion
}

echo $data['mensaje'];
