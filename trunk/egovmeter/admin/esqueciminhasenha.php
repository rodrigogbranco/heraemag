<html>

<head>
<meta http-equiv="Content-Language" content="pt-br">
<meta name="LabCat - Laboratório de Catálise">
<META NAME="TITLE" CONTENT="E-GOVMeter - Esqueci minha senha">
<meta name="Googlebot" content="all">
<meta name="robots" content="All">
<META NAME="AUTHOR" CONTENT="Thiago Jabur Bittar">
<meta name="revisit-after" content="10 days">
<meta name="content-language" content="pt-br">
<meta name="distribution" content="Global">
<META NAME="RATING" CONTENT="General">
<link rel="stylesheet" href="../egovmeter.css">
<title>Comunidade LabCat</title>
</head>
<?php include("../includes/egovmeter_javascript.inc.php") ?>
<body onload="foco()">
<div align="center">
<p class=titulo>Esqueci minha senha ou login</p>
<strong><br>
Caso tenha esquecido o login use o formul&aacute;rio abaixo:</strong> <BR>
<form action="esqueciminhasenha_login_action.php" onSubmit="return Valida(this)" method="post" name="form" id="form">
    <table class="FormTable" cellspacing="0" width="310">
        <td class="FormTitulo" height="20" colspan="4">Entre
          com seu e-mail que enviaremos seu login e senha </td>
      </tr>
      <tr>
        <td class="FormTD"><br>
        E-mail:<br>
        <Br></td>
        <td width="217" colspan="3"class="FormTD"><Br><input name="email" type="text" id="email" size="25" maxlength="50" label="E=mail" foco="true" required="true"><Br><br></td>
      </tr>
      <tr bgcolor="#F8F8F8">
        <td width="87" class="FormTitulo">&nbsp;</td>
        <td width="217">&nbsp;</td>
      </tr>
    </table>
        <br>
    <br>
    <input name="f" type="submit" value="Enviar login e senha por e-mail">
</form>
<BR><BR>

<BR>



<a href=../>Voltar</a>
</div>
</body>
</html>
