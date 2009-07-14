<?php

define ('IDIOMA', 'pt');
require('inc/config.php'); // Config file
require('lang/'.IDIOMA.'/lang.php'); // Interface texts
require("lang/".IDIOMA."/wcag.php"); // Guidelines texts
require ("inc/common.php"); // Some core libraries
require('inc/resumen.php'); // Class to build the summary of results
require("inc/metrics.php");

$metric = new Metric;
//$site = 'http://www.google.com.br';
$metric->barriers();
//echo "URL: $site<br/>";

$res_a3 = $metric->a3("auto");

$res_a3_1 = $metric->A3_1("auto");

$res_pot = $metric->potential_problems("auto");

$res_wab = $metric->WAB("auto");

$res_uwem = $metric->UWEM("auto");

$res_uwem1 = $metric->UWEM_1("auto");

$res_waqm = $metric->WAQM("auto");

$res_waqm1 = $metric->WAQM1("auto");

$resum = $metric->resume();

echo "Resultado a3: $res_a3 <br/>";
echo "Resultado a3_1: $res_a3_1 <br/>";
echo "Resultado pot: $res_pot <br/>";
echo "Resultado wab: $res_wab <br/>";
echo "Resultado uwen: $res_uwem <br/>";
echo "Resultado uwen1: $res_uwem1 <br/>";
echo "Resultado waqm: $res_waqm <br/>";
echo "Resultado waqm1: $res_waqm1 <br/>";

$resumo = base64_encode(serialize($resum));

//echo "Resumo: $resumo";


?>
