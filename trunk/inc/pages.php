<?php
if(!defined('IDIOMA')){die();}
require('lang/'.IDIOMA.'/texto.php');
$esta = (isset($_GET['ini']))? $_GET['ini'] : '';
?>
<div class="caja">

<div class="dona">
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick" />
<input type="image" src="http://www.sidar.org/hera/img/donahera-es.gif"  name="submit" alt="<?php echo $texto['dona_alt']; ?>" />
<input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----
" />
</form>
</div>

<h2><?php
switch ($esta) {
	case 'help': echo $texto['help_h1']; break;
	case 'info': echo $texto['info_h1']; break;
	case 'code': echo $texto['code_h1']; break;
	case 'thanks': echo $texto['thanks_h1']; break;
	default: echo $texto['intro_h1']; break;
}
?></h2>

<p class="derecha"><span class="duda"> [ 
<?php
if ($esta == '') {
	echo 'HERA | ';
} else {
	echo '<a href="'.PHP_SELF.'">HERA</a> | ';
}
if ($esta == 'help') {
	echo $lang['txt_a_hlp'].' | ';
} else {
	echo '<a href="'.PHP_SELF.'?ini=help" title="'.$lang['txt_tit_hlp'].'">'.$lang['txt_a_hlp'].'</a> | ';
}
if ($esta == 'info') {
	echo $lang['txt_a_info'].' | ';
} else {
	echo '<a href="'.PHP_SELF.'?ini=info" title="'.$lang['txt_tit_info'].'">'.$lang['txt_a_info'].'</a> | ';
}
if ($esta == 'code') {
	echo $lang['txt_a_code'].' | ';
} else {
	echo '<a href="'.PHP_SELF.'?ini=code" title="'.$lang['txt_tit_code'].'">'.$lang['txt_a_code'].'</a> | ';
}
?>
<a href="mailto:hera@sidar.org" title="<?php echo $lang['txt_tit_mail']; ?>"><?php echo $lang['txt_a_mail']; ?></a> ]</span></p>

