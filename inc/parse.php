<?php
/*=======================================
  HERA v.2.0 Beta                        
  File: inc/parse.php                    
  Parse page & define automatic results  
=======================================*/

class Parse {
	var $cssinc = ''; // Embed CSS content
	var $cssext = array(); // External CSS
	var $cssimport = array(); // Import CSS
	var $tot = array(); // Elements, attributes, etc.
	var $pto = array();  // Result of each checkpoint
	var $hrefa = array(); // A href
	var $marcos = array(); // Frames
	var $res_11_mal = 0;
	var $res_11_duda = 0;
	var $elem_prog = 0;

	function This_Page($redir="", $meta="") {
		global $tags, $contents;
		$dep_applet = array('hspace','vspace','align','archive','code', 'codebase','height','name','object','width');
		$dep_basefont = array('size','color','face');
		$dep_body = array('text','vlink','alink','link','background', 'bgcolor');
		// $dep_font = $dep_basefont
		$dep_hr = array('align','size','width','noshade');
		$dep_img = array('align','border','hspace','vspace');
//$dep_object = $dep_img
		$dep_ol = array('type','start','compact');
		$dep_table = array('align','bgcolor');
		$dep_td = array('height','width','bgcolor','nowrap');
		$dep_ul = array('compact','type');
		$pres_applet = array('hspace','vspace','align','height','width');
		$asoc_td = array('axis','headers','scope');
		$atributos = array('title', 'lang', 'style', 'class', 'accesskey', 'charset', 'tabindex', 'target');
		$eventos = array('onload', 'onfocus', 'onblur', 'onsubmit', 'onreset', 'onselect', 'onchange', 'onunload', 'onclick', 'onmousedown', 'onmouseup', 'onkeypress', 'onkeydown', 'onkeyup', 'ondblclick', 'onmousemove', 'onmouseover', 'onmouseout');
		$items_na = array(1101, 1102, 1103, 1104, 1105, 1106, 1107, 1108, 1109, 1110, 1111, 11, 12, 1301, 1302, 1303, 13, 1401, 1402, 1403, 14, 15, 3202, 51, 52, 54, 55, 56, 61, 6201, 6202, 62, 6301, 6302, 6303, 6304, 63, 64, 6501, 6502, 65, 8101, 8102, 8103, 8104, 81, 91, 9201, 9202, 92, 93, 102, 103, 104, 105, 121, 122, 124, 131, /*eMag*/ 313 /*eMag*/);
		foreach ($items_na as $res) {
			$this->pto[$res] = 'na';
		}

		$items_duda = array(21, 22, 3202, 32, 3401, 34, 36, 37, 41, 42, 94, 111, 113, 114, 123, 132, 133, 134, 135, 136, 137, 138, 139, 1310, 141, 142, 143);
		foreach ($items_duda as $res) {
			$this->pto[$res] = 'duda';
		}

		if ($redir != "") { $this->tot['url_redir'] = $redir; }
		if ($meta != "") { $this->tot['meta_redir'] = $meta; }

		foreach ($tags as $key => $tag) {
			preg_match("@<([/|\?|!]*[\w]+)@i", $tag, $el);
			$elem = strtolower($el[1]);
			
			if ($tag{1} != '/') {
				$this->tot[$elem]++;
				$this->tot['total']++;
			}
			$this->Sumar_Attr($tag,$atributos,'attr_');
			$this->Sumar_Attr($tag,$eventos,'event_');
			if (preg_match("@style=[\"\']?([^\"\'\/\>]*)@i",$tag,$est)) {
				$cssinc .= ' {'.$est[1].'}';
				$this->tot['hay_estilos'] = 1;
			}
			if (($cierre_a == 1) && ($elem == 'a')) {
				$this->tot['a_adya']++;
			}
			$cierre_a = 0;
			if (($noframe_vacio == 1) && ($elem != '/noframes')) {
				$noframe_vacio = 0;
			}

	// TODO: indentation!!
	switch ($elem) {
	case '!doctype':
		$this->tot['dtd'] = htmlspecialchars($tag);
	break;
	
	/*eMag action*/
	case 'form':
		if(isset($_SESSION['choose']))
		{
			if($_SESSION['choose'] == 'emag')
				$this->pto[313] = 'duda';
		}
	break;

	case 'a':
	preg_match("@href=([\"\'])? (?(1) (.*?)\\1 | ([^\s\>]+))@ix",$tag,$outurl);
	$this->hrefa[] = Absolute_URL(URL_BASE,$outurl[2]);
	if (preg_match("@^javascript:@i", $outurl[2])) {
		$this->tot['href_javascript']++;
		$this->pto[6301] = 'mal';
	}
	if (count(count_chars($outurl[2], 1)) < 2) {
		if (preg_match("@on(click|keypress|dblclick)@i",$tag)) {
			$this->tot['href_javascript']++;
			$this->pto[6301] = 'mal';
		}
	}
	if (preg_match("@\.(aif|aifc|aiff|au|m3u|mid|mp3|ra|ram|rmi|snd|wav)$@i", $outurl[2])) {
		$this->tot['hrefson']++;
		$this->res_11_duda++;
		$this->pto[1109] = 'duda';
	} else if (preg_match("@\.(asf|asr|asx|avi|lsf|lsx|mov|movie|mp2|mpa|mpe|mpeg|mpg|mpv2|ppt|qt|swf)$@i", $outurl[2])) {
		$this->tot['hrefapp']++;
		$this->res_11_duda++;
		$this->pto[1110] = 'duda';
		$this->pto[1303] = 'duda';
		$this->pto[1403] = 'duda';
	}
	$this->pto[131] = 'duda';
	break;

	case '/a':
	$enlace = preg_replace('@&nbsp;@','',$contents[$key]);
	if (trim($enlace) == '') {
		$cierre_a = 1;
	}
	break;

	case 'applet':
	$this->Sum_Attr_Elem($tag,$dep_applet,'attr_deprec');
	$this->Sum_Attr_Elem($tag,'alt','alt_applet');
	$this->Sum_Attr_Elem($tag,$pres_applet,'attr_pres');
	$this->elem_prog++;
	$this->res_11_duda++;
	$this->pto[1106] = 'duda';
	$this->pto[31] = 'duda';
	$this->pto[6201] = 'duda';
	$this->pto[6304] = 'duda';
	$this->pto[63] = 'duda';
	$this->pto[8103] = 'duda';
	break;

	case 'area':
	preg_match("@href=([\"\'])? (?(1) (.*?)\\1 | ([^\s\>]+))@ix",$tag,$outar);
	$this->tot['areas'][] = Absolute_URL(URL_BASE,$outar[2]);
	$this->Sum_Attr_Elem($tag,'alt','alt_area');
	if (preg_match("@\.(aif|aifc|aiff|au|m3u|mid|mp3|ra|ram|rmi|snd|wav)$@i", $outar[2])) {
		$this->tot['hrefson']++;
		$this->res_11_duda++;
		$this->pto[1109] = 'duda';
	} else if (preg_match("@\.(asf|asr|asx|avi|lsf|lsx|mov|movie|mp2|mpa|mpe|mpeg|mpg|mpv2|ppt|qt|swf)$@i", $outar[2])) {
		$this->tot['hrefapp']++;
		$this->res_11_duda++;
		$this->pto[1110] = 'duda';
		$this->pto[1303] = 'duda';
		$this->pto[1403] = 'duda';
	}
	break;

	case 'basefont':
	$this->Sum_Attr_Elem($tag,$dep_basefont,'attr_deprec');
	$this->Sum_Attr_Elem($tag,$dep_basefont,'attr_pres');
	break;

	case 'body':
	$body = 1;
	$this->Sum_Attr_Elem($tag,$dep_body,'attr_deprec');
	$this->Sum_Attr_Elem($tag,$dep_body,'attr_pres');
	break;

	case 'blockquote':
	$this->Sum_Attr_Elem($tag,'cite','attr_meta');
	break;

	case 'br':
	$this->Sum_Attr_Elem($tag,'clear','attr_deprec');
	$this->Sum_Attr_Elem($tag,'clear','attr_pres');
	break;

	case 'caption':
	$this->Sum_Attr_Elem($tag,'align','attr_deprec');
	$this->Sum_Attr_Elem($tag,'align','attr_pres');
	break;

	case 'del':
	$this->Sum_Attr_Elem($tag,'cite','attr_meta');
	break;

	case 'dir':
	$this->Sum_Attr_Elem($tag,'compact','attr_deprec');
	$this->Sum_Attr_Elem($tag,'compact','attr_pres');
	break;

	case 'div':
	$this->Sum_Attr_Elem($tag,'align','attr_deprec');
	$this->Sum_Attr_Elem($tag,'align','attr_pres');
	break;

	case 'dl':
	$this->Sum_Attr_Elem($tag,'compact','attr_deprec');
	$this->Sum_Attr_Elem($tag,'compact','attr_pres');
	break;

	case 'embed':
	$this->pto[1301] = 'duda';
	$this->pto[1401] = 'duda';
	$this->pto[31] = 'duda';
	$this->pto[6201] = 'duda';
	$this->pto[6303] = 'duda';
	$this->pto[63] = 'duda';
	$this->pto[8102] = 'duda';
	break;

	case 'font':
	$this->Sum_Attr_Elem($tag,$dep_basefont,'attr_deprec');
	$this->Sum_Attr_Elem($tag,$dep_basefont,'attr_pres');
	break;

	case 'frame':
	$this->pto[6202] = 'duda';
	if (stristr($tag," src=")) {
		preg_match("@src=([\"\'])? (?(1) (.*?)\\1 | ([^\s\>]+))@ix",$tag,$frm);
		$this->marcos[] = Absolute_URL(URL_BASE,$frm[2]);
		if (preg_match("@\.(jpg|jpeg|gif|png|tif|bmp|swf)$@i", $frm[2])) {
			$this->tot['img_en_frame']++;
			$this->pto[6202] = 'mal';
			$this->pto[62] = 'mal';
		}
	} else {
		$this->marcos[] = '(Marco sin contenido inicial)';
	}
	if (strstr($tag,'title=')) {
		$this->tot['titulo_frame']++;
	}
	if (strstr($tag,'longdesc=')) {
		$this->tot['longdesc_frame']++;
	}
	break;

	case 'h1':
	$this->Sum_Attr_Elem($tag,'align','attr_deprec');
	$this->Sum_Attr_Elem($tag,'align','attr_pres');
	break;

	case 'h2':
	$this->Sum_Attr_Elem($tag,'align','attr_deprec');
	$this->Sum_Attr_Elem($tag,'align','attr_pres');
	if($this->tot['h1'] == 0) {
		$this->tot['horden']++;
	}
	break;

	case 'h3':
	$this->Sum_Attr_Elem($tag,'align','attr_deprec');
	$this->Sum_Attr_Elem($tag,'align','attr_pres');
	if (($this->tot['h2'] == 0) || ($this->tot['h1'] == 0)) {
		$this->tot['horden']++;
	}
	break;

	case 'h4':
	$this->Sum_Attr_Elem($tag,'align','attr_deprec');
	$this->Sum_Attr_Elem($tag,'align','attr_pres');
	if (($this->tot['h3'] == 0) || ($this->tot['h2'] == 0) || ($this->tot['h1'] == 0)) {
		$this->tot['horden']++;
	}
	break;

	case 'h5':
	$this->Sum_Attr_Elem($tag,'align','attr_deprec');
	$this->Sum_Attr_Elem($tag,'align','attr_pres');
	if (($this->tot['h4'] == 0) || ($this->tot['h3'] == 0) || ($this->tot['h2'] == 0) || ($this->tot['h1'] == 0)) {
		$this->tot['horden']++;
	}
	break;

	case 'h6':
	$this->Sum_Attr_Elem($tag,'align','attr_deprec');
	$this->Sum_Attr_Elem($tag,'align','attr_pres');
	if (($this->tot['h3'] == 5) || ($this->tot['h3'] == 4) || ($this->tot['h3'] == 0) || ($this->tot['h2'] == 0) || ($this->tot['h1'] == 0)) {
		$this->tot['horden']++;
	}
	break;

	case 'hr':
	$this->Sum_Attr_Elem($tag,$dep_hr,'attr_deprec');
	$this->Sum_Attr_Elem($tag,$dep_hr,'attr_pres');
	break;

	case 'html':
	preg_match("@ lang=([\"\'])? (?(1) (.*?)\\1 | ([^\s\>]+))@ix",$tag,$outlan);
	$this->tot['lang_pri'] = $outlan[2];
	$this->tot['attr_lang']--;
	if (stristr($tag,"xhtml")) {
		$this->tot['xhtml']++;
		preg_match("@xml:lang=([\"\'])? (?(1) (.*?)\\1 | ([^\s\>]+))@ix",$tag,$outxml);
		$this->tot['lang_xml'] = $outxml[2];
	}
	break;

	case 'iframe':
	$this->Sum_Attr_Elem($tag,'align','attr_deprec');
	$this->Sum_Attr_Elem($tag,'align','attr_pres');
	$this->res_11_duda++;
	$this->pto[1108] = 'duda';
	break;

	case 'img':
	$this->Sum_Attr_Elem($tag,$dep_img,'attr_deprec');
	$this->Sum_Attr_Elem($tag,$dep_img,'attr_pres');
	$this->Sum_Attr_Elem($tag,'alt','alt_img');
	if (stristr($tag," usemap")) { $this->tot['usemap']++; }
	if (stristr($tag," ismap")) {
		$this->tot['ismap']++;
		$this->pto[12] = 'duda';
		$this->pto[91] = 'mal';
		$this->pto[9201] = 'duda';
	}
	$this->pto[31] = 'duda';
	break;

	case 'input':
	$this->Sum_Attr_Elem($tag,'align','attr_deprec');
	$this->Sum_Attr_Elem($tag,'align','attr_pres');
	if (preg_match("@type=[\"\']?image@i",$tag)) {
		$this->tot['input_image']++;
		$this->Sum_Attr_Elem($tag,'alt','alt_input');
		if (stristr($tag," usemap")) { $this->tot['usemap']++; }
		if (stristr($tag," ismap")) {
			$this->tot['ismap']++;
			$this->pto[12] = 'duda';
			$this->pto[91] = 'mal';
			$this->pto[9201] = 'duda';
		}
	}
	preg_match("@id=([\"\'])? (?(1) (.*?)\\1 | ([^\s\/\>]+))@ix",$tag,$outid);
	$this->tot['id_for'][] = $outid[2];
	if (preg_match("@type=[\"\']?(text|password|radio|checkbox|file)@i", $tag)) {
	$this->tot['input_label']++;
	}
	if (preg_match("@type=[\"\']?text@i",$tag)) {
		$this->tot['input_text']++;
		if (preg_match("@value=([\"\'])? (?(1) (.*?)\\1 | ([^\s\/\>]+))@ix",$tag,$outxt)) {
			if(trim($outxt[2]) == '') { $this->tot['input_vacio']++; }
		} else {
			$this->tot['input_vacio']++;
		}
	}
	break;

	case 'ins':
	$this->Sum_Attr_Elem($tag,'cite','attr_meta');
	break;

	case 'label':
	$this->Sum_Attr_Elem($tag,'for','attr_for');
	if (preg_match("@for=([\"\'])? (?(1) (.*?)\\1 | ([^\s\/\>]+))@ix",$tag,$outfor)) {
		$this->tot['for_id'][] = $outfor[2];
	}
	break;

	case 'legend':
	$this->Sum_Attr_Elem($tag,'align','attr_deprec');
	$this->Sum_Attr_Elem($tag,'align','attr_pres');
	break;

	case 'li':
	$this->Sum_Attr_Elem($tag,'type','attr_deprec');
	$this->Sum_Attr_Elem($tag,'type','attr_pres');
	break;

	case 'link':
	if (preg_match("@rel=[\"\']?(.*)stylesheet@i",$tag)) {
		if (!preg_match("@media=[\"\']?print[\"\']?@i",$tag)) {
			$this->tot['css_externa']++;
			preg_match("@href=([\"\'])? (?(1) (.*?)\\1 | ([^\s\/\>]+))@ix",$tag,$outlk);
			$this->cssext[] = Absolute_URL(URL_BASE,$outlk[2]);
			$this->tot['css'][] = Absolute_URL(URL_BASE,$outlk[2]);
		}
		$this->tot['hay_estilos'] = 1;
	}
	if (preg_match("@ (rel|rev)=@i",$tag)) {
		$this->tot['link_rel']++;
	}
	break;

	case 'menu':
	$this->Sum_Attr_Elem($tag,'compact','attr_deprec');
	$this->Sum_Attr_Elem($tag,'compact','attr_pres');
	break;

	case 'meta':
	if (preg_match("@http-equiv=[\"\']?refresh@i",$tag)) {
		if (preg_match("@content=[\"\']?\d+;[\s]*URL@i",$tag)) {
			$this->tot['redirect']++;
			$this->pto[7501] = 'mal';
			$this->pto[75] = 'mal';
		} else {
			$this->tot['refresh']++;
			$this->pto[7401] = 'mal';
			$this->pto[74] = 'mal';
		}
	}
	break;

	case 'noframes':
	$nofrm = preg_replace('@&nbsp;@','',$contents[$key]);
	if (trim($nofrm) == '') {
		$noframe_vacio = 1;
	}
	break;

	case '/noframes':
	if ($noframe_vacio == 1) {
		$this->tot['noframe_vacio']++;
	}
	break;

	case 'object':
	$this->Sum_Attr_Elem($tag,$dep_img,'attr_deprec');
	$this->Sum_Attr_Elem($tag,$dep_img,'attr_pres');
	if (stristr($tag," usemap")) { $this->tot['usemap']++; }
	if (stristr($tag,"shockwave/cabs/flash")) {
		$totales['flash']++;
	}
	$this->elem_prog++;
	$this->res_11_duda++;
	$this->pto[1107] = 'duda';
	$this->pto[1302] = 'duda';
	$this->pto[1402] = 'duda';
	$this->pto[31] = 'duda';
	$this->pto[6201] = 'duda';
	$this->pto[6303] = 'duda';
	$this->pto[63] = 'duda';
	$this->pto[8104] = 'duda';
	break;

	case 'ol':
	$this->Sum_Attr_Elem($tag,$dep_ol,'attr_deprec');
	$this->Sum_Attr_Elem($tag,$dep_ol,'attr_pres');
	break;

	case 'p':
	$this->Sum_Attr_Elem($tag,'align','attr_deprec');
	$this->Sum_Attr_Elem($tag,'align','attr_pres');
	break;

	case 'pre':
	$this->Sum_Attr_Elem($tag,'width','attr_deprec');
	$this->Sum_Attr_Elem($tag,'width','attr_pres');
	break;

	case 'q':
	$this->Sum_Attr_Elem($tag,'cite','attr_meta');
	break;

	case 'script':
	$this->Sum_Attr_Elem($tag,'language','attr_deprec');
	if ($body == 1) {
		$this->tot['script_body']++;
		$this->res_11_duda++;
		$this->pto[1104] = 'duda';
	}
	$this->pto[6201] = 'duda';
	$this->pto[6302] = 'duda';
	$this->pto[63] = 'duda';
	$this->pto[6501] = 'duda';
	$this->pto[65] = 'duda';
	break;

	case 'select':
	preg_match("@id=([\"\'])? (?(1) (.*?)\\1 | ([^\s\/\>]+))@ix",$tag,$outsel);
	$this->tot['id_for'][] = $outsel[2];
	break;

	case 'style':
	$cont_style = preg_replace('@&quot;@','"',$contents[$key]);
	$this->Parse_CSS($cont_style, URL_BASE);
	$this->cssinc .= $cont_style;
	$this->tot['hay_estilos'] = 1;
	break;

	case 'table':
	$this->Sum_Attr_Elem($tag,$dep_table,'attr_deprec');
	$this->Sum_Attr_Elem($tag,$dep_table,'attr_pres');
	$this->Sum_Attr_Elem($tag,'summary','summary');
	if (preg_match("@(height|width)=[\"\']?\d[\"\'\s\>]+@i",$tag)) {
		$this->tot['htmlabs']++;
	}
	break;

	case 'td':
	$this->Sum_Attr_Elem($tag,$dep_td,'attr_deprec');
	$this->Sum_Attr_Elem($tag,$dep_td,'attr_pres');
	$this->Sum_Attr_Elem($tag,$asoc_td,'cell_asoc');
	if (preg_match("@(height|width)=[\"\']?\d[\"\'\s\>]+@i",$tag)) {
		$this->tot['htmlabs']++;
	}
	break;

	case 'textarea':
	if (trim($contents[$key]) == '') {
		$this->tot['input_vacio']++;
	}
	preg_match("@id=([\"\'])? (?(1) (.*?)\\1 | ([^\s\/\>]+))@ix",$tag,$outxta);
	$this->tot['id_for'][] = $outxta[2];
	break;

	case 'th':
	$this->Sum_Attr_Elem($tag,$dep_td,'attr_deprec');
	$this->Sum_Attr_Elem($tag,$dep_td,'attr_pres');
	$this->Sum_Attr_Elem($tag,$asoc_td,'cell_asoc');
	$this->Sum_Attr_Elem($tag,'abbr','th_abbr');
	if (preg_match("@(height|width)=[\"\']?\d[\"\'\s\>]+@i",$tag)) {
		$this->tot['htmlabs']++;
	}
	break;

	case 'tr':
	$this->Sum_Attr_Elem($tag,'bgcolor','attr_deprec');
	$this->Sum_Attr_Elem($tag,'bgcolor','attr_pres');
	break;

	case 'ul':
	$this->Sum_Attr_Elem($tag,$dep_ul,'attr_deprec');
	$this->Sum_Attr_Elem($tag,$dep_ul,'attr_pres');
	break;
	} // End switch

		} // End foreach

	$this->Revisar_CSS();
	$this->Define_Results();
	$this->Finalizar();

	} // Fin function This_Page

/*========================================
	Function: Add attributes with prefix   
	e.g., $total['event_onload']           
========================================*/

