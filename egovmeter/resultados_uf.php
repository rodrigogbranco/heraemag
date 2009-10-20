<?php 
 $titulo = "Resultados encontrados por Estado";
 include("./includes/egovmeter_header.inc.php");
 conecta();
?>
<script>
//by jabur - dada a sigla do estado, seleciona o estado no combo
function seleciona(sigla) {

	len = formestado.uf.options.length; 

	for (i = 0; i < len; i++) 
	{ 	if (formestado.uf.options[i].value == sigla) 
		{ 
			formestado.uf.selectedIndex = i;
			submete();
			break; 
		} 
	}
}
</script>
<script language="javascript">
function disabilitaMostra(thisDiv) {
 if(!document.getElementById) {
  return;
 }
 obj = document.getElementById(thisDiv);
 obj.style.display = (obj.style.display == "none" ) ? "block" : "none";
}
function Mostra(thisDiv) {
 if(!document.getElementById) {
  return;
 }
 obj = document.getElementById(thisDiv);
 obj.style.display = "block";
}
function disabilita(thisDiv) {
 if(!document.getElementById) {
  return;
 }
 obj = document.getElementById(thisDiv);
 obj.style.display = "none";
}
</script>
<div align="center">
<table border="0" cellpadding="0" cellspacing="0" width="770">
  <tr>
          <td width="320" valign="top"><center>
                  <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="https://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="260" height="256">
                    <param name="movie" value="mapa_egovmeter.swf">
                    <param name="quality" value="high">
                    <param name="wmode" value="transparent">
                    <embed src="mapa_egovmeter.swf" width="260" height="256" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" wmode="transparent"></embed></object>
            <br>
            <br>
          </td>
<td width="20">&nbsp;</td>
    <td width="430" valign="top"><center>
<iframe id="RSIFrame"  name="RSIFrame"  style="width:0px; height:0px; border: 0px"   src="blank.html"></iframe>
<!-- Fim RS --><Br><br><br><br>

<table name="table1" id="table1" border="0" cellspacing="0" width="348" cellpadding="4" > 
  <tr class="EasyLinhaClara">
    <td width="3" class="EasyColunaCampo">Estado:</td>
    <td width="218" class="EasyColunaValor" align="center"><form name="formestado" id="formestado" target="RSIFrame" >
      <p align="left"><select id="uf" name="uf" size="1" tabindex="1" onchange="submete();">
      	  <option value="0">[&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SELECIONE
          O
          ESTADO&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;]</option>


			<?php
			$consulta = mysql_query("select distinct uf from egovmeter_municipio order by uf asc");
            while($result = mysql_fetch_array($consulta, MYSQL_ASSOC))
            { 
               echo "<option value=" . $result["uf"] . ">" . $result["uf"] . "</option>";

               }
            ?>


	</select>
    </td>
  </tr>
  </form>
<script language="javascript"> 
function disabilitaMostra(thisDiv) {
 if(!document.getElementById) {
  return;
 }
 obj = document.getElementById(thisDiv);
 obj.style.display = (obj.style.display == "none" ) ? "block" : "none";
}
function Mostra(thisDiv) {
 if(!document.getElementById) {
  return;
 }
 obj = document.getElementById(thisDiv);
 obj.style.display = "block";
}
</script>   
     </td>
  </tr>
</table>
</td>
</tr>
</table>
</div>
<script>
function mostra_carregando() {
	disabilita('resultado')
	Mostra('carregando')
}
</script>

<div id="carregando" name="carregando" style="width: 300; height: 164">
	<center><font face="Verdana, Arial" size=1>Carregando...<br> <img src=imgs/icones/icon_progress.gif>
	<br><BR><BR><BR><BR><BR><br><BR><BR><BR>
</div>
<script>
disabilitaMostra('carregando')
</script>

<IFRAME src="blank.html" id="resultado" name="resultado" WIDTH="770" height="200" FRAMEBORDER="0" SCROLLING="no" FRAMESPACING="0"></iframe>

<script>
	disabilitaMostra('resultado');
</script>

<form name="formSubmit" method="post" action="result_local.php" target="resultado">
	<input type="hidden" name="UF">
</form>

<script>
function submete() {
	formSubmit.UF.value = formestado.uf.value
	document.getElementById("resultado").height = 0;
	mostra_carregando()
	formSubmit.submit()
	Mostra('resultado')	
}
</script>

<?php 
include("./includes/egovmeter_footer.inc.php");
?>