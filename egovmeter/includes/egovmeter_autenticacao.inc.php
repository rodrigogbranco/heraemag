<?php
/**
 *
 *  Autentica��o Sistema E-GOVMeter Munic�pis
 *  Autor: Thiago Jabur Bittar
 *  Modifica��o: 10/10/2005 20:26
 */
 session_start();

 if(!isset($_SESSION['login']))
 { 	$parametros = $end_absoluto . "/admin/?msg=expirou&redir=" . str_replace($end, "", $_SERVER['REQUEST_URI']);
  // Eliminar todas as vari�veis de sess�o.
  session_unset();
  //  Finalmente, destrui��o da sess�o.
   session_destroy();
   //Header("Location: $parametros");
   die();
 }

/*if (($tipo_pagina == "administrador") && ($_SESSION["admin"] <> "1") ) {
?>
<Br><Br><BR>
<center><font face=Verdana size=1>Voc� n�o tem permiss�o para este acesso.</font></center>
<?php
die();
}*/
?>