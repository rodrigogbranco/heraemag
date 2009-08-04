<?php
if(!defined('IDIOMA')){die();}
include_once('lang/'.IDIOMA.'/help.php');
include_once('lang/'.IDIOMA.'/manual.php');
include_once('lang/'.IDIOMA.'/elem.php');

if (AN == 1) {
	echo '<form action="'.PHP_SELF.'" id="formr" method="post">'."\n";
}

if (PT > 0) {
	echo '<h2 style="margin-top:3em">'.$lang['pauta_sin'].' '.PT.' :<br />';
	if($_SESSION['emag'] == false)
		echo $wcag[PT * 10];
	else
		echo $emag[PT * 10];
	echo "</h2>\n";
	echo $mis_resultados;
} else if (PR > 0) {
	echo '<h2 style="margin-top:-1em">'.$lang['prioridad'].' '.PR.':<br />';
	switch (RE) {
		case 1:
			echo $resultados[_A.'bien'].' '.$lang['res_h2_b'];
		break;
		case 2:
			echo $resultados[_A.'duda'].' '.$lang['res_h2_c'];
		break;
		case 3:
			echo $resultados[_A.'mal'].' '.$lang['res_h2_d'];
		break;
		case 4:
			echo $resultados[_A.'na'].' '.$lang['res_h2_e'];
		break;
		case 5:
			echo $resultados[_A.'parcial'].' '.$lang['res_h2_f'];
		break;
		case 6:
			echo $resultados[_A.'nose'].' '.$lang['res_h2_g'];
		break;
	}
	echo "</h2>\n";
	echo $mis_resultados;
}

$ver_resultado = new checkpoint();

if (PT > 0) {
	/*RGB begin*/
	if($_SESSION['emag'] == false)
	{
		switch (PT) {
			case 1:
				$lst = array(11, 12, 13, 14, 15);
			break;
			case 2:
				$lst = array(21, 22);
			break;
			case 3:
				$lst = array(31, 32, 33, 34, 35, 36, 37);
			break;
			case 4:
				$lst = array(41, 42, 43);
			break;
			case 5:
				$lst = array(51, 52, 53, 54, 55, 56);
			break;
			case 6:
				$lst = array(61, 62, 63, 64, 65);
			break;
			case 7:
				$lst = array(71, 72, 73, 74, 75);
			break;
			case 8:
				$lst = array(81);
			break;
			case 9:
				$lst = array(91, 92, 93, 94, 95);
			break;
			case 10:
				$lst = array(101, 102, 103, 104, 105);
			break;
			case 11:
				$lst = array(111, 112, 113, 114);
			break;
			case 12:
				$lst = array(121, 122, 123, 124);
			break;
			case 13:
				$lst = array(131, 132, 133, 134, 135, 136, 137, 138, 139, 1310);
			break;
			case 14:
				$lst = array(141, 142, 143);
			break;
		}
	}
	else
	{
		switch (PT) {
			case 1:
				$lst = array(134, '111e', 63, '121e');
			break;
			case 2:
				$lst = array(21, 22, 61, 55, 52, 62, 33, 53, 54, 42, 56);
			break;
			case 3:
				$lst = array(32, 34, 36, 31, 37, 35);
			break;
			case 4:
				$lst = array(43, 41, 141, 122, 64, 143, 123, 104, 124, 42, 56, 113, 142);
			break;
			case 5:
				$lst = array(65, 121, 64, 63);
			break;
			case 6:
				$lst = array(71, 72, 94, 73, 114, 75, 101, 93, 112, 95);
			break;
			case 7:
				$lst = array(1310, 134, 102, 135, 136, 137, 138, 139, 131, 313);
			break;
			case 8:
				$lst = array(114);
			break;
		}
	}
	/*RGB end*/

	$last = end($lst);
	foreach ($lst as $x => $y) {
		if ($mis_puntos[$y] != $puntos[$y]) {
			switch ($mis_puntos[$y]) {
				case 'bien':
					$mi_re = 1;
				break;
				case 'duda':
					$mi_re = 2;
				break;
				case 'mal':
					$mi_re = 3;
				break;
				case 'na':
					$mi_re = 4;
				break;
				case 'parcial':
					$mi_re = 5;
				break;
				case 'nose':
					$mi_re = 6;
				break;
			}
			$ver_resultado->Este_Punto($y,$wcag1[$y],$mi_re);
		} else {
			$ver_resultado->Este_Punto($y,$wcag1[$y]);
		}
	}

} else if (PR > 0) {

	switch (PR) {
		case 1:
		$lst = $lst_A;
		break;
		case 2:
		$lst = $lst_AA;
		break;
		case 3:
		$lst = $lst_AAA;
		break;
	}

	$last = end($lst);
	foreach ($lst as $x => $y) {
		if ( ((RE==1)&&($mis_puntos[$y]=='bien')) ||
			((RE==2)&&($mis_puntos[$y]=='duda')) ||
			((RE==3)&&($mis_puntos[$y]=='mal')) ||
			((RE==4)&&($mis_puntos[$y]=='na')) ||
			((RE==5)&&($mis_puntos[$y]=='parcial')) ||
			((RE==6)&&($mis_puntos[$y]=='nose')) ) {
				$ver_resultado -> Este_Punto($y,$wcag1[$y],RE);
			}
	}
}

if (AN == 1) {
	echo '<div class="formdiv">'."\n";
	echo "<fieldset>\n<legend>".$lang['form_leg_res']."</legend>\n";
	echo '<p><label for="coment"><em>'.$lang['form_lbl_com'].'</em><br />'."\n";
	echo '<textarea cols="75" rows="4" name="resumen" id="coment">'.stripslashes($resumen).'</textarea></label><br />';
	echo '<label for="nombre"><em>'.$lang['form_lbl_rev'].'</em><br />'."\n";
	echo '<input type="text" name="nombre" id="nombre" value="'.$nombre.'" size="50" /></label>'."\n";
	echo '<input type="submit" name="resulta" value="'.$lang['form_btn_res'].'" />'."\n";
	echo '<input type="hidden" name="id" value="'.ID.'" />'."\n";
	echo '<input type="hidden" name="hi" value="0" />'."\n";
	echo '<input type="hidden" name="hl" value="0" />'."\n";
	echo '<input type="hidden" name="an" value="0" />'."\n";
	if (PR > 0) {
		echo '<input type="hidden" name="pr" value="'.PR.'" />'."\n";
	}
	if (PT > 0) {
		echo '<input type="hidden" name="pt" value="'.PT.'" />'."\n";
	}
	if (RE > 0) {
		echo '<input type="hidden" name="re" value="'.RE.'" />'."\n";
	}
	echo "</p>\n</fieldset>\n</div>\n";
	echo "</form>\n";
}


class checkpoint {

	var $dif = 0;
	var $res_texto = array (
		'bien' => 'correcto',
		'mal' => 'incorrecto',
		'duda' => 'a verificar',
		'na' => 'no aplicable',
		'parcial' => 'parcial',
		'nose' => 'no sé'	);

	function checkpoint () {
		global $lang;
		$this->res_texto = array (
		'bien' => $lang['result_pass'],
		'mal' => $lang['result_fail'],
		'duda' => $lang['result_notTested'],
		'na' => $lang['result_notApplicable'],
		'parcial' => $lang['result_parcial'],
		'nose' => $lang['result_cannotTell']	);
	}

