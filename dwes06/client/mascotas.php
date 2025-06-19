<?php

require __DIR__.'/vendor/autoload.php';

session_start();

//Comprobamos que existe un token en la sesion
if (isset($_SESSION['token'])) {
    //Creamos el cliente de guzzle
    $guzzleClient=new GuzzleHttp\Client(['http_errors'=>false]);

    //Guaradmos el token en los headers
    $headers = ['Authorization'=>'Bearer '.$_SESSION['token']];

    //Hacemos la peticion GET con los headers
    $response=$guzzleClient->get('http://127.0.0.1:8080/api/mascotasACM',[
                'headers'=>$headers
        ]);
    
    $code=$response->getStatusCode();//Obtenemos el codigo

    //Si obtenemos el codigo 200 obtenemos el body de la respuesta y lo sacamos en forma de tabla
    if ($code==200) {
        $mascotas=json_decode($response->getBody());
        echo "<h2>Lista de mascotas</h2>";
        echo "<table border='1'>
                <tr>
                    <th>Id</th>
                    <th>Nombre</th>
                    <th>Descripcion</th>
                    <th>Tipo</th>
                    <th>Publica</th>
                    <th>Me gustas</th>
                </tr>";
        //Con un foreach sacamos todas las que recibimos
        foreach ($mascotas as $m) {
            echo "<tr>
                    <td>".$m->id."</td>
                    <td>".$m->nombre."</td>
                    <td>".$m->descripcion."</td>
                    <td>".$m->tipo."</td>
                    <td>".$m->publica."</td>
                    <td>".$m->megusta."</td>
                </tr>";
        }
        echo "<table>";
    }else{
        //Si no es codigo 200 obtenemos el body y sacamos el codigo y el mensaje recibido
        $mensaje=json_decode($response->getBody());
        echo "Codigo de error: ".$code."<br>".$mensaje;
    }

}else{
    //Si no se esta logeado (no encuentr el token en la session) sacamos un enlace al login
    echo "<a href='login.php'>Por favor, inicia sesion</a>";
}
