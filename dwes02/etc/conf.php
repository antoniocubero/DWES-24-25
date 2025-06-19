<?php

include_once(__DIR__ . '/../funciones/connection.php');


//Datos para la conexcion
define("HOST", "localhost");
define("DB", "tarea02");
define("USERNAME", "root");
define("PASS", "");

//Creamos la conexion
$conn = connection();

//Creamos las constantes para las categorias y propiedades validas
const VALID_CATEGORIES = ['lacteos', 'conservas', 'bebidas', 'snacks', 'dulces', 'otros'];
const VALID_PROPERTIES = ['sin gluten', 'sin lactosa', 'vegano', 'orgánico', 'sin conservantes', 'sin colorantes'];