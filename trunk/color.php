<?php
//ini_set("display_errors","1");
error_reporting(E_ERROR | /*E_WARNING |*/ E_PARSE);
//ini_set('error_reporting', E_ALL)

define ('IDIOMA', 'pt');
require_once('inc/config.php');
require_once('inc/common.php');

cleanAll();
if ($_REQUEST['lng']) {
	define ('IDIOMA', $_REQUEST['lng']);
} else {
	define ('IDIOMA', 'es');
}
require_once('lang/'.IDIOMA.'/lang.php');

if ($_REQUEST['url']) {
	$pagina = $_REQUEST['url'];
} elseif ($_REQUEST['calcular']) {
	$pagina = $_REQUEST['url_form'];
} else {
	$pagina = 'http://';
}

if ($_REQUEST['url'] || $_REQUEST['calcular']) {
	$miga = '<a href="'.PHP_SELF.'">'.$lang['color_title'].'</a> &raquo; '.$lang['color_title2'];
	$titulo = $lang['color_title2'];
	$ayuda = '<span style="float:right"><a href="'.PHP_SELF.'#hlp" title="'.$lang['ico_tit_man2'].'"><img src="img/helpno.gif" class="pag" alt="'.$lang['ico_alt_man'].'" /></a></span>';
} else {
	$miga = '<a href="http://www.sidar.org/hera/">Hera 2.1 Beta</a>';
	$titulo = $lang['color_title'];
	$ayuda = '';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?php echo IDIOMA; ?>" xml:lang="<?php echo IDIOMA; ?>">

<head>
<title>HERA - <?php echo $titulo; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="estilos.css" type="text/css" rel="stylesheet" />
<link rel="icon" href="img/favicon.ico" type="image/x-icon" />
<style type="text/css">
	div#color { font-family: sans-serif; font-size: 90%; margin: 8px 3% 0px 3%; }
	img, a img { border: none; }
	img.px { width: 20px; height: 20px; }
	img.ico { width: 12px; height: 12px; }
	div#color a { border-right: 2px solid #000;
	border-bottom: 2px solid #000;
	border-left: 2px solid #fff;
	text-decoration: none; }
	h2, h3 { font-size: 1em; font-variant: normal;border-top: 1px solid #9cf; }
	h3 { padding-top: 1em;  }
	div#col { width: 29%; float: left; text-align: center; }
	div#bg { width: 29%; float: right; text-align: center; }
	div#cont { text-align: center; margin: 0px 30%; }
	div#muestra { border: 1px solid #ccc; }
	p.combo { padding:0.5em; border: 1px solid #ccc; margin: 0px; width: 30%; float: left; text-align: center; }
</style>
<script language="javascript" type="text/javascript">
function micolor(esto, que) {
	if (document.layers) {
	clr = document.esto.value;
	} else {
	clr = document.getElementById(esto).value;
	}
	cambia(clr, esto, que);
}

function cambia(color, esto, que) {
  var changeCell; 
  var changeText;
  if (document.layers) { 
	changeCell = "document.muestra.style." + que + "='#" + color + "'";
	changeText = "document.esto.value='" + color + "'";
  } else { 
    changeCell = "document.getElementById('muestra').style." + que + "='#" + color + "'";
	changeText = "document.getElementById(esto).value='" + color + "'";
  } 
  eval(changeCell);
  eval(changeText);
} 

</script>
</head>

<body>
<div id="cabecera">
<div id="top"><?php echo $miga; ?></div>
<div style="position:absolute;right:4px;top:4px"><a href="http://www.sidar.org/hera/" title="<?php echo $lang['logo_tit']; ?>"><img src="http://www.sidar.org/hera/img/hera.gif" width="95" height="70" alt="<?php echo $lang['logo_alt']; ?>" /></a></div>

<form action="<?php echo PHP_SELF; ?>" method="post">
<h1><?php echo $titulo; ?></h1>
<p class="pagina"><label for="url"><?php echo $lang['frm_url']; ?>: 
<input type="text" name="url" id="url" value="<?php echo $pagina; ?>" size="60" />
</label> 
<input type="submit" name="btns" id="btns" value="<?php echo $lang['frm_boton']; ?>" /> <a name="inicio" id="inicio"></a></p>
</form>
</div>
<p class="menu" style="color:#900;font-size:80%;"><?php echo $ayuda.' '.$lang['color_aviso']; ?></p>
<div id="color">
<?php
if ($_REQUEST['url'] || $_REQUEST['calcular']) {
if ($_REQUEST['url']) {
	$color = array('000000', '7F007F', '0000C0');
	$bg = array('FFFFFF');
	
	require('inc/file.php');
	$url_tmp = trim($_REQUEST['url']);
	$File = new File($url_tmp, $_SERVER['HTTP_USER_AGENT']);
	if ($File->fetch($File->uri_real, 'base', 'arry')) {
		Get_File($File->results);
	} else {
		$resultado = ' <p class="centro">'.ucfirst($lang['file_error']).'</p>';
	}

	$array_color = array();
	$array_bg = array();

	foreach ($color as $k => $v) {
		$x = strtoupper(Limpiar_array($v));
		if ($x != '') { $array_color[] = $x; }
		//$array_color[] = strtoupper(Limpiar_array($v));
	}
	foreach ($bg as $k => $v) {
		$x = strtoupper(Limpiar_array($v));
		if ($x != '') { $array_bg[] = $x; }
		//$array_bg[] = strtoupper(Limpiar_array($v));
	}
	$array_color = array_unique($array_color);
	$array_bg = array_unique($array_bg);
	sort($array_color);
	sort($array_bg);
	$color_form = base64_encode(serialize($array_color));
	$bg_form = base64_encode(serialize($array_bg));
	$url_form = $pagina;
	$color1 = '000000';
	$color2 = 'FFFFFF';
	
	$pares = array();

	foreach ($combo as $k => $c) {
		$x = strtoupper(Limpiar_array($c[0]));
		$y = strtoupper(Limpiar_array($c[1]));
		$prueba = $x.'/'.$y;
		if ((!in_array($prueba, $pares)) && ($x != $y)) {
			$pares[] = $prueba;
			//$muestra_pares .= '<p class="combo" style="background:#'.$x.'; color:#'.$y.'">Primer plano: #'.$y.' / Fondo: #'.$x.'</p>'."\n";
		}
	}
	sort($pares);
	$pares_form = base64_encode(serialize($pares));
	
	$muestra_pares = '<h3>'.$lang['color_combos'].'</h3>';
	foreach ($pares as $p) {
		$partes = explode('/', $p);
		$muestra_pares .= '<p class="combo" style="background:#'.$partes[0].'; color:#'.$partes[1].'">#'.$partes[1].' / #'.$partes[0].'</p>'."\n";
	}
	
	} elseif ($_REQUEST['calcular']) {
	
		$color_form = $_REQUEST['color_form'];
		$bg_form = $_REQUEST['bg_form'];
		$url_form = $_REQUEST['url_form'];
		$pares_form = $_REQUEST['pares_form'];
		
		$array_color = unserialize(base64_decode($color_form));
		$array_bg = unserialize(base64_decode($bg_form));
		$color1 = strtoupper($_REQUEST['color1']);
		$color2 = strtoupper($_REQUEST['color2']);
		
		if (preg_match("@[0-9A-F]{6}@i", $color1) && preg_match("@[0-9A-F]{6}@i", $color2)) {
			
		$r1 = hexdec(substr($color1, 0, 2));
		$g1 = hexdec(substr($color1, 2, 2));
		$b1 = hexdec(substr($color1, 4, 2));
		
		$r2 = hexdec(substr($color2, 0, 2));
		$g2 = hexdec(substr($color2, 2, 2));
		$b2 = hexdec(substr($color2, 4, 2));
		
		$brillo1 = (($r1 * 299) + ($g1 * 587) + ($b1 * 114)) / 1000;
		$brillo2 = (($r2 * 299) + ($g2 * 587) + ($b2 * 114)) / 1000;
		$difbrillo = abs(round($brillo1 - $brillo2, 0));
		if ($difbrillo < 126) {
			$brillo = 'mal';
		} else {
			$brillo = 'bien';
		}

		$difcolor = (max($r1, $r2) - min($r1, $r2)) + (max($g1, $g2) - min($g1, $g2)) + (max($b1, $b2) - min($b1, $b2));
		if ($difcolor < 500) {
			$color = 'mal';
		} else {
			$color = 'bien';
		}

		$resultado = ' <p class="centro"><img src="img/'.$brillo.'.gif" alt="'.ucfirst($brillo).'" class="ico" /> ';
		$resultado .= sprintf($lang['color_dif'], $difbrillo);
		$resultado .= '<br /><img src="img/'.$color.'.gif" alt="'.ucfirst($color).'" class="ico" /> ';
		$resultado .= sprintf($lang['color_dif2'], $difcolor).'</p>';
	} else {
		$resultado = ' <p style="color:#c00; text-align:center">'.$lang['color_err'].'</p>';
	}
	
	$array_pares = unserialize(base64_decode($pares_form));
	$muestra_pares = '<h3>'.$lang['color_combos'].'</h3>';
	foreach ($array_pares as $p) {
		$partes = explode('/', $p);
		$muestra_pares .= '<p class="combo" style="background:#'.$partes[0].'; color:#'.$partes[1].'">#'.$partes[1].' / #'.$partes[0].'</p>'."\n";
	}
	
	} // Fin else if

	
	echo $resultado;
	echo ' <form action="'.PHP_SELF.'" method="post"> ';

	echo '<div id="col"><h2>'.$lang['color_h2a'].'</h2><p>'."\n";
	
	foreach ($array_color as $k => $v) {
		echo '<a style="background-color:#'.$v.'" title="#'.$v.'" href="'.PHP_SELF.'" onclick="cambia(\''.$v.'\', \'color1\', \'color\');return false;" onkeypress="cambia(\''.$v.'\', \'color1\', \'color\');return false;">';
		echo '<img src="img/px.gif" alt="#'.$v.'" class="px" />';
		echo "</a>\n";
	}
	echo '</p><p>'.$lang['color_cambio'].':';
	echo ' #<input type="text" name="color1" id="color1" maxlength="6" size="8" value="'.$color1.'" onblur="micolor(\'color1\', \'color\')" />';
	echo ' <button type="button"><img src="img/duda.gif" alt="'.$lang['color_cambio'].'" class="ico" /></button></p>'."\n</div>\n";
	
	echo '<div id="bg"><h2>'.$lang['color_h2b'].'</h2><p>'."\n";
	
	foreach ($array_bg as $k => $v) {
		echo '<a style="background-color:#'.$v.'" title="#'.$v.'" href="'.PHP_SELF.'" onClick="cambia(\''.$v.'\', \'color2\', \'background\');return false;" onKeyPress="cambiabg(\''.$v.'\', \'color2\', \'background\');return false;">';
		echo '<img src="img/px.gif" alt="#'.$v.'" class="px" />';
		echo "</a>\n";
	}
	echo '</p><p>'.$lang['color_cambio'].':';
	echo ' #<input type="text" name="color2" id="color2" maxlength="6" size="8" value="'.$color2.'" onblur="micolor(\'color2\', \'background\')" /> ';
echo ' <button type="button"><img src="img/duda.gif" alt="'.$lang['color_cambio'].'" class="ico" /></button></p>'."\n</div>\n";

echo '<div id="cont"><h2>'.$lang['color_h2c'].'</h2>'."\n";
echo '<div id="muestra" name="muestra" style="color:#'.$color1.';background:#'.$color2.';">';
echo '<p style="padding: 1.5em 0em 2em 0em;"><span style="font-size: 2em;">HERA</span><br /> <span style="font-size: 1.5em">Revisando la Accesibilidad con Estilo</span><br /> <span style="font-size: 1em">(SIDAR)</span></p></div>'."\n</div>\n";

	echo '<p style="text-align:center; clear: both"><input type="hidden" name="color_form" value="'.$color_form.'" />';
	echo '<input type="hidden" name="bg_form" value="'.$bg_form.'" />';
	echo '<input type="hidden" name="url_form" value="'.$url_form.'" />';
	echo '<input type="hidden" name="pares_form" value="'.$pares_form.'" />';
	echo '<input type="submit" name="calcular" id="calcular" value="Comprobar" />';
	echo '</p></form>';
	
}

function Limpiar_array($esto) {
	$search = array ("@#@", "@BLACK@i", "@WHITE@i", "@MAROON@i", "@GREEN@i", "@OLIVE@i", "@NAVY@i", "@PURPLE@i", "@TEAL@i", "@SILVER@i", "@GRAY@i", "@RED@i", "@LIME@i", "@YELLOW@i", "@BLUE@i", "@FUCHSIA@i", "@AQUA@i");
	$replace = array ("", "000000", "FFFFFF", "800000", "008000", "808000", "000080", "800080", "008080", "C0C0C0", "808080", "FF0000", "00FF00", "FFFF00", "0000FF", "FF00FF", "00FFFF");
	$esto = preg_replace($search,$replace,$esto);
	if (strlen($esto) == 3) {
		$r = substr($esto, 0, 1);
		$g = substr($esto, 1, 1);
		$b = substr($esto, 2, 1);
		return $r.$r.$g.$g.$b.$b;
	} else {
		return $esto;
	}
}


function Get_File($fp) {
	global $color, $bg, $cssext, $cssimport, $cssinc, $combo;

	$cssinc = '';
	preg_match_all("@<style[^>]*>(.*)</style>@ismU", $fp, $css, PREG_PATTERN_ORDER);
	for ($i=0; $i < count($css[0]); $i++) {
		$cssinc .= $css[1][$i];
	}

	$cssinc = Limpiar($cssinc);

	$cssext = array();
	if (preg_match_all("/@import[\s]*[url]?[\(]?[\"\']?([^\s\'\"\)\;]+)/i", $cssinc, $imp)) {
		for ($i=0; $i< count($imp[0]); $i++) {
			$cssext[] = Absolute_URL(URL_BASE,$imp[1][$i]);
		}
	}

	$cssinline = '';
	preg_match_all("@<([^>]+)>@sm", $fp, $tagi, PREG_PATTERN_ORDER);
	for ($i=0; $i < count($tagi[0]); $i++) {
		if (preg_match("@style[\s]*=[\s]*[\"\']?([^\"\'\/\>]*)@ism",$tagi[1][$i],$est)) {
			$cssinline .= ' {'.$est[1].'}';
		}
		if (preg_match("@link(.*)rel=[\"\']?(.*)stylesheet@i",$tagi[1][$i])) {
			preg_match("@href[\s]*=[\s]*([\"\'])? (?(1) (.*?)\\1 | ([^\s\/\>]+))@ismx",$tagi[1][$i],$outlk);
			$cssext[] = Absolute_URL(URL_BASE,$outlk[2]);
		}

		if (preg_match("@(BODY|TABLE|TD|TH)(.*)(bgcolor|background)[\s]*=[\s]*[\"\']?([^\"\'\s\/\>]+\#[0-9A-F]{1,6}|Black|Maroon|Green|Olive|Navy|Purple|Teal|Silver|Gray|Red|Lime|Yellow|Blue|Fuchsia|Aqua|White)@ism",$tagi[1][$i], $back)) {
			if (trim($back[4]) != '') { $bg[] = $back[4]; }
		}

		if (preg_match("@(BASEFONT|FONT)(.*)(color)[\s]*=[\s]*([\"\'])? (?(1) (.*?)\\4 | ([^\s\/\>]+))@ismx",$tagi[1][$i], $clr)) {
			if (trim($clr[5]) != '') { $color[] = $clr[5]; }
		}

		if (preg_match("@(BODY)(.*)(text)[\s]*=[\s]*([\"\'])? (?(1) (.*?)\\4 | ([^\s\/\>]+))@ismx",$tagi[1][$i], $clra)) {
			if (trim($clra[5]) != '') { $color[] = $clra[5]; }
		}
		if (preg_match("@(BODY)(.*)([\s]+link)[\s]*=[\s]*([\"\'])? (?(1) (.*?)\\4 | ([^\s\/\>]+))@ismx",$tagi[1][$i], $clrc)) {
			if (trim($clrc[5]) != '') { $color[] = $clrc[5]; }
		}
		if (preg_match("@(BODY)(.*)(alink)[\s]*=[\s]*([\"\'])? (?(1) (.*?)\\4 | ([^\s\/\>]+))@ismx",$tagi[1][$i], $clrb)) {
			if (trim($clrb[5]) != '') { $color[] = $clrb[5]; }
		}
		if (preg_match("@(BODY)(.*)(vlink)[\s]*=[\s]*([\"\'])? (?(1) (.*?)\\4 | ([^\s\/\>]+))@ismx",$tagi[1][$i], $clrd)) {
			if (trim($clrd[5]) != '') { $color[] = $clrd[5]; }
		}
		
		
	}

	$cssinc .= Limpiar($cssinline);

	$cssimport = array();

	foreach ($cssext as $k => $v) {
		$csstmp = '';
		$file = @fopen($v, "r");
		if ($file) {
			while (!feof($file)) {
				$csstmp .= stripslashes(fread($file, 8192));
			}
			fclose($file);
			$csstmp = Limpiar($csstmp);
			if (preg_match_all("/@import[\s]*(url)?[\(]?[\"\']?([^\s\'\"\)\;]+)/i", $csstmp, $imp)) {
			//if (preg_match_all("/@import[\s]*(url)?([\(\"\'])? (?(1) (.*?)\\2 | ([^\s\>\)]+))/ix", $csstmp, $imp)) {
				$sep = explode("/",$v);
				$saca = array_pop($sep);
				$basetmp = rtrim($v,$saca);
				for ($i=0; $i< count($imp[0]); $i++) {
					$cssimport[] = Absolute_URL($basetmp,$imp[2][$i]);
				}
			}
			$cssinc .= $csstmp;
		}
	} // Fin foreach
	
	foreach ($cssimport as $k => $v) {
		$csstmp2 = '';
		$file = @fopen($v, "r");
		if ($file) {
			while (!feof($file)) {
				$csstmp2 .= stripslashes(fread($file, 8192));
			}
			fclose($file);
			$csstmp2 = Limpiar($csstmp2);
			$cssinc .= $csstmp2;
		}
	} // Fin foreach


	$combo = array();
	preg_match_all("@\{[^\}]*\}@smU", $cssinc, $reglas);
	for ($i=0; $i< count($reglas[0]); $i++) {
	//echo $reglas[0][$i]."\n";
		preg_match ("@([^\:]background(-color)?)+[\s]*\:[\s]*(\#[0-9A-F]{1,6}|Black|Maroon|Green|Olive|Navy|Purple|Teal|Silver|Gray|Red|Lime|Yellow|Blue|Fuchsia|Aqua|White)[\s]*[\;\}]+@ism", $reglas[0][$i], $colb);
			if (!in_array($colb[3], $bg)) {
				$bg[] = $colb[3];
			}
			//echo $colb[3];
		preg_match ("@([^\:\-]color)+[\s]*\:[\s]*(\#[0-9A-F]{1,6}|Black|Maroon|Green|Olive|Navy|Purple|Teal|Silver|Gray|Red|Lime|Yellow|Blue|Fuchsia|Aqua|White)[\s]*[\;\}]+@ism", $reglas[0][$i], $colo);
				if (!in_array($colo[2], $color)) {
					$color[] = $colo[2];
				}
				if (($colb[3] != '') && ($colo[2] != '')) {
					$combo[$i][0] = $colb[3];
					$combo[$i][1] = $colo[2];
				}
	} // Fin de for
	
	
} // Fin función Get_File

function Limpiar($esto) {
	$esto = preg_replace( "@\s\s+@", " ", $esto);
	//$esto = preg_replace("|/\*[\d\D]*?\*/|sU","",$esto);
	$esto = preg_replace("@\/\*[^*]*\*+([^/*][^*]*\*+)*\/@smU","",$esto);
	return $esto;
}

/*function Absolute_URL($base, $url) {
	global $totales;

		@extract(parse_url($url));

	do {
		extract(parse_url($base), EXTR_PREFIX_ALL, "B");

		if (!isset($scheme)) { // Scheme de base
			$scheme = $B_scheme;
		} elseif ($scheme != $B_scheme) { // No es relativo
			break;
		}

		if (isset($host) || isset($port)) { // No es relativo
			break;
		}

		if (isset($B_host)) $host = $B_host; // Host de base
		if (isset($B_port)) $port = $B_port; // Port de base

		if (!isset($path)) { // Path de base
			$path=$B_path;
			if (!isset($query) && isset($B_query)) { // Query de base
				$query=$B_query;
			}
		} elseif (!preg_match("@^/@", $path)) { // url no comienza con '/'
			$ppath = "";
			if (isset($B_path)) { // Si base tiene path
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
				$path = preg_replace('@/[^/]/\.\./@','/',$path);} //changed
			while($path != $oldpath);

			$path = preg_replace('@/[^/]/\.\.$@','/',$path);
			$path = preg_replace('@/\.\./@','/',$path);
   	}
	} while(0);

	if (!isset($path)) $path = '/';

	// Construir url
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
}*/
?>
<?php echo (count($pares) > 0)? $muestra_pares : ''; ?>

<h2 style="clear:both"><a name="hlp" id="hlp" style="border:none"></a><?php echo $lang['color_ayuda']; ?></h2>
<p><?php echo $lang['color_p_a']; ?></p>
<p><?php echo $lang['color_p_b']; ?></p>
<p><?php echo $lang['color_p_c']; ?></p>
<p><?php echo $lang['color_p_d']; ?></p>
<p><?php echo $lang['color_p_e']; ?></p>
</div>

<p class="derecha"><a href="<?php echo PHP_SELF; ?>#inicio" title="<?php echo $lang['ico_tit_pie']; ?>"><img src="img/subir.gif" width="32" height="32" alt="<?php echo $lang['ico_alt_pie']; ?>" /></a></p>

<div class="divpie"><div style="float:left;"><a href="http://www.sidar.org/">
<img src="img/minilogosidar.gif" width="70" height="40" alt="<?php echo $lang['ico_alt_logo']; ?>" /></a></div>
<p><a href="http://www.sidar.org/legal/2003/copy.php">Copyright &copy; Sidar 2003-2005</a> <br />
<?php echo $lang['por']; ?> <a href="http://www.sidar.org/que/ge/cb.php" style="font:menu">Carlos Benavídez</a></p></div>
</body>
</html>