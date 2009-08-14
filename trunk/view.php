<?php
/*================================
  HERA v.2.0 Beta                 
  File: view.php                  
  Show the reviewed pag           
================================*/

/*RGB begin*/
//ini_set("display_errors","1");
error_reporting(E_ERROR | /*E_WARNING |*/ E_PARSE);
//ini_set('error_reporting', E_ALL);

define ('IDIOMA', 'pt');

$tags = array();
/*RGB end*/

require('inc/config.php');
require('inc/file.php');
require('inc/common.php');
require('inc/parse.php');
cleanAll();
define ('OPTION', $_REQUEST['opt']);
define ('ID', $_REQUEST['id']);
define ('IDIOMA', $_REQUEST['lng']);
if ($_REQUEST['pto']) {
	define ('QUE', $_REQUEST['pto']);
}
require('lang/'.IDIOMA.'/view.php');
require('lang/'.IDIOMA.'/elem.php');
require('lang/'.IDIOMA.'/lang.php');

DB_Query('select', 'ver');
$File = new File(URL, SOFT);

if (OPTION == 'code') {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?php echo IDIOMA; ?>" xml:lang="<?php echo IDIOMA; ?>">
<head>
	<title>HERA - <?php echo $lang['view_tit_cod']; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="estilos.css" type="text/css" rel="stylesheet" />
<link rel="icon" href="<?php echo WEBSITE; ?>img/favicon.ico" type="image/x-icon" />
<script type="text/javascript" src="display.js"></script>
</head>
<body id="codigo">
<div id="codtop">
<h1><img src="<?php echo WEBSITE; ?>img/minihera.gif" width="60" height="45" alt="<?php echo $lang['logo_alt']; ?>" style="float:right" /> HERA - 
<?php
	if (!defined('QUE')) {
		echo $lang['view_tit_cod'];
		echo '</h1><p class="pagina">'.$lang['frm_url'].' <strong>'.URL.'</strong></p></div> ';
		echo '<div id="cajacod">'."\n";
		$File->fetch(URL, '', '');
		$lines = preg_split("@[\n\r]{1}@", $File->results);
		echo "<ol>\n";
		foreach ($lines as $num => $line) {
			echo "<li>&nbsp;".htmlspecialchars($line)."</li>\n";
		}
		echo "</ol>\n</div>\n";
	} else { // Revisar algo

		function Add($este_tag, $mode=3, $res=DUDA, $txt='', $code=0, $in=0) {
			global $tag, $lang;
			if (($mode==1) || ($mode==4)) {
				$tag = $res.$este_tag;
			} else if (($mode==2) || ($mode==5)) {
				$tag = $este_tag.'[[[/span]]]';
			} else {
				$tag = $res.$este_tag.'[[[/span]]]';
			}
		} // Fin función Add

		if (!$File->fetch(URL, '', 'arry')) {
			exit(ucfirst($lang['file_error']));
		}
		$icoa = '[[[img src=¶'.WEBSITE.'img/';
		$icob = ' class=¶ico¶ /]]] ';
		define("BIEN", $icoa.'bien.gif¶ alt=¶'.ucfirst($lang['result_pass']).'¶'.$icob."[[[span class=¶bien¶]]]");
		define("MAL", $icoa.'mal.gif¶ alt=¶'.ucfirst($lang['result_fail']).'¶'.$icob."[[[span class=¶mal¶]]]");
		define("DUDA", $icoa.'duda.gif¶ alt=¶'.ucfirst($lang['result_notTested']).'¶'.$icob."[[[span class=¶duda¶]]]");
		define("DUDABIS", $icoa.'duda.gif¶ alt=¶'.ucfirst($lang['result_notTested']).'¶'.$icob."[[[span class=¶dudabis¶]]]");

		echo sprintf($lang['view_rev_que'], $elem[QUE]);
		echo '</h1><p class="pagina">'.$lang['frm_url'].' <strong>'.URL.'</strong></p></div> ';
		echo '<hr /><p style="margin: 1em 4%">';
		echo '<a href="view.php?id='.ID.'&amp;pto='.QUE.'&amp;lng='.IDIOMA.'&amp;opt=page" title="'.$lang['dd_tit_page'].'"><img src="img/verpag.gif" alt="'.$lang['dd_alt_page'].'" class="veren" style="float:left;padding:6px;margin:4px;background:#fff;border-top: 1px solid #000;border-left: 1px solid #000;" /></a>';
		echo $view[QUE].'</p>';
		echo '<div id="topcod">'."\n";
		$body = 0;

		foreach ($tags as $key => $tag) {
			preg_match("@<([\/\?\!]*[\w]+)@i", $tag, $el);
			$elemen = strtolower($el[1]);

			if (preg_match("@<body[^>]*>@i",$tag)) {$body = 1;}
			if ($elemen != 'a') {
				$cierre_a = 0;
			}

			Modificar();

			if ($tag{1} != '/') { echo "<br />\n"; }
			$tag =  htmlspecialchars($tag);
			$tag = str_replace("[[[", "<", $tag);
			$tag = str_replace("]]]", ">", $tag);
			$tag = str_replace("¶", '"', $tag);
			if (ereg("<",$tag)) {
				echo $tag;
			} else {
				echo '<code>'.$tag.'</code>';
			}

			switch ($elemen) {
				case '/a':
					$enl = preg_replace('@&nbsp;@','',$contents[$key]);
					if (trim($enl) == '') {
						$cierre_a = 1;
					}
					echo $contents[$key];
				break;
				case 'script':
				case 'style':
					$conten = ereg_replace("\n","<br />", $contents[$key]);
					echo $conten;
				break;
				default:
					echo $contents[$key];
				break;
			} // Fin switch

		} // Fin de FOR
		echo "\n</div>\n";
		echo '<script type="text/javascript">Aviso();</script>'."\n";
		echo "</body>\n</html>\n";

	} // Fin If code/QUE


} else if (OPTION == 'page') {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?php echo IDIOMA; ?>" xml:lang="<?php echo IDIOMA; ?>">
<head>
	<title>HERA: <?php echo sprintf($lang['view_rev_que'], $elem[QUE]); ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="<?php echo WEBSITE; ?>superhera.css" type="text/css" rel="stylesheet" />
<link rel="icon" href="<?php echo WEBSITE; ?>img/favicon.ico" type="image/x-icon" />
<style type="text/css">
body {
	font-family : verdana, sans-serif;
	margin: 0px;
	padding: 0px;
	background-color: #fff;
	color: #000;
	font-size : 0.9em;
}
h1 {
	font-weight: bold;
	font-variant: small-caps;
	font-size: 150%;
	text-align: left;
	margin-left: 5%;
}
dl { margin: 1em 5%; }
dl dt { color: #900; font: menu; margin-top: 1.5em;}
dt span { color: #999; }
dt strong { color: #000; font-family : verdana, sans-serif; }
dl dd { color: #00f; font: menu; margin-left: 0px; padding-left: 1em; }
.duda { color: #000; background-color: #eef9ff; }
.mal { color: #000; background-color: #ffeef6; }
img.ico { width: 12px; height: 12px; }
</style>
</head>
<body>

<?php

function Add($este_tag,$mode=3,$res=DUDA,$txt='',$code=0,$in=0) {
	global $tag;
	if ($code == 0) {
		switch ($mode) {
			case 1:
				if ($in == 0) {
					$tag = $res.$txt.$este_tag;
				} else {
					$tag = $este_tag.$res.$txt;
				}
			break;
			case 2:
				if ($in == 0) {
					$tag = $este_tag.'</div>';
				} else {
					$tag = '</div>'.$este_tag;
				}
			break;
			case 3:
				$tag = $res.$txt.$este_tag.'</div>';
			break;
			case 4:
				$tag = $res.htmlspecialchars($este_tag).'<br />';
			break;
			case 5:
				$tag = '<br />'.htmlspecialchars($este_tag).'</div>';
			break;
			case 6:
				$tag = $res.htmlspecialchars($este_tag).'</div>';
			break;
			case 7:
				$tag = $res.$txt.'</div>'.$este_tag;
			break;
		} // Fin switch
	} // Fin if
} // Fin function

	$quitar_estilos = $_REQUEST['sincss'];

	if (!$File->fetch(URL, '', 'arry')) {
		exit(ucfirst($lang['file_error']));
	}

	$basex = '<base href="'.URL_BASE.'" />';
	$hojaestilo = '';

	$icocss = '<a href="'.WEBSITE.'view.php?id='.ID.'&amp;pto='.QUE.'&amp;lng='.IDIOMA.'&amp;opt=code" title="'.$lang['dd_tit_code'].'"><img src="'.WEBSITE.'img/vercod.gif" alt="'.$lang['dd_alt_code'].'" id="heracodeimg" /></a> ';

	if ($quitar_estilos == 1) {
		$icocss .= '<a href="'.WEBSITE.'view.php?id='.ID.'&amp;pto='.QUE.'&amp;lng='.IDIOMA.'&amp;opt=page" title="'.$lang['view_tit_concss'].'" id="heracssa"><img src="'.WEBSITE.'img/concss.gif" alt="'.$lang['view_alt_concss'].'" id="heracssimg" /></a>';
	} else {
		$icocss .= '<a href="'.WEBSITE.'view.php?id='.ID.'&amp;pto='.QUE.'&amp;lng='.IDIOMA.'&amp;opt=page&amp;sincss=1" title="'.$lang['view_tit_sincss'].'" id="heracssa"><img src="'.WEBSITE.'img/sincss.gif" alt="'.$lang['view_alt_sincss'].'" id="heracssimg" /></a>';
	}

	$icoa = '<img src="'.WEBSITE.'img/';
	$icob = ' class="sidarico" /> ';
	define("BIEN", '<div class="sidarbien">'.$icoa.'bien.gif" alt="'.ucfirst($lang['result_pass']).'"'.$icob);
	define("MAL", '<div class="sidarmal">'.$icoa.'mal.gif" alt="'.ucfirst($lang['result_fail']).'"'.$icob);
	define("DUDA", '<div class="sidarduda">'.$icoa.'duda.gif" alt="'.ucfirst($lang['result_notTested']).'"'.$icob);
	define("DUDABIS", '<div class="sidardudabis">'.$icoa.'duda.gif" alt="'.ucfirst($lang['result_notTested']).'"'.$icob);
	$body = 0;
	$frameset = 0;
	$heradiv = '<div id="heradiv"><span id="icons">'.$icocss.'</span> '.$view[QUE]."\n</div>";
	$herahead = '';
	$hojaestilohera = '<link href="'.WEBSITE.'superhera.css" rel="stylesheet" type="text/css" id="sidar" />'."\n".'<link rel="shortcut icon" href="'.WEBSITE.'img/favicon.ico" type="image/x-icon" />'."\n".'<script type="text/javascript" src="'.WEBSITE.'display.js"></script>'."\n";
	if (QUE != 131) {
		foreach ($tags as $key => $tag) {
			preg_match("@<([\/\?\!]*[\w]+)@i", $tag, $el);
			$elemen = strtolower($el[1]);
			if ($elemen == 'base') {
				$base_exist = 1;
			}
			if ($quitar_estilos == 1) {
				$tag = preg_replace("@style[\s]*=@i", "st=", $tag);
			}
			if ($elemen != 'a') {
				$cierre_a = 0;
			}
			Modificar();

			switch ($elemen) {
				case '?xml':
					if (stristr($tag,"utf-8")) {
						$utf = 1;
					}
					echo "\n".$tag;
				break;
				case '/a':
					$enl = preg_replace('@&nbsp;@','',$contents[$key]);
					if (trim($enl) == '') {
						$cierre_a = 1;
					}
					echo "\n".$tag;
				break;
				case 'base':
					echo "\n".$tag;
					if (!stristr($tag,"href=")) {
						echo "\n".$basex;
					}
				break;
				case 'head':
					echo "\n".$tag;
					if ($base_exist == 0) {
						echo "\n".$basex;
						$base_exist = 1;
					}
				break;
				case '/head':
					if ($hojaestilo != '') {
						echo "\n<style type=\"text/css\">\n".$hojaestilo."</style>";
					}
					echo "\n".$hojaestilohera."\n".$tag;
				break;
				case 'body':
					$body = 1;
					if ($frameset == 0) {
						if ($base_exist == 0) {
							echo "\n".$basex;
						}
						if ($utf == 1) {
							$herahead = utf8_encode($herahead);
						}
						echo "\n".$tag."\n";
						echo '<script type="text/javascript">Aviso();</script>'."\n";
						if ($herahead != '') {
							echo $herahead.'</div>';
						}
					}
				break;
				case '/body':
					if ($frameset == 0) {
						if ($utf == 1) {
							$heradiv = utf8_encode($heradiv);
						}
						echo "\n".$heradiv;
						echo "\n".$tag;
						$final = 1;
					}
				break;
				case '/html':
					if ($final != 1) {
						if ($utf == 1) {
							$heradiv = utf8_encode($heradiv);
						}
						echo "\n".$heradiv."\n".$tag;
						$final = 1;
					} else {
						echo "\n".$tag;
					}
				break;
				case 'style':
					if ($quitar_estilos == 1) {
						echo '';
						$contents[$key] = '';
					} else {
						echo $tag;
						$contents[$key] = html_entity_decode($contents[$key], ENT_QUOTES);
					}
				break;
				case 'link':
					if ($quitar_estilos == 1) {
						echo '';
					} else {
						echo "\n".$tag;
					}
				break;
				case 'meta':
					if (stristr($tag,"utf-8")) {
						$utf = 1;
					}
					if (preg_match("@http-equiv=[\"\']?refresh@i",$tag)) {
						echo "\n<!-- (Desactivado) ".$tag." -->";
					} else {
						echo "\n".$tag;
					}
				break;
				case 'frameset':
				case '/frameset':
					echo '';
					$frameset = 1;
				break;
				case 'frame':
					if (stristr($tag,"<div ")) {
						echo $tag;
					} else {
						echo '<div>'.htmlspecialchars($tag).'</div>';
					}
				break;
				case 'noframes':
				case 'noscript':
				case 'noembed':
					if (stristr($tag,"<div ")) {
						echo $tag;
					} else {
						echo '<div>('.$elemen.')<br />';
					}
					$contents[$key] = preg_replace('@<(\/)?body[^>]*>@i','',$contents[$key]);
				break;
				case '/noframes':
				case '/noscript':
				case '/noembed':
					if (stristr($tag,"</div>")) {
						echo $tag;
					} else {
						echo '<br />('.$elemen.')</div>';
					}
				break;
				case 'script':
					echo "\n".$tag;
					$contents[$key] = html_entity_decode($contents[$key], ENT_QUOTES);
				break;
				case 'title':
					echo "\n".$tag;
					$contents[$key] = 'HERA - '.sprintf($lang['view_rev_que'], $elem[QUE]);
					if ($utf == 1) {
						$contents[$key] = utf8_encode($contents[$key]);
					}
				break;
				default:
					echo "\n".$tag;
				break;
			} // Fin switch

			echo $contents[$key];
		} // Fin de foreach

		if ($final != 1) {
			if ($utf == 1) {
				$heradiv = utf8_encode($heradiv);
			}
			echo $heradiv;
		}

	} else { // Punto 13.1
?>
<div id="heradiv"><span id="icons">
<a href="<?php echo WEBSITE; ?>view.php?id=<?php echo ID; ?>&amp;pto=<?php echo QUE; ?>&amp;lng=<?php echo IDIOMA; ?>&amp;opt=code" title="<?php echo $lang['dd_tit_code'] ?>"><img src="<?php echo WEBSITE; ?>img/vercod.gif" alt="<?php echo $lang['dd_alt_code']; ?>" id="heracodeimg" /></a>
</span> <?php echo $view['p_131']; ?></div>
<h1><?php echo $elem['131']; ?></h1>
<dl>
<?php
		$enlace = array();
		$texto = array();
		$a = 0;
		foreach ($tags as $key => $tag) {
			preg_match("@<([\/\?\!]*[\w]+)@i", $tag, $el);
			$elemen = strtolower($el[1]);

			if ($elemen == 'a') {
				if (preg_match("@href=([\"\'])? (?(1) (.*?)\\1 | ([^\s\>]+))@ix",$tag,$temp)) {
					$enlace[$a] = Absolute_URL(URL_BASE,$temp[2]);
					if (preg_match("@title=([\"\'])? (?(1) (.*?)\\1 | ([^\s\>]+))@ix",$tag,$tit)) {
						$texto[$a] .= "<span>(title=&quot;".$tit[2]."&quot;)</span> ";
					}
					if (trim($contents[$key]) != '') {
						$texto[$a] .= '<strong>'.$contents[$key].'</strong> ';
					}
					$aabierto = 1;
				}
			} else if ($elemen == '/a') {
				if ($aabierto == 1) {
					$aabierto = 0;
					$a++;
				}
			} else {
				if ($aabierto == 1) {
					if (stristr($tag," alt=") || stristr($tag," title=")) {
						$texto[$a] .= ' &lt;'.$elemen.' ';
						if (preg_match("@ alt=[\"\']?([^\"\'\>]*)@i",$tag,$alt)) {
							$texto[$a] .= 'alt=&quot;'.$alt[1].'&quot; ';
						}
						if (preg_match("@ title=[\"\']?([^\"\'\>]*)@i",$tag,$tit)) {
							$texto[$a] .= 'title=&quot;'.$tit[1].'&quot; ';
						}
						$texto[$a] .= '&gt; ';
					}
					if (trim($contents[$key]) != '') {
						$texto[$a] .= '<strong>'.$contents[$key].'</strong> ';
					}
				}
			}
		} // Fin foreach

		natcasesort($texto);

		foreach ($texto as $k => $v) {
			if (trim($v) == '') {
				$dt = '<dt class="mal"><img src="'.WEBSITE.'img/mal.gif" alt="Incorrecto." class="ico" /> ';
				$dd = '<dd class="mal">';
			} else if ($anterior == $v) {
				if ($refer != $enlace[$k]) {
					$dt = '<dt class="mal"><img src="'.WEBSITE.'img/mal.gif" alt="'.ucfirst($lang['result_fail']).'" class="ico" /> ';
					$dd = '<dd class="mal">';
				} else {
					$dt = '<dt class="duda"><img src="'.WEBSITE.'img/duda.gif" alt="'.ucfirst($lang['result_notTested']).'" class="ico" /> ';
					$dd = '<dd class="duda">';
				}
			} else {
				$dt = '<dt>';
				$dd = '<dd>';
			}
			echo $dt.$v."</dt>\n";
			echo $dd.$enlace[$k]."</dd>\n\n";
			$anterior = $v;
			$refer = $enlace[$k];
		}
		echo "</dl>\n";
		echo '<embed src="'.WEBSITE.'img/sonido.wav" hidden="true" loop="false" width="1" height="1"></embed>'."\n";
		echo "</body>\n</html>\n";
	} // Fin 13.1
} // Fin If principal

function Modificar() {
	global $tag, $puntos, $contents, $key, $body, $aabierto, $totales, $herahead, $h1, $h2, $h3, $h4, $h5, $h6, $hojaestilo, $cierre_a, $lang;

	if ($puntos[111] == 'bien') {
		$res_111 = BIEN;
	} else if ($puntos[111] == 'duda') {
		$res_111 = DUDA;
	} else {
		$res_111 = MAL;
	}

switch (QUE) {

case 1101:
if (stristr($tag,"<img")) {
	if (stristr($tag,"alt=")) {
		Add($tag,3,DUDA,htmlspecialchars($tag).'<br />');
	} else {
		Add($tag,3,MAL,htmlspecialchars($tag).'<br />');
	}
}
break;

case 1102:
if (preg_match("@<input .*type=['|\"]?image[^>]*>@i", $tag)) {
	if (stristr($tag,"alt=")) {
		Add($tag,3,DUDA,htmlspecialchars($tag).'<br />');
	} else {
		Add($tag,3,MAL,htmlspecialchars($tag).'<br />');
	}
}
break;

case 1103:
if (stristr($tag,"<area")) {
	if (stristr($tag,"alt=")) {
		Add($tag,6,DUDA);
	} else {
		Add($tag,6,MAL);
	}
}
if (stristr($tag," usemap")) {
	Add($tag,3,DUDA,$lang['view_usemap'].'<br />');
}
break;

case 1104:
if ($body == 1) {
	if (stristr($tag,"<script")) {
		Add($tag,1,DUDA,htmlspecialchars($tag));
	}
	if (stristr($tag,"</script")) {
		Add($tag,2);
	}
	if (stristr($tag,"<noscript")) {
		Add($tag,4,DUDABIS);
	}
	if (stristr($tag,"</noscript")) {
		Add($tag,5);
	}
}
break;

case 1105:
	if (stristr($tag,"<embed")) {
		Add($tag,1,DUDA,htmlspecialchars($tag).'<br />');
	}
	if (stristr($tag,"</embed")) {
		Add($tag,2);
	}
	if (stristr($tag,"<noembed")) {
		Add($tag,4,DUDABIS);
	}
	if (stristr($tag,"</noembed")) {
		Add($tag,2);
	}
break;

case 1106:
case 8103:
	if (stristr($tag,"<applet")) {
		Add($tag,1,DUDA,htmlspecialchars($tag).'<br />');
	}
	if (stristr($tag,"</applet")) {
		Add($tag,2);
	}
break;

case 1107:
case 1302:
case 1402:
case 8104:
	if (stristr($tag,"<object")) {
		Add($tag,1,DUDA,htmlspecialchars($tag).'<br />');
	}
	if (stristr($tag,"</object")) {
		Add($tag,2);
	}
break;

case 1108:
	if (stristr($tag,"<iframe")) {
		Add($tag,1,DUDA,htmlspecialchars($tag).'<br />');
	}
	if (stristr($tag,"</iframe")) {
		Add($tag,2);
	}
break;

case 1109:
case 1110:
case 1303:
case 1403:
if (stristr($tag,"<a ")) {
	preg_match("@href=([\"\'])? (?(1) (.*?)\\1 | ([^\s\>]+))@ix",$tag,$outa);
	if (QUE == 1109) {
		if (preg_match("@\.(aif|aifc|aiff|au|m3u|mid|mp3|ra|ram|rmi|snd|wav)$@i",$outa[2])) {
			Add($tag,1,DUDA,htmlspecialchars($tag).'<br />');
			$aabierto = 1;
		}
	} else {
		if (preg_match("@\.(asf|asr|asx|avi|lsf|lsx|mov|movie|mp2|mpa|mpe|mpeg|mpg|mpv2|ppt|qt|swf)$@i",$outa[2])) {
			Add($tag,1,DUDA,htmlspecialchars($tag).'<br />');
			$aabierto = 1;
		}
	}
} else if (stristr($tag,"<area ")) {
	preg_match("@href=([\"\'])? (?(1) (.*?)\\1 | ([^\s\>]+))@ix",$tag,$outa);
	if (QUE == 1109) {
		if (preg_match("@\.(aif|aifc|aiff|au|m3u|mid|mp3|ra|ram|rmi|snd|wav)$@i",$outa[2])) {
			Add($tag,6,DUDA);
		}
	} else {
		if (preg_match("@\.(asf|asr|asx|avi|lsf|lsx|mov|movie|mp2|mpa|mpe|mpeg|mpg|mpv2|ppt|qt|swf)$@i",$outa[2])) {
			Add($tag,6,DUDA);
		}
	}
}
if (preg_match("@</a[^>]*>@i",$tag) && $aabierto == 1) {
	Add($tag,2);
	$aabierto = 0;
}
break;

case 1111:
case 6202:
case 6502:
if (stristr($tag,"<frame ")) {
	Add($tag,6);
}
if (stristr($tag,"<noframes")) {
	if ($totales['noframe_vacio'] > 0) {
		Add($tag,4,MAL);
	} else {
		Add($tag,4,DUDABIS);
	}
}
if (stristr($tag,"</noframes")) {
	Add($tag,2);
}
break;

case 12:
case 9201:
if (preg_match("@<(img|input).* ismap[^>]*>@i", $tag)) {
	Add($tag,3,DUDA,$lang['view_ismap'].'<br />'.htmlspecialchars($tag).'<br />');
}
break;

case 1301:
case 1401:
case 8102:
	if (stristr($tag,"<embed")) {
		Add($tag,1,DUDA,htmlspecialchars($tag).'<br />');
	}
	if (stristr($tag,"</embed")) {
		Add($tag,2);
	}
break;

case 15:
if (preg_match("@<(img|input|object).* usemap[^>]*>@i", $tag)) {
	Add($tag,3,DUDA,$lang['view_usemap'].'<br />'.htmlspecialchars($tag).'<br />');
}
if (stristr($tag,"<area")) {
	Add($tag,6,DUDA);
}
if (preg_match("@<a\s.*href=([\"\'])? (?(1) (.*?)\\1 | ([^\s\>]+))@ix",$tag,$temp)) {
	$abso=Absolute_URL(URL_BASE,$temp[2]);
	if (in_array($abso,$totales['areas'])) {
		Add($tag,1,BIEN,htmlspecialchars($tag).'<br />');
		$aabierto = 1;
	}
}
if (preg_match("@</a[^>]*>@i",$tag) && $aabierto == 1) {
	Add($tag,2);
	$aabierto = 0;
}
break;

case 22:
if (stristr($tag,"<style")) { Add($tag,1,DUDA,'',1); }
if (stristr($tag,"</style")) { Add($tag,2,DUDA,'',1); }
if (preg_match("@<link.*rel=[\'\"]?(alternate )?stylesheet[^>]*>@i",$tag)) {
	Add($tag,3,DUDA,'',1);
} else if (stristr($tag," style=")) {
	Add($tag,3,DUDA,'',1);
} else if (stristr($tag," id=")) {
	Add($tag,3,DUDA,'',1);
} else if (stristr($tag," class=")) {
	Add($tag,3,DUDA,'',1);
}
break;

case 31:
if (stristr($tag,"<applet")) {
	Add($tag,1);
}
if (stristr($tag,"</applet")) {
	Add($tag,2);
}
if (stristr($tag,"<embed")) {
	Add($tag,1);
}
if (stristr($tag,"</embed")) {
	Add($tag,2);
}
if (stristr($tag,"<img")) { Add($tag); }
if (stristr($tag,"<object")) {
	Add($tag,1);
}
if (stristr($tag,"</object")) {
	Add($tag,2);
}
break;

case 3301:
if (stristr($tag,"<style")) {
	if ($herahead=='') { $herahead .= BIEN.' '.$lang['view_head_con']; }
	$herahead .= '<br />'.htmlspecialchars($tag).' '.$lang['view_css'];
	Add($tag,3,BIEN,'',1);
}
if (preg_match("@<link.*rel=[\'\"]?(alternate )?stylesheet[^>]*>@i",$tag)) {
	if ($herahead=='') { $herahead .= BIEN.' '.$lang['view_head_con']; }
	$herahead .= '<br />'.htmlspecialchars($tag);
	Add($tag,3,BIEN,'',1);
}
if (stristr($tag," style=")) { Add($tag,7,BIEN,htmlspecialchars($tag)); }
if (stristr($tag,"<table")) {
	Add($tag,1,DUDA,'&lt;table&gt;');
}
if (stristr($tag,"</table")) { Add($tag,2); }
break;

case 3302:
if (preg_match("@<(b|center|font|i|s|strike|u)(\s|>)+@i",$tag)) {
	Add($tag,7,MAL,htmlspecialchars($tag));
}
if (stristr($tag,"<basefont")) {
	if ($herahead=='') { $herahead .= MAL.' '.$lang['view_head_con']; }
	$herahead .= '<br />'.htmlspecialchars($tag);
	Add($tag,3,MAL,'',1);
}
break;

case 3303:
if (preg_match("@<(applet).*(hspace|vspace|align|height|width)=@i",$tag,$papple)) {
	Add($tag,7,MAL,'&lt;'.$apple[1].' '.$apple[2].'&gt;');
}
if (preg_match("@<basefont.*(size|color|face)=@i",$tag)) {
	if ($herahead=='') { $herahead .= MAL.' '.$lang['view_head_con']; }
	$herahead .= '<br />'.htmlspecialchars($tag);
	Add($tag,3,MAL,'',1);
}
if (preg_match("@<body.*(text|vlink|alink|link|background|bgcolor)=@i",$tag)) {
	if ($herahead=='') { $herahead .= MAL.' '; }
	else { $herahead .= '<br /><br />'; }
	$herahead .= htmlspecialchars($tag);
	Add($tag,3,MAL,'',1);
}
if (preg_match("@<(br) .*(clear)=@i",$tag,$br)) {
	Add($tag,7,MAL,'&lt;'.$br[1].' '.$br[2].'&gt;');
}
if (preg_match("@<(caption|div|h1|h2|h3|h4|h5|h6|iframe|input|legend|p) .*(align)=@i",$tag,$ali)) {
	Add($tag,7,MAL,'&lt;'.$ali[1].' '.$ali[2].'&gt;');
}
if (preg_match("@<(dir|dl|menu) .*(compact)=@i",$tag,$di)) {
	Add($tag,7,MAL,'&lt;'.$di[1].' '.$di[2].'&gt;');
}
if (preg_match("@<(font) .*(size|color|face)=@i",$tag,$fo)) {
	Add($tag,7,MAL,'&lt;'.$fo[1].' '.$fo[2].'&gt;');
}
if (preg_match("@<(hr) .*(align|size|width|noshade)=@i",$tag,$hr)) {
	Add($tag,7,MAL,'&lt;'.$hr[1].' '.$hr[2].'&gt;');
}
if (preg_match("@<(img|object) .*(align|border|hspace|vspace)=@i",$tag,$im)) {
	Add($tag,7,MAL,'&lt;'.$im[1].' '.$im[2].'&gt;');
}
if (preg_match("@<(li) .*(type)=@i",$tag,$lit)) {
	Add($tag,7,MAL,'&lt;'.$lit[1].' '.$lit[2].'&gt;');
}
if (preg_match("@<(ol|ul) .*(type|start|compact)=@i",$tag,$ol)) {
	Add($tag,7,MAL,'&lt;'.$ol[1].' '.$ol[2].'&gt;');
}
if (preg_match("@<(pre) .*(width)=@i",$tag,$pre)) {
	Add($tag,7,MAL,'&lt;'.$pre[1].' '.$pre[2].'&gt;');
}
if (preg_match("@<(table) .*(align|bgcolor)=@i",$tag,$tab)) {
	Add($tag,7,MAL,'&lt;'.$tab[1].' '.$tab[2].'&gt;');
}
if (preg_match("@<(td|th) .*(height|width|bgcolor|nowrap)=@i",$tag,$td)) {
	Add($tag,7,MAL,'&lt;'.$td[1].' '.$td[2].'&gt;');
}
if (preg_match("@<(tr) .*(bgcolor)=@i",$tag,$tr)) {
	Add($tag,7,MAL,'&lt;'.$tr[1].' '.$tr[2].'&gt;');
}
break;

case 3401:
if (preg_match("@<(table|td|th) .*(height|width)=[\"\']?\d[\"\'\s\>]+@i",$tag)) {
	Add($tag,7,MAL,htmlspecialchars($tag));
}
break;

case 3402:
if (preg_match("@<\w .*style=[\"\']?([^\"\'\>]*)@i",$tag,$st34)) {
	if (preg_match("@:(.*)[0-9]+(in|cm|mm|pt|pc)@i",$st34[1]) || preg_match("@font(-size)[\s]*:(.*)[0-9]+px@i",$st34[1])) {
		Add($tag,7,MAL,htmlspecialchars($tag));
	} else {
		Add($tag,7,BIEN,htmlspecialchars($tag));
	}
}
if (stristr($tag,"<style")) {
	if (preg_match("@:(.*)[0-9]+(in|cm|mm|pt|pc)@i",$contents[$key]) || preg_match("@font(-size)[\s]*:(.*)[0-9]+px@i",$contents[$key])) {
		$res34 = MAL;
	} else {
		$res34 = DUDA;
	}
	if ($herahead=='') {$herahead .= $res34.' '.$lang['view_head_con'];}
	$herahead .= '<br />'.htmlspecialchars($tag).' '.$lang['view_css'];
	Add($tag,3,$res34,'',1);
}
if (preg_match("@<link.*rel=[\'\"]?(alternate )?stylesheet[^>]*>@i",$tag)) {
	if ($totales['cssabs'] + $totales['cssfontpx'] > 1) {
		$r34 = MAL;
	} else {
		$r34 = DUDA;
	}
	if ($herahead=='') {
		$herahead .= $r34.' '.$lang['view_head_con'].'<br />';
		//$herahead .= '<br />'.htmlspecialchars($tag);
		if (is_array($totales['css'])) {
			foreach ($totales['css'] as $c) {
				$herahead .= '<a href="'.$c.'">'.$c.'</a><br />';
			}
		}
	}
	Add($tag,3,$r34,'',1);
}
break;

case 35:
if (stristr($tag,"<h1")) {
	$h1 = 1;
	if (($h2==1) || ($h3==1) || ($h4==1) || ($h5==1) || ($h6==1)) {
		Add($tag,1,DUDABIS,htmlspecialchars($tag));
	} else {
		Add($tag,1,DUDA,htmlspecialchars($tag));
	}
}
if (stristr($tag,"<h2")) {
	$h2 = 1;
	if ($h1 != 1) {
		Add($tag,1,DUDABIS,htmlspecialchars($tag));
	} else {
		Add($tag,1,DUDA,htmlspecialchars($tag));
	}
}
if (stristr($tag,"<h3")) {
	$h3 = 1;
	if (($h1 != 1) || ($h2 != 1)) {
		Add($tag,1,DUDABIS,htmlspecialchars($tag));
	} else {
		Add($tag,1,DUDA,htmlspecialchars($tag));
	}
}
if (stristr($tag,"<h4")) {
	$h4 = 1;
	if (($h1 != 1) || ($h2 != 1) || ($h3 != 1)) {
		Add($tag,1,DUDABIS,htmlspecialchars($tag));
	} else {
		Add($tag,1,DUDA,htmlspecialchars($tag));
	}
}
if (stristr($tag,"<h5")) {
	$h5 = 1;
	if (($h1 != 1) || ($h2 != 1) || ($h3 != 1) || ($h4 != 1)) {
		Add($tag,1,DUDABIS,htmlspecialchars($tag));
	} else {
		Add($tag,1,DUDA,htmlspecialchars($tag));
	}
}
if (stristr($tag,"<h6")) {
	$h6 = 1;
	if (($h1 != 1)||($h2 != 1)||($h3 != 1)||($h4 != 1)||($h5 != 1)) {
		Add($tag,1,DUDABIS,htmlspecialchars($tag));
	} else {
		Add($tag,1,DUDA,htmlspecialchars($tag));
	}
}
if (preg_match("@</h[1-6][^>]*>@i",$tag)) {Add($tag,2);}
break;

case 36:
if (preg_match("@<(dt|dd|li)\b[^>]*>@i",$tag)) {
	Add($tag,1,DUDA,htmlspecialchars($tag));
}
if (preg_match("@<(ol|ul|dl)\b[^>]*>@i",$tag)) {
	Add($tag,1,DUDABIS,htmlspecialchars($tag));
}
if (preg_match("@</(ol|ul|dl|dt|dd|li)\b[^>]*>@i",$tag)) {Add($tag,2);}
break;

case 37:
if (preg_match("@<(q|blockquote)[^>]*@i",$tag)) {
	Add($tag,1,DUDA,htmlspecialchars($tag));
}
if (preg_match("@</(q|blockquote)[^>]*@i",$tag)) {Add($tag,2);}
break;

case 41:
if (preg_match("@<(meta|link) .*(lang|hreflang|charset|language)@i",$tag)) {
	if ($herahead=='') { $herahead .= BIEN.' '.$lang['view_head_con']; }
	$herahead .= '<br />'.htmlspecialchars($tag);
	Add($tag,3,BIEN,'',1);
}
if ($body == 1) {
	if (preg_match("@<.*(lang|hreflang|charset)=@i",$tag)) {
		Add($tag,7,BIEN,htmlspecialchars($tag));
	}
}
break;

case 42:
if (preg_match("@<(abbr|acronym)[^>]*>@i",$tag)) {
	Add($tag,1,DUDA,htmlspecialchars($tag));
}
if (preg_match("@</(abbr|acronym)[^>]*>@i",$tag)) {Add($tag,2);}
break;

case 43:
if (stristr($tag,"<html")) {
	if ($totales['lang_pri']) {
		if (($totales['xhtml'] > 0) && (!$totales['lang_xml'])) {
			$r43 = MAL;
		} else if (($totales['lang_xml']) && ($totales['lang_xml'] != $totales['lang_pri'])) {
			$r43 = MAL;
		} else {
			$r43 = BIEN;
		}
	} else {
		$r43 = MAL;
	}
	if ($herahead=='') { $herahead .= $r43.' '.$lang['view_head_con']; }
	$herahead .= '<br />'.htmlspecialchars($tag);
	Add($tag,3,$r43,'',1);
}
break;

case 51:
case 54:
if (stristr($tag,"<table")) {
	Add($tag,1,DUDA,'&lt;table&gt;');
}
if (preg_match("@<th\b[^>]*>@i",$tag)) {
	Add($tag,1,DUDABIS,'&lt;th&gt;<br />',0,1);
}
if (stristr($tag,"</table")) { Add($tag,2); }
if (stristr($tag,"</th>")) { Add($tag,2,DUDABIS,'',0,1); }
$hojaestilo = "td { border: 2px solid #F0F !important; padding: 2px !important; }";
break;

case 52:
if (stristr($tag,"<table")) { Add($tag,1,DUDA,'&lt;table&gt;'); }
if (stristr($tag,"</table")) { Add($tag,2); }
if (preg_match("@<(td|th)\b.*(id|axis|headers|scope)=@i",$tag)) {
	Add($tag,1,DUDABIS,htmlspecialchars($tag)."<br />",0,1);
} else if (preg_match("@<(td|th)\b[^>]*>@i",$tag)) {
	Add($tag,1,DUDA,htmlspecialchars($tag)."<br />",0,1);
}
if (preg_match("@</(td|th)\b[^>]*>@i",$tag)) {
	Add($tag,2,DUDA,'',0,1);
}
break;

case 53:
if (OPTION == 'page') {
	if (preg_match("@<(\/)?(table|thead|tbody|tfoot)[^>]*>@i",$tag)) {
		$tag = '';
	} else if (preg_match("@<(\/)?(td|th)[^>]*>@i",$tag)) {
		$tag = "\t";
	} else if (preg_match("@<tr[^>]*>@i",$tag)) {
		$tag = "<div>";
	} else if (preg_match("@</tr[^>]*>@i",$tag)) {
		$tag = "</div>";
	}
} else {
	if (stristr($tag,"<table")) { Add($tag,1); }
	if (stristr($tag,"</table")) { Add($tag,2); }
}
break;

case 55:
if (preg_match("@<table.*summary=[\"\']?([^\"\'\>]*)@i",$tag)) {
	Add($tag,1,DUDABIS,htmlspecialchars($tag));
} else if (preg_match("@<table[^>]*>@i",$tag)) {
	Add($tag,1,DUDA,htmlspecialchars($tag));
}
if (stristr($tag,"</table")) { Add($tag,2); }
if (stristr($tag,"<caption")) {
	Add($tag,4,BIEN);
}
if (stristr($tag,"</caption")) { Add($tag,5); }
break;

case 56:
if (stristr($tag,"<table")) { Add($tag,1,DUDA,'&lt;table&gt;'); }
if (stristr($tag,"</table")) { Add($tag,2); }
if (preg_match("@<th.*abbr=[\"\']?([^\"\'\>]*)@i",$tag,$thab)) {
	Add($tag,1,DUDABIS,'&lt;th abbr="'.$thab[1].'"&gt;<br />',0,1);
} else if (preg_match("@<th\b[^>]*>@i",$tag)) {
	Add($tag,1,DUDA,'&lt;th&gt;<br />',0,1);
}
if (preg_match("@</th\b[^>]*>@i",$tag)) {
	Add($tag,2,DUDA,'',0,1);
}
$hojaestilo = "td { border: 2px solid #F0F !important; padding: 2px !important; }";
break;

case 61:
if (stristr($tag,"<style")) { Add($tag,1,DUDA,'',1); }
if (stristr($tag,"</style")) { Add($tag,2,DUDA,'',1); }
if (preg_match("@<link.*rel=[\'\"]?(alternate )?stylesheet[^>]*>@i",$tag)) { Add($tag,3,DUDA,'',1); }
if (stristr($tag," style=")) { Add($tag,3,DUDA,'',1); }
break;

case 6201:
if ($body == 1) {
	if (stristr($tag,"<script")) {
		Add($tag,1,DUDA,htmlspecialchars($tag));
	}
	if (stristr($tag,"</script")) {
		Add($tag,2);
	}
}
if (preg_match("@<(applet|embed|object)[^>]*>@i", $tag)) {
	Add($tag,1,DUDA,htmlspecialchars($tag).'<br />');
} else if (preg_match("@<(\/)?(applet|embed|object)[^>]*>@i", $tag)) {
	Add($tag,2);
}
break;
// 6202 - Con 1111

case 6301:
if (preg_match("@<a .*href=([\"\'])? (?(1) (.*?)\\1 | ([^\s\>]+))@ix",$tag,$temp)) {
//if (preg_match("@<a .*href=([\"\'])?([^\"\'\s\>]+)@i",$tag,$temp)) {
	if (preg_match("@^javascript:@i", $temp[2])) {
		Add($tag,1,MAL,htmlspecialchars($tag).'<br />');
	} else if (count(count_chars($temp[2], 1)) < 2) {
		if (preg_match("@on(click|keypress|dblclick)@i",$tag)) {
			Add($tag,1,MAL,htmlspecialchars($tag).'<br />');
		}
	} else {
		Add($tag,1,DUDA,htmlspecialchars($tag).'<br />');
	}
}
if (preg_match("@</a[^>]*>@i", $tag)) {
	Add($tag,2);
}
break;

case 6302:
if (OPTION == 'page') {
	if (stristr($tag,"<script")) {
		$contents[$key] = '';
	}
	if (preg_match("@<(\/)?(script|noscript)[^>]*>@i",$tag)) {
		$tag = '';
	}
} else {
	if (stristr($tag,"<script")) {
		Add($tag,1);
	}
	if (stristr($tag,"</script")) {
		Add($tag,2);
	}
}
break;

case 6303:
if (OPTION == 'page') {
	if (preg_match("@<(\/)?(embed|object|param|noembed)[^>]*>@i",$tag)) {
		$tag = '';
	}
} else {
	if (preg_match("@<(embed|object)[^>]*>@i", $tag)) {
		Add($tag,1);
	} else if (preg_match("@<(\/)?(embed|object)[^>]*>@i", $tag)) {
		Add($tag,2);
	}
}
break;

case 6304:
if (OPTION == 'page') {
	if (preg_match("@<(\/)?(applet|param)[^>]*>@i",$tag)) {
		$tag = '';
	}
} else {
	if (stristr($tag,"<applet")) {
		Add($tag,1);
	}
	if (stristr($tag,"</applet")) {
		Add($tag,2);
	}
}
break;

case 64:
case 8101:
case 93:
if (preg_match("@on(dblclick|mousemove|mouseover|mouseout)=@i",$tag)) {
	Add($tag,7,MAL,htmlspecialchars($tag));
} else if (preg_match("@on(click|mousedown|mouseup)=@i",$tag)) {
	if (preg_match("@on(keypress|keydown|keyup)=@i",$tag)) {
		Add($tag,7,DUDA,htmlspecialchars($tag));
	} else {
		Add($tag,7,MAL,htmlspecialchars($tag));
	}
}  else if (preg_match("@on(keypress|keydown|keyup)=@i",$tag)) {
	if (preg_match("@on(click|mousedown|mouseup)=@i",$tag)) {
		Add($tag,7,DUDA,htmlspecialchars($tag));
	} else {
		Add($tag,7,MAL,htmlspecialchars($tag));
	}
} else if (preg_match("@on(load|focus|blur|submit|reset|select|change|unload)=@i",$tag)) {
	Add($tag,7,BIEN,htmlspecialchars($tag));
}
break;

case 6501:
if ($body == 1) {
	if (stristr($tag,"<script")) {
		Add($tag,1,DUDA,htmlspecialchars($tag));
	}
	if (stristr($tag,"</script")) {
		Add($tag,2);
	}
	if (stristr($tag,"<noscript")) {
		Add($tag,4,DUDABIS);
	}
	if (stristr($tag,"</noscript")) {
		Add($tag,5);
	}
} else {
	if (stristr($tag,"<script")) {
		if ($herahead=='') { $herahead .= DUDA.' '.$lang['view_head_con']; }
		if (preg_match("@src=([\"\'])? (?(1) (.*?)\\1 | ([^\s\>]+))@ix",$tag,$temp)) {
			$scr = Absolute_URL(URL_BASE,$temp[2]);
			$herahead .= '<br /><a href="'.$scr.'">'.$scr.'</a>';
		} else {
			$herahead .= '<br />'.htmlspecialchars($tag).' '.$lang['view_scripts'];
		}
		Add($tag,1,DUDA,htmlspecialchars($tag),1);
	}
	if (stristr($tag,"</script")) {
		Add($tag,2);
	}
}
break;

// 6502 - Con 1111

case 71:
case 7402:
case 7502:
if (preg_match("@<(script|applet|embed|object)[^>]*>@i", $tag)) {
	Add($tag,1,DUDA,'',1);
} else if (preg_match("@<(\/)?(script|applet|embed|object)[^>]*>@i", $tag)) {
	Add($tag,2,'','',1);
}
break;

case 72:
if (stristr($tag,"<blink")) { Add($tag,1,MAL); }
if (stristr($tag,"</blink")) { Add($tag,2,MAL); }
if (preg_match("@<(script|applet|embed|object)[^>]*>@i", $tag)) {
	Add($tag,1,DUDA,'',1);
} else if (preg_match("@<(\/)?(script|applet|embed|object)[^>]*>@i", $tag)) {
	Add($tag,2,'','',1);
}
if (stristr($tag,"<img")) {
	Add($tag,3,DUDA,'',1);
}
break;

case 73:
if (stristr($tag,"<marquee")) { Add($tag,1,MAL); }
if (stristr($tag,"</marquee")) { Add($tag,2,MAL); }
if (preg_match("@<(script|applet|embed|object)[^>]*>@i", $tag)) {
	Add($tag,1,DUDA,'',1);
} else if (preg_match("@<(\/)?(script|applet|embed|object)[^>]*>@i", $tag)) {
	Add($tag,2,'','',1);
}
if (stristr($tag,"<img")) {
	Add($tag,3,DUDA,'',1);
}
break;

case 7401:
case 7501:
if (preg_match("@http-equiv=[\"\']?refresh@i",$tag)) {
	if (preg_match("@content=[\"\']?(.*)url@i",$tag)) {
		if (QUE == 7501) {
			$re = MAL;
		} else {
			$re = BIEN;
		}
			if ($herahead=='') { $herahead .= $re.' '.$lang['view_head_con']; }
			$herahead .= '<br />'.htmlspecialchars($tag);
			Add($tag,3,$re);
	} else {
		if (QUE == 7401) {
			$re = MAL;
		} else {
			$re = BIEN;
		}
			if ($herahead=='') { $herahead .= $re.' '.$lang['view_head_con']; }
			$herahead .= '<br />'.htmlspecialchars($tag);
			Add($tag,3,$re);
	}
}
break;

// case 7402 y 7502: con 71
// case 8101: Con 6.4
// case 8102: Con 1301
// case 8103: Con 1106
//case 8104: Con 1107

case 91:
if (preg_match("@<(img|input).* ismap[^>]*>@i", $tag)) {
	Add($tag,3,MAL,$lang['view_ismap'].'<br />'.htmlspecialchars($tag).'<br />');
}
if (preg_match("@<(img|input|object).* usemap[^>]*>@i", $tag)) {
	Add($tag,3,BIEN,$lang['view_usemap'].'<br />'.htmlspecialchars($tag).'<br />');
}
break;

//case 9201: Con punto 1.2

case 9202:
if (preg_match("@<(applet|embed|object)[^>]*>@i", $tag,$elp)) {
	Add($tag,1,DUDA,$elp[1].'<br />');
} else if (preg_match("@<(\/)?(applet|embed|object)[^>]*>@i", $tag)) {
	Add($tag,2);
}
break;

// case 93: Con 6.4

case 94:
if (preg_match("@ tabindex=@i",$tag)) {
	Add($tag,7,DUDA,htmlspecialchars($tag));
}
break;

case 95:
if (preg_match("@ accesskey=@i",$tag)) {
	Add($tag,7,DUDA,htmlspecialchars($tag));
}
break;

case 10101:
if (preg_match("@ target=@i",$tag)) {
	if (stristr($tag,"<base")) {
		if ($herahead=='') {
			$herahead .= DUDA.' '.$lang['view_head_con'];
		}
		$herahead .= '<br />'.htmlspecialchars($tag);
		Add($tag,3,DUDA,'',1);
	} else {
		Add($tag,7,DUDA,htmlspecialchars($tag));
	}
}
break;

case 10102:
if (preg_match("@<(applet|embed|object)[^>]*>@i", $tag,$este)) {
	Add($tag,1,DUDA,'&lt;'.$este[1].'&gt;<br />');
} else if (preg_match("@<\/(applet|embed|object)[^>]*>@i", $tag)) {
	Add($tag,2);
}
if ($body == 1) {
	if (stristr($tag,"<script")) {
		Add($tag,1,DUDA,'&lt;script&gt;<br />');
	}
	if (stristr($tag,"</script")) {
		Add($tag,2);
	}
} else {
	if (stristr($tag,"<script")) {
		if ($herahead=='') { $herahead .= DUDA.' '.$lang['view_head_con']; }
		if (preg_match("@src=([\"\'])? (?(1) (.*?)\\1 | ([^\s\>]+))@ix",$tag,$temp)) {
			$scr = Absolute_URL(URL_BASE,$temp[2]);
			$herahead .= '<br /><a href="'.$scr.'">'.$scr.'</a>';
		} else {
			$herahead .= '<br />'.htmlspecialchars($tag).' '.$lang['view_scripts'];
		}
		Add($tag,1,DUDA,htmlspecialchars($tag),1);
	}
	if (stristr($tag,"</script")) {
		Add($tag,2);
	}
}
if (preg_match("@on(blur|submit|select|change|click|dblclick|mouseover|keypress|keydown)=@i",$tag)) {
	Add($tag,7,DUDA,htmlspecialchars($tag));
}
break;

case 102:
if (stristr($tag,"<input")) {
	if (preg_match("@type=[\"\']?(text|password|radio|checkbox|file)@i",$tag)) {
		Add($tag,3,DUDA,htmlspecialchars($tag).'<br />');
	} else {
		Add($tag,3,BIEN,htmlspecialchars($tag).'<br />');
	}
}
if (preg_match("@<(textarea|select)[^>]*>@i",$tag)) {
	Add($tag,1,DUDA,htmlspecialchars($tag).'<br />');
} else if (preg_match("@</(textarea|select|label)[^>]*>@i",$tag)) {
	Add($tag,2);
}
if (stristr($tag,"<label")) {
	Add($tag,1,DUDABIS,htmlspecialchars($tag).'<br />');
}
break;

case 103:
if (stristr($tag,"<table")) { Add($tag,1,DUDA,'&lt;table&gt;'); }
if (stristr($tag,"</table")) { Add($tag,2); }
$hojaestilo = "td { border: 2px solid #F0F !important; padding: 2px !important; }\nth { border: 2px solid #0FF !important; padding: 2px !important; }";
break;

case 104:
if (preg_match("@<input.*type=[\'\"]?text[^>]*>@i",$tag)) {
	if (preg_match("@value=([\"\'])? (?(1) (.*?)\\1 | ([^\s\/\>]+))@ix",$tag,$outxt)) {
		if (trim($outxt[2]) == '') {
			$res = MAL;
		} else {
			$res = BIEN;
		}
	} else {
		$res = MAL;
	}
	Add($tag,3,$res,'<br />');
}
if (stristr($tag,"<textarea")) {
	if (trim($contents[$key]) == '') {
		$re = MAL;
	} else {
		$re = BIEN;
	}
	Add($tag,1,$re,'<br />');
}
if (stristr($tag,"</textarea")) {
	Add($tag,2);
}
break;

case 105:
if (preg_match("@<a [^>]*>@i",$tag)) {
	if ($cierre_a == 1) {
		Add($tag,1,MAL);
	}
	$cierre_a = 0;
	$aabierto = 1;
}
if (preg_match("@</a[^>]*>@i",$tag) && $aabierto == 1) {
	Add($tag,2);
	$aabierto = 0;
}
break;

case 111:
if (stristr($tag,"<body")) {
	if ($totales['!doctype'] == 0) {
		if ($herahead=='') {
			$herahead .= MAL.' '.$lang['view_head_con'];
		}
		$herahead .= '<br />'.$lang['view_no_dtd'];
	}
}
if (stristr($tag,"<!doctype")) {
	if ($herahead=='') {
		$herahead .= DUDA.' '.$lang['view_head_con'];
	}
	$herahead .= '<br />'.htmlspecialchars($tag);
	Add($tag,3,DUDA,'',1);
	if ($totales['hay_estilos'] > 0) {
		$herahead .= '<br />'.$lang['view_si_css'];
	} else {
		$herahead .= '<br />'.$lang['view_no_css'];
	}
}
if (stristr($tag,"<applet")) { Add($tag,7,MAL,'applet'); }
if (stristr($tag,"<embed")) { Add($tag,7,MAL,'embed'); }
if (stristr($tag,"<blink")) { Add($tag,7,MAL,'blink'); }
if (stristr($tag,"<marquee")) { Add($tag,7,MAL,'marquee'); }
if (stristr($tag,"<object")) {
	if (stristr($tag,"shockwave/cabs/flash")) {
		Add($tag,7,MAL,'Flash');
	}
}
if (stristr($tag,"<style")) { Add($tag,1,BIEN,'',1); }
if (stristr($tag,"</style")) { Add($tag,2,BIEN,'',1); }
if (preg_match("@<link.*rel=[\'\"]?(alternate )?stylesheet[^>]*>@i",$tag)) { Add($tag,3,BIEN,'',1); }
if (stristr($tag," style=")) { Add($tag,3,BIEN,'',1); }
break;

case 11201:
if (preg_match("@<(applet|basefont|center|dir|font|isindex|menu|s|strike|u)\b[^>]*>@i",$tag)) {
	Add($tag,7,MAL,htmlspecialchars($tag));
}
break;

case 11202:
if (preg_match("@<body.*(text|vlink|alink|link|background|bgcolor)=@i", $tag)) {
	if (OPTION == 'page') {
		$tag .= MAL.htmlspecialchars($tag).'</div>';
	} else {
		Add($tag,7,MAL);
	}
}
if (preg_match("@<(br|li|ol|ul) .*(clear|type|start|compact)=@i",$tag,$d1)) {
	Add($tag,7,MAL,$d1[1].': '.$d1[2]);
}
if (preg_match("@<(caption|div|h(1-6)|iframe|input|legend|p|table) .*align=@i",$tag, $d2)) {
	Add($tag,7,MAL,$d2[1].': align');
}
if (preg_match("@<hr .*(align|size|width|noshade)=@i",$tag,$d3)) {
	Add($tag,7,MAL,'hr: '.$d3[1]);
}
if (preg_match("@<(img|object) .*(align|border|hspace|vspace)=@i",$tag,$d4)) {
	Add($tag,7,MAL,$d4[1].': '.$d4[2]);
}
if (preg_match("@<pre .*width=@i",$tag)) {
	Add($tag,7,MAL,'pre: width');
}
if (preg_match("@<script .*language=@i",$tag)) {
	if ($body == 0) {
		if ($herahead=='') {
			$herahead .= MAL.' '.$lang['view_head_con'];
		}
		$herahead .= '<br />&lt;script: language&gt;';
		Add($tag,1,MAL,'',1);
	} else {
		Add($tag,7,MAL,'script: language');
	}
}
if (preg_match("@<(td|th) .*(height|width|bgcolor|nowrap)=@i", $tag, $d6)) {
	Add($tag,7,MAL,$d6[1].': '.$d6[2]);
}
break;

// 11.3 y 11.4 Nada

case 121:
if (stristr($tag,"<frame ")) {
	if (stristr($tag," title=")) {
		Add($tag,6);
	} else {
		Add($tag,6,MAL);
	}
}
if (stristr($tag,"<noframes")) {
	if ($totales['noframe_vacio'] > 0) {
		Add($tag,4,MAL);
	} else {
		Add($tag,4,DUDABIS);
	}
}
if (stristr($tag,"</noframes")) {
	Add($tag,2);
}
break;

case 122:
if (stristr($tag,"<frame ")) {
	if (stristr($tag," title=") || stristr($tag," longdesc=")) {
		Add($tag,6,DUDABIS);
	} else {
		Add($tag,6,MAL);
	}
}
if (stristr($tag,"<noframes")) {
	if ($totales['noframe_vacio'] > 0) {
		Add($tag,4,MAL);
	} else {
		Add($tag,4,DUDABIS);
	}
}
if (stristr($tag,"</noframes")) {
	Add($tag,2);
}
break;

case 123:
if (preg_match("@<(fieldset|legend|optgroup|caption|thead|tbody|tfoot|colgroup|ul|ol|dl|h[1-6]|p)\b[^>]*>@i",$tag,$blo)) {
	Add($tag,7,BIEN,'&lt;'.$blo[1].'&gt;');
}
break;

case 124:
if (stristr($tag,"<input")) {
	if (preg_match("@type=[\"\']?(text|password|radio|checkbox|file)@i", $tag)) {
		if (preg_match("@id=([\"\'])? (?(1) (.*?)\\1 | ([^\s\/\>]+))@ix",$tag,$outid)) {
			if (in_array($outid[2], $totales['for_id'])) {
				Add($tag,3,DUDABIS,htmlspecialchars($tag).'<br />');
			} else {
				Add($tag,3,MAL,htmlspecialchars($tag).'<br />');
			}
		} else {
			Add($tag,3,MAL,htmlspecialchars($tag).'<br />');
		}
	}
}
if (preg_match("@<(textarea|select)[^>]*>@i",$tag)) {
	if (preg_match("@id=([\"\'])? (?(1) (.*?)\\1 | ([^\s\/\>]+))@ix",$tag,$outid)) {
		if (in_array($outid[2], $totales['for_id'])) {
			Add($tag,3,DUDABIS,htmlspecialchars($tag).'<br />');
		} else {
			Add($tag,3,MAL,htmlspecialchars($tag).'<br />');
		}
	} else {
		Add($tag,3,MAL,htmlspecialchars($tag).'<br />');
	}
} else if (preg_match("@</(textarea|select|label)[^>]*>@i",$tag)) {
	Add($tag,2);
}
if (stristr($tag,"<label")) {
	if (preg_match("@for=([\"\'])? (?(1) (.*?)\\1 | ([^\s\/\>]+))@ix",$tag,$outfor)) {
		if (in_array($outfor[2], $totales['id_for'])) {
			Add($tag,3,BIEN,htmlspecialchars($tag).'<br />');
		} else {
			Add($tag,3,MAL,htmlspecialchars($tag).'<br />');
		}
	} else {
		Add($tag,3,MAL,htmlspecialchars($tag).'<br />');
	}
}
break;

case 131:
if (OPTION == 'code') {
	if (preg_match("@<a .*href=@i",$tag)) {
		if (preg_match("@title=([\"\'])? (?(1) (.*?)\\1 | ([^\s\/\>]+))@ix",$tag,$outit)) {
			Add($tag,1,DUDABIS);
		} else {
			Add($tag,1,DUDA);
		}
	}
	if (preg_match("@</a>@i",$tag)) {
		Add($tag,2);
	}
}
break;

case 132:
if (preg_match("@<(!doctype|meta|link|title)[^>]*>@i",$tag)) {
	if ($herahead=='') { $herahead .= DUDA.' '.$lang['view_head_con']; }
	if (stristr($tag,"<title")) {
		$herahead .= '<br />&lt;title&gt;'.$contents[$key].'&lt;/title&gt;';
	} else {
		if (!preg_match("@http-equiv=[\"\']?refresh@i",$tag) && !preg_match("@<link.*rel=[\'\"]?(alternate )?stylesheet[^>]*>@i",$tag)) {
			$herahead .= '<br />'.htmlspecialchars($tag);
		}
	}
	Add($tag,3,DUDA,'',1);
}
if (preg_match("@<(address|del|ins)[^>]*>@i",$tag,$outmet)) {
	Add($tag,1,BIEN, '&lt;'.$outmet[1].'&gt; ');
}
if (preg_match("@</(address|del|ins)[^>]*>@i",$tag)) {
	Add($tag,2);
}
if ($body == 1) {
	if (preg_match("@title=([\"\'])? (?(1) (.*?)\\1 | ([^\s\/\>]+))@ix",$tag,$outx)) {
		Add($tag,7,BIEN,'title=&quot;'.$outx[2].'&quot;<br />');
	}
	if (preg_match("@cite=([\"\'])? (?(1) (.*?)\\1 | ([^\s\/\>]+))@ix",$tag,$outxx)) {
		Add($tag,7,BIEN,'cite=&quot;'.$outxx[2].'&quot;<br />');
	}
}
break;

case 136:
if (preg_match("@<(map|li|dd|dt)\b[^>]*>@i",$tag)) {
	Add($tag,1,DUDA,htmlspecialchars($tag));
}
if (preg_match("@<(dl|ol|ul)\b[^>]*>@i",$tag,$lista)) {
	Add($tag,1,DUDABIS,'&lt;'.$lista[1].'&gt;');
}
if (preg_match("@</(map|li|dd|dt|dl|ol|ul)>@i",$tag)) {
	Add($tag,2);
}
if (preg_match("@<(td|th)\b[^>]*>@i",$tag)) {
	Add($tag,1,MAL,'',0,1);
}
if (preg_match("@</(td|th)>@i",$tag)) {
	Add($tag,2,MAL,'',0,1);
}
break;

case 138:
if (preg_match("@<(ul|ol|dl|li|dt|dd|h1|h2|h3|h4|h5|h6|p)\b[^>]*>@i", $tag)) {
	Add($tag,1);
} else if (preg_match("@<\/(ul|ol|dl|li|dt|dd|h1|h2|h3|h4|h5|h6|p)\b[^>]*>@i", $tag)) {
	Add($tag,2);
}
break;

case 139:
if (preg_match("@ (rel|rev)=@i",$tag)) {
	if ($body == 0) {
		if ($herahead=='') { $herahead .= DUDA.' '.$lang['view_head_con']; }
		$herahead .= '<br />'.htmlspecialchars($tag);
		Add($tag,3,DUDA,'',1);
	} else {
		Add($tag,7,BIEN,htmlspecialchars($tag).'<br />');
	}
}
break;

} // Fin switch
} // Fin function Modificar
?>