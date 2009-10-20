<?

define ('IDIOMA', 'pt');
require('inc/config.php'); // Config file
require('lang/'.IDIOMA.'/lang.php'); // Interface texts
require("lang/".IDIOMA."/wcag.php"); // Guidelines texts
require ("inc/common.php"); // Some core libraries
require('inc/resumen.php'); // Class to build the summary of results
require("inc/metrics.php");

$cons_pages = "select * from egovmeter_acessibilidade_municipios order by id_municipio";

$query_pages = mysql_query($cons_pages);

$metric = new Metric;

while ($page = mysql_fetch_array($query_pages)) {
	$site = $page['url'];
	$mun_id = $page['id_municipio'];

	$comando = "httrack $site -r2 -O municipios/$mun_id -N1";
	echo "$comando\n";
	exec($comando);

	$files = array();
	$dh  = opendir("municipios/$mun_id/web");
	while (false !== ($filename = readdir($dh))) {
		$res = substr_count($filename, ".htm");
		if ($res) {
    			$files[] = $filename;
			$insert = "insert into egovmeter_acessibilidade_link values (NULL, $mun_id, 'http://agua.intermidia.icmc.usp.br/hera/municipios/$mun_id/web/$filename',
				NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL)";
			mysql_query($insert); 
		}
	
	}

	sort($files);

}

?>
