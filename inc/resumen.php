<?php

// Alteração VVB - 27/10/2008
require("metrics.php");
// ----------------------------------------- end VVB

/*=======================================
  HERA v.2.0 Beta                        
  File: resumen.php                      
  Make summary and navigation system     
=======================================*/

	// Alteração VVB - 28/10/2008
	function Obter_Resultados()
	{
		$metrics = new Metric;
		$metrics->barriers();
		$results = array();
		$results[0] = $metrics->potential_problems("auto");
		$results[1] = $metrics->WAB("auto");
		$results[2] = $metrics->UWEM("auto");
		$results[3] = $metrics->a3("auto");
		$results[4] = $metrics->WAQM("auto");
		//echo "teste: " . $results[0];
		return $results;
	}
	// ----------------------------------------- end VVB

class Resumen {
	var $t_duda = 0;
	var $t_mal = 0;
	var $t_parcial = 0;
	var $t_nose = 0;
	var $accesibilidad = '';

/*====================================================*\
	Function: Total results by priorities                
	e.g., $resultados['AAAduda'] means:                  
	checkpoints of priority 'AAA'- result 'cannot tell'  
\*====================================================*/

	function __construct()
	{
		changeVariables();
	}


	function Resumen() {
	
		global $mis_puntos, $wcag1, $lst_A, $lst_AA, $lst_AAA, $resultados, $lang;
		
		$resultados = array();
		
		$letras = array('A' => 'lst_A', 'AA' => 'lst_AA', 'AAA' => 'lst_AAA');
		
		foreach ($letras as $p => $arr) {
			foreach ($$arr as $k => $v) {
				if (array_key_exists($v, $wcag1)) {
					$x = $p.$mis_puntos[$v];
				}
				$resultados[$x]++;
			}
		}
		$this->t_duda = $resultados['Aduda'] + $resultados['AAduda'] + $resultados['AAAduda'];
		$this->t_mal = $resultados['Amal'] + $resultados['AAmal'] + $resultados['AAAmal'];
		$this->t_parcial = $resultados['Aparcial'] + $resultados['AAparcial'] + $resultados['AAAparcial'];
		$this->t_nose = $resultados['Anose'] + $resultados['AAnose'] + $resultados['AAAnose'];

		if ($resultados['Aduda'] + $resultados['Anose'] + $resultados['Aparcial'] + $resultados['Amal'] == 0) {
			if ($resultados['AAduda'] + $resultados['AAnose'] + $resultados['AAparcial'] + $resultados['AAmal'] == 0) {
				if ($resultados['AAAduda'] + $resultados['AAAnose'] + $resultados['AAAparcial'] + $resultados['AAAmal'] == 0) {
					$ico_acc = 'AAA';
				} else {
					$ico_acc = 'AA';
				}
			} else {
				$ico_acc = 'A';
			}
			$this->accesibilidad = ' <img src="img/her_'.$ico_acc.'.gif" alt="'.sprintf($lang['ico_hera_acc'], $ico_acc).'" width="90" height="30" style="float:right" />';
		}
	} // End function Resumen

/*===============================*\
	Function: Write summary table   
\*===============================*/

