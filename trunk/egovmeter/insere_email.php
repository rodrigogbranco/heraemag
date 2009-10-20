<?php
require_once("./includes/egovmeter_config.inc.php");

conecta();
$id_municipio = $_POST['id_municipio'];
$email = $_POST['email'];

$sql = "insert into egovmeter_email (id_municipio, email) values ($id_municipio, '$email') ";

//echo $sql;
mysql_query($sql); 


header("location: falta_email.php");
?>
