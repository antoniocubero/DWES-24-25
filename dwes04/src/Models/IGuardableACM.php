<?php

/* La interfaz IGuardableXYZ tendrá 3 métodos:

Método estático guardar. El método guardar será un método que tendrá como parámetro una conexión PDO a la base de datos.
Método estático rescatar. El método rescatar será un método que tendrá dos parámetros: una conexión PDO a la base de datos, y el identificador (id), que corresponde con la clave primaria en la tabla asociada.
Método estático borrar. El método borrar será un método que también tendrá dos parámetros: una conexión PDO a la base de datos, y el identificador (id), que corresponde con la clave primaria en la tabla asociada.
El objetivo de estos métodos es unificar los métodos que se utilizan para gestionar los datos almacenados en la base de datos. En este caso solo usamos una tabla, pero cuando se usan muchas tablas tener métodos con los mismos nombres y parámetros facilita el trabajo. */

namespace DWES04\Models;

use \PDO;

interface IGuardableACM{
    public function guardar(PDO $conn);

    public static function rescatar(PDO $conn, int $id);

    public static function borrar(PDO $conn, int $id);
}