	function Results() {
	
		// Alteração VVB - 28/10/2008
		$results = Obter_Resultados();
		// ----------------------------------------- end VVB

		global $totales, $lang, $wcag, $param, $marcos, $fecha, $nombre, $lang, $software;
		/*RGB begin*/
		global $emag;
		/*RGB end*/
		$note_a = '<p class="nota"><img src="img/nota.gif" alt="'.$lang['ico_alt_aviso'].'" class="ico" /> ';
		$note_b = "</p>\n";

		echo '<div class="caja">'."\n";
		if ($totales['url_redir']) {
			echo '<p class="nota" style="color:#666">'.sprintf($lang['nota_uri'], $totales['url_redir'], URL).'</p>';
		}
		if ($totales['meta_redir']) {
			echo $note_a.sprintf($lang['nota_meta'], $totales['meta_redir'], URL).$note_b;
		}
		if (count($marcos) > 0) {
			echo $note_a;
			printf($lang['frame_aviso'], count($marcos));
			echo $note_b."<ol class=\"nota_f\">\n";
			foreach ($marcos as $links) {
				echo '<li>'.$links."</li>\n";
			}
			echo "</ol>\n";
			$nota_marcos = '<br />'.$lang['frame_aviso2'];
		} else {
			if ($totales['body'] != 1) {
				if ($totales['body'] > 1) {
					$err1 = sprintf($lang['err_body_a'], $totales['body']);
				} else {
					$err1 = $lang['err_body_b'];
				}
				echo $note_a.$err1.' '.$lang['err_body_c'].$note_b;
			}
			if ($totales['redirect'] > 0) {
				echo $note_a.$lang['nota_redirect'].$note_b;
			} else if ($totales['refresh'] > 0) {
				echo $note_a.$lang['nota_refresh'].$note_b;
			}
			if ($totales['script'] > 0) {
				echo $note_a.$lang['nota_scripts'].$note_b;
			}
		}

		echo "\n\n".'<div style="display:none">';
		foreach ($totales as $k => $v) {
			echo $k.' : '.$v."\n";
		}
		echo "</div>\n";

?>
<h2 style="margin: 0px 5%;text-align:left"><img src="img/heraico.gif" class="pag" alt="<?php echo $lang['logo_alt']; ?>" /> <?php echo $lang['h2_sumario']; ?></h2>

<ul class="resumen">
<li><em>URL</em>: <?php echo URL.$this->accesibilidad; ?></li>
<li><em><?php echo $lang['li_fecha']; ?></em>: <?php echo gmdate($lang['formato_fecha'], strtotime($fecha)); ?></li>
<li><?php echo sprintf($lang['li_total'], $totales['total']); ?></li>
<li><?php echo sprintf($lang['li_tiempo'], $totales['tiempo']); ?></li>
<?php
		if ($this->t_mal > 0) {
			echo '<li><em>'.$lang['li_error'].'</em>: ';
			echo '<strong class="mal"> '.sprintf($lang['li_error_vs'], $this->t_mal).'</strong></li>';
		}
/* Alterações VVB 29/10/2008*/	
?> 
<li><strong class="duda"><?php echo $lang['li_manual']; ?>: 
<?php
		if ($this->t_duda > 0) {
			echo sprintf($lang['li_manual_vs'], $this->t_duda).'</strong>';
		} else {
			echo $lang['li_manual_no'].'</strong>';
		}
		echo $nota_marcos;
		$autor = ($nombre == '')? $lang['li_autor_no'] : $nombre;
?></li>
<li><em><?php echo $lang['li_autor']; ?></em>: <?php echo $autor; ?></li>
<?/*-------------------------------------------end VVB*/ ?>

<li><em>Navegador</em>: <?php $this->_UA($software); ?></li>
</ul>

<h3><?php echo $lang['h3_nav_res']; ?></h3>
<p><em><?php echo $lang['p_nav_res']; ?></em></p>

<table summary="<?php echo $lang['res_summary']; ?>" cellspacing="0" cellpadding="3" class="totales">
<caption><?php echo $lang['res_caption']; ?></caption>
<tr>
<th style="width:90px" scope="col"><?php echo $lang['res_th_a']; ?></th>
<th scope="col"><?php echo $lang['res_th_c']; ?></th>
<th scope="col"><?php echo $lang['res_th_b']; ?></th>
<th scope="col"><?php echo $lang['res_th_d']; ?></th>
<th scope="col"><?php echo stripslashes($lang['res_th_e']); ?></th>
<?php
		if ($this->t_parcial > 0) {
?>
<th scope="col"><?php echo $lang['res_th_f']; ?></th>
<?php
		}
		if ($this->t_nose > 0) {
?>
<th scope="col"><?php echo $lang['res_th_g']; ?></th>
<?php
		}
?>
</tr>
<?php
		$cel = array ( 2 => 'duda', 1 => 'bien', 3 => 'mal', 4 => 'na', 5 => 'parcial', 6 => 'nose' );
			$prx = 'A';
			$num = 1;
			for ($x=1; $x < 4; $x++) {
				$txt = 'res_alt_'.$prx;
				echo '<tr>'."\n".'<th scope="row" class="thpri"><img src="img/wcag1'.$prx.'.gif" class="wcag" alt="'.$lang[$txt].'" /></th>'."\n";
				foreach ($cel as $key => $val) {
					if (($key < 5) || (($key == 5) && ($this->t_parcial > 0)) || (($key == 6) && ($this->t_nose > 0))) {
						echo '<td class="'.$val.'">'.$this->ico_res($prx, $val).'</td>'."\n";
					}
				}
				echo "</tr>\n";
				$prx = $prx.'A';
				$num++;
			}
?>
</table>

<?php /*Necessário Alterar - RGB*/ ?>
<h3><?php echo $lang['h3_nav_pautas']; ?></h3>
<p><em><?php echo $lang['p_nav_pautas']; ?></em></p>
<ul class="pr_lista">
<?php
		for ($x=1; $x < 15; $x++) {
			$wc = $x * 10;
			echo '<li><a href="'.PHP_SELF.$param.'&amp;pt='.$x.'" title="'.$wcag[$wc].'">'.sprintf($lang['li_nav_pautas'], $x).'</a></li>'."\n";
		}
?>
</ul>
<? /*Fim alteração - RGB*/ ?>

<? // Alteração VVB - 28/10/2008 ?>

<h3 id="metrics"><?php echo $lang['met_avl']; ?></h3>
<ul class="resumen_met">
<li><em>URL</em>: <?php echo URL.$this->accesibilidad; ?></li>
<li><?php echo sprintf($lang['li_total'], $totales['total']); ?></li>
<?php
		if ($this->t_mal > 0) {
			echo '<li><em>'.$lang['li_error'].'</em>: ';
			echo '<strong class="mal"> '.sprintf($lang['li_error_vs'], $this->t_mal).'</strong></li>';
		}
?> 
<li><em>Erros por total de elementos</em>: 
<?php 
	$numero = sprintf("%d", $this->t_mal); 
	//echo $numero;
	$resultado = $numero / $totales['total'] ;
	echo '<strong>';
    echo number_format($resultado, 2, '.', '');
	echo '</strong>';	
?></li>	
</ul>

<table summary="<?php echo $lang['met_summary']; ?>" cellspacing="0" cellpadding="3" class="total">
<caption><?php echo $lang['met_caption']; ?></caption>
<tr>
<th style="width:140px" scope="col"><?php echo $lang['met_th_a']; ?></th>
<th scope="col"><?php echo $lang['met_th_b']; ?></th>
</tr>
<tr> <td scope="row" class="na"> POT </td> <td class="bien"><?php echo number_format($results[0], 2, '.', ''); ?></td> </tr>
<tr> <td scope="row" class="na"> WAB </td> <td class="bien"><?php echo number_format($results[1], 2, '.', ''); ?></td> </tr>
<tr> <td scope="row" class="na"> UWEM </td> <td class="bien"><?php echo number_format($results[2], 2, '.', ''); ?></td> </tr>
<tr> <td scope="row" class="na"> A3 </td> <td class="bien"><?php echo number_format($results[3], 2, '.', ''); ?></td> </tr>
<tr> <td scope="row" class="na"> WAQM </td> <td class="bien"><?php echo number_format($results[4], 2, '.', ''); ?></td> </tr>
</table>

<h3 id="metrics"><?php echo $lang['h3_met_result']; ?></h3>
<ul class="resumen_met">
<li id="metrics"><em><?php echo $lang['li_met_pot']; ?></em>: <?php echo $lang['li_met_pot_exp']; ?>
	<ul><li id="sub"><?php echo $lang['li_met_pot_exp_v']; ?></li></ul></li>
<li id="metrics"><em><?php echo $lang['li_met_wab']; ?></em>: <?php echo $lang['li_met_wab_exp']; ?>
	<ul><li id="sub"><?php echo $lang['li_met_wab_exp_v']; ?></li></ul></li>
<li id="metrics"><em><?php echo $lang['li_met_uwem']; ?></em>: <?php echo $lang['li_met_uwem_exp']; ?>
	<ul><li id="sub"><?php echo $lang['li_met_uwem_exp_v']; ?></li></ul></li>
<li id="metrics"><em><?php echo $lang['li_met_a3']; ?></em>: <?php echo $lang['li_met_a3_exp']; ?>
	<ul><li id="sub"><?php echo $lang['li_met_a3_exp_v']; ?></li></ul></li>
<li id="metrics"><em><?php echo $lang['li_met_waqm']; ?></em>: <?php echo $lang['li_met_waqm_exp']; ?>
	<ul><li id="sub"><?php echo $lang['li_met_waqm_exp_v']; ?></li></ul></li>
</ul>

<?// ----------------------------------------- end VVB?>
</div>

<?php
	} // Fin función Results

/*================================================*\
	Función: Crea la tabla o lista de navegación
\*================================================*/

