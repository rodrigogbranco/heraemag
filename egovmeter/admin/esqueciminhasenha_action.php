<head>
<link rel="stylesheet" href="<?php echo $end ?>sbpmat.css">
<title>Comunidade LabCat</title>
<link rel="stylesheet" href="lab.css">
</head>
<?php
include ("includes/lab_config.inc.php");

conecta();
$sql = mysql_query("SELECT email, senha, nome FROM lab_participante a, 
lab_usuario b WHERE a.login = '$login' 
AND b.login = '$login' AND b.status > 0")

         or die("A query falhou ".mysql_error());
  if ($res = mysql_fetch_array($sql, MYSQL_ASSOC)) {
	  $email = $res["email"];
	  $titulo = "Envio de Senha";
	  $senha = des($res["senha"]);
	  $mensagem = "Você requisitou sua senha no LabCat, seu login é: $login e sua senha é:" . " $senha ! \n Obrigado por fazer parte do LabCat.";

	$nome = $res["nome"];

	  $bool = send_mail("LabCat", "secretaria@labcat.org", $nome, $email, $titulo, $mensagem);

  
?>
<br>
<br>
<br><?php
alerta("ok.gif", "Prezado $nome, sua senha foi enviada com sucesso para <Br>o e-mail " . $res["email"], "");
?>
<Center><Br>
<br>
<b>Atenção: o e-mail com a senha pode demorar alguns minutos para chegar, por favor aguarde.</b>
<BR><br><BR><BR><BR><BR><BR>
<center><a href="../">Voltar</a></center>

<br>
<?php

}
else 
{
?><br><BR>
<p class="erro" align="center">O login informado não existe. Favor voltar e tentar novamente.</p>

<?php
}
?>
