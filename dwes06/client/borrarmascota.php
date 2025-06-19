<?php

require __DIR__.'/vendor/autoload.php';

session_start();

//Comprobamos que existe un token en la sesion
if (isset($_SESSION['token'])) {

    //Hacemos una pequeña comprobacion para comprobar que hemos recibido id y que no esta vacio
    if (isset($_POST['id'])&&$_POST['id']!='') {
        //Creamos el cliente de guzzle
        $guzzleClient = new GuzzleHttp\Client(['http_errors'=>false]);

        //Obtenemos la respuesta a la API para borrar la mascota
        $response = $guzzleClient->delete('http://localhost:8080/api/mascotaACM/'.$_POST['id'], [
            'headers' => ['Authorization'=>'Bearer '.$_SESSION['token']]
        ]);

        //Obtenemos el codigo y el cuerpo de la respuesta
        $code = $response->getStatusCode();
        $data=json_decode($response->getBody());

        //Sacamos el codigo
        echo "<h2>Codigo: ".$code."<br></h2>";
        if (isset($data->mensaje)) {//Si hemos recibido datos de mensaje lo sacamos
            echo $data->mensaje."<br>";
        }

        if (isset($data->error)){//Si hemos recibido algun error lo sacamos
            echo "Error: {$data->error}<br>";
        }
    }else{//Si no se reciben datos sacamos el formulario
        echo "<h2>Borrar mascota</h2>
        <form method='POST' action='borrarmascota.php'>
        <label for='id'>ID de la mascota:</label>
        <input type='text' id='id' name='id'>
        <input type='submit' value='Eliminar mascota'>
        </form>";
    }


}else{//Si no existe el token, significa que no hay usuario conectado por lo que sacamos un enlace al login
    echo "<a href='login.php'>Por favor, inicia sesion</a>";
}