	function Navega($by) {
		global $lang, $param;

		if ($by == 'pauta') {
			echo '<dl class="submenu"><dt style="font-size:80%">'.$lang['h3_nav_pautas'].':</dt>'."\n";
			for ($i=1; $i < 15; $i++) {
				if (PT == $i) {
					echo '<dd class="actual">'.$i.'</dd>'."\n";
				} else {
					echo '<dd><a href="'.PHP_SELF.$param.'&amp;pt='.$i.'">'.$i.'</a></dd>'."\n";
				}
			}
			echo '</dl>'."\n\n";
		} else if ($by == 'prioridad') {
			echo '<table summary="'.$lang['ico_tit_res'].'" class="tsubmenu">'."\n";
			echo '<caption style="font-size:80%">'.$lang['h3_nav_res'].'</caption>'."\n";

			$cel = array ( 2 => 'duda', 1 => 'bien', 3 => 'mal', 4 => 'na', 5 => 'parcial', 6 => 'nose' );
			$prx = 'A';
			$num = 1;
			for ($x=1; $x < 4; $x++) {
				echo '<tr>'."\n".'<th class="pr" scope="row"><abbr title="'.sprintf($lang['bc_priori'], $num).'">P.'.$num.'</abbr></th>'."\n";
				foreach ($cel as $key => $val) {
					if (($key < 5) || (($key == 5) && ($this->t_parcial > 0)) || (($key == 6) && ($this->t_nose > 0))) {
						echo '<td'.$this->Clase($num,$key,$val).'>'.$this->ico_res($prx, $val, true).'</td>'."\n";
					}
				}
				echo "</tr>\n";
				$prx = $prx.'A';
				$num++;
			}
			echo "</table>\n\n";
		}
		//echo '<div class="caja">'."\n";
	} // Fin función Details

/*================================================*\
	Función: Define la clase para las celdas
\*================================================*/

