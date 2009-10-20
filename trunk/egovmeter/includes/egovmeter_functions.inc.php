<?php
function conecta() {
   $conexao = mysql_connect($GLOBALS["bd_servidor"], $GLOBALS["bd_usuario"], $GLOBALS["bd_senha"])
       or die("Não pude conectar: " . mysql_error());
   mysql_select_db($GLOBALS["bd_base"]) or die("Não pude selecionar o banco de dados");
}

function alerta($imagem, $titulo, $texto) {
?>
<center>
<div id="alerta" align=center>
<table border="0" cellpadding="0" style="border-collapse: collapse" id="table1">
	<tr>
		<td width="35"><img border="0" src="<?php echo$GLOBALS["end"] ?>imgs/icones/<?php echo$imagem ?>" width="35" height="35"></td>
		<td align=center width=90% ><b><?php echo$titulo ?></b><br><?php echo$texto ?></td>
		<td align=center width="35">&nbsp;</td>
	</tr>
</table>
</div>
</center>
<?php
} 

function mostra_primeiro_nome($nome)
{
	$dados_nome = explode(" ", $nome);
    $primeiro_nome = $dados_nome[0];
	return $primeiro_nome;
}

function mostradata($data_texto)
{
	$parte = explode ("-", $data_texto);
	$data_texto = $parte[2] . "/" . $parte[1] .  "/" . $parte[0];
	return $data_texto;
}

function arrumadata($data_texto)
{
	$parte = explode ("/", $data_texto);
	$data_texto = $parte[2] . "-" . $parte[1] .  "-" . $parte[0];
	return $data_texto;
}

function send_mail($myname, $myemail, $contactname, $contactemail, $subject, $message) {
  $subject = $GLOBALS["prefixo_email"] . " " . $subject; 
  $headers = "MIME-Version: 1.0\n";
  $headers .= "Content-type: text/plain; charset=iso-8859-1\n";
  $headers .= "X-Priority: 1\n";
  $headers .= "X-MSMail-Priority: High\n";
  $headers .= "X-Mailer: php\n";
  $headers .= "From: \" $myname \" <".$myemail.">\n";
  return(mail("\"".$contactname."\" <".$contactemail.">", $subject, $message, $headers));
}

function send_mail_html($myname, $myemail, $contactname, $contactemail, $subject, $message) {
  $subject = $GLOBALS["prefixo_email"] . " " . $subject; 
  $headers = "MIME-Version: 1.0\n";
  $headers .= "Content-type: text/html; charset=iso-8859-1\n";
  $headers .= "X-Priority: 1\n";
  $headers .= "X-MSMail-Priority: High\n";
  $headers .= "X-Mailer: php\n";
  $headers .= "From: \" $myname \" <".$myemail.">\n";
  return(mail("\"".$contactname."\" <".$contactemail.">", $subject, $message, $headers));
}

/*    função auxiliar para a função altaebaixa

*/

function trocaini($wStr,$w1,$w2) {
        $wde = 1;
        $para=0;
    while($para<1) {
        $wpos = strpos($wStr, $w1, $wde);
        if ($wpos > 0) {
            $wStr = str_replace($w1, $w2, $wStr);
            $wde = $wpos+1;
        } else {
            $para=2;
        }
    }
    $trocou = $wStr;
    return $trocou;
}

function altaebaixa($umtexto) {
        $troca = strtolower($umtexto);
        $troca = ucwords($troca);
        $troca = trocaini($troca, " E ", " e ");
        $troca = trocaini($troca, " De ", " de ");
        $troca = trocaini($troca, " Da ", " da ");
        $troca = trocaini($troca, " Do ", " do ");
        $troca = trocaini($troca, " Das ", " das ");
        $troca = trocaini($troca, " Dos ", " dos ");

        $altabaixa = $troca;
        return $altabaixa;

}

function getfilesize($bytes) {
   if ($bytes >= pow(2,40)) {
       $return = round($bytes / pow(1024,4), 2);
       $suffix = "TB";
   } elseif ($bytes >= pow(2,30)) {
       $return = round($bytes / pow(1024,3), 2);
       $suffix = "GB";
   } elseif ($bytes >= pow(2,20)) {
       $return = round($bytes / pow(1024,2), 2);
       $suffix = "MB";
   } elseif ($bytes >= pow(2,10)) {
       $return = round($bytes / pow(1024,1), 2);
       $suffix = "KB";
   } else {
       $return = $bytes;
       $suffix = "Bytes";
   }
   if ($return == 1) {
       $return .= " " . $suffix;
   } else {
       $return .= " " . $suffix . "";
   }
   return $return;
}


function enc($string){ 
    if((isset($string)) && (is_string($string))){ 
        $enc_string = base64_encode($string); 
        $enc_string = str_replace("=","",$enc_string); 
        $enc_string = strrev($enc_string); 
        $md5 = md5($string); 
        $enc_string = substr($md5,0,3).$enc_string.substr($md5,-3); 
    }else{ 
        $enc_string = "Parâmetro incorreto ou inexistente!"; 
    } 
    return $enc_string; 
} 

function des($string){ 
    if((isset($string)) && (is_string($string))){ 
        $ini = substr($string,0,3); 
        $end = substr($string,-3); 
        $des_string = substr($string,0,-3); 
        $des_string = substr($des_string,3); 
        $des_string = strrev($des_string); 
        $des_string = base64_decode($des_string); 
        $md5 = md5($des_string); 
        $ver = substr($md5,0,3).substr($md5,-3); 
        if($ver != $ini.$end){ 
            $des_string = "Erro na desencriptação!"; 
        } 
    }else{ 
        $des_string = "Parâmetro incorreto ou inexistente!"; 
    } 
    return $des_string; 
} 

?>