	function Sumar_Attr($tag,$arry,$pref) {
		$count = count($arry); 
		for ($i = 0; $i < $count; $i++) {
   		if (stristr($tag,' '.$arry[$i].'=')) {
				$this->tot[$pref.$arry[$i]]++;
			}
		}
	} // End function Sumar_Attr

/*========================================
	Function: Add attributes               
	e.g., $total['attr_deprec']            
========================================*/

	function Sum_Attr_Elem($tag,$arg,$var) {
		if (is_array($arg)) {
			$count = count($arg); 
			for ($i = 0; $i < $count; $i++) {
   			if (stristr($tag,' '.$arg[$i].'=')) {
					$this->tot[$var]++;
				}
			}
		} else {
			if (stristr($tag,' '.$arg.'=')) {
				$this->tot[$var]++;
			}
		}
	}// End function Sum_Attr_Elem

/*===============================
	Function: Parse CSS           
	Get URI's of external CSS     
===============================*/

	function Parse_CSS($esta, $base, $op='ext') {
		$esta = preg_replace( "@\s\s+@", " ", $esta);
		$esta = preg_replace("@/\*[\s\S]*\*/@sU","",$esta);
		$esta = preg_replace("|@import\s+\S+\s+print\s?;|is","",$esta);
		$this->CSS_Absolute($esta);
		preg_match_all("/@import\s+(url)?[\(]?[\"|']?([^ |'|\"|\;]*)/", $esta, $imp);
		for ($i=0; $i< count($imp[0]); $i++) {
			if ($op == 'ext') {
				$this->cssext[] = Absolute_URL($base,$imp[2][$i]);
			} else {
				$this->cssimport[] = Absolute_URL($base,$imp[2][$i]);
			}
			if (is_array($this->tot['css']) && !in_array($imp[2][$i],$this->tot['css'])) {
				$this->tot['css'][] = Absolute_URL($base,$imp[2][$i]);
			}
		}
	} // End function Parse_CSS

/*==========================
	Function: Check CSS      
	for absolutes values     
==========================*/

