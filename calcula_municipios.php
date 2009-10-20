<?

define ('IDIOMA', 'pt');
require('inc/config.php'); // Config file
require('lang/'.IDIOMA.'/lang.php'); // Interface texts
require("lang/".IDIOMA."/wcag.php"); // Guidelines texts
require ("inc/common.php"); // Some core libraries
require('inc/resumen.php'); // Class to build the summary of results
require("inc/metrics.php");

$cons_pages = "select * from egovmeter_acessibilidade_municipios WHERE id_municipio <= 6000 and id_municipio > 5000";
$query_pages = mysql_query($cons_pages);

$today = date("F j, Y, g:i a");
$handle = fopen ("tempo_calculo_municipios.php", "a");

fwrite($handle, "inicio: " . $today.'\r\n');

fclose($handle);


while ($page = mysql_fetch_array($query_pages)) {
	$site = $page['url'];
	$mun_id = $page['id_municipio'];

	echo "Executando site $site\n";

	$cons = "select * from egovmeter_acessibilidade_link WHERE mun_id = $mun_id";

	$query_links = mysql_query($cons);

	while ($row = mysql_fetch_array($query_links)) { 
		$link_id = $row['link_id'];
		$url = $row['url'];

		$eval = "http://agua.intermidia.icmc.usp.br/hera/metric_results?url=$url";

		$count = 0;
                while (!($handle = fopen ("$eval", "rb")) && $count < 2) $count++;
		if (!$handle){
			continue;
		}
                $conteudo = "";
                do {
                        $data = fread($handle, 8192);
                        if (strlen($data) == 0) {
                                break;
                        }
                        $conteudo .= $data;
                } while(true);
                fclose ($handle);

                $res_array = explode(" ", $conteudo);

                $res_a3 = $res_array[0];
                $res_a3_1 = $res_array[1];
                $res_pot = $res_array[2];
                $res_uwem = $res_array[3];
                $res_uwem_1 = $res_array[4];
                $res_wab = $res_array[5];
                $res_waqm = $res_array[6];
                $res_resumo  = $res_array[7];

		$saida =  "$link_id $res_a3 $res_a3_1 $res_pot $res_uwem $res_uwem1 $res_wab $res_waqm $res_resumo";

		$handle = fopen ("saida_municipios4.txt", "a");

		fwrite($handle, "$saida\n");

		fclose($handle);

        	mysql_query("update egovmeter_acessibilidade_link SET a3 = $res_a3, a3_1 = $res_a3_1, uwem = $res_uwem, uwem_1 = $res_uwem_1, pot = $res_pot, wab = $res_wab, waqm = $res_waqm, avaliacao='$res_resumo' WHERE mun_id = $mun_id");
	}	

	$num_lines = 0;
	$avg_a3 = 0;
	$avg_a3_1 = 0;
	$avg_uwem = 0;
	$avg_uwem_1 = 0;
	$avg_pot = 0;
	$avg_wab = 0;
	$avg_waqm = 0;
	
	$cons = "select * from egovmeter_acessibilidade_link WHERE mun_id = $mun_id";
	$query = mysql_query($cons);
	while($row = mysql_fetch_array($query)) {
		$a3 = $row['a3'];
		$a3_1 = $row['a3_1'];	
		$uwem = $row['uwem'];
		$uwem_1 = $row['uwem_1'];
		$pot = $row['pot'];
		$wab = $row['wab'];
		$waqm = $row['waqm'];
		$avg_a3 += $a3;
		$avg_a3_1 += $a3_1;
		$avg_uwem += $uwem;
		$avg_uwem_1 += $uwem_1;
		$avg_pot += $pot;
		$avg_wab += $wab;
		$avg_waqm += $waqm;
		$num_lines++;
	}

	$avg_a3 = $avg_a3 / $num_lines;
	$avg_a3_1 = $avg_a3_1 / $num_lines;
	$avg_uwem = $avg_uwem / $num_lines;
	$avg_uwem_1 = $avg_uwem_1 / $num_lines;
	$avg_pot = $avg_pot / $num_lines;
	$avg_wab = $avg_wab / $num_lines;
	$avg_waqm = $avg_waqm / $num_lines;
	
	$cons = "update egovmeter_acessibilidade_municipios SET a3 = $avg_a3, a3_1 = $avg_a3_1, uwem = $avg_uwem, uwem_1 = $avg_uwem_1, pot = $avg_pot, wab = $avg_wab, waqm = $avg_waqm WHERE id_municipio = $mun_id";
	mysql_query($cons);
}

$today = date("F j, Y, g:i a");
$handle = fopen ("tempo_calculo_municipios.php", "a");

fwrite($handle, "fim: " . $today.'\r\n');

fclose($handle);


?>
