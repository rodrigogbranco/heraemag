<?php
$autenticacao = 1;
include("../includes/egovmeter_header.inc.php") ?>
<body>
<p>Testando Sites</p>
<p>&nbsp;</p>
<?php 
set_time_limit(0);

conecta();

$descricao = $_POST['descricao'];
mysql_query("insert into egovmeter_sessao_monitoramento (descricao, date_inicio, id_sessao) values ('$descricao', now(), " . $_SESSION["id_sessao"] . ")");	   
$id_sessao_monitoramento = mysql_insert_id();


$consulta = mysql_query("select * from egovmeter_municipio");

 while($result = mysql_fetch_array($consulta, MYSQL_ASSOC))
 { 
    testipaddress($result["url"], $result["id_municipio"], $id_sessao_monitoramento);
 }


function testipaddress ($nametotest, $id_municipio, $id_sessao_monitoramento) {
   $ipaddress = $nametotest;
   $ipaddress = gethostbyname($nametotest);
   if ($ipaddress == $nametotest) {
       echo "Não tem site: $nametotest<br>";
	   mysql_query("insert into egovmeter_monitoramento (id_municipio, id_sessao_monitoramento, ip) values ('$id_municipio', '$id_sessao_monitoramento', null)");
   }
   else {
       echo "Tem Site: $nametotest,  IP = $ipaddress<br>";
	   mysql_query("insert into egovmeter_monitoramento (id_municipio, id_sessao_monitoramento, ip) values ('$id_municipio', '$id_sessao_monitoramento', '$ipaddress')");	   
   }
}
?>
<?php  include("../includes/egovmeter_header.inc.php") ?>
</body>