	function Clase($p, $r, $cl) {
		if (($p == PR) && ($r == RE)) {
			return ' class="tdactual"';
		} else {
			return ' class="'.$cl.'"';
		}
	} // Fin función Clase


/*================================================*\
	Función: Crea los iconos de acuerdo al resultado
\*================================================*/

	function ico_res($priori, $resulta, $mini=false) {
		global $param, $lang, $resultados;

		if ($priori == 'A') {
			$pri = 1;
		} else if ($priori == 'AA') {
			$pri = 2;
		} else if ($priori == 'AAA') {
			$pri = 3;
		}

		switch ($resulta) {
			case 'bien':
				$res = 1;
				$txt_tit = $lang['res_tit_b'];
			break;
			case 'duda':
				$res = 2;
				$txt_tit = $lang['res_tit_c'];
			break;
			case 'mal':
				$res = 3;
				$txt_tit = $lang['res_tit_d'];
			break;
			case 'na':
				$res = 4;
				$txt_tit = $lang['res_tit_e'];
			break;
			case 'parcial':
				$res = 5;
				$txt_tit = $lang['res_tit_f'];
			break;
			case 'nose':
				$res = 6;
				$txt_tit = $lang['res_tit_g'];
			break;
		}
		$res_array = $priori.$resulta;

		if ($mini == false) {
			if ($resultados[$res_array] > 0) {
				return '<a href="'.PHP_SELF.$param.'&amp;pr='.$pri.'&amp;re='.$res.'" title="'.$txt_tit.' '.$pri.'.">'.$resultados[$res_array].' <img src="img/'.$resulta.'.gif" alt="'.$txt_tit.' '.$pri.'." class="ico" /></a>';
			} else {
				return '--';
			}
		} else {
			if ($resultados[$res_array] > 0) {
				return '<a href="'.PHP_SELF.$param.'&amp;pr='.$pri.'&amp;re='.$res.'" title="'.$txt_tit.' '.$pri.'.">'.$resultados[$res_array].' <img src="img/'.$resulta.'.gif" alt="'.$txt_tit.' '.$pri.'." class="ico2" /></a>';
			} else {
				return '-';
			}
		}
	} // Fin function ico_res


/*================================================*\
	Función: Muestra el formulario del informe       
\*================================================*/

