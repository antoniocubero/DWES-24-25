<?php
require_once __DIR__ . '/comun.php';
require_once __DIR__ . '/conf/Conection.php';

use Jaxon\Jaxon;
use Jaxon\Response\Response;
use GuzzleHttp\Client;



$jaxon = jaxon();
$jaxon->setOption("js.lib.uri", BASE_URL . "jaxon-dist");
$jaxon->setOption('core.request.uri', BASE_URL . 'backend.php');

function logMessage(Response $r, mixed $dato)
{
    $r->append('log', 'innerHTML', '<div>' . print_r($dato, true) . '</div>');
}

function funcion1($fechaYhora)
{
    $response = new Response();
    logMessage($response,"La fecha y la hora es: $fechaYhora");
    return $response;
}

function funcion2($nombre)
{
    $response = new Response();
    logMessage($response,"El nombre del autor o autora es $nombre");
    return $response;
}

function listarLibrosAutor ($isbn)
{
    //Creamos la peticion a utilizar y la conexion
    $response = new Response();
    $conn = Conection::conectar();

    try {
        //Preparamos la query, enlazamos los parametros y la ejecutamos
        $stmt = $conn->prepare('SELECT autor FROM libros WHERE isbn = :isbn');
        $stmt->bindParam('isbn',$isbn);
        $stmt->execute();

        //Comprobamos que hemos obtenido resultados
        $filas = $stmt->rowCount();
        if ($filas>0) {
            $autor = $stmt->fetch(PDO::FETCH_ASSOC);

            //Usamos rawurlencode para adaptar el nombre a la URL
            $autorEncoded=rawurlencode($autor['autor']);

            //Creamos la url
            $url = 'https://openlibrary.org/search/authors.json?q='.$autorEncoded;

            //Cremos el cliente Guzzle
            $clienteHTTP = new GuzzleHttp\Client();

            //Hazemos la peticion GET a la url
            $peticion = $clienteHTTP->request('GET',$url);
            //Comprobamos que la peticion ha sido correcta
            if ($peticion->getStatusCode()==200) {

                //Limpiamos el bloque y le ponemos los estilos
                $response->clear('otros_libros_autor');
                $response->assign('otros_libros_autor','style.display','block');
                $response->assign('otros_libros_autor','style.border','2px dotted blue');
                $response->assign('otros_libros_autor','style.padding','10px');

                //Obtenemos el resultado de la peticion
                $cuerpo = json_decode($peticion->getBody());

                //Cada libro viene en el array docs dentro de la respuesta, por lo que lo recorremos con un foreach
                foreach ($cuerpo->docs as $linea) {
                    //Comprobamos que work_count sea mayor que 0, esto es porque si no es asi, no existe top_work (el nombre del libro)
                    if ($linea->work_count>0) {
                        //Lo unimos al bloque donde se va a sacar, ponemos cada linea en un parrafo <p> y el nombre del autor y el libro en cursiva con <i>
                        $response->append('otros_libros_autor','innerHTML','<p>Titulo: <i>'.$linea->top_work.'</i> | Autor: <i>'.$linea->name.'</i></p>');
                    }
                }
            }else{
                //Si el codigo de estatus no fuese 200 lo sacariamos en log
                logMessage($response,'ERROR: Codigo '.$peticion->getStatusCode());
            }
        }else{
            //Si no existiese ningun libro con el ISBN pasado lo sacariamos en el log
            logMessage($response,'ERROR: No existe ningun libro en la base de datos con ese ISBN');
        }

    } catch (PDOException $e) {
        //Si ocurriese algun error en la conexion lo sacariamos en el log
        logMessage($response,'ERROR: Ha ocurrido un error en la conexion');
    }
    
    //Devolvemos la respuesta
    return $response;
}