<?php
if ($esta == 'help') {
?>
<p><?php echo $texto['help_a']; ?><img src="img/heraini.gif" class="der" alt="<?php echo $texto['help_img_1']; ?>" /></p>
<dl>
<dt><span class="bien"><img src="img/bien.gif" alt="" class="ico" /> <?php echo $lang['res_th_b']; ?> </span></dt> 
<dd><?php echo $texto['help_dd_bien']; ?></dd>
<dt><span class="duda"><img src="img/duda.gif" alt="" class="ico" /> <?php echo $lang['res_th_c']; ?> </span></dt>
<dd><?php echo $texto['help_dd_duda']; ?></dd>
<dt><span class="mal"><img src="img/mal.gif" alt="" class="ico" /> <?php echo $lang['res_th_d'] ?> </span></dt>
<dd><?php echo $texto['help_dd_mal']; ?></dd>
<dt><span class="na"><img src="img/na.gif" alt="" class="ico" /> <?php echo $lang['res_th_e'] ?> </span></dt>
<dd><?php echo $texto['help_dd_na']; ?></dd>
</dl>
<p><?php echo $texto['help_b']; ?><img src="img/estado1.gif" class="der" alt="<?php echo $texto['help_img_2']; ?>" /></p>
<dl>
<dt><span class="parcial"><img src="img/parcial.gif" alt="" class="ico" /> <?php echo $lang['res_th_f']; ?> </span></dt>
<dd><?php echo $texto['help_dd_parcial']; ?></dd>
<dt><img src="img/nose.gif" alt="" class="ico" /> <?php echo $lang['res_th_g']; ?></dt>
<dd><?php echo $texto['help_dd_nose']; ?></dd>
</dl>
<h3><a name="op" id="op"></a><?php echo $texto['help_h2_a']; ?></h3>
<p><?php echo $texto['help_c']; ?></p>
<p><img src="img/revisa1.gif" class="center" alt="<?php echo $texto['help_img_3']; ?>" /></p>
<p><?php echo $texto['help_d']; ?></p>
<p><img src="img/minihelp.gif" alt="<?php echo $lang['dd_alt_instruc']; ?>" class="veren" />
<?php echo $texto['help_icon_a']; ?></p>
<p><img src="img/verpag.gif" alt="<?php echo $lang['dd_alt_page']; ?>" class="veren" />
<?php echo $texto['help_icon_b']; ?></p>
<p><img src="img/vercod.gif" alt="<?php echo $lang['dd_alt_code']; ?>" class="veren" />
<?php echo $texto['help_icon_c']; ?></p>
<p><?php echo $texto['help_e']; ?></p>
<p><?php echo $texto['help_f']; ?></p>
<p><img src="img/page.gif" class="pag" alt="<?php echo $lang['alt_pag_orig']; ?>" />
<?php echo $texto['help_icon_d']; ?></p>
<p><img src="img/code.gif" class="pag" alt="<?php echo $lang['alt_cod_pag']; ?>" />
<?php echo $texto['help_icon_e']; ?></p>
<h3><?php echo $texto['help_h2_b']; ?></h3>
<p><img src="img/heraico.gif" class="pag" alt="<?php echo $lang['ico_alt_res']; ?>" />
<?php echo $texto['help_icon_f']; ?></p>
<p><img src="img/helpno.gif" class="pag" alt="<?php echo $lang['ico_alt_man']; ?>" />
<?php echo $texto['help_icon_g']; ?></p>
<p><img src="img/formno.gif" class="pag" alt="<?php echo $lang['ico_alt_form']; ?>" />
<?php echo $texto['help_icon_h']; ?></p>
<p><img src="img/informe.gif" class="pag" alt="<?php echo $lang['ico_alt_info']; ?>" />
<?php echo $texto['help_icon_i']; ?></p>
<h3><?php echo $texto['help_h3_estil']; ?></h3>
<p><?php echo $texto['help_estil_a']; ?></p>
<h4><?php echo $texto['help_h41_estil']; ?></h4>
<p><img src="img/navega2.gif" class="center" alt="<?php echo $texto['help_img_4']; ?>" /></p>
<p><?php echo $texto['help_estil_b']; ?></p>
<h4><?php echo $texto['help_h42_estil']; ?></h4>
<p><img src="img/navega1.gif" class="center" alt="<?php echo $texto['help_img_5']; ?>" /></p>
<p><?php echo $texto['help_estil_c']; ?></p>
<h3><?php echo $texto['help_h3_informe']; ?></h3>
<p><?php echo $texto['help_informe_a']; ?></p>
<p><?php echo $texto['help_informe_b']; ?></p>
<p><?php echo $texto['help_informe_c']; ?></p>
<h4><?php echo $texto['help_h4_infor1']; ?></h4>
<p><img src="img/vinforhtml.gif" class="der" alt="<?php echo $texto['help_img_6']; ?>" /><?php echo $texto['help_informe_d']; ?></p>
<p><?php echo $texto['help_informe_e']; ?></p>
<h4><?php echo $texto['help_h4_infor2']; ?></h4>
<p><img src="img/vinforrdf.gif" class="der" alt="<?php echo $texto['help_img_7']; ?>" /><?php echo $texto['help_informe_f']; ?></p>
<p><?php echo $texto['help_informe_g']; ?></p>
<p><?php echo $texto['help_informe_h']; ?></p>
<h4><?php echo $texto['help_h4_infor3']; ?></h4>
<p><img src="img/vinforpdf.gif" class="der" alt="<?php echo $texto['help_img_8']; ?>" /><?php echo $texto['help_informe_i']; ?></p>
<h3><?php echo $texto['help_h3_declara']; ?></h3>
<p><?php echo $texto['help_declara_a']; ?></p>
<p><?php echo $texto['help_declara_b']; ?></p>
<p class="centro">
<?php
$arr = array('A', 'AA', 'AAA');
foreach ($arr as $k => $v) {
	echo '<img src="img/her_'.$v.'.gif" alt="'.sprintf($lang['ico_hera_acc'], $v).'" width="90" height="30" />'."\n";
}
?></p>
<p><?php echo $texto['help_declara_c']; ?></p>
<p class="centro">
<?php
$arr = array('A', 'AA', 'AAA');
foreach ($arr as $k => $v) {
	echo '<img src="img/heranwai'.$v.'.gif" alt="'.sprintf($lang['ico_hera_acc'], $v).'" width="80" height="15" />'."\n";
}
?></p>
<p><?php echo $texto['help_declara_d']; ?></p>
<?php echo $texto['help_declara_e']; ?>
<p><?php echo $texto['help_declara_f']; ?></p>
<h3><?php echo $texto['help_h3_integra']; ?></h3>
<p><?php echo $texto['help_integra_a']; ?></p>
<h4><?php echo $texto['help_h4_integra1']; ?></h4>
<p><?php echo $texto['help_integra_b']; ?></p>
<p><?php echo $texto['help_integra_c']; ?></p>
<p><?php echo $texto['help_integra_d']; ?></p>
<p><?php echo $texto['help_integra_e']; ?></p>
<?php echo $texto['help_integra_f']; ?>
<p><?php echo $texto['help_integra_f1']; ?></p>
<h4><?php echo $texto['help_h4_integra2']; ?></h4>
<p><?php echo $texto['help_integra_g']; ?></p>
<p><?php echo $texto['help_integra_h']; ?></p>
<p><?php echo $texto['help_integra_i']; ?></p>
<img src="img/wdfhera1.jpg" class="center" alt="<?php echo $texto['help_img_integrai']; ?>" />
<p><?php echo $texto['help_integra_i2']; ?></p>
<img src="img/wdfhera2.jpg" class="center" alt="<?php echo $texto['help_img_integrai2']; ?>" />
<p><?php echo $texto['help_integra_i3']; ?></p>
<img src="img/wdfhera3.jpg" class="center" alt="<?php echo $texto['help_img_integrai3']; ?>" />
<p><?php echo $texto['help_integra_i4']; ?></p>
<img src="img/wdfhera4.jpg" class="center" alt="<?php echo $texto['help_img_integrai4']; ?>" />
<p><?php echo $texto['help_integra_j']; ?></p>
<h4><?php echo $texto['help_h4_integra3']; ?></h4>
<p><?php echo $texto['help_integra_k']; ?></p>
<p><img src="img/w3devhera.gif" class="der" alt="<?php echo $texto['help_img_9']; ?>" /><?php echo $texto['help_integra_l']; ?></p>
<p><?php echo $texto['help_integra_m']; ?></p>

<p><em><?php echo $texto['help_g']; ?></em></p>
<?php
} else if ($esta == 'info') {
?>
<?php echo $texto['info_indice']; ?>
<p><?php echo $texto['info_a']; ?></p>
<h2><?php echo $texto['info_h2_sobre']; ?></h2>
<p><?php echo $texto['info_origen']; ?></p>
<p><?php echo $texto['info_define']; ?></p>
<p><?php echo $texto['info_difiere']; ?></p>
<p><?php echo $texto['info_proceso']; ?></p>
<h2><?php echo $texto['info_h2cola']; ?></h2>
<p><?php echo $texto['info_b']; ?></p>
<p><?php echo sprintf($texto['info_c'], PHP_SELF.'?ini=code'); ?></p>
<p><?php echo $texto['info_d']; ?></p>
<p class="centro">
<?php
$arr = array('A', 'AA', 'AAA');
foreach ($arr as $k => $v) {
	echo '<img src="img/her_'.$v.'.gif" alt="'.sprintf($lang['ico_hera_acc'], $v).'" width="90" height="30" />'."\n";
}
?></p>
<p><?php echo $texto['info_masicos']; ?></p>
<p><?php echo $texto['info_e']; ?></p>
<h2><?php echo $texto['info_h2']; ?></h2>
<p><?php echo $texto['info_f']; ?></p>
<p><?php echo $texto['info_g']; ?></p>
<p><?php echo $texto['info_h']; ?></p>
<p><?php echo $texto['info_i']; ?></p>
<h2><?php echo $texto['info_h2tradu']; ?></h2>
<p><?php echo $texto['info_a_1']; ?></p>
<?php 
@include_once('lang/'.IDIOMA.'/traducciones.php');
@include_once('lang/traductores.php');
if(is_array($lista_traductores) and !empty($lista_traductores)){
echo "<dl>\n";
foreach ($lista_traductores as $k => $v) {
	echo "<dt>".sprintf($texto['info_trada'], $traducciones[$k])."</dt>\n";
	foreach ($v as $v2) {
		$temp = explode("|", $v2);
		echo '<dd><a href="mailto:'.$temp[1].'" title="Envía un mensaje a '.$temp[0].'."><span lang="';
		if ($temp[0] == 'Ramiro Benavidez') {
			echo 'es';
		} else if ($temp[0] == 'Charles McCathieNevile') {
			echo 'en';
		} else {
			echo $k;
		}
		echo '">'.$temp[0]."</span></a></dd>\n";
	}
}
echo "</dl>\n";
}
?>

<p><?php echo $texto['info_tracola']; ?></p>

<?php
} else if ($esta == 'code') {
?>
<p><?php echo $texto['code_p']; ?></p>
<?php
$archivos = array(
1 => 'index.php.es',
2 => 'view.php',
3 => 'informe.php',
4 => 'color.php',
5 => 'estilos.css',
6 => 'superhera.css',
7 => 'inc/common.php',
8 => 'inc/main.php',
9 => 'inc/file.php',
10 => 'inc/parse.php',
11 => 'inc/resumen.php',
12 => 'inc/content.php',
13 => 'lang/es/elem.php',
14 => 'lang/es/help.php',
15 => 'lang/es/lang.php',
16 => 'lang/es/manual.php',
17 => 'lang/es/view.php',
18 => 'lang/es/wcag.php',
19 => 'lang/es/info.php',
20 => 'lang/es/texto.php'
);
?>
<ul>
<?php
for ($x = 1; $x < 7; $x++) {
	$xx = 'code_'.$x;
	echo '<li><strong>'.$archivos[$x].'</strong> (<a href="codigo.php?p='.$x.'" target="code">'.$texto['code_op_a'].'</a> | <a href="codigo.php?p='.$x.'&amp;opt=down" target="code">'.$texto['code_op_b'].'</a>)<br /><span class="small">'.$texto[$xx].'</span>';
	if ($x == 6) {
		echo "<br /><br /></li>\n\n";
	} else {
		echo "</li>\n\n";
	}
}
?>
<li><?php echo $texto['code_li_a']; ?>
<ul>
<?php
for ($x = 7; $x < 13; $x++) {
	$xx = 'code_'.$x;
	echo '<li><strong>'.$archivos[$x].'</strong> (<a href="codigo.php?p='.$x.'" target="code">'.$texto['code_op_a'].'</a> | <a href="codigo.php?p='.$x.'&amp;opt=down" target="code">'.$texto['code_op_b'].'</a>)<br /><span class="small">'.$texto[$xx].'</span>';
	if ($x == 12) {
		echo "<br /><br /></li>\n\n";
	} else {
		echo "</li>\n\n";
	}
}
?>
</ul></li>
<li><?php echo $texto['code_li_b']; ?>
<ul>
<?php
for ($x = 13; $x < 21; $x++) {
	$xx = 'code_'.$x;
	echo '<li><strong>'.$archivos[$x].'</strong> (<a href="codigo.php?p='.$x.'" target="code">'.$texto['code_op_a'].'</a> | <a href="codigo.php?p='.$x.'&amp;opt=down" target="code">'.$texto['code_op_b'].'</a>)<br /><span class="small">'.$texto[$xx].'</span>';
	if ($x == 20) {
		echo "<br /><br /></li>\n\n";
	} else {
		echo "</li>\n\n";
	}
}
?>
</ul></li>
</ul>
<?php
} else if ($esta == 'thanks') {
?>
<p><?php echo $texto['thanks_a']; ?></p>
<p><?php echo $texto['thanks_b']; ?></p>
<p><?php echo $texto['thanks_c']; ?></p>
<?php
} else {
?>
<p><?php echo $texto['intro_a']; ?></p>
<p><?php echo $texto['intro_b']; ?></p>
<p><?php echo $texto['intro_c']; ?></p>
<p><?php echo $texto['intro_d']; ?></p>
<p><?php echo $texto['intro_e']; ?></p>
<?php
}
if ($_GET['lst']) {
	echo "<h3>Directorio de revisiones</h3>\n";
	DB_Query('select', 'lista', $_GET['lst']);
	$cantidad = mysql_num_rows ($consulta);
	if ($cantidad > 0) {
		echo "<dl class=\"directorio\">\n";
		$x = 1;
		while ($datos = mysql_fetch_array($consulta)) {
			echo "<dt>".$x." - <a href=\"".$PHP_SELF."?id=".$datos['id']."\">".$datos['url']."</a></dt>\n";
			echo "<dd>Fecha: ".gmdate("d/m/Y", strtotime($datos['fecha']))." - Hora: ".gmdate("G:i:s", strtotime($datos['fecha']))." GMT";
			if ($datos['revision'] != '') {
				echo " <em>(Modificado: ".gmdate("d/m/Y", strtotime($datos['revision']))." - ".gmdate("G:i", strtotime($datos['revision']))." GMT)</em>\n";
			}
			echo "</dd>\n";
			if ($datos['resumen'] != '') {
				echo "<dd style=\"margin-left:6em\"><em>".stripslashes($datos['resumen'])."</em></dd>\n";
			}
			$x++;
		}
		echo "</dl>";
	} else {
		echo "<p>No existen revisiones.</p>";
	}
}
?> 
</div>
