<?php

define ('DB_DSN','mysql:host=localhost;dbname=2425_dwes07');
define ('DB_USER','root');
define ('DB_PASSWD','');

if (!defined('DB_USER') || !defined('DB_PASSWD'))
{
    die("<H1>Configura en ".__FILE__." las constantes DB_USER y DB_PASSWD");
}
