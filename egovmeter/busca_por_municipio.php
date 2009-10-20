<?php 
 $titulo = "Resultados da busca sobre " .  $municipio ;
 include("./includes/egovmeter_header.inc.php");
?>

<?php
function testipaddress ($nametotest, $ip_se_ja_teve) {
   $ipaddress = $nametotest;
   $ipaddress = gethostbyname($nametotest);
   if ($ipaddress == $nametotest) {
		if ($ip_se_ja_teve <> "") {
			echo "[ Não disponível no momento mas já houve histórico desse site pelo ip: $ip_se_ja_teve ]";
		}
		else
	       echo "[ Nenhuma resposta de site encontrada ]";
   }
   else {
       echo "[ Disponível com IP de resposta: $ipaddress ]";
   }
}
?>

<div align="center">
	<table border="0" cellpadding="0" style="border-collapse: collapse" width="770" id="table2">
		<tr>
			<td>			<p align="center"><br>
			<b><font size="2" face="Verdana">Busca por munic&iacute;pio </font></b></p>
						<form name="form1" method="post" action="busca_por_municipio.php">
		    <font face="Verdana" size="1">Busca por munic&iacute;pio: 
			  <input name="municipio" type="text" value="<?php echo  $municipio ?>" size="30" maxlength="80">
                <input type="submit" name="Submit" value="Buscar">
              </form><font face="Verdana" size="1">Data da consulta: <?php echo  date("d/m/Y h:i:s"); ?> 
			  			
			  <p align="justify"><font face="Verdana" size="1"><B>RESULTADOS ENCONTRADOS</B><BR>
			    <BR>
			<?php			
			conecta();	
			
			$ip = getenv ("REMOTE_ADDR");
			$basebusca = "INSERT INTO `egovmeter_busca_municipio` (	`busca` , `ip` , `time_stamp_ins`)	VALUES ('$municipio','$ip'  , NOW())";
			mysql_query($basebusca) or die('Query failed: ' . mysql_error());
			
			$consulta = mysql_query("select a.municipio, a.uf, a.url, a.id_municipio, max(id_sessao_monitoramento), b.ip from egovmeter_municipio a
left join egovmeter_monitoramento b on a.id_municipio = b.id_municipio
where concat( a.municipio, ' ', a.uf ) LIKE '%$municipio%'
OR concat( a.municipio, ' - ', a.uf ) LIKE '%$municipio%'
OR concat( a.municipio, '-', a.uf ) LIKE '%$municipio%'
OR concat( a.municipio, ', ', a.uf ) LIKE '%$municipio%'
group by a.id_municipio");
			$i = 1;
			if (mysql_num_rows($consulta) == 0 ) {
				echo "Nenhum resultado encontrado. Tente buscar novamente.";
			}
			if (mysql_num_rows($consulta) > 100 ) {
				echo "Busca muito ampla. Tente buscar novamente.";
			}
			else {
            while($result = mysql_fetch_array($consulta, MYSQL_ASSOC))
            { 
               echo "<b> $i - " . $result["municipio"] . "-". $result["uf"] .  "</b><Br>";
               echo "URL testada: <A href=http://" . $result["url"] . ">http://" . $result["url"] . "</a><BR>";
               echo "Status do site: ";			   
			   echo testipaddress ($result["url"], $result["ip"]) . "<BR><br>";
               $i++;
               }
			}
			
			?>
            <BR><BR>
			<br>
			</td>
		</tr>
	</table>
</div>
<?php 
include("./includes/egovmeter_footer.inc.php");
?>