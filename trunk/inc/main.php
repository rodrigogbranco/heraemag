<?php
session_start();

//ini_set("display_errors","1");
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
cleanAll();

/*RGB begin*/
if(isset($_POST['choose']))
{
	$_SESSION['choose'] = $_POST['choose'];
	
	if ($_SESSION['choose'] == 'emag')
	{
		$_SESSION['emag'] = true;
		$_SESSION['wcag'] = false;
	}
	else
	{
		$_SESSION['wcag'] = true;
		$_SESSION['emag'] = false;
	}
}
else
{
	if(!isset($_SESSION['emag']))
	{
		$_SESSION['wcag'] = false;
		$_SESSION['emag'] = false;
	}
}
/*RGB end*/

$variables = null;

if (!empty($_REQUEST['url'])) {  // An URI is sent
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

} else if ($_REQUEST['id']) { // An ID is sent

	require_once('lang/'.IDIOMA.'/info.php');
	define('ID', (int)$_REQUEST['id']);
	$param = '?id='.ID;
	
	// Declare sent parameters as constants
	if ($_REQUEST['pr']) { define('PR', $_REQUEST['pr']); } // Priority
	if ($_REQUEST['pt']) { define('PT', $_REQUEST['pt']); } // Checkpoint
	if ($_REQUEST['re']) { define('RE', $_REQUEST['re']); } // Results
	if ($_REQUEST['hx']) { define('HX', $_REQUEST['hx']); } // Chkpoint help
	if ($_REQUEST['hl']) { define('HL', $_REQUEST['hl']); } // Manual
	if ($_REQUEST['in']) { define('IN', $_REQUEST['in']); } // Report
	if ($_REQUEST['an']) { // Register results
		define('AN', $_REQUEST['an']);
		$param .= '&amp;an=1';
	}

	DB_Query('select', 'todo');
	if ($OK == 1) {
		if ($_POST['resulta']) {  // Form to register result sent
			DB_Query('update');
		}

		$New_Resumen = new Resumen;
		$opt_head['form'] = URL;

		if ($_REQUEST['pt']) { // Check a guideline

			$opt_head['bread'] = 'pauta';
			$opt_head['bar'] = 'icons';
			include_once('inc/header.php');
			$New_Resumen->Navega('pauta');
			require_once('inc/content.php');

		} else if ($_REQUEST['pr']) { // Check a priority

			if (PR == 1) { define ('_A', 'A'); }
			else if (PR == 2) { define ('_A', 'AA'); }
			else if (PR == 3) { define ('_A', 'AAA'); }

			$opt_head['bread'] = 'priori';
			$opt_head['bar'] = 'icons';
			include_once('inc/header.php');
			$New_Resumen->Navega('prioridad');
			require_once('inc/content.php');

		} else if ($in) { // Generate report

			$opt_head['bread'] = 'informe';
			$opt_head['bar'] = 'resumen';
			include_once('inc/header.php');
			$New_Resumen->Form_Info();

		} else { // ID without parameters

			$opt_head['bread'] = 'resumen';
			$opt_head['bar'] = 'info';
			include_once('inc/header.php');
			$New_Resumen->Results();
		}

	} else {
		$opt_head['error'] = 'No existe una revisión con ese ID.';
		include_once('inc/header.php');
		include_once('inc/pages.php');
	}

} else { // Start page

	$borrar = @mysql_query("DELETE FROM ".DBTABLE." WHERE revision IS NOT NULL AND to_days(now())-to_days(revision) > 7");
	$borrar2 = @mysql_query("DELETE FROM ".DBTABLE." WHERE revision IS NULL AND to_days(now())-to_days(fecha) > 0");

	if (mysql_affected_rows() != 0) {
		$optimizar = @mysql_query("OPTIMIZE TABLE ".DBTABLE);
	}

	include_once('inc/header.php');
	include_once('inc/pages.php');
}
include_once('inc/footer.php');
?>