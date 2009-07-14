<?php
$website = 'http://www.sidar.org/hera/';
$default_lang = 'es';
$db_table = 'ariadna';

$db_host = "localhost";
$db_name = "hera"; // Nombre de la base de datos
$db_user = "hera"; // Nombre de usuario
$db_pw = ""; // Password

$opt_head = array(
	'error' => '',
	'bread' => '',
	'form' => '',
	'bar' => ''
);

/* No modificar */
if (!defined('IDIOMA')) { define ('IDIOMA', $default_lang); }
define ('WEBSITE', $website);
define ('PHP_SELF', $_SERVER['PHP_SELF']);
define ('DBTABLE', $db_table);
?>