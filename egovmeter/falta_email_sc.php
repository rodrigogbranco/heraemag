<?php
require_once("./includes/egovmeter_config.inc.php");
?>

<div align="center"><center>
	<table border="0" cellpadding="0" style="border-collapse: collapse" width="770" id="table2">
		<tr>
			<td>
			<p align="center">
			<p align="justify"><font face="Verdana" size="1">Prefeituras que estão com e-mail faltando<BR><BR>
			<?php
			
			conecta();
	
		$sql = "SELECT * 
FROM egovmeter_email a
RIGHT JOIN egovmeter_municipio b ON a.id_municipio = b.id_municipio
WHERE b.uf = 'PR'
AND a.id_municipio IS NULL LIMIT 3";
 	
			$consulta = mysql_query($sql) ; 

echo mysql_num_rows($consulta)  . "<BR>";
?>

<?php

$i = 1;
            while($result = mysql_fetch_array($consulta, MYSQL_ASSOC))
            { 
               echo "<div style='float: left;'>" . $i . " - <A target=_blank href=http://" . $result["url"] . ">" . $result["url"] . "</a> - ". $result["municipio"] .  "</div><div ><form action=insere_email.php method=post><input type=hidden name=id_municipio value=" . $result["id_municipio"] . "> <input type=text name=email size=20></form><div> <Br>";
               $i++;
               }



?>

			<br>
			<br>
</td>
</tr>
</table>
