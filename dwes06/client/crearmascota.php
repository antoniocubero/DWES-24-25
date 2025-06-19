<?php

require __DIR__.'/vendor/autoload.php';

session_start();

//Comprobamos que existe un token en la sesion
if (isset($_SESSION['token'])) {

    //Almacenamos los datos recibidos en un array
    $datos['nombre']=$_POST['nombre'];
    $datos['descripcion']=$_POST['descripcion'];
    $datos['tipo']=$_POST['tipo'];
    //Si hemos recibido publica lo guardamos, hago esto para evitar un error por si no se recibe publica en $_POST
    if (isset($_POST['publica'])) {
        $datos['publica']=$_POST['publica'];
    }

    //Creamos el cliente de guzzle
    $guzzleClient=new GuzzleHttp\Client(['http_errors'=>false]);

    //Creamos el header
    $headers = ['Authorization'=>'Bearer '.$_SESSION['token']];

    //Hacemos la peticion a la API con los datos que hemos recibido
    $response=$guzzleClient->post('http://127.0.0.1:8080/api/crearmascotaACM',[
                'form_params'=>$datos,
                'headers'=>$headers
        ]);
    
    //Obtenemos el codigo recibido
    $code=$response->getStatusCode();

    //Si el codigo es 200 el borrado se ha hecho correctamente obtenemos el body y imprimimos los datos recibidos
    if ($code==200) {
        $data=json_decode($response->getBody());
        echo "<h2>Código: ".$code."</h2><br>Id de la mascota creada: ".$data->id_mascota."<br>Mi nombre: ".$data->implementador;
    }elseif ($code==400){//Si el codigo es 400 es que ha habido algun error, sacamos el codigo recibido y los errores
        $data=json_decode($response->getBody());
        echo "<h2>Código: ".$code."</h2>";
        echo "<br><h2>Errores</h2>";
        foreach ($data->errores as $k => $e) {
            print_r($e."<br>");
        }
    }
}else{
    //Si el usuario no esta logeado, creamos un enlace al login
    echo "<a href='login.php'>Por favor, inicia sesion</a>";
}