function listarLibrosACM(){
    //creamos la response y la conexion
    $response = new Response();
    $conn = Conection::conectar();

    //Limpiamos el bloque
    $response->clear('listaLibros');

    try {
        //Preparamos la query y la ejecutamos
        $stmt = $conn->prepare('SELECT * FROM libros');
        $stmt->execute();

        //Comprobamos que hay resultados
        if ($stmt->rowCount()>0) {
            //Añadimos la cabecera de la tabla
            $response->append('listaLibros', 'innerHTML',
            '<table>
                <thead>
                    <tr>
                        <th>ID</th><th>Titulo</th><th>Autor</th><th>ISBN</th><th>Año de publicación</th><th>Páginas</th><th>Ejemplares disponibles</th><th>Fecha de creación</th><th>Fecha de actualización</th>
                    </tr>
                </thead>
                <tbody>');

            //Obtenemos los resultados en formato array asociativo
            $libros = $stmt->fetchAll(PDO::FETCH_ASSOC);

            //Recorremos todos los libros obtenidos con un foreach
            foreach ($libros as $libro) {
                //Imprimimos los valores de cada libro encontrado
                $response->append('listaLibros', 'innerHTML',
                            '<tr>
                                <td>'.$libro['id'].'</td><td>'.$libro['titulo'].'</td><td>'.$libro['autor'].'</td><td>'.$libro['isbn'].'</td><td>'.$libro['anio_publicacion'].'</td><td>'.$libro['paginas'].'</td><td>'.$libro['ejemplares_disponibles'].'</td><td>'.$libro['fecha_creacion'].'</td><td>'.$libro['fecha_actualizacion'].'</td>
                            </tr>
                        ');
            }

            //Cerramos la tabla
            $response->append('listaLibros', 'innerHTML',
            '</tbody></table>');
        }
    } catch (PDOException $e) {
        //Si ocurre algun error lo sacamos en el bloque
        $response->assign('listaLibros','innerHTML','<h3>Ha ocurrido un error con la conexion a la base de datos</h3>');
    }

    //Devolvemos la respuesta
    return $response;
}

function registrarLibroACM($datos){
    //creamos la conexion, un array vacio donde guardar los posibles errores y creamos el objeto response
    $conn = Conection::conectar();
    $errors=[];
    $response = new Response();

    //Usamos filter_var para elimiar caracteres especiales si los hubiese
    $titulo = filter_var($datos['titulo'], FILTER_SANITIZE_SPECIAL_CHARS);
    //Comprobamos que no esta vacio y no tiene mas longitud de 255, si no se cumpliese creariamos un error en el array errors
    if ($titulo=='' || strlen($titulo)>255) {
        $errors[]='ERROR: El titulo no es valido';
    }

    //Usamos filter_var para comprobar que sea un numero
    $isbn = filter_var($datos['isbn'],FILTER_VALIDATE_INT);
    //Comprobamos que ha pasado el filtro y que no tiene una longitud mayor a 13, si no se cumpliese creariamos un error en el array errors
    if (!$isbn || strlen($datos['isbn'])>13) {
        $errors[]='ERROR: El valor del isbn no es valido';
    }

    //Usamos filter_var para elimiar caracteres especiales si los hubiese
    $autor = filter_var($datos['autor'], FILTER_SANITIZE_SPECIAL_CHARS);
    //Comprobamos que no esta vacio y no tiene mas longitud de 255, si no se cumpliese creariamos un error en el array errors
    if ($autor=='' || strlen($autor)>255) {
        $errors[]='ERROR: El nombre del autor no es valido';
    }

    //Usamos filter_var para comprobar que sea un numero
    $anio = filter_var($datos['anio'],FILTER_VALIDATE_INT);
    //Comprobamos que ha pasado el filtro y que es un numero entre 0 y el año actual, si no se cumpliese creariamos un error en el array errors
    if (!$anio || $anio>date('Y') || $anio<=0) {
        $errors[]='ERROR: El año no es valido';
    }

    //Usamos filter_var para comprobar que sea un numero
    $paginas = filter_var($datos['paginas'],FILTER_VALIDATE_INT);
    //Comprobamos que ha pasado el filtro y que no es 0, si no se cumpliese creariamos un error en el array errors
    if (!$paginas || $paginas<=0) {
        $errors[]='ERROR: El numero de paginas introducido no es valido';
    }

    //Usamos filter_var para comprobar que sea un numero
    $ejemplares = filter_var($datos['ejemplares'],FILTER_VALIDATE_INT);
    //Comprobamos que ha pasado el filtro y que no es menor a 0, si no se cumpliese creariamos un error en el array errors
    if (!$ejemplares || $ejemplares<0) {
        $errors[]='ERROR: El numero de ejemplares introducido no es valido';
    }


    //Comprobamos si existen errores
    if(count($errors)>0){
        //Si existen, los recorremos con un foreach y los vamos poniendo en el log
        foreach ($errors as $error) {
            logMessage($response,$error);
        }
    }else{
        try {
            //Si no hay errores preparamos la query
            $stmt = $conn->prepare('INSERT INTO libros (titulo, isbn, autor, anio_publicacion, paginas, ejemplares_disponibles) VALUES (:titulo, :isbn, :autor, :anio_publicacion, :paginas, :ejemplares_disponibles)');

            //enlazamos los parametros y ejecutamos la query
            $stmt->execute([
                'titulo'=>$titulo,
                'isbn'=>$isbn,
                'autor'=>$autor,
                'anio_publicacion'=>$anio,
                'paginas'=>$paginas,
                'ejemplares_disponibles'=>$ejemplares
            ]);

            //Comprobamos que ha habido cambios
            $filas=$stmt->rowCount();
            if($filas>0){
                //Si se ha guardado lo sacamos por log, junto al id y mi nombre
                logMessage($response, 'Libro creado con id: '.$conn->lastInsertId().'. Antonio Cubero Martinez');
                //Tras esto hacemos una llamada a la funcion de cargar los libros para que actualize la tabla
                $response->call('jaxon_listarLibrosACM');
            }else{
                //Si no hay filas significa que no se ha podido guardar, asi que lo sacamos por log
                logMessage($response, 'ERROR: No se ha podido guardar');
            }
        } catch (PDOException $e) {
            //Si ocurre una excepcion es porque el isbn pasado pertenece a otro libro, asi que lo sacamos por log
            logMessage($response, 'ERROR: El isbn ya esta siendo usado por otro libro');
        }
    }

    //Devolvemos la respuesta
    return $response;
}


$jaxon->register(Jaxon::CALLABLE_FUNCTION, 'funcion1');
$jaxon->register(Jaxon::CALLABLE_FUNCTION, 'funcion2');
$jaxon->register(Jaxon::CALLABLE_FUNCTION, 'listarLibrosAutor');

//Registramos las funciones creadas
$jaxon->register(Jaxon::CALLABLE_FUNCTION, 'listarLibrosACM');
$jaxon->register(Jaxon::CALLABLE_FUNCTION, 'registrarLibroACM');
