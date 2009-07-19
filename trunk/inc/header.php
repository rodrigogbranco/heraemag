<?php if(!defined('IDIOMA')){die();} ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?php echo IDIOMA; ?>" xml:lang="<?php echo IDIOMA; ?>">

<head>
<title><?php _Title($opt_head); ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="estilos.css" type="text/css" rel="stylesheet" />
<link rel="icon" href="<?php echo WEBSITE; ?>img/favicon.ico" type="image/x-icon" />
<script type="text/javascript" src="<?php echo WEBSITE; ?>display.js"></script>
<?php _Idiomas(); ?>
</head>

<body<?php
if ($opt_head['bread'] == 'pagina_informe') {
	echo ' id="informe"';
}
?>>
<div id="cabecera">

<div id="top"><?php _Breadcrumb($opt_head); ?></div>

<div style="position:absolute;right:4px;top:4px"><a href="<?php echo PHP_SELF; ?>" title="<?php echo $lang['logo_tit']; ?>"><img src="<?php echo WEBSITE; ?>img/hera.gif" width="95" height="70" alt="<?php echo $lang['logo_alt']; ?>" /></a></div>

<h1><?php _Title($opt_head); ?></h1>

<?php _Form($opt_head); ?>

</div>

<p class="menu"><?php
if ($opt_head['bar'] == '') {
?>
<span style="float:right"><?php _Idiomas('body'); ?></span>
<span style="color:#900;font-size:80%;padding:1em"><?php echo $lang['paciencia']; ?></span>
<?php
} else {
	_Bar($opt_head);
}
?></p>

<?php

function _Title($opt) {
	global $lang;
	if ($opt['bread'] != '') {
		if ($opt['bread'] == 'pagina_informe') {
			echo $lang['informe_html_tit'];
		} else {
			if (PT > 0) {
				echo sprintf($lang['tit_pauta'], PT);
			} else if (PR > 0) {
				echo sprintf($lang['tit_priori'], PR);
			} else if (IN > 0) {
				echo $lang['bc_info'];
			} else {
				echo $lang['tit_resumen'];
				if ($opt['error'] != '') {
					echo ' - '.$lang['bc_error'];
				}
			}
		}
	} else {
		echo $lang['titulo'];
	}
} // End function _Title


function _Idiomas($opt='head') {
	@include_once('lang/idiomas.php');
	if (is_array($lista_idiomas)) {
		asort($lista_idiomas);
		foreach ($lista_idiomas as $k => $v) {
			if ($k != IDIOMA) {
				if ($opt == 'head') {
					echo '<link rel="language" href="index.php.'.$k.'" hreflang="'.$k.'" title="'.$v.'" />'."\n";
				} else {
					echo '[<a href="index.php.'.$k.'" hreflang="'.$k.'" title="'.$v.'">'.$k.'</a>] ';
				}
			}
		}
	}
} // End function _Idiomas


function _Breadcrumb($opt) {
	global $lang, $param;
	if (($opt['bread'] == 'pagina_informe') || ($opt['bread'] == '')) {
		echo 'HERA 2.1 Beta';
		 if ($opt['error'] != '') {
			echo ' &raquo; '.$lang['bc_error'];
		}
	} else {
		echo ' <a href="'.PHP_SELF.'">'.$lang['bc_inicio'].'</a>';
		if ($opt['bread'] == 'resumen') {
			echo ' &raquo; '.$lang['bc_resumen'];
		} else {
			echo ' &raquo; <a href="'.PHP_SELF.$param.'">'.$lang['bc_resumen'].'</a>';
		}
		if ($opt['bread'] == 'pauta') {
			echo ' &raquo; '.sprintf($lang['bc_pauta'], PT);
		} else if ($opt['bread'] == 'priori') {
			echo ' &raquo; '.sprintf($lang['bc_priori'], PR);
		} else if ($opt['bread'] == 'informe') {
			echo ' &raquo; '.$lang['bc_info'];
		}
	}
} // End function _Breadcrumb


