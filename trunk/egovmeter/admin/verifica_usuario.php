<?php 
session_start();
// Eliminar todas as variáveis de sessão.
session_unset();
// Destruição da sessão. Vai que tava logado antes e nao clicou em sair
session_destroy();
session_start();

include ("../includes/egovmeter_config.inc.php"); 
conecta();
$senha_compara = /*enc(*/$_POST["senha"]/*)*/;
$sql = mysql_query("SELECT * FROM egovmeter_usuario WHERE login = '" . $_POST["login"] . "' AND senha = '" . $senha_compara . "' AND status >= 0") or die("A query falhou: " . mysql_error());
$result = mysql_fetch_array($sql, MYSQL_ASSOC);
$n = mysql_num_rows($sql); 

if($n != 0)
{
	  //Setando as variáveis de sessão
	  $_SESSION["id_usuario"] = $result["id_usuario"]; 
	  $_SESSION["login"] = /*$login*/$_POST["login"]; 
	  $_SESSION["status"] = $result["status"];
	  
	  $ip = getenv ("REMOTE_ADDR");
	  //gravando a sessao
	  mysql_query("insert into egovmeter_sessao_acesso(id_usuario, ip, time_stamp) values ( '" . $result["id_usuario"] . "', '$ip', now()) ");
 	  $_SESSION["id_sessao"] = mysql_insert_id();

      if ($redir == "") { 	  

  	  	  //header("location: " . $end_absoluto . "admin/principal.php");		  header("location: ../admin/principal.php");
     
         }else  {
                  header( "location: " . $end_absoluto  . $redir);
         }
               
 }
 else
 {
 	 header("location: index.php?msg=not_auth"); 
 } 
 
?>
