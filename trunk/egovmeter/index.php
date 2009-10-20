<?php 
 require("./includes/egovmeter_header.inc.php");
?>

<div align="center">
	<table border="0" cellpadding="0" style="border-collapse: collapse" width="764" id="table2">
		<tr>
			<td>
			<p align="left"><br>
			<font face="Verdana" size="1">Visando obter dados atuais sobre o 
			desenvolvimento de E-GOV em nível municipal criou-se o sistema de 
			medição e monitoração on-line E-GOVMeter Municípios.<br>
			<br>
			Trata-se de um robô de pesquisa chamado "E-GOVMeterBot crawler" que vasculha possíveis mais de 5600 
			URL's de Gestões Municipais verificando se existem servidores para a 
			hospedagem de cada site. <br>
			<br>
			<form name="form1" method="post" action="busca_por_municipio.php">
		    Busca por munic&iacute;pio: 
			  <input name="municipio" foco=true type="text" size="30" maxlength="80">
                <input type="submit" name="Submit" value="Buscar">
              </form>			
              <p align="left">&nbsp;</p>
			<p align="center"><font face="Verdana" size="1">
			</font></p>
			<table width="759" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="323" valign="top"><font face="Verdana" size="1">Clique nos links abaixo para maiores informações:<br />
                    <br />
                    <br />
                    <a href="metodologia.php">Metodologia 
	        utilizada</a><br />
            <br />
            <a href="municipios.php">Listagem de Municípios pesquisados</a><br />
            <br />
            <a href="urls.php">URL's pesquisadas</a><br />
            <br />
            <a href="resultados.php">Resultados encontrados</a><br />
            <br />
            <a href="resultados_uf.php">Resultados encontrados por Estado</a></font></td>
                <td width="436"><p align="left">Autor: Thiago Jabur Bittar | Software divulgado nos anais dos eventos: WebMedia 2005 e SAC 2008, nos artigos abaixo citados. </p>
                  <p align="left">FREIRE, A. P. ; BITTAR, T. J. ; FORTES, R. P. M. . An Approach based on Metrics for Monitoring Web Accessibility in Brazilian Municipalities Web Sites. In: 23rd Annual ACM Symposium on Applied Computing, 2008, Fortaleza-CE. Proceedings of the 2008 ACM Symposium on Applied Computing. New York, NY : ACM Press, 2008. v. 1. p. 2421-2425.</p>
                <p align="left">BITTAR, T. J. ; COUTINHO, J. ; PENTEADO, R. A. D. ; FILGUEIRAS, L. . Short presentation of E-GOVMeter Munic&iacute;pios, a Brazilian monitoring system of Eletronic Government (E-GOV) municipal WEB Services. In: WebMedia 2005 - Simp&oacute;sio Brasileiro de Sistemas Multim&iacute;dia e WEB, 2005, Po&ccedil;os de Caldas MG. Anais do WebMedia 2005 - Simp&oacute;sio Brasileiro de Sistemas Multim&iacute;dia e WEB, 2005.</p></td>
              </tr>
            </table>
			<p align="center"><font face="Verdana" size="1"><br>
		    &nbsp;</font></p>
			<p align="left">&nbsp;</p>
			<table border="0" width="100%">
<Tr><td width="44%" valign="middle">			
<a href="http://lia.dc.ufscar.br"><img src="imgs/apoio.jpg" width="287" height="111" border=0></a>
</td>
<td width="56%" valign="middle"><p align="center">
<a onmouseover="window.status='Faça do E-GOVMeter Municípios sua página inicial';return true;" onclick="this.style.behavior='url(#default#homepage)';this.setHomePage('http://www.governoeletronico.com.br/egovmeter');" onmouseout="window.status=' ';" href="#">Faça 
        do E-GOVMeter Municípios a sua página inicial</a><BR><BR><BR>
<!-- <a href="rss.xml"><img border=0 src=imgs/rss.gif></a><br><a href=http://www.rssficado.com.br>O que é isso?</a> -->
</td>
</Tr>
</table>
</td>
		</tr>
	</table>
</div>
<Center>
</Center>
<? 
$no_back = "1";
include("./includes/egovmeter_footer.inc.php");
?>