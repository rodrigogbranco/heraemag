<?php include("functions.php") ?>
<html>

<head>
<meta http-equiv="Content-Language" content="pt-br">
<title>E-GOVMeter by e-democracia.com.br</title>
</html>
</head>

<body topmargin="3" leftmargin="3">
&nbsp;<div align="center">
	<table border="0" cellpadding="0" style="border-collapse: collapse" width="780" id="table1">
		<tr>
			<td width="242">
			<a href="index.php">
			<img border="0" src="egovmeter.jpg" width="240" height="141"></a></td>
			<td width="538">
			<img border="0" src="edemocracia.gif" width="220" height="84" align="right"></td>
		</tr>
	</table>
</div>
<div align="center">
	<table border="0" cellpadding="0" style="border-collapse: collapse" width="780" id="table2">
		<tr>
			<td>
			<p align="center"><br>
			<b><font face="Verdana" size="2">Resultados encontrados</font></b></p>
			<p align="justify"><font face="Verdana" size="1">Número de URL's válidas encontradas: <?
			
			conecta();			
			
			$consulta = mysql_query("select count(*) as nro from municipio where tem_site = 1");

            $result = mysql_fetch_array($consulta, MYSQL_ASSOC);
            echo $result["nro"] ;
            				$nro = $result["nro"];
			?>  
			<?
				$consulta = mysql_query("select count(*) as nro_total from municipio");
				$result = mysql_fetch_array($consulta, MYSQL_ASSOC);
				

				$total = $result["nro_total"];
				$porcentagem =  ($nro * 100) /$total ;
				
               echo " (" . number_format($porcentagem,2,",",".") . "%) de " .  $result["nro_total"];

			?> URL's pesquisadas.			
			
			<br>
			<br>
			Data da última pesquisa: 28/02/2005.<br><br><br><br>	
			<a href="index.php">.: voltar :.</a></font></p>
			<p align="center"><font face="Times New Roman" size="1">
			<font color="#C0C0C0">
			__________________________________________________________________________________________________</font><br>
			© </font><font face="Verdana" size="1">e-govMeter by e-democracia.com.br<br>
&nbsp;</font></td>
		</tr>
	</table>
</div>
</body>
</html>