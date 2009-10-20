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
			E-GOV consultou-se o Portal de Serviços e Informações de Governo – 
			RedeGoverno (<a href="http://www.redegoverno.gov.br">http://www.redegoverno.gov.br</a>), que tem como uma de 
			suas funções centralizar de maneira organizada os sites 
			governamentais brasileiros. Entretanto, estão homologados no Portal, 
			em fevereiro de 2005, apenas 579 sites de Gestões Municipais, menos 
			da metade do número de sites em 2001 relatados pelo IBGE. <br>
			<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Dessa maneira procurou-se sem sucesso, por 
			observação dos sites listados, um critério para presença no Portal 
			(na listagem existem links para municípios grandes, pequenos; sites 
			de serviços e informativos, prontos e em construção). Já o IBGE 
			informa que o critério utilizado foi a análise de formulários 
			enviados pelas Prefeituras, sendo que não foram testados os links 
			para os sites. Não se limitando aos dados do IBGE e Portal 
			RedeGoverno fez-se um experimento com metodologia específica na 
			tentativa da obtenção de dados atuais condizentes com a realidade.
			<br>
			<br>
&nbsp;&nbsp;&nbsp;&nbsp; Tal experimento, realizado no LIA – Laboratório de 
			Interação Avançada (Tidia-AE) da UFSCar &agrave; partir de fevereiro de 2005, 
			consistiu na obtenção de uma listagem atualizada de estados e 
			municípios junto ao site do TSE - Tribunal Superior Eleitoral e 
			formação de todas as possíveis URL’s (Uniform Resource Locator) 
			seguindo as normas do Comitê Gestor da Internet no Brasil. Em 
			seguida, um software robô tenta acessar todas as URL’s geradas, de 
			forma sistemática e em períodos estipulados, e retorna se existem 
			servidores para a hospedagem de cada site. O experimento não retorna 
			dados qualitativos, somente nos informa quantos domínios tem a 
			infra-estrutura técnica necessária para a presença de um site na 
			Internet. Pode ser que existam sites de Gestões Municipais ainda em 
			construção e outros com endereços diferentes dos gerados. Algumas 
			URL’s de municípios com nomes compostos foram geradas manualmente.
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