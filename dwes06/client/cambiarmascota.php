<?php

require __DIR__.'/vendor/autoload.php';

session_start();

//Comprobamos que existe un token en la sesion
if(isset($_SESSION['token'])){

    //hacemos una pequeña comprobacion para comprobar que hemos recibido los campos con algun dato, y que no estan vacios
    if (isset($_POST['id']) && $_POST['id']!='' && isset($_POST['descripcion']) && isset($_POST['publica'])) {
        //Creamos el cliente de guzzle
        $guzzleClient = new GuzzleHttp\Client(['http_errors'=>false]);
        //Creamos un array con los datos que vamos a enviar, no se validan aqui porque se validaran en la API
        $datosAEnviar = [
            'descripcion' => $_POST['descripcion'],
            'publica' => $_POST['publica']
        ];
        //Creamos la peticion PUT a la API pasandole los datos en formato JSON y obtenemos su respuesta
        $response = $guzzleClient->put('http://localhost:8080/api/mascotaACM/'.$_POST['id'], [
            'json' => $datosAEnviar,
            'headers' => ['Authorization'=>'Bearer '.$_SESSION['token']]
        ]);

        //Obtenemos el codigo y el cuerpo de la respuesta
        $code = $response->getStatusCode();
        $data=json_decode($response->getBody());

        //Sacamos el codigo
        echo "Código: ".$code."<br>";
        if (isset($data->mensaje)) {//Si hemos recibido datos de mensaje lo sacamos
            echo $data->mensaje."<br>";
        }

        if (isset($data->errores)){//Si recibimos errores los sacamos con un foreach
            echo "Errores: <br>";
            foreach ($data->errores as $e) {
                echo $e."<br>";
            }
        }

    }else{//Si los datos recibidos estan vacios o no se ha recibido ninguno sacamos el formulario
        echo "<h2>Editar mascota</h2>
        <form method='POST' action='cambiarmascota.php'>
        
        <label for='id'>ID de la mascota:</label>
        <input type='text' id='id' name='id'><br>
        <label for='descripcion'>Descripcion:</label>
        <textarea id='descripcion' name='descripcion' cols='30' ></textarea><br>
        
        <label for='publica'>¿Publica?</label><br>
        <input type='radio' id='publica_si' name='publica' value='Si'>
        <label for='publica_si'>Sí</label>
        <input type='radio' id='publica_no' name='publica' value='No'>
        <label for='publica_no'>No</label><br>
        <input type='submit' value='Crear'>
        </form>";
    }

}else{
    //Si no se esta logeado (no encuentr el token en la session) sacamos un enlace al login
    echo "<a href='login.php'>Por favor, inicia sesion</a>";
}