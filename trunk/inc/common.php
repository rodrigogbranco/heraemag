<?php
if(!defined('WEBSITE')){die();}
/*=======================================
  HERA v.2.0 Beta                        
  File: inc/common.php                   
  Core libraries                         
=======================================*/


// DB connection
$conectar = @mysql_connect($db_host, $db_user, $db_pw);

if (!$conectar) {
	$opt_head['error'] = 'No es posible establecer la conexión a la base de datos.';
} else {
	$conectar2 = @mysql_select_db($db_name);
	if (!$conectar2) {
		$opt_head['error'] = 'No es posible establecer la conexión a la tabla en la base de datos.';
	}
}
if ($opt_head['error'] != '') {
	include('inc/header.php');
	include('inc/pages.php');
	include('inc/footer.php');
	exit;
}


/*========================================
	Function: Select or update queries     
========================================*/

function DB_Query($q, $que='todo', $cant=25) {
	global $totales, $puntos, $mis_puntos, $marcos, $comentarios, $resumen, $tag, $elem, $cont, $css, $mis_resultados, $fecha, $consulta, $nombre, $OK, $lang, $software;

	if ($q == 'select') {
		switch ($que) {
			case 'todo':
				$consulta = @mysql_query("SELECT * FROM ".DBTABLE." WHERE id = ".ID) or die (mysql_errno());
				$datos = mysql_fetch_array($consulta);
				if (!defined('URL')) {
   				define ('URL', $datos['url']);
				}
				if (!defined('URL_BASE')) {
   				define ('URL_BASE', $datos['url_base']);
				}
				$nombre = $datos['nombre'];
				$resumen = $datos['resumen'];
				$software = stripslashes($datos['software']);
				$totales = unserialize(base64_decode($datos['totales']));
				$puntos = unserialize(stripslashes($datos['puntos']));
				$mis_puntos = unserialize(stripslashes($datos['mis_puntos']));
				$marcos = unserialize(base64_decode($datos['marcos']));
				$comentarios = unserialize(base64_decode($datos['comentarios']));
				$fecha = $datos['fecha'];
				$OK = (mysql_num_rows($consulta) == 0)? 0 : 1;
			break;
			case 'resumen':
				$consulta = @mysql_query("SELECT url, url_base, totales, mis_puntos, marcos, fecha FROM ".DBTABLE." WHERE id = ".ID) or die (mysql_errno());
				$datos = mysql_fetch_array($consulta);
				define ('URL', $datos['url']);
				define ('URL_BASE', $datos['url_base']);
				$totales = unserialize(base64_decode($datos['totales']));
				$mis_puntos = unserialize(stripslashes($datos['mis_puntos']));
				$marcos = unserialize(base64_decode($datos['marcos']));
				$fecha = $datos['fecha'];
			break;
			case 'ver':
				$consulta = @mysql_query("SELECT software, url, url_base, totales FROM ".DBTABLE." WHERE id = ".ID) or die (mysql_errno());
				$datos = mysql_fetch_array($consulta);
				define ('SOFT', $datos['software']);
				define ('URL', $datos['url']);
				define ('URL_BASE', $datos['url_base']);
				$totales = unserialize(base64_decode($datos['totales']));
			break;
			case 'informe';
				$consulta = @mysql_query("SELECT * FROM ".DBTABLE." WHERE id = ".ID) or die (mysql_errno());
				$datos = mysql_fetch_array($consulta);
				define ('URL', $datos['url']);
				$nombre = $datos['nombre'];
				$totales = unserialize(base64_decode($datos['totales']));
				$puntos = unserialize(stripslashes($datos['puntos']));
				$mis_puntos = unserialize(stripslashes($datos['mis_puntos']));
				$comentarios = unserialize(base64_decode($datos['comentarios']));
				$fecha = $datos['fecha'];
			break;
			case 'lista':
				$consulta = @mysql_query("SELECT id, url, resumen, revision, fecha FROM ".DBTABLE." ORDER BY id DESC LIMIT $cant") or die (mysql_errno());
			break;
		} // End switch
	} else if ($q == 'update') {
		foreach ($_POST as $k => $v) {
			if (strstr($k, '_')) {
				$k = str_replace('_', '', $k);
				if ($k{0} == 'c') {
					$x = substr($k, 1);
					$comentarios[$x] = trim(htmlspecialchars($v, ENT_QUOTES));
				} else if ($k{0} == 'r') {
					$x = substr($k, 1);
					$mis_puntos[$x] = $v;
				}
			}
		}

		$resumen = trim(htmlspecialchars($_POST['resumen'], ENT_QUOTES));
		$nombre = trim(htmlspecialchars($_POST['nombre'], ENT_QUOTES));
		$query = "UPDATE ".DBTABLE." SET
			nombre='".$nombre."',
			resumen='".$resumen."',
			mis_puntos='".serialize($mis_puntos)."',
			comentarios='".base64_encode(serialize($comentarios))."',
			revision = now() WHERE id=".ID;
		$guardar = @mysql_query($query);

		if ($guardar) {
			$mis_resultados = '<p class="dbbien"><strong>'.$lang['db_no_err'].'</strong><br /><br />';
			//$hasta = gmdate($lang['formato_fecha'], strtotime("now + 7 days"));
			#$mis_resultados .= 'Hasta el día '.gmdate('d/m/Y', strtotime("now + 7 days")).', usted podrá retomar su trabajo ingresando a:<br /><a href="http://www.sidar.org'.PHP_SELF.'?id='.ID.'">http://www.sidar.org'.PHP_SELF.'?id='.ID.'</a>.</p>';
			$mis_resultados .= 'Hasta el día '.gmdate('d/m/Y', strtotime("now + 7 days")).', usted podrá retomar su trabajo ingresando a:<br /><a href="'.WEBSITE.'?id='.ID.'">'.WEBSITE.'?id='.ID.'</a>.</p>';
			unset($_SESSION['ultimo_id']);
		} else {
			$mis_resultados = '<p class="dbmal"><strong>'.$lang['db_err'].'</strong></p>';
		}
	}
} // End function DB_Query