	function CSS_Absolute($esta_css) {
		preg_match_all("/[\{|\;](.*)[\}|\;]/sU", $esta_css, $resulta);
		for ($i=0; $i< count($resulta[0]); $i++) {
			if (preg_match("@:(.*)[0-9]+(in|cm|mm|pt|pc)@i", $resulta[1][$i])) {
				$this->tot['cssabs']++;
			}
			if (preg_match("@font(-size)[\s]*:(.*)[0-9]+px@i", $resulta[1][$i])) {
				$this->tot['cssfontpx']++;
			}
		} // End for
	} // End function CSS_Absolute

/*=================================
	Function: Read external CSS &   
	get URI base                    
=================================*/

	function Revisar_CSS() {
		$css = array ('cssext', 'cssimport');
		foreach ($css as $kcss => $vcss) {
			foreach ($this->$vcss as $k => $v) {
				$csstmp = '';
				$file = @fopen($v, "r");
				if ($file) {
					while (!feof($file)) {
						$csstmp .= stripslashes(fread($file, 8192));
					}
					fclose($file);
					// URI base
					$sep = explode("/",$v);
					$saca = array_pop($sep);
					$basetmp = rtrim($v,$saca);
					$this->Parse_CSS($csstmp, $basetmp, 'imp');
					if ($vcss == 'cssimport') {
						$this->cssext[] = $v; // Add URI
					}
				}
			} // End foreach
		} // End foreach
	} // End function Revisar_CSS


/*=======================================
	Function: Define results for each     
	checkpoint & sub-item                 
	e.g., $pto[11] means checkpoint 1.1   
	$pto[1101] means sub-item 01 (images) 
	of checkpoint 1.1                     
=======================================*/

