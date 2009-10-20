<?php 
 $titulo = "Detalhes da sessão de monitoramento";
 include("./includes/egovmeter_header.inc.php");
?>

<div align="center">
	<table border="0" cellpadding="0" style="border-collapse: collapse" width="770" id="table2">
		<tr>
			<td>
			<p align="center"><br>
			<p align="justify"><font face="Verdana" size="1">
			<?php
			
			conecta();

			
			$consulta = mysql_query("select descricao, DATE_FORMAT(date_fim,'%d/%m/%Y (%H:%ihs)') as data_fim, DATE_FORMAT(date_inicio,'%d/%m/%Y (%H:%ihs)') as data_ini, id_sessao_monitoramento from egovmeter_sessao_monitoramento
 where id_sessao_monitoramento = $id_sessao");

$result = mysql_fetch_array($consulta, MYSQL_ASSOC);

			   echo "Descrição: " . $result["descricao"] . "<Br>";
               echo "Início: " . $result["data_ini"] . "<Br>";
               echo "Término: " . $result["data_fim"] . "<Br>";


			?>
			<br>
			<br>
			<br>
			</td>
		</tr>
	</table>
</div>
<?php 
include("./includes/egovmeter_footer.inc.php");
?>