	function Este_Punto($x,$y,$z=0) {
	
	global $puntos, $mis_puntos, $wcag, $totales, $manual, $help, $comentarios, $elem, $lang;
	if (AN == 1) {
		$z = 0;
	}

	if ($mis_puntos[$x] != $puntos[$x]) {
		$this->dif = 1;
	}
	
	$skip = false;
	if(($_SESSION['emag'] ==  true) && ($x == 53 || $x == 56 || $x == 92 || $x == 72))
		$skip = true;
		
	//duplicateds itens, do not check
	if($skip == false)
	{
		$this->Icon_Res($mis_puntos[$x],$y,$puntos[$x]);
		echo '<dd class="dd_wcag"><blockquote title="';
		echo sprintf($lang['dd_tit_blq'], $y);
		echo '">'.$wcag[$x]."</blockquote></dd>\n\n";

			// Manual
			if (HL == 1) {
				$items[11] = array (1101, 1102, 1103, 1104, 1105, 1106, 1107, 1108, 1109, 1110, 1111);
				$items[13] = array (1301, 1302, 1303);
				$items[14] = array (1401, 1402, 1403);
				$items[32] = array (3201,3202);
				$items[33] = array (3301, 3302, 3303);
				$items[34] = array (3401, 3402);
				$items[62] = array (6201, 6202);
				$items[63] = array (6301, 6302, 6303, 6304);
				$items[65] = array (6501, 6502);
				$items[74] = array (7401, 7402);
				$items[75] = array (7501, 7502);
				$items[81] = array (8101, 8102, 8103, 8104);
				$items[92] = array (9201, 9202);
				$items[101] = array (10101, 10102);
				$items[112] = array (11201, 11202);
				echo '<dd class="man"><p><img src="img/helpsia.gif" alt="'.$lang['ico_alt_man'].'" class="ninihlp" /> <strong>';
				echo sprintf($lang['dd_txt_hlp'], $y);
				echo '</strong></p>'."\n".$manual[$x];
				echo "<ul>\n";
				if (is_array($items[$x])) {
					foreach ($items[$x] as $item) {
						echo "<li>".$help[$item]."</li>\n";
					}
				} else {
					echo "<li>".$help[$x]."</li>\n";
				}
				echo "</ul>\n</dd>\n\n";
			}
		if ($this->dif == 1) {
			$this->Punto($mis_puntos[$x],Info(1,'chked'),$comentarios[$x],$x);
		} else if ($comentarios[$x] != '') {
			$this->Punto($puntos[$x],'Comentario',$comentarios[$x],1000);
		}
	}

	switch ($x) {
	
	case '111e':
		if (($puntos['11101e']=='mal')&&(($z==0)||($z==3))) {
			$this->Punto('mal',$elem['11101e'],Info('11101e','mal'),'11101e');
		} else if (($puntos['11101e']=='duda')&&(($z==0)||($z==2))) {
			$this->Punto('duda',$elem['11101e'],Info('11101e','duda'),'11101e');
		} else if (($puntos['11101e']=='na')&&(($z==0)||($z==4))) {
			$this->Punto('na',$elem['11101e'],Info('11101e','na'),'11101e');
		} else if ($this->dif == 1) {
			$this->Punto($mis_puntos['111e'],$elem['11101e'],Info(1,'chk'),'11101e');
		}

		if (($puntos['11102e']=='mal')&&(($z==0)||($z==3))) {
			$this->Punto('mal',$elem['11102e'],Info('11102e','mal'),'11102e');
		} else if (($puntos['11102e']=='duda')&&(($z==0)||($z==2))) {
			$this->Punto('duda',$elem['11102e'],Info('11102e','duda'),'11102e');
		} else if (($puntos['11102e']=='na')&&(($z==0)||($z==4))) {
			$this->Punto('na',$elem['11102e'],Info('11102e','na'),'11102e');
		} else if ($this->dif == 1) {
			$this->Punto($mis_puntos['111e'],$elem['11102e'],Info(1,'chk'),'11102e');
		}

		if (($puntos['11103e']=='mal')&&(($z==0)||($z==3))) {
			$this->Punto('mal',$elem['11103e'],Info('11103e','mal'),'11103e');
		} else if (($puntos['11103e']=='duda')&&(($z==0)||($z==2))) {
			$this->Punto('duda',$elem['11103e'],Info('11103e','duda'),'11103e');
		} else if (($puntos['11103e']=='na')&&(($z==0)||($z==4))) {
			$this->Punto('na',$elem['11103e'],Info('11103e','na'),'11103e');
		} else if ($this->dif == 1) {
			$this->Punto($mis_puntos['111e'],$elem['11103e'],Info(1,'chk'),'11103e');
		}

		if (($puntos['11104e']=='duda')&&(($z==0)||($z==2))) {
			$this->Punto('duda',$elem['11104e'],Info('11104e','duda'),'11104e');
		} else if (($puntos['11104e']=='na')&&(($z==0)||($z==4))) {
			$this->Punto('na',$elem['11104e'],Info('11104e','na'),'11104e');
		} else if ($this->dif == 1) {
			$this->Punto($mis_puntos['111e'],$elem['11104e'],Info(1,'chk'),'11104e');
		}
	break;
	
	case '121e':
		if (($puntos['12101e']=='duda')&&(($z==0)||($z==2))) {
			$this->Punto('duda',$elem['12101e'],Info('12101e','duda'),'12101e');
		} else if (($puntos['12101e']=='na')&&(($z==0)||($z==4))) {
			$this->Punto('na',$elem['12101e'],Info('12101e','na'),'12101e');
		} else if ($this->dif == 1) {
			$this->Punto($mis_puntos['121e'],$elem['12101e'],Info(1,'chk'),'12101e');
		}

		if (($puntos['12102e']=='mal')&&(($z==0)||($z==3))) {
			$this->Punto('mal',$elem['12102e'],Info('12102e','mal'),'12102e');
		} else if (($puntos['12102e']=='duda')&&(($z==0)||($z==2))) {
			$this->Punto('duda',$elem['12102e'],Info('12102e','duda'),'12102e');
		} else if (($puntos['12102e']=='na')&&(($z==0)||($z==4))) {
			$this->Punto('na',$elem['12102e'],Info('12102e','na'),'12102e');
		} else if ($this->dif == 1) {
			$this->Punto($mis_puntos['121e'],$elem['12102e'],Info(1,'chk'),'12102e');
		}

		if (($puntos['12103e']=='duda')&&(($z==0)||($z==2))) {
			$this->Punto('duda',$elem['12103e'],Info('12103e','duda'),'12103e');
		} else if (($puntos['12103e']=='na')&&(($z==0)||($z==4))) {
			$this->Punto('na',$elem['12103e'],Info('12103e','na'),'12103e');
		} else if ($this->dif == 1) {
			$this->Punto($mis_puntos['121e'],$elem['12103e'],Info(1,'chk'),'12103e');
		}

		if (($puntos['12104e']=='duda')&&(($z==0)||($z==2))) {
			$this->Punto('duda',$elem['12104e'],Info('12104e','duda'),'12104e');
		} else if (($puntos['12104e']=='na')&&(($z==0)||($z==4))) {
			$this->Punto('na',$elem['12104e'],Info('12104e','na'),'12104e');
		} else if ($this->dif == 1) {
			$this->Punto($mis_puntos['121e'],$elem['12104e'],Info(1,'chk'),'12104e');
		}	

		if (($puntos['12105e']=='duda')&&(($z==0)||($z==2))) {
			$this->Punto('duda',$elem['12105e'],Info('12105e','duda'),'12105e');
		} else if (($puntos['12105e']=='na')&&(($z==0)||($z==4))) {
			$this->Punto('na',$elem['12105e'],Info('12105e','na'),'12105e');
		} else if ($this->dif == 1) {
			$this->Punto($mis_puntos['121e'],$elem['12105e'],Info(1,'chk'),'12105e');
		}

		if (($puntos['12106e']=='duda')&&(($z==0)||($z==2))) {
			$this->Punto('duda',$elem['12106e'],Info('12106e','duda'),'12106e');
		} else if (($puntos['12106e']=='na')&&(($z==0)||($z==4))) {
			$this->Punto('na',$elem['12106e'],Info('12106e','na'),'12106e');
		} else if ($this->dif == 1) {
			$this->Punto($mis_puntos['121e'],$elem['12106e'],Info(1,'chk'),'12106e');
		}
	break;

	case 11:
		if (($puntos[1101]=='mal')&&(($z==0)||($z==3))) {
			$this->Punto('mal',$elem[1101],Info(1101,'mal'),1101);
		} else if (($puntos[1101]=='duda')&&(($z==0)||($z==2))) {
			$this->Punto('duda',$elem[1101],Info(1101,'duda'),1101);
		} else if (($puntos[1101]=='na')&&(($z==0)||($z==4))) {
			$this->Punto('na',$elem[1101],Info(1101,'na'),1101);
		} else if ($this->dif == 1) {
			$this->Punto($mis_puntos[11],$elem[1101],Info(1,'chk'),1101);
		}

		if (($puntos[1102]=='mal')&&(($z==0)||($z==3))) {
			$this->Punto('mal',$elem[1102],Info(1102,'mal'),1102);
		} else if (($puntos[1102]=='duda')&&(($z==0)||($z==2))) {
			$this->Punto('duda',$elem[1102],Info(1102,'duda'),1102);
		} else if (($puntos[1102]=='na')&&(($z==0)||($z==4))) {
			$this->Punto('na',$elem[1102],Info(1102,'na'),1102);
		} else if ($this->dif == 1) {
			$this->Punto($mis_puntos[11],$elem[1102],Info(1,'chk'),1102);
		}

		if (($puntos[1103]=='mal')&&(($z==0)||($z==3))) {
			$this->Punto('mal',$elem[1103],Info(1103,'mal'),1103);
		} else if (($puntos[1103]=='duda')&&(($z==0)||($z==2))) {
			$this->Punto('duda',$elem[1103],Info(1103,'duda'),1103);
		} else if (($puntos[1103]=='na')&&(($z==0)||($z==4))) {
			$this->Punto('na',$elem[1103],Info(1103,'na'),1103);
		} else if ($this->dif == 1) {
			$this->Punto($mis_puntos[11],$elem[1103],Info(1,'chk'),1103);
		}

	if (($puntos[1104]=='duda')&&(($z==0)||($z==2))) {
		$this->Punto('duda',$elem[1104],Info(1104,'duda'),1104);
	} else if (($puntos[1104]=='na')&&(($z==0)||($z==4))) {
		$this->Punto('na',$elem[1104],Info(1104,'na'),1104);
	} else if ($this->dif == 1) {
		$this->Punto($mis_puntos[11],$elem[1104],Info(1,'chk'),1104);
	}

	if (($puntos[1105]=='mal')&&(($z==0)||($z==3))) {
		$this->Punto('mal',$elem[1105],Info(1105,'mal'),1105);
	} else if (($puntos[1105]=='duda')&&(($z==0)||($z==2))) {
		$this->Punto('duda',$elem[1105],Info(1105,'duda'),1105);
	} else if (($puntos[1105]=='na')&&(($z==0)||($z==4))) {
		$this->Punto('na',$elem[1105],Info(1105,'na'),1105);
	} else if ($this->dif == 1) {
		$this->Punto($mis_puntos[11],$elem[1105],Info(1,'chk'),1105);
	}

	if (($puntos[1106]=='duda')&&(($z==0)||($z==2))) {
		$this->Punto('duda',$elem[1106],Info(1106,'duda'),1106);
	} else if (($puntos[1106]=='na')&&(($z==0)||($z==4))) {
		$this->Punto('na',$elem[1106],Info(1106,'na'),1106);
	} else if ($this->dif == 1) {
		$this->Punto($mis_puntos[11],$elem[1106],Info(1,'chk'),1106);
	}

	if (($puntos[1107]=='duda')&&(($z==0)||($z==2))) {
		$this->Punto('duda',$elem[1107],Info(1107,'duda'),1107);
	} else if (($puntos[1107]=='na')&&(($z==0)||($z==4))) {
		$this->Punto('na',$elem[1107],Info(1107,'na'),1107);
	} else if ($this->dif == 1) {
		$this->Punto($mis_puntos[11],$elem[1107],Info(1,'chk'),1107);
	}

	if (($puntos[1108]=='duda')&&(($z==0)||($z==2))) {
		$this->Punto('duda',$elem[1108],Info(1108,'duda'),1108);
	} else if (($puntos[1108]=='na')&&(($z==0)||($z==4))) {
		$this->Punto('na',$elem[1108],Info(1108,'na'),1108);
	} else if ($this->dif == 1) {
		$this->Punto($mis_puntos[11],$elem[1108],Info(1,'chk'),1108);
	}

	if (($puntos[1109]=='duda')&&(($z==0)||($z==2))) {
		$this->Punto('duda',$elem[1109],Info(1109,'duda'),1109);
	} else if (($puntos[1109]=='na')&&(($z==0)||($z==4))) {
		$this->Punto('na',$elem[1109],Info(1109,'na'),1109);
	} else if ($this->dif == 1) {
		$this->Punto($mis_puntos[11],$elem[1109],Info(1,'chk'),1109);
	}

	if (($puntos[1110]=='duda')&&(($z==0)||($z==2))) {
		$this->Punto('duda',$elem[1110],Info(1110,'duda'),1110);
	} else if (($puntos[1110]=='na')&&(($z==0)||($z==4))) {
		$this->Punto('na',$elem[1110],Info(1110,'na'),1110);
	} else if ($this->dif == 1) {
		$this->Punto($mis_puntos[11],$elem[1110],Info(1,'chk'),1110);
	}

	if (($puntos[1111]=='duda')&&(($z==0)||($z==2))) {
		$this->Punto('duda',$elem[1111],Info(1111,'duda'),1111);
	} else if (($puntos[1111]=='mal')&&(($z==0)||($z==3))) {
		$this->Punto('mal',$elem[1111],Info(1111,'mal'),1111);
	} else if (($puntos[1111]=='na')&&(($z==0)||($z==4))) {
		$this->Punto('na',$elem[1111],Info(1111,'na'),1111);
	} else if ($this->dif == 1) {
		$this->Punto($mis_puntos[11],$elem[1111],Info(1,'chk'),1111);
	}
	break;

	case 12:
		if (($puntos[12]=='duda')&&(($z==0)||($z==2))) {
			$this->Punto('duda',$elem[12],Info(12,'duda'),12);
		} else if (($puntos[12]=='na')&&(($z==0)||($z==4))) {
			$this->Punto('na',$elem[12],Info(12,'na'),12);
		} else if ($this->dif == 1) {
			$this->Punto($mis_puntos[12],$elem[12],Info(1,'chk'),12);
		}
	break;

	case 13:
		if (($puntos[1301]=='duda')&&(($z==0)||($z==2))) {
			$this->Punto('duda',$elem[1301],Info(1301,'duda'),1301);
		} else if (($puntos[1301]=='na')&&(($z==0)||($z==4))) {
			$this->Punto('na',$elem[1301],Info(1301,'na'),1301);
		} else if ($this->dif == 1) {
			$this->Punto($mis_puntos[13],$elem[1301],Info(1,'chk'),1301);
		}

		if (($puntos[1302]=='duda')&&(($z==0)||($z==2))) {
			$this->Punto('duda',$elem[1302],Info(1302,'duda'),1302);
		} else if (($puntos[1302]=='na')&&(($z==0)||($z==4))) {
			$this->Punto('na',$elem[1302],Info(1302,'na'),1302);
		} else if ($this->dif == 1) {
			$this->Punto($mis_puntos[13],$elem[1302],Info(1,'chk'),1302);
		}

		if (($puntos[1303]=='duda')&&(($z==0)||($z==2))) {
			$this->Punto('duda',$elem[1303],Info(1303,'duda'),1303);
		} else if (($puntos[1303]=='na')&&(($z==0)||($z==4))) {
			$this->Punto('na',$elem[1303],Info(1303,'na'),1303);
		} else if ($this->dif == 1) {
			$this->Punto($mis_puntos[13],$elem[1303],Info(1,'chk'),1303);
		}
	break;

	case 14:
		if (($puntos[1401]=='duda')&&(($z==0)||($z==2))) {
			$this->Punto('duda',$elem[1401],Info(1401,'duda'),1401);
		} else if (($puntos[1401]=='na')&&(($z==0)||($z==4))) {
			$this->Punto('na',$elem[1401],Info(1401,'na'),1401);
		} else if ($this->dif == 1) {
			$this->Punto($mis_puntos[14],$elem[1401],Info(1,'chk'),1401);
		}

		if (($puntos[1402]=='duda')&&(($z==0)||($z==2))) {
			$this->Punto('duda',$elem[1402],Info(1402,'duda'),1402);
		} else if (($puntos[1402]=='na')&&(($z==0)||($z==4))) {
			$this->Punto('na',$elem[1402],Info(1402,'na'),1402);
		} else if ($this->dif == 1) {
			$this->Punto($mis_puntos[14],$elem[1402],Info(1,'chk'),1402);
		}

		if (($puntos[1403]=='duda')&&(($z==0)||($z==2))) {
			$this->Punto('duda',$elem[1403],Info(1403,'duda'),1403);
		} else if (($puntos[1403]=='na')&&(($z==0)||($z==4))) {
			$this->Punto('na',$elem[1403],Info(1403,'na'),1403);
		} else if ($this->dif == 1) {
			$this->Punto($mis_puntos[14],$elem[1403],Info(1,'chk'),1403);
		}
	break;

	case 15:
		if (($puntos[15]=='bien')&&(($z==0)||($z==1))) {
			$this->Punto('bien',$elem[15],Info(15,'bien'),15);
		} else if (($puntos[15]=='mal')&&(($z==0)||($z==3))) {
			$this->Punto('mal',$elem[15],Info(15,'mal'),15);
		} else if (($puntos[15]=='na')&&(($z==0)||($z==4))) {
			$this->Punto('na',$elem[15],Info(15,'na'),15);
		} else if ($this->dif == 1) {
			$this->Punto($mis_puntos[15],$elem[15],Info(1,'chk'),15);
		}
	break;

	case 21:
		if (($puntos[21]=='duda')&&(($z==0)||($z==2))) {
			$this->Punto('duda',$elem[21],Info(21,'duda'),21,false);
		} else if ($this->dif == 1) {
			$this->Punto($mis_puntos[21],$elem[21],Info(1,'chk'),21);
		}
	break;

	case 22:
		if (($puntos[22]=='duda')&&(($z==0)||($z==2))) {
			$this->Punto('duda',$elem[22],Info(22,'duda'),22,true,'contraste');
		} else if ($this->dif == 1) {
			$this->Punto($mis_puntos[22],$elem[22],Info(1,'chk'),22);
		}
	break;

	case 31:
		if (($puntos[31]=='bien')&&(($z==0)||($z==1))) {
			$this->Punto('bien',$elem[31],Info(31,'bien'),31);
		} else if (($puntos[31]=='duda')&&(($z==0)||($z==2))) {
			$this->Punto('duda',$elem[31],Info(31,'duda'),31);
		} else if ($this->dif == 1) {
			$this->Punto($mis_puntos[31],$elem[31],Info(1,'chk'),31);
		}
	break;

	case 32:
		if (($puntos[3201]=='bien')&&(($z==0)||($z==1))) {
			$this->Punto('bien',$elem[3201],Info(3201,'bien'),3201,true,'validator');
		} else if (($puntos[3201]=='mal')&&(($z==0)||($z==3))) {
			$this->Punto('mal',$elem[3201],Info(3201,'mal'),3201, true,'validator');
		} else if (($puntos[3201]=='duda')&&(($z==0)||($z==2))) {
			$this->Punto('duda',$elem[3201],Info(3201,'duda'),3201,true,'validator');
		} else if ($this->dif == 1) {
			$this->Punto($mis_puntos[32],$elem[3201],Info(1,'chk'),3201);
		}

		if (($puntos[3202]=='bien')&&(($z==0)||($z==1))) {
			$this->Punto('bien',$elem[3202],Info(3202,'bien'),3202,true,'css');
		} else if (($puntos[3202]=='mal')&&(($z==0)||($z==3))) {
			$this->Punto('mal',$elem[3202],Info(3202,'mal'),3202,true,'css');
		} else if (($puntos[3202]=='duda')&&(($z==0)||($z==2))) {
			$this->Punto('duda',$elem[3202],Info(3202,'duda'),3202,true,'css');
		} else if (($puntos[3202]=='na')&&(($z==0)||($z==4))) {
			$this->Punto('na',$elem[3202],Info(3202,'na'),3202,true,'css');
		} else if ($this->dif == 1) {
			$this->Punto($mis_puntos[32],$elem[3202],Info(1,'chk'),3202);
		}
	break;

	case 33:
		if (($puntos[3301]=='mal')&&(($z==0)||($z==3))) {
			$this->Punto('mal',$elem[3301],Info(3301,'mal'),3301);
		} else if (($puntos[3301]=='duda')&&(($z==0)||($z==2))) {
			$this->Punto('duda',$elem[3301],Info(3301,'duda'),3301);
		} else if (($puntos[3301]=='bien')&&(($z==0)||($z==1))) {
			$this->Punto('bien',$elem[3301],Info(3301,'bien'),3301);
		} else if ($this->dif == 1) {
			$this->Punto($mis_puntos[33],$elem[3301],Info(1,'chk'),3301);
		}

		if (($puntos[3302]=='mal')&&(($z==0)||($z==3))) {
			$this->Punto('mal',$elem[3302],Info(3302,'mal'),3302);
		} else if (($puntos[3302]=='bien')&&(($z==0)||($z==1))) {
			$this->Punto('bien',$elem[3302],Info(3302,'bien'),3302);
		} else if ($this->dif == 1) {
			$this->Punto($mis_puntos[33],$elem[3302],Info(1,'chk'),3302);
		}

		if (($puntos[3303]=='mal')&&(($z==0)||($z==3))) {
			$this->Punto('mal',$elem[3303],Info(3303,'mal'),3303);
		} else if (($puntos[3303]=='bien')&&(($z==0)||($z==1))) {
			$this->Punto('bien',$elem[3303],Info(3303,'bien'),3303);
		} else if ($this->dif == 1) {
			$this->Punto($mis_puntos[33],$elem[3303],Info(1,'chk'),3303);
		}
		
		if($_SESSION['emag'] == true)
		{
			if (($puntos[53]=='duda')&&(($z==0)||($z==2))) {
				$this->Punto('duda',$elem[53],Info(53,'duda'),53,false);
			} else if (($puntos[53]=='bien')&&(($z==0)||($z==1))) {
				$this->Punto('bien',$elem[53],Info(53,'bien'),53);
			} else if ($this->dif == 1) {
				$this->Punto($mis_puntos[53],$elem[53],Info(1,'chk'),53);
			}
		}
	break;

	case 34:
		if (($puntos[3401]=='duda')&&(($z==0)||($z==2))) {
			$this->Punto('duda',$elem[3401],Info(3401,'duda'),3401);
		} else if (($puntos[3401]=='mal')&&(($z==0)||($z==3))) {
			$this->Punto('mal',$elem[3401],Info(3401,'mal'),3401);
		} else if ($this->dif == 1) {
			$this->Punto($mis_puntos[34],$elem[3401],Info(1,'chk'),3401);
		}

		if (($puntos[3402]=='mal')&&(($z==0)||($z==3))) {
			$this->Punto('mal',$elem[3402],Info(3402,'mal'),3402);
		} else if (($puntos[3402]=='bien')&&(($z==0)||($z==1))) {
			$this->Punto('bien',$elem[3402],Info(3402,'bien'),3402);
		} else if ($this->dif == 1) {
			$this->Punto($mis_puntos[34],$elem[3402],Info(1,'chk'),3402);
		}
	break;

	case 35:
		if (($puntos[35]=='duda')&&(($z==0)||($z==2))) {
			$this->Punto('duda',$elem[35],Info(35,'duda'),35);
		} else if (($puntos[35]=='bien')&&(($z==0)||($z==1))) {
			$this->Punto('bien',$elem[35],Info(35,'bien'),35);
		} else if (($puntos[35]=='mal')&&(($z==0)||($z==3))) {
			$this->Punto('mal',$elem[35],Info(35,'mal'),35);
		} else if ($this->dif == 1) {
			$this->Punto($mis_puntos[35],$elem[35],Info(1,'chk'),35);
		}
	break;

	case 36:
		if (($puntos[36]=='mal')&&(($z==0)||($z==3))) {
			$this->Punto('mal',$elem[36],Info(36,'mal'),36);
		} else if (($puntos[36]=='duda')&&(($z==0)||($z==2))) {
			$this->Punto('duda',$elem[36],Info(36,'duda'),36);
		} else if ($this->dif == 1) {
			$this->Punto($mis_puntos[36],$elem[36],Info(1,'chk'),36);
		}
	break;

	case 37:
		if (($puntos[37]=='duda')&&(($z==0)||($z==2))) {
			$this->Punto('duda',$elem[37],Info(37,'duda'),37);
		} else if ($this->dif == 1) {
			$this->Punto($mis_puntos[37],$elem[37],Info(1,'chk'),37);
		}
	break;

	case 41:
		if (($puntos[41]=='duda')&&(($z==0)||($z==2))) {
			$this->Punto('duda',$elem[41],Info(41,'duda'),41);
		} else if ($this->dif == 1) {
			$this->Punto($mis_puntos[41],$elem[41],Info(1,'chk'),41);
		}
	break;

	case 42:
		if (($puntos[42]=='duda')&&(($z==0)||($z==2))) {
			$this->Punto('duda',$elem[42],Info(42,'duda'),42);
		} else if ($this->dif == 1) {
			$this->Punto($mis_puntos[42],$elem[42],Info(1,'chk'),42);
		}
		
		if($_SESSION['emag'] == true)
		{
			if (($puntos[56]=='duda')&&(($z==0)||($z==2))) {
				$this->Punto('duda',$elem[56],Info(56,'duda'),56);
			} else if (($puntos[56]=='na')&&(($z==0)||($z==4))) {
				$this->Punto('na',$elem[56],Info(56,'na'),56);
			} else if ($this->dif == 1) {
				$this->Punto($mis_puntos[56],$elem[56],Info(1,'chk'),56);
			}
		}
	break;

	case 43:
		if (($puntos[43]=='bien')&&(($z==0)||($z==1))) {
			$this->Punto('bien',$elem[43],Info(43,'bien'),43);
		} else if (($puntos[43]=='mal')&&(($z==0)||($z==3))) {
			$this->Punto('mal',$elem[43],Info(43,'mal'),43);
		} else if ($this->dif == 1) {
			$this->Punto($mis_puntos[43],$elem[43],Info(1,'chk'),43);
		}
	break;

	case 51:
		if (($puntos[51]=='duda')&&(($z==0)||($z==2))) {
			$this->Punto('duda',$elem[51],Info(51,'duda'),51);
		} else if (($puntos[51]=='na')&&(($z==0)||($z==4))) {
			$this->Punto('na',$elem[51],Info(51,'na'),51);
		} else if ($this->dif == 1) {
			$this->Punto($mis_puntos[51],$elem[51],Info(1,'chk'),51);
		}
	break;

	case 52:
		if (($puntos[52]=='duda')&&(($z==0)||($z==2))) {
			$this->Punto('duda',$elem[52],Info(52,'duda'),52);
		} else if (($puntos[52]=='na')&&(($z==0)||($z==4))) {
			$this->Punto('na',$elem[52],Info(52,'na'),52);
		} else if ($this->dif == 1) {
			$this->Punto($mis_puntos[52],$elem[52],Info(1,'chk'),52);
		}
	break;

	case 53:
		if($_SESSION['emag'] == false)
		{
			if (($puntos[53]=='duda')&&(($z==0)||($z==2))) {
				$this->Punto('duda',$elem[53],Info(53,'duda'),53,false);
			} else if (($puntos[53]=='bien')&&(($z==0)||($z==1))) {
				$this->Punto('bien',$elem[53],Info(53,'bien'),53);
			} else if ($this->dif == 1) {
				$this->Punto($mis_puntos[53],$elem[53],Info(1,'chk'),53);
			}
		}
	break;

	case 54:
		if (($puntos[54]=='duda')&&(($z==0)||($z==2))) {
			$this->Punto('duda',$elem[54],Info(54,'duda'),54);
		} else if (($puntos[54]=='bien')&&(($z==0)||($z==1))) {
			$this->Punto('bien',$elem[54],Info(54,'bien'),54);
		} else if (($puntos[54]=='na')&&(($z==0)||($z==4))) {
			$this->Punto('na',$elem[54],Info(54,'na'),54);
		} else if ($this->dif == 1) {
			$this->Punto($mis_puntos[54],$elem[54],Info(1,'chk'),54);
		}
	break;

	case 55:
		if (($puntos[55]=='duda')&&(($z==0)||($z==2))) {
			$this->Punto('duda',$elem[55],Info(55,'duda'),55);
		} else if (($puntos[55]=='mal')&&(($z==0)||($z==3))) {
			$this->Punto('mal',$elem[55],Info(55,'mal'),55);
		} else if (($puntos[55]=='na')&&(($z==0)||($z==4))) {
			$this->Punto('na',$elem[55],Info(55,'na'),55);
		} else if ($this->dif == 1) {
			$this->Punto($mis_puntos[55],$elem[55],Info(1,'chk'),55);
		}
	break;

	case 56:
		if($_SESSION['emag'] == false)
		{
			if (($puntos[56]=='duda')&&(($z==0)||($z==2))) {
				$this->Punto('duda',$elem[56],Info(56,'duda'),56);
			} else if (($puntos[56]=='na')&&(($z==0)||($z==4))) {
				$this->Punto('na',$elem[56],Info(56,'na'),56);
			} else if ($this->dif == 1) {
				$this->Punto($mis_puntos[56],$elem[56],Info(1,'chk'),56);
			}
		}
	break;

	case 61:
		if (($puntos[61]=='duda')&&(($z==0)||($z==2))) {
			$this->Punto('duda',$elem[61],Info(61,'duda'),61,true,'sincss');
		} else if (($puntos[61]=='na')&&(($z==0)||($z==4))) {
			$this->Punto('na',$elem[61],Info(61,'na'),61);
		} else if ($this->dif == 1) {
			$this->Punto($mis_puntos[61],$elem[61],Info(1,'chk'),61);
		}
	break;

	case 62:
		if (($puntos[6201]=='duda')&&(($z==0)||($z==2))) {
			$this->Punto('duda',$elem[6201],Info(6201,'duda'),6201);
		} else if (($puntos[6201]=='na')&&(($z==0)||($z==4))) {
			$this->Punto('na',$elem[6201],Info(6201,'na'),6201);
		} else if ($this->dif == 1) {
			$this->Punto($mis_puntos[62],$elem[6201],Info(1,'chk'),6201);
		}

		if (($puntos[6202]=='mal')&&(($z==0)||($z==3))) {
			$this->Punto('mal',$elem[6202],Info(6202,'mal'),6202);
		} else if (($puntos[6202]=='duda')&&(($z==0)||($z==2))) {
			$this->Punto('duda',$elem[6202],Info(6202,'duda'),6202);
		} else if (($puntos[6202]=='na')&&(($z==0)||($z==4))) {
			$this->Punto('na',$elem[6202],Info(6202,'na'),6202);
		} else if ($this->dif == 1) {
			$this->Punto($mis_puntos[62],$elem[6202],Info(1,'chk'),6202);
		}
	break;

	case 63:
		if (($puntos[6301]=='mal')&&(($z==0)||($z==3))) {
			$this->Punto('mal',$elem[6301],Info(6301,'mal'),6301);
		} else if (($puntos[6301]=='duda')&&(($z==0)||($z==2))) {
			$this->Punto('duda',$elem[6301],Info(6301,'duda'),6301);
		} else if (($puntos[6301]=='na')&&(($z==0)||($z==4))) {
			$this->Punto('na',$elem[6301],Info(6301,'na'),6301);
		} else if ($this->dif == 1) {
			$this->Punto($mis_puntos[63],$elem[6301],Info(1,'chk'),6301);
		}

		if (($puntos[6302]=='duda')&&(($z==0)||($z==2))) {
			$this->Punto('duda',$elem[6302],Info(6302,'duda'),6302);
		} else if (($puntos[6302]=='na')&&(($z==0)||($z==4))) {
			$this->Punto('na',$elem[6302],Info(6302,'na'),6302);
		} else if ($this->dif == 1) {
			$this->Punto($mis_puntos[63],$elem[6302],Info(1,'chk'),6302);
		}

		if (($puntos[6303]=='duda')&&(($z==0)||($z==2))) {
			$this->Punto('duda',$elem[6303],Info(6303,'duda'),6303);
		} else if (($puntos[6303]=='na')&&(($z==0)||($z==4))) {
			$this->Punto('na',$elem[6303],Info(6303,'na'),6303);
		} else if ($this->dif == 1) {
			$this->Punto($mis_puntos[63],$elem[6303],Info(1,'chk'),6303);
		}

		if (($puntos[6304]=='duda')&&(($z==0)||($z==2))) {
			$this->Punto('duda',$elem[6304],Info(6304,'duda'),6304);
		} else if (($puntos[6304]=='na')&&(($z==0)||($z==4))) {
			$this->Punto('na',$elem[6304],Info(6304,'na'),6304);
		} else if ($this->dif == 1) {
			$this->Punto($mis_puntos[63],$elem[6304],Info(1,'chk'),6304);
		}
	break;

	case 64:
		if (($puntos[64]=='bien')&&(($z==0)||($z==1))) {
			$this->Punto('bien',$elem[64],Info(64,'bien'),64);
		} else if (($puntos[64]=='mal')&&(($z==0)||($z==3))) {
			$this->Punto('mal',$elem[64],Info(64,'mal'),64);
		} else if (($puntos[64]=='duda')&&(($z==0)||($z==2))) {
			$this->Punto('duda',$elem[64],Info(64,'duda'),64);
		} else if (($puntos[64]=='na')&&(($z==0)||($z==4))) {
			$this->Punto('na',$elem[64],Info(64,'na'),64);
		} else if ($this->dif == 1) {
			$this->Punto($mis_puntos[64],$elem[64],Info(1,'chk'),64);
		}
	break;

	case 65:
		if (($puntos[6501]=='duda')&&(($z==0)||($z==2))) {
			$this->Punto('duda',$elem[6501],Info(6501,'duda'),6501);
		} else if (($puntos[6501]=='na')&&(($z==0)||($z==4))) {
			$this->Punto('na',$elem[6501],Info(6501,'na'),6501);
		} else if ($this->dif == 1) {
			$this->Punto($mis_puntos[65],$elem[6501],Info(1,'chk'),6501);
		}

		if (($puntos[6502]=='duda')&&(($z==0)||($z==2))) {
			$this->Punto('duda',$elem[6502],Info(6502,'duda'),6502);
		} else if (($puntos[6502]=='mal')&&(($z==0)||($z==3))) {
			$this->Punto('mal',$elem[6502],Info(6502,'mal'),6502);
		} else if (($puntos[6502]=='na')&&(($z==0)||($z==4))) {
			$this->Punto('na',$elem[6502],Info(6502,'na'),6502);
		} else if ($this->dif == 1) {
			$this->Punto($mis_puntos[11],$elem[6502],Info(1,'chk'),6502);
		}
	break;

	case 71:
		if (($puntos[71]=='duda')&&(($z==0)||($z==2))) {
			$this->Punto('duda',$elem[71],Info(71,'duda'),71);
		} else if (($puntos[71]=='bien')&&(($z==0)||($z==1))) {
			$this->Punto('bien',$elem[71],Info(71,'bien'),71);
		} else if ($this->dif == 1) {
			$this->Punto($mis_puntos[71],$elem[71],Info(1,'chk'),71);
		}
	
		if($_SESSION['emag'] == true)
		{
			if (($puntos[72]=='duda')&&(($z==0)||($z==2))) {
				$this->Punto('duda',$elem[72],Info(72,'duda'),72);
			} else if (($puntos[72]=='mal')&&(($z==0)||($z==3))) {
				$this->Punto('mal',$elem[72],Info(72,'mal'),72);
			} else if (($puntos[72]=='bien')&&(($z==0)||($z==1))) {
				$this->Punto('bien',$elem[72],Info(72,'bien'),72);
			} else if ($this->dif == 1) {
				$this->Punto($mis_puntos[72],$elem[72],Info(1,'chk'),72);
			}
		}
	break;

	case 72:
		if($_SESSION['emag'] == false)
		{
			if (($puntos[72]=='duda')&&(($z==0)||($z==2))) {
				$this->Punto('duda',$elem[72],Info(72,'duda'),72);
			} else if (($puntos[72]=='mal')&&(($z==0)||($z==3))) {
				$this->Punto('mal',$elem[72],Info(72,'mal'),72);
			} else if (($puntos[72]=='bien')&&(($z==0)||($z==1))) {
				$this->Punto('bien',$elem[72],Info(72,'bien'),72);
			} else if ($this->dif == 1) {
				$this->Punto($mis_puntos[72],$elem[72],Info(1,'chk'),72);
			}
		}
	break;

	case 73:
		if (($puntos[73]=='duda')&&(($z==0)||($z==2))) {
			$this->Punto('duda',$elem[73],Info(73,'duda'),73);
		} else if (($puntos[73]=='mal')&&(($z==0)||($z==3))) {
			$this->Punto('mal',$elem[73],Info(73,'mal'),73);
		} else if (($puntos[73]=='bien')&&(($z==0)||($z==1))) {
			$this->Punto('bien',$elem[73],Info(73,'bien'),73);
		} else if ($this->dif == 1) {
			$this->Punto($mis_puntos[73],$elem[73],Info(1,'chk'),73);
		}
	break;

	case 74:
		if (($puntos[7401]=='mal')&&(($z==0)||($z==3))) {
			$this->Punto('mal',$elem[7401],Info(7401,'mal'),7401);
		} else if (($puntos[7401]=='bien')&&(($z==0)||($z==1))) {
			$this->Punto('bien',$elem[7401],Info(7401,'bien'),7401);
		} else if ($this->dif == 1) {
			$this->Punto($mis_puntos[74],$elem[7401],Info(1,'chk'),7401);
		}

		if (($puntos[7402]=='bien')&&(($z==0)||($z==1))) {
			$this->Punto('bien',$elem[7402],Info(7402,'bien'),7402);
		} else if (($puntos[7402]=='duda')&&(($z==0)||($z==2))) {
			$this->Punto('duda',$elem[7402],Info(7402,'duda'),7402);
		} else if ($this->dif == 1) {
			$this->Punto($mis_puntos[74],$elem[7402],Info(1,'chk'),7402);
		}
	break;

	case 75:
		if (($puntos[7501]=='mal')&&(($z==0)||($z==3))) {
			$this->Punto('mal',$elem[7501],Info(7501,'mal'),7501);
		} else if (($puntos[7501]=='bien')&&(($z==0)||($z==1))) {
			$this->Punto('bien',$elem[7501],Info(7501,'bien'),7501);
		} else if ($this->dif == 1) {
			$this->Punto($mis_puntos[75],$elem[7501],Info(1,'chk'),7501);
		}

		if (($puntos[7502]=='bien')&&(($z==0)||($z==1))) {
			$this->Punto('bien',$elem[7502],Info(7502,'bien'),7502);
		} else if (($puntos[7502]=='duda')&&(($z==0)||($z==2))) {
			$this->Punto('duda',$elem[7502],Info(7502,'duda'),7502);
		} else if ($this->dif == 1) {
			$this->Punto($mis_puntos[75],$elem[7502],Info(1,'chk'),7502);
		}
	break;

	case 81:
		if (($puntos[8101]=='bien')&&(($z==0)||($z==1))) {
			$this->Punto('bien',$elem[8101],Info(8101,'bien'),8101);
		} else if (($puntos[8101]=='mal')&&(($z==0)||($z==3))) {
			$this->Punto('mal',$elem[8101],Info(8101,'mal'),8101);
		} else if (($puntos[8101]=='duda')&&(($z==0)||($z==2))) {
			$this->Punto('duda',$elem[8101],Info(8101,'duda'),8101);
		} else if (($puntos[8101]=='na')&&(($z==0)||($z==4))) {
			$this->Punto('na',$elem[8101],Info(8101,'na'),8101);
		} else if ($this->dif == 1) {
			$this->Punto($mis_puntos[81],$elem[8101],Info(1,'chk'),8101);
		}

		if (($puntos[8102]=='duda')&&(($z==0)||($z==2))) {
			$this->Punto('duda',$elem[8102],Info(8102,'duda'),8102);
		} else if (($puntos[8102]=='na')&&(($z==0)||($z==4))) {
			$this->Punto('na',$elem[8102],Info(8102,'na'),8102);
		} else if ($this->dif == 1) {
			$this->Punto($mis_puntos[81],$elem[8102],Info(1,'chk'),8102);
		}

		if (($puntos[8103]=='duda')&&(($z==0)||($z==2))) {
			$this->Punto('duda',$elem[8103],Info(8103,'duda'),8103);
		} else if (($puntos[8103]=='na')&&(($z==0)||($z==4))) {
			$this->Punto('na',$elem[8103],Info(8103,'na'),8103);
		} else if ($this->dif == 1) {
			$this->Punto($mis_puntos[81],$elem[8103],Info(1,'chk'),8103);
		}

		if (($puntos[8104]=='duda')&&(($z==0)||($z==2))) {
			$this->Punto('duda',$elem[8104],Info(8104,'duda'),8104);
		} else if (($puntos[8103]=='na')&&(($z==0)||($z==4))) {
			$this->Punto('na',$elem[8104],Info(8104,'na'),8104);
		} else if ($this->dif == 1) {
			$this->Punto($mis_puntos[81],$elem[8104],Info(1,'chk'),8104);
		}
		
		if($_SESSION['emag'] == true)
		{
			if (($puntos[9201]=='duda')&&(($z==0)||($z==2))) {
				$this->Punto('duda',$elem[9201],Info(9201,'duda'),9201);
			} else if (($puntos[9201]=='na')&&(($z==0)||($z==4))) {
				$this->Punto('na',$elem[9201],Info(9201,'na'),9201);
			} else if ($this->dif == 1) {
				$this->Punto($mis_puntos[92],$elem[9201],Info(1,'chk'),9201);
			}

			if (($puntos[9202]=='duda')&&(($z==0)||($z==2))) {
				$this->Punto('duda',$elem[9202],Info(9202,'duda'),9202);
			} else if (($puntos[9202]=='na')&&(($z==0)||($z==4))) {
				$this->Punto('na',$elem[9202],Info(9202,'na'),9202);
			} else if ($this->dif == 1) {
				$this->Punto($mis_puntos[92],$elem[9202],Info(1,'chk'),9202);
			}
		}
	break;

	case 91:
		if (($puntos[91]=='mal')&&(($z==0)||($z==3))) {
			$this->Punto('mal',$elem[91],Info(91,'mal'),91);
		} else if (($puntos[91]=='bien')&&(($z==0)||($z==1))) {
			$this->Punto('bien',$elem[91],Info(91,'bien'),91);
		} else if (($puntos[91]=='na')&&(($z==0)||($z==4))) {
			$this->Punto('na',$elem[91],Info(91,'na'),91);
		} else if ($this->dif == 1) {
			$this->Punto($mis_puntos[91],$elem[91],Info(1,'chk'),91);
		}
	break;

	case 92:
		if($_SESSION['emag'] == false)
		{
			if (($puntos[9201]=='duda')&&(($z==0)||($z==2))) {
				$this->Punto('duda',$elem[9201],Info(9201,'duda'),9201);
			} else if (($puntos[9201]=='na')&&(($z==0)||($z==4))) {
				$this->Punto('na',$elem[9201],Info(9201,'na'),9201);
			} else if ($this->dif == 1) {
				$this->Punto($mis_puntos[92],$elem[9201],Info(1,'chk'),9201);
			}

			if (($puntos[9202]=='duda')&&(($z==0)||($z==2))) {
				$this->Punto('duda',$elem[9202],Info(9202,'duda'),9202);
			} else if (($puntos[9202]=='na')&&(($z==0)||($z==4))) {
				$this->Punto('na',$elem[9202],Info(9202,'na'),9202);
			} else if ($this->dif == 1) {
				$this->Punto($mis_puntos[92],$elem[9202],Info(1,'chk'),9202);
			}
		}
	break;

	case 93:
		if (($puntos[93]=='bien')&&(($z==0)||($z==1))) {
			$this->Punto('bien',$elem[93],Info(93,'bien'),93);
		} else if (($puntos[93]=='mal')&&(($z==0)||($z==3))) {
			$this->Punto('mal',$elem[93],Info(93,'mal'),93);
		} else if (($puntos[93]=='na')&&(($z==0)||($z==4))) {
			$this->Punto('na',$elem[93],Info(93,'na'),93);
		} else if ($this->dif == 1) {
			$this->Punto($mis_puntos[93],$elem[93],Info(1,'chk'),93);
		}
	break;

	case 94:
		if (($puntos[94]=='duda')&&(($z==0)||($z==2))) {
			$this->Punto('duda',$elem[94],Info(94,'duda'),94);
		} else if ($this->dif == 1) {
			$this->Punto($mis_puntos[94],$elem[94],Info(1,'chk'),94);
		}
	break;

	case 95:
		if (($puntos[95]=='bien')&&(($z==0)||($z==1))) {
			$this->Punto('bien',$elem[95],Info(95,'bien'),95);
		} else if (($puntos[95]=='mal')&&(($z==0)||($z==3))) {
			$this->Punto('mal',$elem[95],Info(95,'mal'),95);
		} else if ($this->dif == 1) {
			$this->Punto($mis_puntos[95],$elem[95],Info(1,'chk'),95);
		}
	break;

	case 101:
		if (($puntos[10101]=='bien')&&(($z==0)||($z==1))) {
			$this->Punto('bien',$elem[10101],Info(10101,'bien'),10101);
		} else if (($puntos[10101]=='duda')&&(($z==0)||($z==2))) {
			$this->Punto('duda',$elem[10101],Info(10101,'duda'),10101);
		} else if ($this->dif == 1) {
			$this->Punto($mis_puntos[101],$elem[10101],Info(1,'chk'),10101);
		}

		if (($puntos[10102]=='bien')&&(($z==0)||($z==1))) {
			$this->Punto('bien',$elem[10102],Info(10102,'bien'),10102);
		} else if (($puntos[10102]=='duda')&&(($z==0)||($z==2))) {
			$this->Punto('duda',$elem[10102],Info(10102,'duda'),10102);
		} else if ($this->dif == 1) {
			$this->Punto($mis_puntos[101],$elem[10102],Info(1,'chk'),10102);
		}
	break;

	case 102:
		if (($puntos[102]=='mal')&&(($z==0)||($z==3))) {
			$this->Punto('mal',$elem[102],Info(102,'mal'),102);
		} else if (($puntos[102]=='duda')&&(($z==0)||($z==2))) {
			$this->Punto('duda',$elem[102],Info(102,'duda'),102);
		} else if (($puntos[102]=='na')&&(($z==0)||($z==4))) {
			$this->Punto('na',$elem[102],Info(102,'na'),102);
		} else if ($this->dif == 1) {
			$this->Punto($mis_puntos[102],$elem[102],Info(1,'chk'),102);
		}
	break;

	case 103:
		if (($puntos[103]=='duda')&&(($z==0)||($z==2))) {
			$this->Punto('duda',$elem[103],Info(103,'duda'),103);
		} else if (($puntos[103]=='na')&&(($z==0)||($z==4))) {
			$this->Punto('na',$elem[103],Info(103,'na'),103);
		} else if ($this->dif == 1) {
			$this->Punto($mis_puntos[103],$elem[103],Info(1,'chk'),103);
		}
	break;

	case 104:
		if (($puntos[104]=='bien')&&(($z==0)||($z==1))) {
			$this->Punto('bien',$elem[104],Info(104,'bien'),104);
		} else if (($puntos[104]=='mal')&&(($z==0)||($z==3))) {
			$this->Punto('mal',$elem[104],Info(104,'mal'),104);
		} else if (($puntos[104]=='na')&&(($z==0)||($z==4))) {
			$this->Punto('na',$elem[104],Info(104,'na'),104);
		} else if ($this->dif == 1) {
			$this->Punto($mis_puntos[104],$elem[104],Info(1,'chk'),104);
		}
	break;

	case 105:
		if (($puntos[105]=='bien')&&(($z==0)||($z==1))) {
			$this->Punto('bien',$elem[105],Info(105,'bien'),105);
		} else if (($puntos[105]=='mal')&&(($z==0)||($z==3))) {
			$this->Punto('mal',$elem[105],Info(105,'mal'),105);
		} else if (($puntos[105]=='na')&&(($z==0)||($z==4))) {
			$this->Punto('na',$elem[105],Info(105,'na'),105);
		} else if ($this->dif == 1) {
			$this->Punto($mis_puntos[105],$elem[105],Info(1,'chk'),105);
		}
	break;

	case 111:
		if (($puntos[111]=='mal')&&(($z==0)||($z==3))) {
			$this->Punto('mal',$elem[111],Info(111,'mal'),111);
		} else if (($puntos[111]=='duda')&&(($z==0)||($z==2))) {
			$this->Punto('duda',$elem[111],Info(111,'duda'),111);
		} else if ($this->dif == 1) {
			$this->Punto($mis_puntos[111],$elem[111],Info(1,'chk'),111);
		}
	break;

	case 112:
		if (($puntos[11201]=='bien')&&(($z==0)||($z==1))) {
			$this->Punto('bien',$elem[11201],Info(11201,'bien'),11201);
		} else if (($puntos[11201]=='mal')&&(($z==0)||($z==3))) {
			$this->Punto('mal',$elem[11201],Info(11201,'mal'),11201);
		} else if ($this->dif == 1) {
			$this->Punto($mis_puntos[112],$elem[11201],Info(1,'chk'),11201);
		}

		if (($puntos[11202]=='bien')&&(($z==0)||($z==1))) {
			$this->Punto('bien',$elem[11202],Info(11202,'bien'),11202);
		} else if (($puntos[11202]=='mal')&&(($z==0)||($z==3))) {
			$this->Punto('mal',$elem[11202],Info(11202,'mal'),11202);
		} else if ($this->dif == 1) {
			$this->Punto($mis_puntos[112],$elem[11202],Info(1,'chk'),11202);
		}
	break;

	case 113:
		if (($puntos[113]=='duda')&&(($z==0)||($z==2))) {
			$this->Punto('duda',$elem[113],Info(113,'duda'),113,false);
		} else if ($this->dif == 1) {
			$this->Punto($mis_puntos[113],$elem[113],Info(1,'chk'),113);
		}
	break;

	case 114:
		if (($puntos[114]=='duda')&&(($z==0)||($z==2))) {
			$this->Punto('duda',$elem[114],Info(114,'duda'),114,false);
		} else if ($this->dif == 1) {
			$this->Punto($mis_puntos[114],$elem[114],Info(1,'chk'),114);
		}
	break;

	case 121:
		if (($puntos[121]=='mal')&&(($z==0)||($z==3))) {
			$this->Punto('mal',$elem[121],Info(121,'mal'),121);
		} else if (($puntos[121]=='duda')&&(($z==0)||($z==2))) {
			$this->Punto('duda',$elem[121],Info(121,'duda'),121);
		} else if (($puntos[121]=='na')&&(($z==0)||($z==4))) {
			$this->Punto('na',$elem[121],Info(121,'na'),121);
		} else if ($this->dif == 1) {
			$this->Punto($mis_puntos[121],$elem[121],Info(1,'chk'),121);
		}
	break;

	case 122:
		if (($puntos[122]=='mal')&&(($z==0)||($z==3))) {
			$this->Punto('mal',$elem[122],Info(122,'mal'),122);
		} else if (($puntos[122]=='duda')&&(($z==0)||($z==2))) {
			$this->Punto('duda',$elem[122],Info(122,'duda'),122);
		} else if (($puntos[122]=='na')&&(($z==0)||($z==4))) {
			$this->Punto('na',$elem[122],Info(122,'na'),122);
		} else if ($this->dif == 1) {
			$this->Punto($mis_puntos[122],$elem[122],Info(1,'chk'),122);
		}
	break;

	case 123:
		if (($puntos[123]=='mal')&&(($z==0)||($z==3))) {
			$this->Punto('mal',$elem[123],Info(123,'mal'),123);
		} else if (($puntos[123]=='duda')&&(($z==0)||($z==2))) {
			$this->Punto('duda',$elem[123],Info(123,'duda'),123);
		} else if ($this->dif == 1) {
			$this->Punto($mis_puntos[123],$elem[123],Info(1,'chk'),123);
		}
	break;

	case 124:
		if (($puntos[124]=='mal')&&(($z==0)||($z==3))) {
			$this->Punto('mal',$elem[124],Info(124,'mal'),124);
		} else if (($puntos[124]=='duda')&&(($z==0)||($z==2))) {
			$this->Punto('duda',$elem[124],Info(124,'duda'),124);
		} else if (($puntos[124]=='na')&&(($z==0)||($z==4))) {
			$this->Punto('na',$elem[124],Info(124,'na'),124);
		} else if ($this->dif == 1) {
			$this->Punto($mis_puntos[124],$elem[124],Info(1,'chk'),124);
		}
	break;

	case 131:
		if (($puntos[131]=='duda')&&(($z==0)||($z==2))) {
			$this->Punto('duda',$elem[131],Info(131,'duda'),131);
		} else if (($puntos[131]=='na')&&(($z==0)||($z==4))) {
			$this->Punto('na',$elem[131],Info(131,'na'),131);
		} else if ($this->dif == 1) {
			$this->Punto($mis_puntos[131],$elem[131],Info(1,'chk'),131);
		}
	break;

	case 132:
		if (($puntos[132]=='duda')&&(($z==0)||($z==2))) {
			$this->Punto('duda',$elem[132],Info(132,'duda'),132);
		} else if ($this->dif == 1) {
			$this->Punto($mis_puntos[132],$elem[132],Info(1,'chk'),132);
		}
	break;

	case 133:
		if (($puntos[133]=='duda')&&(($z==0)||($z==2))) {
			$this->Punto('duda',$elem[133],Info(133,'duda'),133,false);
		} else if ($this->dif == 1) {
			$this->Punto($mis_puntos[133],$elem[133],Info(1,'chk'),133);
		}
	break;

	case 134:
		if (($puntos[134]=='duda')&&(($z==0)||($z==2))) {
			$this->Punto('duda',$elem[134],Info(134,'duda'),134,false);
		} else if ($this->dif == 1) {
			$this->Punto($mis_puntos[134],$elem[134],Info(1,'chk'),134);
		}
	break;

	case 135:
		if (($puntos[135]=='duda')&&(($z==0)||($z==2))) {
			$this->Punto('duda',$elem[135],Info(135,'duda'),135,false);
		} else if ($this->dif == 1) {
			$this->Punto($mis_puntos[135],$elem[135],Info(1,'chk'),135);
		}
	break;

	case 136:
		if (($puntos[136]=='duda')&&(($z==0)||($z==2))) {
			$this->Punto('duda',$elem[136],Info(136,'duda'),136);
		} else if ($this->dif == 1) {
			$this->Punto($mis_puntos[136],$elem[136],Info(1,'chk'),136);
		}
	break;

	case 137:
		if (($puntos[137]=='duda')&&(($z==0)||($z==2))) {
			$this->Punto('duda',$elem[137],Info(137,'duda'),137,false);
		} else if ($this->dif == 1) {
			$this->Punto($mis_puntos[137],$elem[137],Info(1,'chk'),137);
		}
	break;

	case 138:
		if (($puntos[138]=='duda')&&(($z==0)||($z==2))) {
			$this->Punto('duda',$elem[138],Info(138,'duda'),138);
		} else if ($this->dif == 1) {
			$this->Punto($mis_puntos[138],$elem[138],Info(1,'chk'),138);
		}
	break;

	case 139:
		if (($puntos[139]=='duda')&&(($z==0)||($z==2))) {
			$this->Punto('duda',$elem[139],Info(139,'duda'),139);
		} else if ($this->dif == 1) {
			$this->Punto($mis_puntos[139],$elem[139],Info(1,'chk'),139);
		}
	break;

	case 1310:
		if (($puntos[1310]=='duda')&&(($z==0)||($z==2))) {
			$this->Punto('duda',$elem[1310],Info(1310,'duda'),1310);
		} else if ($this->dif == 1) {
			$this->Punto($mis_puntos[1310],$elem[1310],Info(1,'chk'),1310);
		}
	break;

	case 141:
		if (($puntos[141]=='duda')&&(($z==0)||($z==2))) {
			$this->Punto('duda',$elem[141],Info(141,'duda'),141);
		} else if ($this->dif == 1) {
			$this->Punto($mis_puntos[141],$elem[141],Info(1,'chk'),141);
		}
	break;

	case 142:
		if (($puntos[142]=='duda')&&(($z==0)||($z==2))) {
			$this->Punto('duda',$elem[142],Info(142,'duda'),142);
		} else if ($this->dif == 1) {
			$this->Punto($mis_puntos[142],$elem[142],Info(1,'chk'),142);
		}
	break;

	case 143:
		if (($puntos[143]=='duda')&&(($z==0)||($z==2))) {
			$this->Punto('duda',$elem[143],Info(143,'duda'),143);
		} else if ($this->dif == 1) {
			$this->Punto($mis_puntos[143],$elem[143],Info(1,'chk'),143);
		}
	break;
	//eMag points
	/*RGB begin*/
	case 313:
		if (($puntos[313]=='duda')&&(($z==0)||($z==2))) {
			$this->Punto('duda',$elem[313],Info(313,'duda'),313);
		} else if (($puntos[313]=='na')&&(($z==0)||($z==4))) {
			$this->Punto('na',$elem[313],Info(313,'na'),313);
		} else if ($this->dif == 1) {
			$this->Punto($mis_puntos[313],$elem[313],Info(1,'chk'),313);
		}
	break;
} // Fin switch

		// Formulario
		if (AN == 1) {
			$this->Formulario($x,$y,$mis_puntos[$x]);
		}
		echo "</dl>\n";
	} // Fin función Este_Punto


