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
//cleanAll();

$_POST['choose'] = 'emag';
$_SESSION['choose'] = 'emag';
$_SESSION['emag'] = true;
$_SESSION['wcag'] = false;
$_REQUEST['btns'] = 'Rever';

$variables = null;

$sessao = 26;

$consulta = mysql_query("select id_municipio from egovmeter_monitoramento");
$total = mysql_num_rows($consulta);

$consulta = mysql_query("select id_municipio from egovmeter_monitoramento where id_sessao_monitoramento = $sessao and not (ip is NULL or ip = '208.69.32.132' or ip = '67.215.66.132')");
$havesite = mysql_num_rows($consulta);

while($result = mysql_fetch_array($consulta, MYSQL_ASSOC))
{
	$id_mun = intval($result['id_municipio']);
	$consulta2 = mysql_query("select url from egovmeter_municipio where id_municipio = $id_mun");
	$result2 = mysql_fetch_array($consulta2,MYSQL_ASSOC);
	
	$_REQUEST['url'] = $result2['url'];
	
	echo $_REQUEST['url'];
	
	$tags = array(); // Page tags
	$contents = array(); // Page content

	define ('TIME_START', Get_MTime());

	if ($_REQUEST['hid']) {
		define ('HID', (int)$_REQUEST['hid']);
	}

	if ($_REQUEST['url'] == 'referer') {
		$url_tmp = cleanStr($_SERVER["HTTP_REFERER"]);
	} else {
		$url_tmp = trim($_REQUEST['url']);
	}

	require_once('inc/file.php');
	$File = new File(urldecode($url_tmp), $_SERVER['HTTP_USER_AGENT']);

	if ($File->error == '') {
		if (!$File->fetch($File->uri_real, 'base', 'arry')) {
		// The target page could not be read
			$opt_head['error'] = $lang['file_error'];
		} else {
			if ($File->lastredirectaddr != '') {
				$url_redir = $File->uri_real;
			}
			if ($File->meta_redirect != '') {
				$meta_redir = $File->meta_redirect;
			}
		}
	} else {
		$opt_head['error'] = $File->error;
	}

	if ($opt_head['error'] != '') {

		include_once('inc/header.php');
		include_once('inc/pages.php');

	} else { // No error

		if ($_SESSION['uri_anterior']) {
			if (!defined(HID) && isset($_SESSION['ultimo_id'])) {
				define ('HID', (int)$_SESSION['ultimo_id']);
			}
		}
		$_SESSION['uri_anterior'] = URL;
		require_once ("inc/parse.php");
		$New_Parse = new Parse;
		$New_Parse->This_Page($url_redir, $meta_redir);

		if (defined('ID')) { // Parse page was successful
			$param = '?id='.(int)ID;
			$opt_head['bread'] = 'resumen';
			$opt_head['form'] = URL;
			$opt_head['bar'] = 'info';
			include_once('inc/header.php');
			
			DB_Query('select', 'todo');
			$New_Resumen = new Resumen;
			$New_Resumen->Results();

		} else { // Parse page fails

			$opt_head['error'] = $lang['page_error'];
			include_once('inc/header.php');
			include_once('inc/pages.php');
		}
	}
	
	die();
	
}


/*RGB End*/
?>
