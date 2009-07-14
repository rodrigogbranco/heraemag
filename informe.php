<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: private");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: private");

require_once('inc/config.php');
require_once ("inc/common.php");

cleanAll();
define ('ID', $_REQUEST['id']);
define ('IDIOMA', $_REQUEST['idioma']);
require_once('lang/'.IDIOMA.'/elem.php');
require_once('lang/'.IDIOMA.'/lang.php');
require_once('lang/'.IDIOMA.'/info.php');
require_once("lang/".IDIOMA."/wcag.php");

DB_Query('select', 'informe');

$Comentario = trim(htmlspecialchars($_REQUEST['Comentario'], ENT_QUOTES));
$autor = trim(htmlspecialchars($_REQUEST['nombre'], ENT_QUOTES));
$titulo = trim(htmlspecialchars($_REQUEST['titulo'], ENT_QUOTES));
$email = trim(htmlspecialchars($_REQUEST['email'], ENT_QUOTES));

$guardar = @mysql_query("UPDATE ".DBTABLE." SET resumen='".$Comentario."', nombre='".$autor."' WHERE id=".ID);

$TOTAL = array();
$boxes = count($_REQUEST['box']);
if ($boxes > 0) {
	foreach ($wcag1 as $k => $v) {
		if (in_array($mis_puntos[$k], $_REQUEST['box'])) {
			$TOTAL[] = $k;
		}
	}
}