// Checkpoints arrays
$wcag1 = array(11 => '1.1', 12 => '1.2', 13 => '1.3', 14 => '1.4', 15 => '1.5', 21 => '2.1', 22 => '2.2', 31 => '3.1', 32 => '3.2', 33 => '3.3', 34 => '3.4', 35 => '3.5', 36 => '3.6', 37 => '3.7', 41 => '4.1', 42 => '4.2', 43 => '4.3', 51 => '5.1', 52 => '5.2', 53 => '5.3', 54 => '5.4', 55 => '5.5', 56 => '5.6', 61 => '6.1', 62 => '6.2', 63 => '6.3', 64 => '6.4', 65 => '6.5', 71 => '7.1', 72 => '7.2', 73 => '7.3', 74 => '7.4', 75 => '7.5', 81 => '8.1', 91 => '9.1', 92 => '9.2', 93 => '9.3', 94 => '9.4', 95 => '9.5', 101 => '10.1', 102 => '10.2', 103 => '10.3', 104 => '10.4', 105 => '10.5', 111 => '11.1', 112 => '11.2', 113 => '11.3', 114 => '11.4', 121 => '12.1',  122 => '12.2', 123 => '12.3', 124 => '12.4', 131 => '13.1', 132 => '13.2', 133 => '13.3', 134 => '13.4', 135 => '13.5', 136 => '13.6', 137 => '13.7', 138 => '13.8', 139 => '13.9', 1310 => '13.10', 141 => '14.1', 142 => '14.2', 143 => '14.3');
$lst_A = array(11, 12, 13, 14, 21, 41, 51, 52, 61, 62, 63, 71, 81, 91, 114, 121, 141);
$lst_AA = array(22, 31, 32, 33, 34, 35, 36, 37, 53, 54, 64, 65 , 72, 73, 74, 75, 92, 93, 101, 102, 111, 112, 122, 123, 124, 131, 132, 133, 134);
$lst_AAA = array(15, 42, 43, 55, 56, 94, 95, 103, 104, 105, 113, 135, 136, 137, 138, 139, 1310, 142, 143);

/*RGB begin*/
$emag2 = array(/*11 => '1.11',*/ 12 => '1.12', 14 => '1.22', 21 => '1.4', 22 => '1.5', 31 => '2.7', 32 => '2.1', 33 => '2.12', 34 => '2.2', 35 => '2.10', 36 => '.23', 37 => '2.8', 41 => '1.2', 42 => '3.2', 43 => '1.1', 52 => '1.14', 53 => '2.12', 54 => '2.13', 55 => '1.13', 56 => '3.2', 61 => '1.6', 62 => '1.15', 63 => '1.20', 64 => '1.19', 65 => '1.16', 71 => '1.7', 72 => '1.7', 73 => '12.3', 74 => '2.4', 75 => '2.5', 81 => '2.18', 92 => '2.18', 93 => '2.19', 94 => '1.8', 95 => '3.3', 101 => '2.6', 102 => '2.16', 104 => '2.14', 105 => '3.4', 112 => '3.1', 113 => '3.5', 114 => '1.24', 121 => '1.17',  122 => '1.18', 123 => '2.11', 124 => '2.15', 131 => '3.12', 132 => '3.14', 133 => '2.17', 134 => '1.10', 135 => '3.6', 136 => '3.7', 137 => '3.8', 138 => '3.9', 139 => '3.10', 1310 => '1.3', 141 => '1.9', 142 => '3.11', 143 => '2.9', 313 => '3.13', '111e' => '1.11', '121e' => '1.21');
$lst_Aemag = array(11, 12, 14, 21, 22, 41, 43, 52, 55, 61, 62, 63, 65, 71, 72, 73, 94, 114, 121, 122, 134, 1310, 141, '111e', '121e');
$lst_AAemag = array(32, 34, 36, 74, 75, 101, 31, 37, 143, 35, 123, 33, 53, 54, 104, 124, 102, 133, 81, 92, 93);
$lst_AAAemag = array(112, 42, 56, 95, 105, 113, 135, 136, 137, 138, 139, 142, 131, 132, 313);
/*RGB end*/

/*=====================================================
	Function: Make an absolute URI from a relative one  
=====================================================*/

function Absolute_URL($base, $url) {
	global $totales;
		@extract(parse_url($url));

	do {
		extract(parse_url($base), EXTR_PREFIX_ALL, "B");

		if (!isset($scheme)) { // Base scheme
			$scheme = $B_scheme;
		} else if ($scheme != $B_scheme) { // Not relative
			break;
		}

		if (isset($host) || isset($port)) { // Not relative
			break;
		}

		if (isset($B_host)) $host = $B_host; // Base host
		if (isset($B_port)) $port = $B_port; // Base port

		if (!isset($path)) { // Base path
			$path=$B_path;
			if (!isset($query) && isset($B_query)) { // Base query
				$query=$B_query;
			}
		} else if (!preg_match("@^/@", $path)) { // URI don't start with '/'
			$ppath = "";
			if (isset($B_path)) { // Base have path
				$ppath = $B_path;
				$ppath = preg_replace("@/[^/]*$@", "/", $ppath);
			} else {
				$ppath = "/";
			}
			$path = $ppath.$path;

			$oldpath = "";
			do {
				$oldpath = $path;
				$path = preg_replace('@/\./@','/',$path);
			} while($path != $oldpath);

			$path = preg_replace('@/\.$@', '/', $path);

			do {
				$oldpath = $path;
				$path = preg_replace('@/[^/]*/\.\./@','/',$path);}
			while($path != $oldpath);

			$path = preg_replace('@/[^/]/\.\.$@','/',$path);
			$path = preg_replace('@/\.\./@','/',$path);
   	}
	} while(0);

	if (!isset($path)) $path = '/';

	// Make URI
	if (isset($scheme)) { $url = "$scheme:"; }
	if (isset($host)) {
		$url .= "//$host";
		if (isset($port)) { $url .= ":$port"; }
	}
	if (isset($path)) $url .= $path;
	if (isset($query)) {
		if (!isset($path)) $url .= "/";
		$url .= "?$query";
	}
	if (isset($fragment)) $url .= "#$fragment";
	return $url;
} // End function Absolute_URL


