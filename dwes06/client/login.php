<?php

require __DIR__.'/vendor/autoload.php';

session_start();

//Comprobamos si existe el token en la sesion
if (!isset($_SESSION['token'])){
    //Comprobamos que hemos recibido datos en $_POST de email y password
    if (isset($_POST['email']) && isset($_POST['password'])) { 
        //Guardamos los datos recibidos en el array datos
        $datos['email'] = $_POST['email'];
        $datos['password'] = $_POST['password'];

        $guzzleClient=new GuzzleHttp\Client( ['http_errors'=>false]);
        $response=$guzzleClient->post('http://127.0.0.1:8080/api/login', ['form_params'=>$datos]);
        $code=$response->getStatusCode();//Obtenemos el codigo de la respuesta
        $data=json_decode($response->getBody(), true);//Obtenemos el contenido de la respuesta

        //Si el codigo es 200 es que se ha iniciado sesion correctamente, y creamos el token en la sesion
        if ($code == 200) {
            $_SESSION['token']=$data['token'];
            echo "<h3>Has iniciado sesion correctamente</h3>";
        }else{//Si no es codigo 200 sacamos el codigo y el mensaje recibido
            echo "<h3>Error ".$code.": ".$data['mensaje']."</h3>";
        }
    }
    
    //Si no se ha creado el token en la sesion en este punto volvemos a poner el formulario
    if (!isset($_SESSION['token'])) {
        echo "
            <h2>Login</h2>
            <form action='login.php' method='post'>
                <label for='email'>Correo:</label>
                <input type='text' name='email'><br>
                <label for='password'>Contraseña:</label>
                <input type='password' name='password'><br>
                <input type='submit' value='Iniciar sesión'>
            </form>";
    }
}else{
    echo "Ya has iniciado sesion";
}