function _Form($opt) {
	global $lang;
	if ($opt['form'] != 'pagina_informe') {
?>
<form action="<?php echo PHP_SELF; ?>" method="post">
<p class="pagina"><a name="inicio" id="inicio"></a>
<?php
		if ($opt['form'] == '') {
			if ($opt['error'] != '') {
				echo '<strong>'.$lang['bc_error'].': '.$opt['error']."</strong><br /><br />\n";
			}
?>
<?php /*RGB begin*/ ?>
<input type="radio" name="choose" value="wcag" checked="true"><strong>WCAG 1.0</strong>
<input type="radio" name="choose" value="emag"><strong>eMag 2.0</strong>
<br>
<?php /*RGB end*/ ?>
<label for="url"><?php echo $lang['frm_url']; ?>
<input type="text" name="url" id="url" value="http://" size="60" /></label> <input type="submit" name="btns" id="btns" value="<?php echo $lang['frm_boton']; ?>" /> 
<?php
		} else {
?>
<strong><?php echo $opt['form']; ?></strong>
<a href="<?php echo $opt['form']; ?>" target="pag" title="<?php echo $lang['tit_pag_orig']; ?>"><img src="<?php echo WEBSITE; ?>img/page.gif" class="pag2" alt="<?php echo $lang['alt_pag_orig']; ?>" /></a>
<a href="view.php?id=<?php echo ID; ?>&amp;lng=<?php echo IDIOMA; ?>&amp;opt=code" target="pag" title="<?php echo $lang['tit_cod_pag']; ?>"><img src="<?php echo WEBSITE; ?>img/code.gif" class="pag2" alt="<?php echo $lang['alt_cod_pag']; ?>" /></a> 
<input type="hidden" name="url" id="url" value="<?php echo $opt['form']; ?>" /> 
<input type="hidden" name="hid" id="hid" value="<?php echo ID; ?>" /> 
<input type="submit" name="btns" id="btns" value="<?php echo $lang['frm_boton2']; ?>" /> 
<?php
		}
?>
</p>
</form>
<?php
	}
} // End function _Form

function _Bar($opt) {
	global $lang;
	$ico_info = '<img src="'.WEBSITE.'img/informe.gif" class="pag" alt="'.$lang['ico_alt_info'].'" />';
	$ico_hera = '<img src="'.WEBSITE.'img/heraico.gif" class="pag" alt="'.$lang['ico_alt_res'].'" />';
	switch ($opt['bar']) {
		case 'info':
			$bar = '<a href="'.PHP_SELF.'?id='.ID.'&amp;in=1" title="'.$lang['ico_tit_info'].'">'.$ico_info.'</a>';
		break;
		case 'resumen':
			$bar = '<a href="'.PHP_SELF.'?id='.ID.'" title="'.$lang['ico_tit_res'].'">'.$ico_hera.'</a>';
		break;
		case 'icons':
			if(HL > 0) { $parhl = '&amp;hl='.HL; }
			if(AN > 0) { $paran = '&amp;an='.AN; }
			$bar = '<a href="'.PHP_SELF.'?id='.ID.$parhl.$paran.'" title="'.$lang['ico_tit_res'].'">'.$ico_hera.'</a> ';
			$param1 = '?id='.ID;
			if (PT > 0) {
				$param1 .= '&amp;pt='.PT;
			} else if (PR > 0) {
				$param1 .= '&amp;pr='.PR.'&amp;re='.RE;
			}
			// Manual icon
			if (HL == 0) {
				$param3 = '&amp;hl=1';
				$title_hl = $lang['ico_tit_man2'];
				$img_hl = 'helpno.gif';
			} else {
				$param3 = '&amp;hl=0';
				$title_hl = $lang['ico_tit_man1'];
				$img_hl = 'helpsi.gif';
			}
			$bar .= '<a href="'.PHP_SELF.$param1.$param3.'" title="'.$title_hl.'"><img src="'.WEBSITE.'img/'.$img_hl.'" class="pag" alt="'.$lang['ico_alt_man'].'" /></a> ';
			// Form
			if (AN == 0) {
				$param4 = '&amp;an=1';
				$title_an = $lang['ico_tit_form2'];
				$img_an = 'formno.gif';
			} else {
				$param4 = '&amp;an=0';
				$title_an = $lang['ico_tit_form1'];
				$img_an = 'formsi.gif';
			}
			$bar .= '<a href="'.PHP_SELF.$param1.$param4.'" title="'.$title_an.'"><img src="'.WEBSITE.'img/'.$img_an.'" class="pag" alt="'.$lang['ico_alt_form'].'" /></a> ';
			$bar .= '<a href="'.PHP_SELF.'?id='.ID.'&amp;in=1" title="'.$lang['ico_tit_info'].'">'.$ico_info.'</a>';
		break;
	}
	if ($opt['bar'] == 'pagina_informe') {
		echo '&nbsp;';
	} else {
		echo '<span id="iconos">'.$bar.'</span>';
	}
} // End function _Bar
?>