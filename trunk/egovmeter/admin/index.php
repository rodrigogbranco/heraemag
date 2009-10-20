<html>
<head>
<title>E-GOVMeter - Administração</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="../egovmeter.css">
<?php require("../includes/egovmeter_javascript.inc.php"); 
   require("../includes/egovmeter_config.inc.php"); 
?>
</head>


<body onload="foco()" topmargin="0" leftmargin="0" bottommargin="0">
<div align="center">
<?php
if (isset($_GET['msg']) ){	$msg = $_GET['msg'];}
if  (isset($msg) && $msg == "not_auth") {
alerta("erro.gif", "Login ou senha não encontrados", "");
echo "<br>";
}

if  (isset($msg) && $msg == "expirou") {
alerta("exclama.gif", "Sua sessão expirou, por favor acesse novamente!", "");
echo "<br>";
}
?>

<form style="margin-top:0px" method="POST" name="formLogin" id="formLogin" action="verifica_usuario.php" OnSubmit="return Valida(this);">
	<table class="Menu"  border="0" cellpadding="0" style="border-collapse: collapse" width="207" id="table1">
      <tr> 
        <td height="57" colspan="3" class="enquete-corpo"><p align="left"><font face="Verdana" size="1"><img src="imgs/acesso.gif" width="218" height="28"><br>&nbsp;</font><font face="Verdana" size="1">Entre com seu Login e Senha:<br>
            </font></p>
        </td>
      </tr>
      <tr> 
        <td class="enquete-corpo" width="46">&nbsp;</td>
        <td class="enquete-corpo" width="52"><font face="Verdana" size="1">Login:</font></td>
        <td class="enquete-corpo" width="115"><input size=9 maxlength=15 type="text" label="Login" required="true" foco="true" name="login" ID="login"> 
          &nbsp;</td>
      </tr>
      <tr> 
        <td class="enquete-corpo" width="46">&nbsp;</td>
        <td class="enquete-corpo" width="52"><font face="Verdana" size="1">Senha:</font></td>
        <td class="enquete-corpo" width="115"><input size=9 maxlength=15 type="password" label="Senha" required="true" name="senha" ID="senha"> 
          &nbsp;</td>
      </tr>
      <tr> 
        <td class="enquete-corpo" colspan="3"> <p align="center"><br>
            <input name="redir" type="hidden" value="<?= $redir ?>">
            <input name="botaoSubmitLogin" type="submit" value="Acessar">
            <br>
            <br>
            <font face="Verdana" size="1"> <a href="esqueciminhasenha.php">Esqueci minha senha ou login </a><br>
            &nbsp;
        </td>
      </tr>
    </table>
</form>
</div>
</body>
</html>