function Info($pto, $res) {
	global $elem, $totales, $info, $lang;

	$total_prog = array (
			'script' => $totales['script'],
			'applet' => $totales['applet'],
			'embed' => $totales['embed'],
			'object' => $totales['object']
			);
	$nada = sprintf($info['nada'], strtolower($elem[$pto]));

	switch ($pto) {
		case 1:
			if ($res == 'chk') {
				$txt = '('.$lang['dd_alt_ico_man2'].')';
			} else if ($res == 'chked') {
				$txt = 'Verificación manual';
			}
		break;
		case 1101:
			if ($res=='mal') {
				$resta = $totales['img'] - $totales['alt_img'];
				$txt = sprintf($info['p1101_mal'], $resta);
				if ($totales['alt_img']) {
					$txt .= ' '.sprintf($info['p1101_mal2'], $totales['alt_img']);
				}
			} else if ($res=='duda') {
				$txt = sprintf($info['p1101_duda'], $totales['alt_img']);
			} else if ($res=='na') {
				$txt = $nada;
			}
		break;
		case 1102:
			if ($res=='mal') {
				$resta2 = $totales['input_image'] - $totales['alt_input'];
				$txt = sprintf($info['p1102_mal'], $resta2);
				if ($totales['alt_input']) {
					$txt .= ' '.sprintf($info['p1102_mal2'], $totales['alt_input']);
				}
			} else if ($res=='duda') {
				$txt = sprintf($info['p1102_duda'], $totales['alt_input']);
			} else if ($res=='na') {
				$txt = $nada;
			}
		break;
		case 1103:
			if ($res=='mal') {
				$resta3 = $totales['area'] - $totales['alt_area'];
				$txt = sprintf($info['p1103_mal'], $resta3);
				if ($totales['alt_area']) {
					$txt .= ' '.sprintf($info['p1103_mal2'], $totales['alt_area']);
				}
			} else if ($res=='duda') {
				$txt = sprintf($info['p1103_duda'], $totales['alt_area']);
			} else if ($res=='na') {
				$txt = $nada;
			}
		break;
		case 1104:
			if ($res=='duda') {
				if ($totales['noscript'] == 0) {
					$txt = sprintf($info['p1104_duda'], $totales['script_body']);
				} else {
					$txt = sprintf($info['p1104_duda2'], $totales['noscript'], $totales['script_body']);
				}
			} else if ($res=='na') {
				$txt = $info['p1104_na'];
			}
		break;
		case 1105:
			if ($res=='mal') {
				if ($totales['noembed'] == 0) {
					$cant5 = $info['p1105_malb'];
				} else if ($totales['noembed'] == 1) {
					$cant5 = $info['p1105_malc'];
				} else {
					$cant5 = sprintf($info['p1105_mald'], $totales['noembed']);
				}
				$txt = sprintf($info['p1105_mala'], $totales['embed']).' '.$cant5;
			} else if ($res=='duda') {
				$txt = sprintf($info['p1105_duda'], $totales['embed']);
			} else if ($res=='na') {
				$txt = $nada;
			}
		break;
		case 1106:
			if ($res=='duda') {
				$txt = sprintf($info['p1106_duda'], $totales['applet'], $totales['alt_applet']);
			} else if ($res=='na') {
				$txt = $nada;
			}
		break;
		case 1107:
			if ($res=='duda') {
				$txt = sprintf($info['p1107_duda'], $totales['object']);
			} else if ($res=='na') {
				$txt = $nada;
			}
		break;
		case 1108:
			if ($res=='duda') {
				$txt = sprintf($info['p1108_duda'], $totales['iframe']);
			} else if ($res=='na') {
				$txt = $nada;
			}
		break;
		case 1109:
			if ($res=='duda') {
				$txt = sprintf($info['p1109_duda'], $totales['hrefson']);
			} else if ($res=='na') {
				$txt = $info['p1109_na'];
			}
		break;
		case 1110:
			if ($res=='duda') {
				$txt = sprintf($info['p1110_duda'], $totales['hrefapp']);
			} else if ($res=='na') {
				$txt = $info['p1110_na'];
			}
		break;
		case 1111:
			if ($res=='duda') {
				$txt = $info['p1111_duda'];
			} else if ($res=='mal') {
				if ($totales['noframes'] > 0) {
					$txt = $info['p1111_mal'];
				} else {
					$txt = $info['p1111_mal2'];
				}
			} else if ($res=='na') {
				$txt = $nada;
			}
		break;
		case 12:
			if ($res=='duda') {
				$txt = sprintf($info['p12_duda'], $totales['ismap']);
			} else if ($res=='na') {
				$txt = $nada;
			}
		break;
		case 1301:
			if ($res=='duda') {
				$txt = sprintf($info['p1301_duda'], $totales['embed']);
			} else if ($res=='na') {
				$txt = $nada;
			}
		break;
		case 1302:
			if ($res=='duda') {
				$txt = sprintf($info['p1302_duda'], $totales['object']);
			} else if ($res=='na') {
				$txt = $nada;
			}
		break;
		case 1303:
			if ($res=='duda') {
				$txt = sprintf($info['p1303_duda'], $totales['hrefapp']);
			} else if ($res=='na') {
				$txt = $info['p1303_na'];
			}
		break;
		case 1401:
			if ($res=='duda') {
				$txt = sprintf($info['p1401_duda'], $totales['embed']);
			} else if ($res=='na') {
				$txt = $nada;
			}
		break;
		case 1402:
			if ($res=='duda') {
				$txt = sprintf($info['p1402_duda'], $totales['object']);
			} else if ($res=='na') {
				$txt = $nada;
			}
		break;
		case 1403:
			if ($res=='duda') {
				$txt = sprintf($info['p1403_duda'], $totales['hrefapp']);
			} else if ($res=='na') {
				$txt = $info['p1403_na'];
			}
		break;
		case 15:
			if ($res=='bien') {
				$txt = sprintf($info['p15_bien'], $totales['usemap'], $totales['area']);
			} else if ($res=='mal') {
				$txt = sprintf($info['p15_mal'], $totales['usemap'], $totales['area'], $totales['area_sin_red']);
			} else if ($res=='na') {
				$txt = $nada;
			}
		break;
		case 21:
			if ($res=='duda') {
				$txt = $info['p21_duda'];
			}
		break;
		case 22:
			if ($res=='duda') {
				$txt = $info['p22_duda'];
			}
		break;
		case 31:
			if ($res=='bien') {
				$txt = $info['p31_bien'];
			} else if ($res=='duda') {
				$txt = $info['p31_duda'];
			}
		break;
		case 3201:
			if ($res=='bien') {
				$txt = sprintf($info['p3201_bien'], $totales['dtd_version']);
			} else if ($res=='mal') {
				if ($totales['!doctype'] == 1) {
					$txt = sprintf($info['p3201_mal'], $totales['dtd_version']);
				} else if ($totales['!doctype'] > 1) {
					$txt = sprintf($info['p3201_mal2'], $totales['!doctype']);
				} else {
					$txt = $info['p3201_mal3'];
				}
			} else if ($res=='duda') {
				$txt = sprintf($info['p3201_duda'], $totales['dtd']);
			}
		break;
		case 3202:
			if ($res=='bien') {
				$txt = $info['p3202_bien'];
			} else if ($res=='mal') {
				$txt = $info['p3202_mal'];
			} else if ($res=='duda') {
				$txt = $info['p3202_duda'];
			} else if ($res=='na') {
				$txt = $nada;
			}
		break;
		case 3301:
			if ($res=='mal') {
				$txt = $info['p3301_mal'];
			} else if ($res=='duda') {
				$txt = $info['p3301_duda'];
			} else if ($res=='bien') {
				if ($totales['hay_estilos'] == 1) {
					$txt = $info['p3301_bien'];
				} else {
					$txt = $info['p3301_bien2'];
				}
			}
		break;
		case 3302:
			$presentacion = $totales['b'] + $totales['center'] + $totales['font'] + $totales['i'] + $totales['s'] + $totales['strike'] + $totales['u'];
			if ($res=='mal') {
				$txt = sprintf($info['p3302_mal'], intval($presentacion));
			} else if ($res=='bien') {
				$txt = $info['p3302_bien'];
			}
		break;
		case 3303:
			if ($res=='mal') {
				$txt = sprintf($info['p3303_mal'], $totales['attr_pres']);
			} else if ($res=='bien') {
				$txt = $info['p3303_bien'];
			}
		break;
		case 3401:
			if ($res=='duda') {
				if ($totales['table'] > 0) {
					$txt = $info['p3401_duda'];
				}
				$txt .= ' '.$info['p3401_duda2'];
			} else if ($res=='mal') {
				$txt = $info['p3401_mal'];
			}
		break;
		case 3402:
			if ($res=='mal') {
				$txt = $info['p3402_mal'];
			} else if ($res=='bien') {
				$txt = $info['p3402_bien'];
			}
		break;
		case 35:
			if ($res=='duda') {
				if($totales['h1'] == 0) {
					$txt = $info['p35_duda'];
				}
				if($totales['horden'] > 0) {
					$txt .= ' '.$info['p35_duda2'];
				}
			} else if ($res=='bien') {
				$txt = $info['p35_bien'];
			} else if ($res=='mal') {
				$txt = $info['p35_mal'];
			}
		break;
		case 36:
			if ($res=='mal') {
				$txt = $info['p36_mal'];
			} else if ($res=='duda') {
				if ($totales['ol']>0) { $lst = sprintf($info['p36_lia'], $totales['ol']).' '; }
				if ($totales['ul']>0) { $lst .= sprintf($info['p36_lib'], $totales['ul']).' '; }
				if ($totales['dl']>0) { $lst .= sprintf($info['p36_lic'], $totales['dl']); }
				if ($lst != '') {
					$txt = sprintf($info['p36_duda'], trim($lst));
				} else {
					$txt = $nada;
				}
				$txt .= ' '.$info['p36_duda2'];
			}
		break;
		case 37:
			if ($res=='duda') {
				if ($totales['q'] + $totales['blockquote'] > 0) {
					$txt = $info['p37_duda'];
				} else {
					$txt = $info['p37_duda2'];
				}
				$txt .= ' '.$info['p37_duda3'];
			}
		break;
		case 41:
			if ($totales['attr_lang'] > 0) {
				$textoi = sprintf($info['p41_duda2'], $totales['attr_lang']);
			}
			if ($res=='duda') {
				$txt = $info['p41_duda'].' '.$textoi.' '.$info['p41_duda3'];
			}
		break;
		case 42:
			if ($res=='duda') {
					$cant = $totales['abbr'] + $totales['acronym'];
				if ($cant > 0) {
					$textoa = sprintf($info['p42_duda2'], $cant);
				}
				$txt = $info['p42_duda'].' '.$textoa.' '.$info['p42_duda3'];
			}
		break;
		case 43:
			if ($res=='bien') {
				if (stristr($totales['!doctype'],'XHTML 1.1')) {
					$cod = $totales['lang_xml'];
				} else {
					$cod = $totales['lang_pri'];
				}
				$txt = sprintf($info['p43_bien'], $cod);
			} else if ($res=='mal') {
				if (!$totales['lang_pri']) {
					$txt = $info['p43_mal'];
				} else {
					if (($totales['xhtml'] > 0) && (!$totales['lang_xml'])) {
						$txt = sprintf($info['p43_mal2'], $totales['lang_pri']);
					} else if (($totales['lang_xml']) && ($totales['lang_xml'] != $totales['lang_pri'])) {
						$txt = $info['p43_mal3'];
					}
				}
			}
		break;
		case 51:
			if ($res=='duda') {
				$txt = sprintf($info['p51_duda'], $totales['table'], $totales['td']);
				if ($totales['th'] > 0) {
					$txt .= ' '.sprintf($info['p51_duda2'], $totales['th']);
				} else {
					$txt .= ' '.$info['p51_duda3'];
				}
			} else if ($res=='na') {
				$txt = $nada;
			}
		break;
		case 52:
			if ($res=='duda') {
				$tab = $info['p52_duda3'];
				if ($totales['th'] > 0) {
					$txt = sprintf($info['p52_duda'], $totales['table']);
					if ($totales['cell_asoc'] > 1) {
						$txt .= ' '.$info['p52_duda2'];
					} else {
						$txt .= ' '.$tab;
					}
				} else {
					$txt = sprintf($info['p52_duda4'], $totales['table']).' '.$tab;
				}
			} else if ($res=='na') {
				$txt = $nada;
			}
		break;
		case 53:
			if ($res=='duda') {
				$txt = $info['p53_duda'];
			} else if ($res=='bien') {
				$txt = $nada;
			}
		break;
		case 54:
			if ($res=='duda') {
				$txt = $info['p54_duda'];
			} else if ($res=='bien') {
				$txt = sprintf($info['p54_bien'], $totales['table']);
			} else if ($res=='na') {
				$txt = $nada;
			}
		break;
		case 55:
			if ($res=='duda') {
				if ($totales['th'] > 0) {
					if ($totales['summary'] > 0) {
						$txt = sprintf($info['p55_duda'], $totales['table'], $totales['summary']);
					}
				} else {
					if (!$totales['summary']) {
						$txt = sprintf($info['p55_duda2'], $totales['table']);
					}
				}
			} else if ($res=='mal') {
				if ($totales['th'] > 0) {
					if (!$totales['summary']) {
						$txt = sprintf($info['p55_mal'], $totales['table']);
					}
				} else {
					if ($totales['summary'] > 0) {
						$txt = sprintf($info['p55_mal2'], $totales['table'], $totales['summary']);
					}
				}
			} else if ($res=='na') {
				$txt = sprintf($info['nada'], strtolower($elem[103]));
			}
		break;
		case 56:
			if ($res=='duda') {
				if ($totales['th_abbr']) {
					$txt = sprintf($info['p56_duda'], $totales['th_abbr']);
				} else {
					$txt = $info['p56_duda2'];
				}
				$txt .= ' '.$info['p56_duda3'];
			} else if ($res=='na') {
				$txt = $info['p56_na'];
			}
		break;
		case 61:
			if ($res=='duda') {
				$txt = $info['p61_duda'];
			} else if ($res=='na') {
				$txt = $nada;
			}
		break;
		case 6201:
			if ($res=='duda') {
				$txt = $info['p6201_duda'];
			} else if ($res=='na') {
				$txt = $nada;
			}
		break;
		case 6202:
			if ($res=='mal') {
				$txt = sprintf($info['p6202_mal'], $totales['img_en_frame']);
			} else if ($res=='duda') {
				$txt = $info['p6202_duda'];
			} else if ($res=='na') {
				$txt = $nada;
			}
		break;
		case 6301:
			if ($res=='mal') {
				$txt = sprintf($info['p6301_mal'], $totales['href_javascript']);
			} else if ($res=='duda') {
				$txt = $info['p6301_duda'];
			} else if ($res=='na') {
				$txt = $nada;
			}
		break;
		case 6302:
			if ($res=='duda') {
				$txt = sprintf($info['p6302_duda'], $totales['script']);
			} else if ($res=='na') {
				$txt = $nada;
			}
		break;
		case 6303:
			if ($res=='duda') {
				$txt = sprintf($info['p6303_duda'], $totales['embed'], $totales['object']);
			} else if ($res=='na') {
				$txt = $nada;
			}
		break;
		case 6304:
			if ($res=='duda') {
				$txt = sprintf($info['p6304_duda'], $totales['applet']);
			} else if ($res=='na') {
				$txt = $nada;
			}
		break;
		case 64:
			if ($res=='bien') {
				$txt = $info['p64_bien'];
			} else if ($res=='mal') {
				$txt = $info['p64_mal'];
			} else if ($res=='duda') {
				$txt = $info['p64_duda'];
			} else if ($res=='na') {
				$txt = $nada;
			}
		break;
		case 6501:
			if ($res=='duda') {
				$txt = sprintf($info['p6501_duda'], $totales['script']);
			} else if ($res=='na') {
				$txt = $nada;
			}
		break;
		case 6502:
			if ($res=='duda') {
				$txt = $info['p6502_duda'];
			} else if ($res=='mal') {
				if ($totales['noframes'] > 0) {
					$txt = $info['p6502_mal'];
				} else {
					$txt = $info['p6502_mal2'];
				}
			} else if ($res=='na') {
				$txt = $nada;
			}
		break;
		case 71:
			if ($res=='duda') {
				$txt = $info['p71_duda'];
				foreach($total_prog as $k => $v) {
					if ($v > 0) {
						$txt .= ' ('.$k.': '.$v.')';
					}
				}
			} else if ($res=='bien') {
				$txt = $info['p71_bien'];
			}
		break;
		case 72:
			if ($res=='duda') {
				$txt = $info['p72_duda'];
				foreach($total_prog as $k => $v) {
					if ($v > 0) {
						$txt .= ' ('.$k.': '.$v.')';
					}
				}
			} else if ($res=='mal') {
				$txt = $info['p72_mal'];
			} else if ($res=='bien') {
				$txt = $info['p72_bien'];
			}
		break;
		case 73:
			if ($res=='duda') {
				$txt = $info['p73_duda'];
				foreach($total_prog as $k => $v) {
					if ($v > 0) {
						$txt .= ' ('.$k.': '.$v.') ';
					}
				}
			} else if ($res=='mal') {
				$txt = $info['p73_mal'];
			} else if ($res=='bien') {
				$txt = $info['p73_bien'];
			}
		break;
		case 7401:
			if ($res=='mal') {
				$txt = $info['p7401_mal'];
			} else if ($res=='bien') {
				if ($totales['refresh'] > 0) {
					$txt = $info['p7401_bien'];
				} else {
					$txt = $info['p7401_bien2'];
				}
			}
		break;
		case 7402:
			if ($res=='bien') {
				$txt = $info['p7402_bien'];
			} else if ($res=='duda') {
				$txt = $info['p7402_duda'];
			}
		break;
		case 7501:
			if ($res=='mal') {
				$txt = $info['p7501_mal'];
			} else if ($res=='bien') {
				if ($totales['redirect'] > 0) {
					$txt = $info['p7501_bien'];
				} else {
					$txt = $info['p7501_bien2'];
				}
			}
		break;
		case 7502:
			if ($res=='bien') {
				$txt = $info['p7502_bien'];
			} else if ($res=='duda') {
				$txt = $info['p7502_duda'];
			}
		break;
		case 8101:
			if ($res=='bien') {
				$txt = $info['p8101_bien'];
			} else if ($res=='mal') {
				$txt = $info['p8101_mal'];
			} else if ($res=='duda') {
				$txt = $info['p8101_duda'];
			} else if ($res=='na') {
				$txt = $nada;
			}
		break;
		case 8102:
			if ($res=='duda') {
				$txt = sprintf($info['p8102_duda'], $totales['embed']);
			} else if ($res=='na') {
				$txt = $nada;
			}
		break;
		case 8103:
			if ($res=='duda') {
				$txt = sprintf($info['p8103_duda'], $totales['applet']);
			} else if ($res=='na') {
				$txt = $nada;
			}
		break;
		case 8104:
			if ($res=='duda') {
				$txt = sprintf($info['p8104_duda'], $totales['object']);
			} else if ($res=='na') {
				$txt = $nada;
			}
		break;
		case 91:
			if ($res=='mal') {
				$txt = sprintf($info['p91_mal'], $totales['ismap']);
			} else if ($res=='bien') {
				$txt = sprintf($info['p91_bien'], $totales['usemap']);
			} else if ($res=='na') {
				$txt = $nada;
			}
		break;
		case 9201:
			if ($res=='duda') {
				$txt = sprintf($info['p9201_duda'], $totales['ismap']);
			} else if ($res=='na') {
				$txt = $nada;
			}
		break;
		case 9202:
			if ($res=='duda') {
				$txt = $info['p9202_duda'];
				foreach($total_prog as $k => $v) {
					if (($k != 'script') && ($v > 0)) {
						$txt .= ' ('.$k.': '.$v.')';
					}
				}
			} else if ($res=='na') {
				$txt = $nada;
			}
		break;
		case 93:
			if ($res=='bien') {
				$txt = $info['p93_bien'];
			} else if ($res=='mal') {
				$txt = $info['p93_mal'];
			} else if ($res=='na') {
				$txt = $nada;
			}
		break;
		case 94:
			if ($res=='duda') {
				if ($totales['attr_tabindex'] > 0) {
					$txt = sprintf($info['p94_duda'], $totales['attr_tabindex']);
				} else {
					$txt = $info['p94_duda2'];
				}
				$txt .= ' '.$info['p94_duda3'];
			}
		break;
		case 95:
			if ($res=='bien') {
				$txt = sprintf($info['p95_bien'], $totales['attr_accesskey']);
			} else if ($res=='mal') {
				$txt = $info['p95_mal'];
			}
		break;
		case 10101:
			if ($res=='bien') {
				$txt = $info['p10101_bien'];
			} else if ($res=='duda') {
				$txt = sprintf($info['p10101_duda'], $totales['attr_target']);
			}
		break;
		case 10102:
			if ($res=='bien') {
				$txt = $info['p10102_bien'];
			} else if ($res=='duda') {
				$txt = $info['p10102_duda'];
			}
		break;
		case 102:
			$form_label = $totales['input_label'] + $totales['select'] + $totales['textarea'];
			if ($res=='mal') {
				$txt = sprintf($info['p102_mal'], $form_label);
				if ($totales['label'] > 0) {
					$txt .= ' '.sprintf($info['p102_mal2'], $totales['label']);
				} else {
					$txt .= ' '.$info['p102_mal3'];
				}
			} else if ($res=='duda') {
				$txt = sprintf($info['p102_duda'], $form_label, $totales['label']);
			} else if ($res=='na') {
				$txt = $info['p102_bien'];
			}
		break;
		case 103:
			if ($res=='duda') {
				$txt = $info['p103_duda'];
			} else if ($res=='na') {
				$txt = $nada;
			}
		break;
		case 104:
			if ($res=='bien') {
				$txt = $info['p104_bien'];
			} else if ($res=='mal') {
				$txt = sprintf($info['p104_mal'], $totales['input_vacio']);
			} else if ($res=='na') {
				$txt = $info['p104_na'];
			}
		break;
		case 105:
			if ($res=='bien') {
				$txt = $info['p105_bien'];
			} else if ($res=='mal') {
				$txt = sprintf($info['p105_mal'], $totales['a_adya']);
			} else if ($res=='na') {
				$txt = $info['p105_na'];
			}
		break;
		case 111:
			if ($res=='mal') {
				if ($totales['dtd_vieja'] > 0) {
					$txt = sprintf($info['p111_mal'], $totales['dtd']);
				}
				if ($totales['!doctype'] == 0) {
					$txt .= ' '.$info['p111_mal2'];
				}
				if ($totales['applet'] + $totales['embed'] + $totales['blink'] + $totales['marquee'] + $totales['flash'] > 0) {
					$txt .= ' '.$info['p111_mal3'];
				}
			} else if ($res=='duda') {
				if ($totales['dtd_nueva'] > 0) {
					$txt = $info['p111_duda'];
				}
				if ($totales['hay_estilos'] > 0) {
					$txt .= ' '.$info['p111_duda2'];
				}
				$txt .= ' '.$info['p111_duda3'];
			}
		break;
		case 11201:
			if ($res=='bien') {
				$txt = $info['p11201_bien'];
			} else if ($res=='mal') {
				$txt = sprintf($info['p11201_mal'], $totales['elem_deprec']);
			}
		break;
		case 11202:
			if ($res=='bien') {
				$txt = $info['p11202_bien'];
			} else if ($res=='mal') {
				$txt = sprintf($info['p11202_mal'], $totales['attr_deprec']);
			}
		break;
		case 113:
			if ($res=='duda') {
				$txt = $info['p113_duda'];
			}
		break;
		case 114:
			if ($res=='duda') {
				$txt = $info['p114_duda'];
			}
		break;
		case 121:
			if ($res=='mal') {
				if ($totales['titulo_frame'] > 0) {
					if ($totales['frame'] > $totales['titulo_frame']) {
						$txt = $info['p121_mal'];
					}
				} else {
					$txt = $info['p121_mal2'];
				}
			} else if ($res=='duda') {
				$txt = $info['p121_duda'];
			} else if ($res=='na') {
				$txt = $nada;
			}
		break;
		case 122:
			if ($res=='mal') {
				$txt = $info['p122_mal'];
			} else if ($res=='duda') {
				$txt = $info['p122_duda'];
				if ($totales['longdesc_frame'] > 0) {
					$txt .= ' '.sprintf($info['p122_duda2'], $totales['longdesc_frame']);
				} else {
					$txt .= ' '.$info['p122_duda3'];
				}
			} else if ($res=='na') {
				$txt = $nada;
			}
		break;
		case 123:
			if ($res=='mal') {
				$txt = $info['p123_mal'];
			} else if ($res=='duda') {
				$txt = $info['p123_duda'];
			}
		break;
		case 124:
			$form_label = $totales['input_label'] + $totales['select'] + $totales['textarea'];
			if ($res=='mal') {
				if ($form_label > $totales['label']) {
					if ($totales['label'] > 0) {
						$txt = $info['p124_mal'];
					} else {
						$txt = $info['p124_mal2'];
					}
				} else {
					if ($totales['label'] > $totales['attr_for']) {
						$txt = $info['p124_mal3'];
					} else {
						foreach ($totales['for_id'] as $f) {
							if (!in_array($f, $totales['id_for'])) {
								$txt = $info['p124_mal4'];
							}
						}
					}
				}
			} else if ($res=='duda') {
				$txt = sprintf($info['p124_duda'], $form_label, $totales['label']);
			} else if ($res=='na') {
				$txt = $info['p124_na'];
			}
		break;
		case 131:
			if ($res=='duda') {
				$txt = $info['p131_duda'];
			} else if ($res=='na') {
				$txt = $nada;
			}
		break;
		case 132:
			if ($res=='duda') {
				$txt = $info['p132_duda'];
			}
		break;
		case 133:
			if ($res=='duda') {
				$txt = $info['p133_duda'];
			}
		break;
		case 134:
			if ($res=='duda') {
				$txt = $info['p134_duda'];
			}
		break;
		case 135:
			if ($res=='duda') {
				$txt = $info['p135_duda'];
			}
		break;
		case 136:
			if ($res=='duda') {
				$txt = $info['p136_duda'];
			}
		break;
		case 137:
			if ($res=='duda') {
				$txt = $info['p137_duda'];
			}
		break;
		case 138:
			if ($res=='duda') {
				$txt = $info['p138_duda'];
			}
		break;
		case 139:
			if ($res=='duda') {
				$txt = $info['p139_duda'];
				if ($totales['link_rel'] > 0) {
					$txt .= ' '.sprintf($info['p139_duda2'], $totales['link_rel']);
				}
			}
		break;
		case 1310:
			if ($res=='duda') {
				$txt = $info['p1310_duda'];
			}
		break;
		case 141:
			if ($res=='duda') {
				$txt = $info['p141_duda'];
			}
		break;
		case 142:
			if ($res=='duda') {
				$txt = $info['p142_duda'];
			}
		break;
		case 143:
			if ($res=='duda') {
				$txt = $info['p143_duda'];
			}
		break;
		//eMag cases
		case 313:
			if ($res=='duda') {
				$txt = $info['p313_duda'];
			} else if ($res=='na') {
				$txt = $nada;
			}
		break;
		
		case '11101e':
			if ($res=='mal') {
				$resta = $totales['img'] - $totales['alt_img'];
				$txt = sprintf($info['p11101e_mal'], $resta);
				if ($totales['alt_img']) {
					$txt .= ' '.sprintf($info['p11101e_mal2'], $totales['alt_img']);
				}
			} else if ($res=='duda') {
				$txt = sprintf($info['p11101e_duda'], $totales['alt_img']);
			} else if ($res=='na') {
				$txt = $nada;
			}
		break;
		case '11102e':
			if ($res=='mal') {
				$resta2 = $totales['input_image'] - $totales['alt_input'];
				$txt = sprintf($info['p11102e_mal'], $resta2);
				if ($totales['alt_input']) {
					$txt .= ' '.sprintf($info['p11102e_mal2'], $totales['alt_input']);
				}
			} else if ($res=='duda') {
				$txt = sprintf($info['p11102e_duda'], $totales['alt_input']);
			} else if ($res=='na') {
				$txt = $nada;
			}
		break;
		case '11103e':
			if ($res=='mal') {
				$resta3 = $totales['area'] - $totales['alt_area'];
				$txt = sprintf($info['p11103e_mal'], $resta3);
				if ($totales['alt_area']) {
					$txt .= ' '.sprintf($info['p11103e_mal2'], $totales['alt_area']);
				}
			} else if ($res=='duda') {
				$txt = sprintf($info['p11103e_duda'], $totales['alt_area']);
			} else if ($res=='na') {
				$txt = $nada;
			}
		break;
		case '12101e':
			if ($res=='duda') {
				if ($totales['noscript'] == 0) {
					$txt = sprintf($info['p12101e_duda'], $totales['script_body']);
				} else {
					$txt = sprintf($info['p12101e_duda2'], $totales['noscript'], $totales['script_body']);
				}
			} else if ($res=='na') {
				$txt = $info['p12101e_na'];
			}
		break;
		case '12102e':
			if ($res=='mal') {
				if ($totales['noembed'] == 0) {
					$cant5 = $info['p12102e_malb'];
				} else if ($totales['noembed'] == 1) {
					$cant5 = $info['p12102e_malc'];
				} else {
					$cant5 = sprintf($info['p12102e_mald'], $totales['noembed']);
				}
				$txt = sprintf($info['p12102e_mala'], $totales['embed']).' '.$cant5;
			} else if ($res=='duda') {
				$txt = sprintf($info['p12102e_duda'], $totales['embed']);
			} else if ($res=='na') {
				$txt = $nada;
			}
		break;
		case '12103e':
			if ($res=='duda') {
				$txt = sprintf($info['p12103e_duda'], $totales['applet'], $totales['alt_applet']);
			} else if ($res=='na') {
				$txt = $nada;
			}
		break;
		case '11104e':
			if ($res=='duda') {
				$txt = sprintf($info['p11104e_duda'], $totales['object']);
			} else if ($res=='na') {
				$txt = $nada;
			}
		break;
		case '12104e':
			if ($res=='duda') {
				$txt = sprintf($info['p12104e_duda'], $totales['object']);
			} else if ($res=='na') {
				$txt = $nada;
			}
		break;
		case '12105e':
			if ($res=='duda') {
				$txt = sprintf($info['p12105e_duda'], $totales['hrefson']);
			} else if ($res=='na') {
				$txt = $info['p12105e_na'];
			}
		break;
		case '12106e':
			if ($res=='duda') {
				$txt = sprintf($info['p12106e_duda'], $totales['hrefapp']);
			} else if ($res=='na') {
				$txt = $info['p12106e_na'];
			}
		break;
	} // End switch

	return $txt;

} // End function Info()

