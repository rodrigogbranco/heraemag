<?php
/*RGB Begin*/
session_start();

ini_set("display_errors","1");
error_reporting(E_ERROR | /*E_WARNING |*/ E_PARSE);
//ini_set('error_reporting', E_ALL);

// Includes some necesary files
require_once('inc/config.php'); // Config file
/*RGB begin*/
include_once("lang/".IDIOMA."/emag.php");
/*RGB end*/
require_once('lang/'.IDIOMA.'/lang.php'); // Interface texts
require_once("lang/".IDIOMA."/wcag.php"); // Guidelines texts
require_once ("inc/common.php"); // Some core libraries
require_once('inc/resumen.php'); // Class to build the summary of results
require_once('inc/file.php');
require_once("inc/parse.php");
//cleanAll();

$_POST['choose'] = 'emag';
$_SESSION['choose'] = 'emag';
$_SESSION['emag'] = true;
$_SESSION['wcag'] = false;
$_REQUEST['btns'] = 'Rever';

$variables = null;

$user_agent = "Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.8.0.10) Gecko/20070302 Ubuntu/dapper-security Firefox/1.5.0.10";

$sessao = 26;

$consulta1 = mysql_query("select id_municipio from egovmeter_monitoramento");
$total = mysql_num_rows($consulta1);

$consulta1 = mysql_query("select id_municipio from egovmeter_monitoramento where id_sessao_monitoramento = $sessao and not (ip is NULL or ip = '208.69.32.132' or ip = '67.215.66.132')");
$havesite = mysql_num_rows($consulta1);

$x = 0;

while($result = mysql_fetch_array($consulta1, MYSQL_ASSOC))
{
	$id_mun = intval($result['id_municipio']);
	$consulta2 = mysql_query("select url from egovmeter_municipio where id_municipio = $id_mun");
	$result2 = mysql_fetch_array($consulta2,MYSQL_ASSOC);
	
	$_REQUEST['url'] = $result2['url'];
	$url = $result2['url'];
	echo $url.'<br>';
	
	
		$File = new File(urldecode($url), $user_agent);

		if ($File->error == '') {
			if (!$File->fetch($File->uri_real, 'base', 'arry')) {
				$opt_head['error'] = "Not fetched";
			} else {
				if ($File->lastredirectaddr != '') {
					$url_redir = $File->uri_real;
				}
				if ($File->meta_redirect != '') {
					$meta_redir = $File->meta_redirect;
				}
			}
		} else {
			$opt_head['error'] = "Not opened";
		}

		if ($opt_head['error'] != '') {
			//return -1;
		} else { // No error
			$parse_res = new Parse;
			$parse_res->This_Page($url_redir, $meta_redir);

			if (defined('ID')) 
			{ // Parse page was successful
				DB_Query('select', 'todo');

				$New_Resumen = new Resumen;
				$this_results = Obter_Resultados();
				var_dump($New_Resumen);
				var_dump($this_results);
			}
		}
	
	if ($x < 5)
		$x++;
	else
		die();
	
}


/*RGB End*/
?>