	function Icon_Res($res, $n, $era) {
		global $lang;
		echo '<dl class="'.$res.'">'."\n";
		echo '<dt class="dt_'.$res.'">';
		echo '<span><img src="img/'.$res.'.gif" alt="'.$this->res_texto[$res].'" class="ico" /> ';
		echo sprintf($lang['dt_txt'], $n, $this->res_texto[$res]);
		if ($this->dif == 1) {
			echo ' (<img src="img/'.$era.'.gif" alt="'.$lang['dt_alt_ico'].'" title="';
			echo sprintf($lang['dt_tit_ico'], $this->res_texto[$era]);
			echo '" class="ico" />)';
		}
		echo "</span></dt>\n\n";
	} // Fin Icon_Res


	function Punto ($resultado, $elemento, $texto, $punto, $ver=true, $w3c='') {
		global $help, $param, $lang;

		if (PR > 0) {
			$esto = '&amp;pr=';
			$x = PR.'&amp;re='.RE;
		} else if (PT > 0) {
			$esto = '&amp;pt=';
			$x = PT;
		}
		if (!strstr($param,$esto)) {
			$param .= $esto.$x;
		}
		$ancla = 'p_'.$punto;

		if (($elemento=='Verificación manual') || ($punto==1000)) {
			$texto = nl2br($texto);
			if ($texto != '' ) {
				echo '<dd class="'.$resultado.'"><img src="img/persona.gif" alt="'.$lang['dd_alt_ico_man'].'" width="16" height="16" /> <strong>'.$lang['dd_txt_man'].'</strong>: '.stripslashes($texto)." ";
				echo "</dd>\n\n";
			}
		} else {
			if ($this->dif == 1) {
				$ico_manual = '<img src="img/persona2.gif" alt="'.$lang['dd_alt_ico_man2'].'" width="16" height="16" /> ';
			}

			echo '<dd class="ico_tool">';
			if ($ancla != HX) {
				if (HL == 1) {
					echo  '<img src="img/minidim.gif" alt="" class="veren" /> <span class="inv">|</span> ';
				} else {
					echo  '<a href="'.PHP_SELF.$param.'&amp;hx=p_'.$punto.'" title="';
					echo sprintf($lang['dd_tit_instruc'], $elemento);
					echo '" onclick="display(\''.$ancla.'\'); return false;"><img src="img/minihelp.gif" alt="'.$lang['dd_alt_instruc'].'" class="veren" /></a> <span class="inv">|</span> ';
				}
			} else {
				echo  '<a href="'.PHP_SELF.$param.'" title="'.$lang['dd_tit_instruc2'].'" onclick="display(\''.$ancla.'\'); return false;"><img src="img/minihelpa.gif" alt="'.$lang['dd_alt_instruc'].'" class="ninihlp" /></a> <span class="inv">|</span> ';
			}

			if ($ver == true) {
				if ($w3c == 'validator') {
					echo '<a href="http://validator.w3.org/check?uri='.URL.'" target="demo" title="'.$lang['dd_tit_validator'].'"><img src="img/w3c.gif" alt="'.$lang['dd_alt_validator'].'" width="30" height="16" /></a>';
				} else if ($w3c == 'css') {
					echo '<a href="http://jigsaw.w3.org/css-validator/validator?uri='.URL.'&warning=2&profile=css2&usermedium=all" target="demo" title="'.$lang['dd_tit_css'].'"><img src="img/w3c.gif" alt="'.$lang['dd_alt_css'].'" width="30" height="16" /></a>';
				} else if ($w3c == 'contraste') {
					echo '<a href="color.php?url='.URL.'&amp;lng='.IDIOMA.'" target="demo" title="'.$lang['dd_tit_contraste'].'"><img src="img/vercolor.gif" alt="'.$lang['dd_alt_contraste'].'" class="veren" /></a>';
					echo ' <span class="inv">|</span> <a href="view.php?id='.ID.'&amp;pto='.$punto.'&amp;lng='.IDIOMA.'&amp;opt=code" target="demo" title="'.$lang['dd_tit_code'].'"><img src="img/vercod.gif" alt="'.$lang['dd_alt_code'].'" class="veren" /></a>';
				} else if ($w3c == 'sincss') {
					echo '<a href="view.php?id='.ID.'&amp;pto='.$punto.'&amp;lng='.IDIOMA.'&amp;opt=page&amp;sincss=1" target="demo" title="'.$lang['dd_tit_page'].'"><img src="img/verpag.gif" alt="'.$lang['dd_alt_page'].'" class="veren" /></a>'."\n";
				} else {
					echo '<a href="view.php?id='.ID.'&amp;pto='.$punto.'&amp;lng='.IDIOMA.'&amp;opt=page" target="demo" title="'.$lang['dd_tit_page'].'"><img src="img/verpag.gif" alt="'.$lang['dd_alt_page'].'" class="veren" /></a>'."\n";
					echo ' <span class="inv">|</span> <a href="view.php?id='.ID.'&amp;pto='.$punto.'&amp;lng='.IDIOMA.'&amp;opt=code" target="demo" title="'.$lang['dd_tit_code'].'"><img src="img/vercod.gif" alt="'.$lang['dd_alt_code'].'" class="veren" /></a>';
				}
			} else {
				echo '<a href="view.php?id='.ID.'&amp;pto='.$punto.'&amp;lng='.IDIOMA.'&amp;opt=page" target="demo" title="'.$lang['dd_tit_page'].'"><img src="img/verpag.gif" alt="'.$lang['dd_alt_page'].'" class="veren" /></a>';
			}
			echo "</dd>\n\n";

			echo '<dd class="'.$resultado.'">'.$ico_manual.'<img src="img/'.$resultado.'.gif" alt="'.$this->res_texto[$resultado].'" class="ico" /> <strong>'.ucfirst($elemento).'</strong>: '.$texto." ";

			echo "\n<ul class=\"hlp\" id=\"".$ancla."\" style=\"display:none\">\n<li><strong>".$lang['dd_txt_ins']."</strong><br />".$help[$punto].'<br />[<a href="'.PHP_SELF.$param.'" onclick="display(\''.$ancla.'\'); return false;">'.$lang['dd_txt_ins_close'].'</a>]'."</li>\n</ul>\n";
			echo "</dd>\n\n";
		} // fin si no hay revisión manual
	} // Fin función Punto