	function Form_Info() {
		global $resumen, $nombre, $lang;

		$_id = ID;
		$_idioma = IDIOMA;
		$_resumen = stripslashes($resumen);
		$nombre = stripslashes($nombre);
?>
<div class="caja">
<form action="informe.php" id="formi" target="url" method="post">

<div class="formdiv">
<h2><?php echo $lang['ico_alt_form']; ?></h2>
<fieldset>
<legend><?php echo $lang['info_leg_autor']; ?></legend>
<p><label for="nombre"><strong><?php echo $lang['info_input_name']; ?>:</strong>
<input type="text" name="nombre" id="nombre" value="<?php echo $nombre; ?>" size="70" /></label></p>
<p><label for="email"><strong><?php echo $lang['info_input_mail']; ?>:</strong>
<input type="text" name="email" id="email" value="" size="70" /></label>
<input type="hidden" name="id" id="id" value="<?php echo $_id; ?>" />
<input type="hidden" name="idioma" id="idioma" value="<?php echo $_idioma; ?>" />
</p>
</fieldset>

<fieldset>
<legend><?php echo $lang['info_leg_info']; ?></legend>
<p><label for="titulo"><strong><?php echo $lang['info_input_title']; ?>:</strong>
<input type="text" name="titulo" id="titulo" value="" size="70" /></label></p>
<p><label for="Comentario"><strong><?php echo $lang['info_input_coment']; ?>:</strong><br /><textarea cols="75" rows="10" name="Comentario" id="Comentario"><?php echo $resumen; ?></textarea></label></p>
</fieldset>

<fieldset>
<legend><?php echo $lang['info_leg_incluir']; ?></legend>
<p><label class="duda"><input type="checkbox" name="box[]" value="duda" id="r1" checked="checked" /> <?php echo ucfirst($lang['result_notTested']); ?></label> | 
<label class="bien"><input type="checkbox" name="box[]" value="bien" id="r2" checked="checked" /> <?php echo ucfirst($lang['result_pass']); ?></label> | 
<label class="mal"><input type="checkbox" name="box[]" value="mal" id="r3" checked="checked" /> <?php echo ucfirst($lang['result_fail']); ?></label> | 
<label class="na"><input type="checkbox" name="box[]" value="na" id="r4" checked="checked" /> <?php echo ucfirst($lang['result_notApplicable']); ?></label> |
<label class="parcial"><input type="checkbox" name="box[]" value="parcial" id="r5" checked="checked" /> <?php echo ucfirst($lang['result_parcial']); ?></label> |
<label class="nose"><input type="checkbox" name="box[]" value="nose" id="r6" checked="checked" /> <?php echo ucfirst($lang['result_cannotTell']); ?></label></p>
</fieldset>

<fieldset>
<legend><?php echo $lang['info_leg_html']; ?></legend>
<p class="centro">
<input type="submit" name="html" value="<?php echo $lang['info_btn_html']; ?>" />
<input type="submit" name="htmldown" value="<?php echo $lang['info_btn_html2']; ?>" /></p>
</fieldset>

<fieldset>
<legend><?php echo $lang['info_leg_rdf']; ?></legend>
<p class="centro">
<input type="submit" name="earl" value="<?php echo $lang['info_btn_rdf']; ?>" />
<input type="submit" name="earldown" value="<?php echo $lang['info_btn_rdf2']; ?>" /></p>
</fieldset>

<fieldset>
<legend><?php echo $lang['info_leg_pdf']; ?></legend>
<p class="centro">
<input type="submit" name="pdf" value="<?php echo $lang['info_btn_pdf']; ?>" />
<br /><span style="font-size:0.9em"><?php echo sprintf($lang['info_txt_pdf'], ' <a href="http://www.fpdf.org/">FPDF</a>'); ?></span>
</p>
</fieldset>
</div>
</form>
</div>

<?php
	} // Fin función Form_Info