	function Define_Results() {

	if ($this->tot['img'] > 0) {
		if ($this->tot['img'] > $this->tot['alt_img']) {
			$this->pto[1101] = 'mal';
			$this->res_11_mal++;
		} else {
			$this->pto[1101] = 'duda';
			$this->res_11_duda++;
		}
	}

	if ($this->tot['input_image'] > 0) {
		if ($this->tot['input_image'] > $this->tot['alt_input']) {
			$this->pto[1102] = 'mal';
			$this->res_11_mal++;
		} else {
			$this->pto[1102] = 'duda';
			$this->res_11_duda++;
		}
	}

	if ($this->tot['area'] > 0) {
		if ($this->tot['area'] > $this->tot['alt_area']) {
			$this->pto[1103] = 'mal';
			$this->res_11_mal++;
		} else {
			$this->pto[1103] = 'duda';
			$this->res_11_duda++;
		}
	}

	// 1104 Script_body en This_Page

	if ($this->tot['embed'] > 0) {
		$this->elem_prog++;
		if ($this->tot['embed'] > $this->tot['noembed']) {
			$this->pto[1105] = 'mal';
			$this->res_11_mal++;
		} else {
			$this->pto[1105] = 'duda';
			$this->res_11_duda++;
		}
	}

	// 1106 Applet en This_Page
	// 1107 Object en This_Page
	// 1108 Iframe en This_Page
	// 1109 hrefson en This_Page
	// 1110 hrefapp en This_Page

	if ($this->tot['frame'] > 0) {
		if ($this->tot['noframes'] > 0) {
			if ($this->tot['noframe_vacio'] > 0) {
				$this->pto[1111] = 'mal';
				$this->res_11_mal++;
				$this->pto[6502] = 'mal';
				$this->pto[65] = 'mal';
				if (($this->tot['longdesc_frame'] == 0) && ($this->tot['frame'] > $this->tot['titulo_frame'])) {
					$this->pto[122] = 'mal';
				} else {
					$this->pto[122] = 'duda';
				}
			} else {
				$this->pto[1111] = 'duda';
				$this->res_11_duda++;
				$this->pto[6502] = 'duda';
				$this->pto[65] = 'duda';
				$this->pto[122] = 'duda';
			}
		} else {
			$this->pto[1111] = 'mal';
			$this->res_11_mal++;
			$this->pto[6502] = 'mal';
			$this->pto[65] = 'mal';
			if (($this->tot['longdesc_frame'] == 0) && ($this->tot['frame'] > $this->tot['titulo_frame'])) {
				$this->pto[122] = 'mal';
			} else {
				$this->pto[122] = 'duda';
			}
		}
		if ($this->tot['frame'] > $this->tot['titulo_frame']) {
			$this->pto[121] = 'mal';
		} else {
			$this->pto[121] = 'duda';
		}
	}

	if ($this->res_11_mal > 0) {
		$this->pto[11] = 'mal';
	} else if ($this->res_11_duda > 0) {
		$this->pto[11] = 'duda';
	}

	// 12 ismap en This_Page

	// 1301 Embed en This_Page
	// 1302 Object en This_Page
	// 1303 hrefapp en This_Page

	if (($this->pto[1301]=='duda') || ($this->pto[1302]=='duda') || ($this->pto[1303]=='duda')) {
		$this->pto[13] = 'duda';
	}

	// 1401 Embed en This_Page
	// 1402 Object en This_Page
	// 1403 hrefapp en This_Page

	if (($this->pto[1401]=='duda') || ($this->pto[1402]=='duda') || ($this->pto[1403]=='duda')) {
		$this->pto[14] = 'duda';
	}

	if ($this->tot['usemap'] > 0) {
		foreach ($this->tot['areas'] as $k => $v) {
			if (!in_array($v,$this->hrefa)) {
				$this->tot['area_sin_red']++;
			}
		}
		if ($this->tot['area_sin_red'] == 0) {
			$this->pto[15] = 'bien';
		} else {
			$this->pto[15] = 'mal';
		}
	}

	if ($this->tot['hay_estilos'] == 1) { // Hay estilos
		// Punto 3202
		$url_css = 'http://jigsaw.w3.org/css-validator/validator?uri='.urlencode(URL).'&warning=no&profile=css2&output=soap12';
		$file_css = @fopen($url_css, "r");
		if ($file_css) {
			while (!feof($file_css)) {
				$res_css .= stripslashes(fread($file_css, 8192));
			}
			fclose($file_css);
		}
		if (preg_match("@\<m:validity\>(.*)\</m:validity\>@i", $res_css, $errcss)) {
			if ($errcss[1] == 'true') {
				$this->pto[3202] = 'bien';
			} else {
				$this->pto[3202] = 'mal';
			}
		}
		$this->tot['hay_estilos'] = 1;
	}

	// 31 Applet, embed, img, object en This_Page
	if ($this->pto[31] != 'duda') {
		$this->pto[31] = 'bien';
	}

	// Si hay una DTD (y sólo una)
	// abre la página del validador W3C y lee el resultado
	if ($this->tot['!doctype'] == 1) {
		$url_val = 'http://validator.w3.org/check?uri='.urlencode(URL);
		$file_val = @fopen($url_val, "r");
		if ($file_val) {
			while (!feof($file_val)) {
				$res_val .= stripslashes(fread($file_val, 8192));
			}
			fclose($file_val);
		}
		preg_match("@<h2(.*?)class=\"(invalid|valid)\">This Page Is( <strong>not</strong>)? Valid <a [^>]*>(.*)</a> ([a-zA-Z]+)\!</h2>@i", $res_val, $tempv);
		$this->tot['dtd_version'] = $tempv[4].' '.$tempv[5];
		if (preg_match("@<strong>not</strong>@i", $res_val)) {
			$this->pto[3201] = 'mal';
		} else if (preg_match("@This Page Is Valid@i", $res_val)) {
			$this->pto[3201] = 'bien';
		} else {
			$this->pto[3201] = 'duda';
		}
	} else {
		$this->pto[3201] = 'mal';
	}

	// 3202 - CSS validator

	if (($this->pto[3201] == 'bien') && (($this->pto[3202] == 'bien') || ($this->pto[3202] == 'na'))) {
		$this->pto[32] = 'bien';
	} else if (($this->pto[3201] == 'mal') || ($this->pto[3202] == 'mal')) {
		$this->pto[32] = 'mal';
	}

	if ($this->tot['hay_estilos'] == 1) {
		if ($this->tot['table'] > 0) {
			$this->pto[3301] = 'duda';
		} else {
			$this->pto[3301] = 'bien';
		}
	} else {
		if ($this->tot['table'] > 0) {
			$this->pto[3301] = 'mal';
		} else {
			$this->pto[3301] = 'bien';
		}
	}

	if ($this->tot['b'] + $this->tot['basefont'] + $this->tot['center'] + $this->tot['font'] + $this->tot['i'] + $this->tot['s'] + $this->tot['strike'] + $this->tot['u'] > 0) {
		$this->pto[3302] = 'mal';
	} else {
		$this->pto[3302] = 'bien';
	}
	if ($this->tot['attr_pres'] > 0) {
		$this->pto[3303] = 'mal';
	} else {
		$this->pto[3303] = 'bien';
	}
	if (($this->pto[3301]=='mal') || ($this->pto[3302]=='mal') || ($this->pto[3303]=='mal')) {
		$this->pto[33] = 'mal';
	} else if ($this->pto[3301]=='duda') {
		$this->pto[33] = 'duda';
	} else {
		$this->pto[33] = 'bien';
	}

	if ($this->tot['htmlabs'] > 0) {
		$this->pto[3401] = 'mal';
	}

	if ($this->tot['cssabs'] + $this->tot['cssfontpx'] > 0) {
		$this->pto[3402] = 'mal';
	} else {
		$this->pto[3402] = 'bien';
	}

	if (($this->pto[3401] == 'mal') || ($this->pto[3402] == 'mal')) {
		$this->pto[34] = 'mal';
	}

	if ($this->tot['h1'] + $this->tot['h2'] + $this->tot['h3'] + $this->tot['h4'] + $this->tot['h5'] + $this->tot['h6'] == 0) {
		$this->pto[35] = 'mal';
	} else if (($this->tot['horden'] > 0) || ($this->tot['h1'] == 0)) {
		$this->pto[35] = 'duda';
	} else {
		$this->pto[35] = 'bien';
	}

	if (($this->tot['li'] > 0) && ($this->tot['ol']+$this->tot['ul'] == 0)) {
		$this->pto[36] = 'mal';
	} else if (($this->tot['dt']+$this->tot['dd'] > 0) && ($this->tot['dl'] == 0)) {
		$this->pto[36] = 'mal';
	}

	// 3.7 - Siempre duda
	// 4.1 - Siempre duda
	// 4.2 - Siempre duda

	if ($this->tot['lang_pri']) {
		if (($this->tot['xhtml'] > 0) && (!$this->tot['lang_xml'])) {
			$this->pto[43] = 'mal';
		} else if (($this->tot['lang_xml']) && ($this->tot['lang_xml'] != $this->tot['lang_pri'])) {
			$this->pto[43] = 'mal';
		} else {
			$this->pto[43] = 'bien';
		}
	} else {
		if (stristr($this->tot['!doctype'],'XHTML 1.1')) {
			if ($this->tot['lang_xml']) {
				$this->pto[43] = 'mal';
			} else {
				$this->pto[43] = 'bien';
			}
		} else {
			$this->pto[43] = 'mal';
		}
	}

	if ($this->tot['table'] > 0) {
		$this->pto[51] = 'duda';
		$this->pto[52] = 'duda';
		$this->pto[53] = 'duda';
		if ($this->tot['th'] > 0) {
			$this->pto[54] = 'duda';
			$this->pto[56] = 'duda';
			if ($this->tot['summary'] > 0) {
				$this->pto[55] = 'duda';
			} else {
				$this->pto[55] = 'mal';
			}
		} else {
			$this->pto[54] = 'bien';
			if ($this->tot['summary'] > 0) {
				$this->pto[55] = 'mal';
			} else {
				$this->pto[55] = 'duda';
			}
		}
		$this->pto[103] = 'duda';
	} else {
		$this->pto[53] = 'bien';
	}

	// 5.2 - Tablas - Con punto 5.1
	// 5.3 - Tablas - Con punto 5.1
	// 5.4 - Tablas - Con punto 5.1
	// 5.5 - Tablas - Con punto 5.1
	// 5.6 - Tablas - Con punto 5.1

	if ($this->tot['style'] + $this->tot['css_externa'] + $this->tot['attr_style'] > 0) {
		$this->pto[61] = 'duda';
	}

	// 6201 script en This_Page
	// 6202 frame en This_Page

	if (($this->pto[6201]=='duda') && ($this->pto[6202]=='duda')) {
		$this->pto[62] = 'duda';
	}

	// 6301 href_javascript en This_Page
	// 6302 Scripts en This_Page
	// 6303 embed y object en This_Page
	// 6304 Applet en This_Page

	if ($this->tot['a'] > 0) {
		if ($this->pto[6301] == 'mal') {
			$this->pto[63] = 'mal';
		} else {
			$this->pto[6301] = 'duda';
			$this->pto[63] = 'duda';
		}
	}

	if ($this->tot['event_ondblclick'] + $this->tot['event_onmouseover'] + $this->tot['event_onmousemove'] + $this->tot['event_onmouseout'] > 0) {
		$this->pto[64] = 'mal';
		$this->pto[8101] = 'mal';
		$this->pto[81] = 'mal';
		$this->pto[93] = 'mal';
	} else if ($this->tot['event_onclick'] + $this->tot['event_onmousedown'] + $this->tot['event_onmouseup'] + $this->tot['event_onkeypress'] + $this->tot['event_onkeydown'] + $this->tot['event_onkeyup'] > 0) {
		if (($this->tot['event_onclick'] != $this->tot['event_onkeypress']) || ($this->tot['event_onkeydown'] != $this->tot['event_onmousedown']) || ($this->tot['event_onkeyup'] != $this->tot['event_onmouseup'])) {
			$this->pto[64] = 'mal';
			$this->pto[8101] = 'mal';
			$this->pto[81] = 'mal';
		} else {
			$this->pto[64] = 'duda';
			$this->pto[8101] = 'duda';
		}
		$this->pto[93] = 'mal';
	} else if ($this->tot['event_onload'] + $this->tot['event_onfocus'] + $this->tot['event_onblur'] + $this->tot['event_onsubmit'] + $this->tot['event_onreset'] + $this->tot['event_onselect'] + $this->tot['event_onchange'] + $this->tot['event_onunload'] > 0) {
		$this->pto[64] = 'bien';
		$this->pto[8101] = 'bien';
		$this->pto[93] = 'bien';
	}

	// 6501 Script en This_Page
	// 6502 - Marcos - Con punto 1111

	if ($this->tot['script'] + $this->elem_prog > 0) {
		$this->pto[71] = 'duda';
		$this->pto[72] = 'duda';
		$this->pto[73] = 'duda';
		$this->pto[7402] = 'duda';
		$this->pto[7502] = 'duda';
		$this->pto[10102] = 'duda';
	} else {
		$this->pto[71] = 'bien';
		$this->pto[72] = 'bien';
		$this->pto[73] = 'bien';
		$this->pto[7402] = 'bien';
		$this->pto[7502] = 'bien';
		$this->pto[10102] = 'bien';
	}

	if ($this->tot['img'] > 0) {
		$this->pto[72] = 'duda';
		$this->pto[73] = 'duda';
	}

	if ($this->tot['blink'] > 0) {
		$this->pto[72] = 'mal';
	}

	if ($this->tot['marquee'] > 0) {
		$this->pto[73] = 'mal';
	}

	if ($this->pto[7401] != 'mal') {
		$this->pto[7401] = 'bien';
		if ($this->pto[7402] == 'duda') {
			$this->pto[74] = 'duda';
		} else {
			$this->pto[74] = 'bien';
		}
	}

	if ($this->pto[7501] != 'mal') {
		$this->pto[7501] = 'bien';
		if ($this->pto[7502] == 'duda') {
			$this->pto[75] = 'duda';
		} else {
			$this->pto[75] = 'bien';
		}
	}

	// 8101 - Eventos - Con punto 6.4
	// 8102 Embed en This_Page
	// 8103 Applet en This_Page
	// 8104 Object en This_Page

	if ($this->pto[8101]=='duda') {
		$this->pto[81] = 'duda';
	} else if ($this->pto[8101]=='bien') {
		if (($this->pto[8102]=='duda') || ($this->pto[8103]=='duda') || ($this->pto[8104]=='duda')) {
			$this->pto[81] = 'duda';
		} else if (($this->pto[8102]=='na') && ($this->pto[8103]=='na') && ($this->pto[8104]=='na')) {
			$this->pto[81] = 'bien';
		}
	} else {
		if (($this->pto[8102]=='duda') || ($this->pto[8103]=='duda') || ($this->pto[8104]=='duda')) {
			$this->pto[81] = 'duda';
		}
	}

	if (($this->tot['usemap'] > 0) && ($this->pto[91] != 'mal')) {
		$this->pto[91] = 'bien';
	}

	// 9201 ismap en This_Page

	if ($this->elem_prog > 0) {
		$this->pto[9202] = 'duda';
	}

	if (($this->pto[9201]=='duda') || ($this->pto[9202]=='duda')) {
		$this->pto[92] = 'duda';
	}

	// 9.3 - Eventos - Con punto 6.4
	// 9.4 - Siempre duda

	if ($this->tot['attr_accesskey'] > 0) {
		$this->pto[95] = 'bien';
	} else {
		$this->pto[95] = 'mal';
	}

	if ($this->tot['attr_target'] > 0) {
		$this->pto[10101] = 'duda';
	} else {
		$this->pto[10101] = 'bien';
	}

	// 10.2 script, progr con 7.1

	if (($this->pto[10101] == 'bien') && ($this->pto[10102] == 'bien')) {
		$this->pto[101] = 'bien';
	} else {
		$this->pto[101] = 'duda';
	}

	$form_label = $this->tot['input_label'] + $this->tot['select'] + $this->tot['textarea'];
	if ($form_label > 0) {
		if ($form_label > $this->tot['label']) {
			$this->pto[102] = 'mal';
			$this->pto[124] = 'mal';
		} else {
			$this->pto[102] = 'duda';
			if ($this->tot['label'] > $this->tot['attr_for']) {
				$this->pto[124] = 'mal';
			} else {
				$this->pto[124] = 'duda';
				foreach ($this->tot['for_id'] as $f) {
					if (!in_array($f, $this->tot['id_for'])) {
						$this->pto[124] = 'mal';
					}
				}
			}
		}
	}

	// 103 - Tablas col. - Con punto 5.1

	if ($this->tot['input_text'] + $this->tot['textarea'] > 0) {
		if ($this->tot['input_vacio'] > 0) {
			$this->pto[104] = 'mal';
		} else {
			$this->pto[104] = 'bien';
		}
	}

	if ($this->tot['a'] > 1) {
		if ($this->tot['a_adya'] > 0) {
			$this->pto[105] = 'mal';
		} else {
			$this->pto[105] = 'bien';
		}
	}

	if ($this->tot['dtd']) {
		if (preg_match("@(XHTML|HTML 4.01)@i",$this->tot['dtd'])) {
			$this->tot['dtd_nueva']++;
		} else if (preg_match("@HTML (2.0|3.0|3.2|4.0)@i",$this->tot['dtd'])) {
			$this->tot['dtd_vieja']++;
			$this->pto[111] = 'mal';
		}
	}
	if ($this->tot['!doctype'] == 0) { $this->pto[111] = 'mal'; }
	if ($this->tot['applet'] + $this->tot['embed'] + $this->tot['blink'] + $this->tot['marquee'] + $this->tot['flash'] > 0) {
		$this->pto[111] = 'mal';
	}

	$this->tot['elem_deprec'] = $this->tot['applet'] + $this->tot['basefont'] + $this->tot['center'] + $this->tot['dir'] + $this->tot['font'] + $this->tot['isindex'] + $this->tot['menu'] + $this->tot['s'] + $this->tot['strike'] + $this->tot['u'];

	if ($this->tot['elem_deprec'] > 0) {
		$this->pto[11201] = 'mal';
	} else {
		$this->pto[11201] = 'bien';
	}

	if ($this->tot['attr_deprec'] > 0) {
		$this->pto[11202] = 'mal';
	} else {
		$this->pto[11202] = 'bien';
	}

	if (($this->pto[11201]=='bien') && ($this->pto[11202]=='bien')) {
		$this->pto[112] = 'bien';
	} else {
		$this->pto[112] = 'mal';
	}

	// 11.3 Duda
	// 11.4 Duda
	// 12.1 marcos
	// 12.2 marcos

	$bloques = $this->tot['h1'] + $this->tot['h2'] + $this->tot['h3'] + $this->tot['h4'] + $this->tot['h5'] + $this->tot['h6'] + $this->tot['p'] + $this->tot['ol'] + $this->tot['ul'] + $this->tot['dl'];
	if ($bloques == 0) {
		$this->pto[123] = 'mal';
	}

	// 12.4 - Con punto 10.2
	// 13.1 A en This_Page
	// 13.2/13.3/13.4/13.5/13.6/13.7/13.8/13.9 y 13.10 Duda
	// 14.1/14.2 y 14.3 Duda

	} // End function Define_Results


/*=================================
	Function: insert data into DB   
	Return the ID                   
=================================*/

	function Finalizar() {
		$time_end = Get_MTime();
		$time = $time_end - TIME_START;
		$this->tot['tiempo'] = round($time,2);

		$puntos = serialize($this->pto);

		$q_tmp = " SET
			software='".addslashes(SOFT)."',
			url='".URL."',
			url_base='".URL_BASE."',
			totales='".base64_encode(serialize($this->tot))."',
			puntos='".$puntos."',
			mis_puntos='".$puntos."',
			marcos='".base64_encode(serialize($this->marcos))."',
			fecha = now()";

		if (defined('HID')) {
			$query = "UPDATE ".DBTABLE.$q_tmp." WHERE id=".HID;
			$guardar = @mysql_query($query);
			if ($guardar) {
				define ('ID', HID);
				$_SESSION['ultimo_id'] = ID;
			}
		} else {
			$query = "INSERT INTO ".DBTABLE.$q_tmp;
			$guardar = @mysql_query($query);
			if ($guardar) {
				$pid = mysql_insert_id();
				define ('ID', $pid);
				$_SESSION['ultimo_id'] = ID;
			}
		} // End if
	} // End function Finalizar
} // Fin class Parse
?>