if ($_REQUEST['earl'] || $_REQUEST['earldown']) {

	$wcag = array(
11 => '#tech-text-equivalent',
12 => '#tech-redundant-server-links',
13 => '#tech-auditory-descriptions',
14 => '#tech-synchronize-equivalents',
15 => '#tech-redundant-client-links',
21 => '#tech-color-convey',
22 => '#tech-color-contrast',
31 => '#tech-use-markup',
32 => '#tech-identify-grammar',
33 => '#tech-style-sheets',
34 => '#tech-relative-units',
35 => '#tech-logical-headings',
36 => '#tech-list-structure',
37 => '#tech-quotes',
41 => '#tech-identify-changes',
42 => '#tech-expand-abbr',
43 => '#tech-identify-lang',
51 => '#tech-table-headers',
52 => '#tech-table-structure',
53 => '#tech-avoid-table-for-layout',
54 => '#tech-table-layout',
55 => '#tech-table-summaries',
56 => '#tech-abbreviate-labels',
61 => '#tech-order-style-sheets',
62 => '#tech-dynamic-source',
63 => '#tech-scripts',
64 => '#tech-keyboard-operable-scripts',
65 => '#tech-fallback-page',
71 => '#tech-avoid-flicker',
72 => '#tech-avoid-blinking',
73 => '#tech-avoid-movement',
74 => '#tech-no-periodic-refresh',
75 => '#tech-no-auto-forward',
81 => '#tech-directly-accessible',
91 => '#tech-client-side-maps',
92 => '#tech-keyboard-operable',
93 => '#tech-device-independent-events',
94 => '#tech-tab-order',
95 => '#tech-keyboard-shortcuts',
101 => '#tech-avoid-pop-ups',
102 => '#tech-unassociated-labels',
103 => '#tech-linear-tables',
104 => '#tech-place-holders',
105 => '#tech-divide-links',
111 => '#tech-latest-w3c-specs',
112 => '#tech-avoid-deprecated',
113 => '#tech-content-preferences',
114 => '#tech-alt-pages',
121 => '#tech-frame-titles',
122 => '#tech-frame-longdesc',
123 => '#tech-group-information',
124 => '#tech-associate-labels',
131 => '#tech-meaningful-links',
132 => '#tech-use-metadata',
133 => '#tech-site-description',
134 => '#tech-clear-nav-mechanism',
135 => '#tech-nav-bar',
136 => '#tech-group-links',
137 => '#tech-searches',
138 => '#tech-front-loading',
139 => '#tech-bundled-version',
1310 => '#tech-skip-over-ascii',
141 => '#tech-simple-and-straightforward',
142 => '#tech-icons',
143 => '#tech-consistent-style');

	$autor = utf8_encode($autor);
	$titulo = utf8_encode($titulo);
	$Comentario = utf8_encode($Comentario);
	$pagina = URL;
	//$fecha = substr($fecha, 0, 10);
	$fecha = date("Y-m-d", strtotime($fecha));

	if (($email != '')) {
		$femail = "\n".'      <foaf:mbox rdf:resource="mailto:'.$email.'"/>';
	}

	if (trim($autor) != '') {
		$persona = "\n".'   <rdf:type rdf:resource="http://xmlns.com/foaf/0.1/Person"/>';
		$persona .= "\n".'      <foaf:name>'.$autor.'</foaf:name>';
		$persona .= $femail;
	}

	if (trim($titulo) != '' ) {
		$tit_informe = "\n".'   <rdfs:label xml:lang="'.IDIOMA.'">'.$titulo.'</rdfs:label>';
	}
	if (trim($Comentario) != '' ) {
		$comen_informe = "\n".'   <rdfs:comment xml:lang="'.IDIOMA.'">'.$Comentario.'</rdfs:comment>';
	}

	if ($_REQUEST['earldown']) {
		header('Content-Disposition: attachment; filename="sidar.rdf"');
		header("Content-type: unknown/unknown");
	} else {
		header("Content-Type: text/plain; charset=utf-8");
	}

	echo '<?phpxml version="1.0"?>'."\n";

	echo <<<FIN
<rdf:RDF xmlns:earl="http://www.w3.org/WAI/ER/EARL/nmg-strawman#" 
 xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
 xmlns:foaf="http://xmlns.com/foaf/0.1/"
 xmlns:sidar="http://www.sidar.org/EARL/mas-earl.rdf#"
 xmlns:rdfs="http://www.w3.org/2000/01/rdf-schema#"
 xmlns:dc="http://purl.org/dc/elements/1.1/">

  <rdf:Description rdf:about="">
    <rdfs:seeAlso rdf:resource="http://www.w3.org/2001/sw/Europe/200305/axforms/earlinst.rdf"/>
    <rdfs:seeAlso rdf:resource="http://www.sidar.org/EARL/mas-earl.rdf"/>$tit_informe$comen_informe
  </rdf:Description>

  <earl:WebContent rdf:about="#subject">
    <earl:reprOf>$pagina</earl:reprOf>
    <dc:date rdf:datatype="http://www.w3.org/2001/XMLSchema#gDate">$fecha</dc:date>
  </earl:WebContent>

  <earl:Assertor rdf:about="#assertor">$persona
    <sidar:usando> 
      <earl:Tool rdf:about="http://www.sidar.org/hera/">
        <dc:title>Hera</dc:title>
        <dc:location>http://www.sidar.org/hera/</dc:location>
      </earl:Tool>
    </sidar:usando>
  </earl:Assertor>
\n
FIN;

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

	function Asse($v, $mode) {
		global $wcag1, $comentarios, $mis_puntos, $puntos, $wcag, $items;
		echo '  <earl:Assertion rdf:about="#wcag1cp'.$wcag1[$v].'">'."\n";
		echo '    <earl:subject rdf:resource="#subject" />'."\n";
		if ($mode == 'auto') {
			$texto = '';
			if (is_array($items[$v])) {
				foreach ($items[$v] as $item) {
					$texto .= Info($item,$puntos[$item])."<br />\n       ";
				}
			} else {
				$texto .= Info($v,$puntos[$v]);
			}
			$texto = preg_replace("@<br />\n       $@","",$texto);
			echo '    <earl:message rdf:parseType="Literal">'."\n";
			echo '      <p xmlns="http://www.w3.org/1999/xhtml" xml:lang="'.IDIOMA.'">'.utf8_encode($texto).'</p>'."\n";
			echo '    </earl:message>'."\n";
			$que = ($puntos[$v] == 'duda')? 'nose' : $puntos[$v];
			$earl_mode = '    <earl:mode rdf:resource="http://www.w3.org/WAI/ER/EARL/nmg-strawman#automatic"/>'."\n";
			if ($v == 32) {
				if (($puntos[3201]=='bien') || ($puntos[3201]=='mal')) {
					$collec1 = 1;
					$earl_by = '    <earl:assertedBy rdf:parseType="Collection">'."\n";
					$earl_by .= '      <earl:Tool rdf:about="http://validator.w3.org/">'."\n";
					$earl_by .= '        <dc:title xml:lang="en">W3C Markup Validator</dc:title>'."\n";
					$earl_by .= '        <dc:location rdf:datatype="http://www.w3.org/2001/XMLSchema#URI">http://validator.w3.org</dc:location>'."\n";
					$earl_by .= '      </earl:Tool>'."\n";
				}
				if (($puntos[3202]=='bien') || ($puntos[3202]=='mal')) {
					$collec2 = 1;
					if ($collec1 != 1) {
						$earl_by = '    <earl:assertedBy rdf:parsetype="Collection">'."\n";
						$earl_by .= '      <earl:Tool rdf:about="htp://www.sidar.org/hera/" />'."\n";
					}
					$earl_by .= '      <earl:Tool rdf:about="http://jigsaw.w3.org/CSSvalidator">'."\n";
					$earl_by .= '        <dc:title xml:lang="en">W3C CSS Validator</dc:title>'."\n";
					$earl_by .= '        <dc:location rdf:datatype="http://www.w3.org/2001/XMLSchema#URI">http://jigsaw.w3.org/CSSValidator</dc:location>'."\n";
					$earl_by .= '      </earl:Tool>'."\n";
				}
				if (($collec1 == 1) && ($collec2 != 1)) {
					$earl_by .= '      <earl:Tool rdf:about="htp://www.sidar.org/hera/" />'."\n";
				}
				if (($collec1 != 1) && ($collec2 != 1)) {
					$earl_by = '    <earl:assertedBy rdf:resource="http://www.sidar.org/hera/" />'."\n";
				} else {
					$earl_by .= '    </earl:assertedBy>'."\n";
				}
			} else {
				$earl_by = '    <earl:assertedBy rdf:resource="http://www.sidar.org/hera/" />'."\n";
			}

		} else {
			echo '    <earl:message>'.utf8_encode($comentarios[$v]).'</earl:message>'."\n";
			$que = $mis_puntos[$v];
			$earl_mode = '    <earl:mode rdf:resource="http://www.w3.org/WAI/ER/EARL/nmg-strawman#manual"/>'."\n";
			$earl_by = '    <earl:assertedBy rdf:resource="#assertor" />'."\n";
		}
			switch ($que) {
				case 'bien':
					echo '    <earl:result rdf:type="http://www.w3.org/WAI/ER/EARL/nmg-strawman#pass"/>'."\n";
				break;
				case 'mal':
					echo '    <earl:result rdf:type="http://www.w3.org/WAI/ER/EARL/nmg-strawman#fail"/>'."\n";
				break;
				case 'parcial':
					echo '    <earl:result rdf:type="http://www.sidar.org/EARL/mas-earl.rdf#parcial"/>'."\n";
				break;
				case 'nose':
					echo '    <earl:result rdf:type="http://www.w3.org/WAI/ER/EARL/nmg-strawman#cannotTell"/>'."\n";
				break;
				case 'na':
					echo '    <earl:result rdf:type="http://www.w3.org/WAI/ER/EARL/nmg-strawman#notApplicable"/>'."\n";
				break;
				case 'duda':
					echo '    <earl:result rdf:type="http://www.w3.org/WAI/ER/EARL/nmg-strawman#notTested"/>'."\n";
				break;
			} // End switch

		echo $earl_mode;
		echo '    <earl:testcase rdf:resource="http://www.w3.org/TR/WCAG10/'.$wcag[$v].'"/>'."\n";
		echo $earl_by;
		echo '  </earl:Assertion>'."\n\n";
	} // End function Assert()

	foreach ($TOTAL as $k => $v) {
		if ($puntos[$v] == $mis_puntos[$v]) {
			if ($comentarios[$v] == '') {
				Asse($v, 'auto');
			} else {
				Asse($v, 'manual');
				Asse($v, 'auto');
			}
		} else {
			Asse($v, 'manual');
			Asse($v, 'auto');
		}
	}

echo '</rdf:RDF>';

} else if ($_REQUEST['html'] || $_REQUEST['htmldown']) {

function ICONORES($res) {
	global $lang;
	$res_texto = array (
	'bien' => ucfirst($lang['result_pass']),
	'mal' => ucfirst($lang['result_fail']),
	'duda' => ucfirst($lang['result_notTested']),
	'na' => ucfirst($lang['result_notApplicable']),
	'parcial' => ucfirst($lang['result_parcial']),
	'nose' => ucfirst($lang['result_cannotTell'])	);
	return '<dd class="'.$res.'"><img src="http://www.sidar.org/hera/img/'.$res.'.gif" alt="'.$res_texto[$res].'" class="icon" /> <strong>'.$res_texto[$res].'.</strong>';
} // Fin ICONORES

	if ($_REQUEST['htmldown']) {
		header('Content-Disposition: attachment; filename="sidar.html"');
	}
	header("Content-type: text/html; charset=iso-8859-1");
	$opt_head['bread'] = 'pagina_informe';
	$opt_head['form'] = 'pagina_informe';
	$opt_head['bar'] = 'pagina_informe';
	include('inc/header.php');
?>
<div class="caja">
<?php
if ($titulo != '') {
	echo '<h2>'.$titulo.'</h2>';
}
?>
<ul id="datos">
<li><a name="inicio" id="inicio"></a> <?php printf($lang['informe_html_pag'], URL); ?></li>
<li><?php echo $lang['informe_html_fecha'].' '.gmdate($lang['formato_fecha'], strtotime($fecha)); ?></li>
<?php
if ($nombre != '') {
	echo '<li>'.sprintf($lang['informe_html_autor'], $nombre);
		if ($email != '') {
			echo ' &lt;'.$email.'&gt;';
		}
	echo "</li>";
}
if ($Comentario != '') {
	echo "<li>".$lang['informe_html_com']."\n<ul>\n";
	echo '<li style="list-style-type:none"><em>'.stripslashes(nl2br($Comentario))."</em></li>\n</ul>\n</li>";
}
?> 
</ul>
<?php
	if ($boxes > 0) {
?>
<h2><?php echo $lang['informe_html_h2']; ?></h2>
<dl>
<?php
foreach ($TOTAL as $k => $v) {
	echo '<dt><strong>'.sprintf($lang['informe_html_pto'], $wcag1[$v]).'</strong> <q>'.$wcag[$v].'</q></dt>'."\n";
	echo ICONORES($mis_puntos[$v]);
	if ($comentarios[$v] != '') {
		echo '<br /><em>'.stripslashes(nl2br($comentarios[$v])).'</em>';
	}
	echo "</dd>\n\n";
}
?>
</dl>
<?php
	} // Fin if boxes
?>
</div>
<?php
	include_once('inc/footer.php');
} else if ($_REQUEST['pdf']) {

require_once('inc/fpdf.php');

class PDF extends FPDF {

function Header() {
	global $lang;
	$this->Image('img/logohera.jpg',20,22,16,0,'', 'http://www.sidar.org/hera/');
	$this->SetFont('Arial','B',14);
	$this->SetDrawColor(0,0,0);
	$this->SetLineWidth(0.5);
	$this->Cell(0,5,$lang['informe_html_tit'],'B',0,'R');
	$this->Ln(20);
}

function Footer() {
	global $lang;
	$this->SetDrawColor(0,0,0);
	$this->Line(20,276,200,276);
	$this->SetY(-15);
	$this->Image('img/logosidar.jpg',20,277,16,0,'', 'http://www.sidar.org/');
	$this->Cell(18);
	$this->SetFont('Arial','B',10);
	$this->Cell(0,5,'Fundación SIDAR');
	$this->SetFont('Arial','I',8);
//	$this->Cell(0,3,'Página '.$this->PageNo().'/{nb}',0,0,'R');
	$tmp = sprintf($lang['informe_html_pag'], $this->PageNo());
	$this->Cell(0,3,$tmp.'/{nb}',0,0,'R');
}

function ICONORES($res) {
	global $lang;
	switch ($res) {
		case 'bien':
			$res = ucfirst($lang['result_pass']);
			$this->SetFillColor(238,255,238);
		break;
		case 'mal':
			$res = ucfirst($lang['result_fail']);
			$this->SetFillColor(255,238,246);
		break;
		case 'duda':
			$res = ucfirst($lang['result_notTested']);
			$this->SetFillColor(238,249,255);
		break;
		case 'na':
			$res = ucfirst($lang['result_notApplicable']);
			$this->SetFillColor(246,246,246);
		break;
		case 'parcial':
			$res = ucfirst($lang['result_parcial']);
			$this->SetFillColor(255,238,221);
		break;
		case 'nose':
			$res = ucfirst($lang['result_cannotTell']);
			$this->SetFillColor(255,255,255);
		break;
	}
    $this->Cell(0,5,$res,0,1,'',1);
}
} // Fin class

//Creación del objeto de la clase heredada
$pdf=new PDF();
$pdf->SetAuthor('Carlos Benavidez');
$pdf->SetCreator('Hera');
$pdf->SetTitle('HERA - '.$lang['informe_html_tit']);
$pdf->SetSubject($lang['informe_html_txt']);
$pdf->SetAutoPageBreak(1,30);
$pdf->SetMargins(20,30,10);
$pdf->SetFont('Times','',10);
$pdf->AliasNbPages();
$pdf->AddPage();

$pag = sprintf($lang['informe_html_pag'], URL);
	$pdf->Cell(0,5,$pag,0,1);

$dia = $lang['informe_html_fecha'].' '.gmdate($lang['formato_fecha'], strtotime($fecha));
	$pdf->Cell(0,5,$dia,0,1);

if (trim($_REQUEST['nombre']) != '') {
	$aut = sprintf($lang['informe_html_autor'], htmlspecialchars(trim($_REQUEST['nombre'])));
		if (trim($_REQUEST['email']) != '') {
			$aut .= ' <'.htmlspecialchars(trim($_REQUEST['email'])).'>';
		}
	$pdf->Cell(0,5,$aut,0,1);
}

if (trim($Comentario) != '') {
	$coment = $lang['informe_html_com']." ".stripslashes(trim($Comentario));
	$pdf->Cell(0,5,$coment,0,1);
}

	$pdf->Ln();
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(0,10,$lang['informe_html_h2'],0,1,'C');
	$pdf->SetLineWidth();
	$pdf->SetDrawColor(153,204,255);
	
	foreach ($TOTAL as $k => $v) {
		$pdf->SetFont('Arial','B',10);
		$txt = sprintf($lang['informe_html_pto'], $wcag1[$v]).'.';
		$pdf->Cell(0,5,$txt,'T',1);
		$txt = '';

		$txt = preg_replace("/<[^>]*>/", "", $wcag[$v]);
		$pdf->SetFont('Times','',10);
		$pdf->MultiCell(0,5,$txt);
		$txt = '';
		
		$pdf->Ln(2);
		$pdf->SetFont('Arial','',10);
		$pdf->SetLeftMargin(30);
		$pdf->ICONORES($mis_puntos[$v]);
		if ($comentarios[$v] != '') {
			$pdf->MultiCell(0,5,$comentarios[$v],0,'L',1);
		}
		$pdf->SetLeftMargin(20);
		$pdf->Ln(10);
	} // Fin foreach
	
	
	$pdf->Output('hera.pdf', 'D');
} else if ($_REQUEST['spraw']) {
	header("Location: spraw.php?id=".ID."&lang=".IDIOMA);
}
?>
