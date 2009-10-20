<?php require_once("./includes/egovmeter_config.inc.php"); 
conecta();


$consulta = mysql_query("select DATE_FORMAT(date_fim,'%d/%m/%Y (%H:%ihs)') as data_ultimo_monitoramento, id_sessao_monitoramento from egovmeter_sessao_monitoramento
order by date_fim desc");
$result = mysql_fetch_array($consulta, MYSQL_ASSOC);
$data_ultimo_monitoramento = $result["data_ultimo_monitoramento"];
$id_sessao_monitoramento= $result["id_sessao_monitoramento"];

$consulta = mysql_query("select count(*) as total_municipios from egovmeter_municipio a 
inner join egovmeter_monitoramento b on a.id_municipio = b.id_municipio
where a.uf = '" . $UF . "' and b.id_sessao_monitoramento = " . $id_sessao_monitoramento);

$result = mysql_fetch_array($consulta, MYSQL_ASSOC);
$total_municipios = $result["total_municipios"];



$sql = "select count(*) as total_municipios_com_site from egovmeter_municipio a 
inner join egovmeter_monitoramento b on a.id_municipio = b.id_municipio
where a.uf = '" . $UF . "' and b.ip is not null and b.id_sessao_monitoramento = " . $id_sessao_monitoramento;

$consulta = mysql_query($sql);

$result = mysql_fetch_array($consulta, MYSQL_ASSOC);
$total_municipios_com_site = $result["total_municipios_com_site"];

$total_municipios_sem_site = $total_municipios - $total_municipios_com_site;
?>
<link rel="stylesheet" href="egovmeter.css">
<div id="divTudo">
<p class=titulo>Estado - <?php echo $UF ?></p>
<BR>
<br>
A seguir tem-se os dados da última medição completa,  feita em: 
<?php echo $data_ultimo_monitoramento ?>

<br>
<br>
Número total de municípios: <?php echo $total_municipios ?>.
<BR><BR>

<?php $porcentagem =  ($total_municipios_com_site * 100) /$total_municipios; ?>
Número total de municípios com site: <?php echo $total_municipios_com_site ?> (<?php echo number_format($porcentagem,2,",",".") ?>%). <BR>
Número total de municípios sem site: <?php echo $total_municipios_sem_site ?> (<?php echo  number_format(100 - $porcentagem,2,",",".") ?>%). <BR>


</div>
<script>
//calcula o tamanho do iframe
re = document.getElementById("divTudo").scrollHeight + 20; //20 é um desconto 
window.parent.document.getElementById("resultado").height = re;
window.parent.document.getElementById("carregando").style.display = "none";
</script>