	function Formulario($punto,$puntodec,$resultado) {
		global $comentarios, $lang;

		echo '<dd class="form"><fieldset>'."\n";
		echo '<legend>'.sprintf($lang['form_legend'], $puntodec)."</legend>\n";
		echo '<p class="centro"><label class="duda"><input type="radio" name="r_'.$punto.'" value="duda"';
		if ($resultado == 'duda') { echo ' checked="checked"'; }
		echo " /> ".ucfirst($lang['result_notTested'])."</label> | \n";
		echo '<label class="bien"><input type="radio" name="r_'.$punto.'" value="bien"';
		if ($resultado == 'bien') { echo ' checked="checked"'; }
		echo " /> ".ucfirst($lang['result_pass'])."</label> | \n";
		echo '<label class="mal"><input type="radio" name="r_'.$punto.'" value="mal"';
		if ($resultado == 'mal') { echo ' checked="checked"'; }
		echo " /> ".ucfirst($lang['result_fail'])."</label> | \n";
		echo '<label class="na"><input type="radio" name="r_'.$punto.'" value="na"';
		if ($resultado == 'na') { echo ' checked="checked"'; }
		echo " /> ".ucfirst($lang['result_notApplicable'])."</label> | \n";
		echo '<label class="parcial"><input type="radio" name="r_'.$punto.'" value="parcial"';
		if ($resultado == 'parcial') { echo ' checked="checked"'; }
		echo " /> ".ucfirst($lang['result_parcial'])."</label> | \n";
		echo '<label class="nose"><input type="radio" name="r_'.$punto.'" value="nose"';
		if ($resultado == 'nose') { echo ' checked="checked"'; }
		echo " /> ".ucfirst($lang['result_cannotTell'])."</label></p>\n";
		echo '<p><label for="c'.$punto.'"><em>'.$lang['form_txtarea'].'</em><br />'."\n";
		echo '<textarea cols="75" rows="4" name="c_'.$punto.'" id="c'.$punto.'">'.stripslashes($comentarios[$punto]).'</textarea></label></p>'."\n";
		echo '<p style="font-size:0.8em; margin:0px;text-align:center">'.$lang['form_aviso'].'</p>';
		echo "\n</fieldset></dd>\n\n";
	} // Fin función Formulario
} // Fin class
?>