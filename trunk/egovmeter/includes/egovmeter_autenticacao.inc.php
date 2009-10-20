<?php
/**
 *
 *  Autenticação Sistema E-GOVMeter Municípis
 *  Autor: Thiago Jabur Bittar
 *  Modificação: 10/10/2005 20:26
 */
 session_start();

 if(!isset($_SESSION['login']))
 { 	$parametros = $end_absoluto . "/admin/?msg=expirou&redir=" . str_replace($end, "", $_SERVER['REQUEST_URI']);
  // Eliminar todas as variáveis de sessão.
  session_unset();
  //  Finalmente, destruição da sessão.
   session_destroy();
   //Header("Location: $parametros");
   die();
 }

/*if (($tipo_pagina == "administrador") && ($_SESSION["admin"] <> "1") ) {
?>
<Br><Br><BR>
<center><font face=Verdana size=1>Você não tem permissão para este acesso.</font></center>
<?php
die();
}*/
?>