	function _UA($nav) {
		$browser = '';
		$version = '';
		$mayor = '0';
		$menor = '0';
		$OS = '';

		if (eregi('Opera ([0-9].[0-9]{1,2})',$nav)) {
			$browser = 'Opera';
			$version = 'Opera';
		} else if (eregi('Opera/([0-9].[0-9]{1,2})',$nav)) {
			$browser = 'Opera';
			$version = 'Opera/';
		} else if (eregi('Konqueror/([0-9].[0-9]{1,2})',$nav)) {
			$browser = 'Konqueror';
			$version = 'Konqueror/';
		} else if (eregi('Safari/([0-9]{1,2})',$nav)) {
			$browser = 'Safari';
			$version = 'Safari/';
		} else if (eregi('Firefox/([0-9]{1,2})',$nav)) {
			$browser = 'Mozilla Firefox';
			$version = 'Firefox/';
		} else if (eregi('MSIE ([0-9].[0-9]{1,2})',$nav)) {
			$browser = 'IE';
			$version = 'MSIE';
		} else if (eregi('Netscape6/([0-9].[0-9]{1,2})',$nav)) {
			$browser = 'Netscape';
			$version = 'Netscape6/';
		} else if (eregi('Netscape/([0-9].[0-9]{1,2})',$nav)) {
			$browser = 'Netscape';
			$version = 'Netscape/';
		} else if (eregi('Mozilla/([0-9].[0-9]{1,2})',$nav)) {
			$browser = 'Netscape';
			$version = 'Mozilla/';
		} else {
			$browser = '--';
		}

		if ($browser != '--') {
			$posy = strpos($nav, $version, 0);
			$startp = $posy + strlen($version);
			$shorts = substr($nav, $startp );
			$tok = strtok($shorts, ".");

			//Netscape 6
			if ($version == 'Mozilla/' && $tok==5) {
				$mayor = '6';
			} else {
				$mayor = $tok;
			}

			$tok = strtok(",;)(' '");
			$menor = $tok;
			$browser = $browser." ". $mayor.".".$menor;

			if (strstr($nav,'Win')) {
				if (strstr($nav,'95')) {
					$OS = 'Windows 95';
				} else if (strstr($nav,'ME')) {
					$OS = 'Windows ME';
				} else if (strstr($nav, '9x 4.90')) {
					$OS = 'Windows ME';
				} else if (strstr($nav,'98')) {
					$OS = 'Windows 98';
				} else if (strstr($nav,'NT 4')) {
					$OS = 'Windows NT';
				} else if (strstr($nav,'NT 5.0')) {
					$OS = 'Windows 2000';
				} else if (strstr($nav,'NT 5.1')) {
					$OS = 'Windows XP';		
				} else {
					$OS = 'Windows NT';
				}
			} else if (strstr($nav,'Mac')) {
				$OS = 'Mac';
			} else if (strstr($nav,'Linux')) {
				$OS = 'Linux';
			} else if (strstr($nav,'Unix')) {
				$OS = 'Unix';
			} else {
				$OS = 'S.O. no identificado';
			}
			echo $browser.' ('.$OS.')';
		} else {
			echo 'Sin identificar';
		}
	} // Fin function _UA()

} // Fin clase Resumen

?>