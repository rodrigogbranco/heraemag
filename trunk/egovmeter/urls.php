<?php 
 $titulo = "URL's pesquisadas";
 include("./includes/egovmeter_header.inc.php");
?>

<div align="center"><center>
	<table border="0" cellpadding="0" style="border-collapse: collapse" width="770" id="table2">
		<tr>
			<td>
			<p align="center">
			<p align="justify"><font face="Verdana" size="1">
			<?php
			
			conecta();
	
			
			$consulta = mysql_query("select * from egovmeter_municipio");
			$i = 1;
            while($result = mysql_fetch_array($consulta, MYSQL_ASSOC))
            { 
               echo $i . " - " . $result["url"] . " - ". $result["municipio"] .  "<Br>";
               $i++;
               }
			?>
			<br>
			<br>
</td>
</tr>
</table>
<?php 
include("./includes/egovmeter_footer.inc.php");
?>