/*======================
	Function: Get time   
======================*/

	function Get_MTime() {
		list($usec, $sec) = explode(" ", microtime());
		return ((float)$usec + (float)$sec);
	}
function cleanStr(&$str){
	$patron="@([^a-zA-Z0-9&:\/\.])@i";
	if(is_string($str)) $str = htmlspecialchars(preg_replace($patron, '', $str));
	else if(is_array($str)){
		while(list($c,$v)=each($str)){cleanStr($str[$c]);}
		reset($str);
	}
}
function cleanAll(){
	if(!empty($_REQUEST)) cleanStr($_REQUEST);
	if(!empty($_POST)) cleanStr($_POST);
	if(!empty($_GET)) cleanStr($_GET);
}



/*RGB begin*/
function changeVariables()
{
		global $mis_puntos, $puntos, $wcag1, $lst_A, $lst_AA, $lst_AAA;
		global $emag2, $lst_Aemag, $lst_AAemag, $lst_AAAemag, $wcagToEmag;
		global $wcag, $emag;
		
		/*Mudando as variaveis de prioridades*/
		if (isset($_SESSION['choose']))
		{
			if($_SESSION['choose'] == "emag")
			{
				$wcag1 = $emag2;
				$lst_A = $lst_Aemag;
				$lst_AA = $lst_AAemag;
				$lst_AAA = $lst_AAAemag;
				$mis_puntos_original = $mis_puntos;
				$puntos_original = $puntos;
				$wcag = array();
				$mis_puntos = array();
				$puntos = array();
				
				/*Alocando novas variaveis*/
				foreach($mis_puntos_original as $bak => $conteudo)
				{
					/*vericando tabela de mapeamento*/
					if (isset($wcagToEmag[$bak]))
					{
						/*verificando se existe um mapeamento valido*/
						if($wcagToEmag[$bak] != 0)
						{
							$wcag[$bak] = $emag[$wcagToEmag[$bak]];
							$mis_puntos[$bak] = $conteudo;
						}
					}
				}
				
				foreach($puntos_original as $bak => $conteudo)
				{
					/*vericando tabela de mapeamento*/
					if (isset($wcagToEmag[$bak]))
					{
						/*verificando se existe um mapeamento valido*/
						if($wcagToEmag[$bak] != 0)
							$puntos[$bak] = $conteudo;
					}
				}
			}
		}
}
/*RGB end*/
?>