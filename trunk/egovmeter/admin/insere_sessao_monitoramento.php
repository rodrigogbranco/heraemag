<?php 
 $autenticacao = 1;
 $titulo = "Iniciando sessão de monitoramento";
 include("../includes/egovmeter_header.inc.php");
 conecta();
?>
</head>
<center>

<form method="POST" name="formIniciaSessaoMonitoramento" OnSubmit="return Valida(this);" action="insere_sessao_monitoramento_action.php">  
   
  <table class="FormTable" cellspacing="0" width="602">
    <tr> 
      <td height="23" colspan="3" valign="middle" class="FormTitulo">Dados da sess&atilde;o de monitoramento </td>
    </tr>
    <tr> 
      <td width="150" height="22" valign="middle" class="FormTD">Descri&ccedil;&atilde;o: 
        *</td>
      <td colspan="2" valign="top" class="FormTD"> <input name="descricao" type="text" ID="descricao" size=70 maxlength="180" label="Descrição" required="true" foco="true"></td>
    </tr>

  </table><BR><BR>
	<input type="Submit" name=SubmitContato value="Iniciar monitoramento" ><BR><BR>
  <p align="left">* Campos obrigat&oacute;rios </p>
</form>


<?php include ("../includes/egovmeter_footer.inc.php") ?>
