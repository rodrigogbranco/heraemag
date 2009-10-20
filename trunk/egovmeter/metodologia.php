<?php
 $titulo = "Metodologia utilizada";
 include("./includes/egovmeter_header.inc.php");
?>

<body topmargin="3" leftmargin="3">

<div align="center">
	<table border="0" cellpadding="0" style="border-collapse: collapse" width="770" id="table2">
		<tr>
			<td>
			<p align="center"><br>
			<p align="justify"><font face="Verdana" size="1">&nbsp;&nbsp;&nbsp;&nbsp; 
			Na busca por dados mais atuais sobre o desenvolvimento municipal em 
			E-GOV consultou-se o Portal de Servi�os e Informa��es de Governo � 
			RedeGoverno (<a href="http://www.redegoverno.gov.br">http://www.redegoverno.gov.br</a>), que tem como uma de 
			suas fun��es centralizar de maneira organizada os sites 
			governamentais brasileiros. Entretanto, est�o homologados no Portal, 
			em fevereiro de 2005, apenas 579 sites de Gest�es Municipais, menos 
			da metade do n�mero de sites em 2001 relatados pelo IBGE. <br>
			<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Dessa maneira procurou-se sem sucesso, por 
			observa��o dos sites listados, um crit�rio para presen�a no Portal 
			(na listagem existem links para munic�pios grandes, pequenos; sites 
			de servi�os e informativos, prontos e em constru��o). J� o IBGE 
			informa que o crit�rio utilizado foi a an�lise de formul�rios 
			enviados pelas Prefeituras, sendo que n�o foram testados os links 
			para os sites. N�o se limitando aos dados do IBGE e Portal 
			RedeGoverno fez-se um experimento com metodologia espec�fica na 
			tentativa da obten��o de dados atuais condizentes com a realidade.
			<br>
			<br>
&nbsp;&nbsp;&nbsp;&nbsp; Tal experimento, realizado no LIA � Laborat�rio de 
			Intera��o Avan�ada (Tidia-AE) da UFSCar &agrave; partir de fevereiro de 2005, 
			consistiu na obten��o de uma listagem atualizada de estados e 
			munic�pios junto ao site do TSE - Tribunal Superior Eleitoral e 
			forma��o de todas as poss�veis URL�s (Uniform Resource Locator) 
			seguindo as normas do Comit� Gestor da Internet no Brasil. Em 
			seguida, um software rob� tenta acessar todas as URL�s geradas, de 
			forma sistem�tica e em per�odos estipulados, e retorna se existem 
			servidores para a hospedagem de cada site. O experimento n�o retorna 
			dados qualitativos, somente nos informa quantos dom�nios tem a 
			infra-estrutura t�cnica necess�ria para a presen�a de um site na 
			Internet. Pode ser que existam sites de Gest�es Municipais ainda em 
			constru��o e outros com endere�os diferentes dos gerados. Algumas 
			URL�s de munic�pios com nomes compostos foram geradas manualmente.
			<br>
			<br>
			<br>
			</font></td>
		</tr>
	</table>
</div>
<?php
include("./includes/egovmeter_footer.inc.php");
?>