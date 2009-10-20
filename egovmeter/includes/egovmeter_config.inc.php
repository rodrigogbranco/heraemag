<?php

/**

 *

 *  Configuração E-GOVMeter

 *  Autor: Thiago Jabur Bittar

 *  Modificação: 09/11/2005 20:26

 */





$prefixo_email = "[E-GOVMeter]";

$email_secretaria = "thiago@governoeletronico.com.br";

$remetente = "E-GOVMeter";



/**

*  $end é o endereço relativo de onde ficará o sistema

*  Exemplo: $end = "/lab/" 

*/

//$end = "/egovmeter/";  //colocar a barra no final

$end = './';

//$end_absoluto = "http://www.governoeletronico.com.br/egovmeter/"; //onde é feito o login

$end = "http://localhost/heraemag/egovmeter/";

$end_unix = "/home/e-democracia/public_html/egovmeter/";





/** 

*   Parametros do MySQL

*

*/ 



$bd_senha = "hera";

$bd_usuario = "hera";

$bd_servidor = "localhost";

$bd_base = "hera";





/**

$bd_senha = "";

$bd_usuario = "root";

$bd_servidor = "localhost";

$bd_base = "egovmeter";

*/



// Não altere as linhas abaixo

require_once("../includes/egovmeter_functions.inc.php");

?>

