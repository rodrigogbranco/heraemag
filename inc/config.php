<?php
$website = 'http://developer.ledes.net/~rodrigo/heraemag/';
$default_lang = 'es';
$db_table = 'ariadna';

$db_host = "db.ledes.net";
$db_name = "hera"; // Nombre de la base de datos
$db_user = "hera"; // Nombre de usuario
$db_pw = "hera"; // Password

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