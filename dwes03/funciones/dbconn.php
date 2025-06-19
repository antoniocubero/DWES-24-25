<?php

function conectar()
{
    static $c = null;
    if ($c === null) {
        try {
            $c = new PDO(DB_DSN, DB_USER, DB_PASSWORD);
            $c->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $c->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND,'SET NAMES utf8');
        } catch (PDOException $e) {
	        var_dump($e);
            die('Error interno. Por favor consulte la aplicación más tarde.');
        }
    }
    return $c;
}
