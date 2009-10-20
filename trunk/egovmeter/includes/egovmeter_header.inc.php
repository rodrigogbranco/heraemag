<?php 
require_once("../includes/egovmeter_config.inc.php");
if (isset($autenticacao)) 
	include_once("../includes/egovmeter_autenticacao.inc.php"); 
?>
<html>

<head>
<meta http-equiv="Content-Language" content="pt-br">
<meta name="Googlebot" content="all">
<meta name="robots" content="All">
<META NAME="AUTHOR" CONTENT="Thiago Jabur Bittar">
<meta name="revisit-after" content="10 days">
<meta name="content-language" content="pt-br">
<meta name="distribution" content="Global">
<META NAME="RATING" CONTENT="General">
<link rel="stylesheet" href="<?php echo $end ?>egovmeter.css">
<title>E-GOVMeter Municípios<?php if (isset($titulo) ) { echo " - " . $titulo; } ?></title>
</head>

<?php include("egovmeter_javascript.inc.php"); ?>

<body onload="foco()" topmargin="0" leftmargin="0" bottommargin="0" background="<?php echo $end ?>imgs/bg.jpg">
<div align="center">
<img src="<?php echo $end ?>imgs/top_curve.gif"><table bgcolor="#FFFFFF" border="0"  cellspacing="0" cellpadding="0" style="border-collapse: collapse" width="780" id="table1">

		<tr>
			<td width="242">		
 <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" width="240" height="141" id="logo_egovmeter" align="middle">
<param name="allowScriptAccess" value="sameDomain" />
<param name="movie" value="<?php echo $end; ?>logo_egovmeter.swf" />
<param name="quality" value="high" />
<param name="bgcolor" value="#ffffff" />
<embed src="<?php echo $end; ?>logo_egovmeter.swf" quality="high" bgcolor="#ffffff" width="240" height="141" name="logo_egovmeter" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
</object>
</td>
			<td width="538" align="right"><a href=http://www.governoeletronico.com.br><img src=<?php echo $end ?>imgs/governoeletronico.gif border=0></a>
			 </td>
		</tr>
</div>
</table>
<div align="center" style="width:780px; background-color: white">
<?php if (isset($autenticacao)) { ?>
<BR>
Login: <?php echo $_SESSION["login"] ?> - <?php echo date("d/m/Y"); ?>&nbsp;&nbsp;<A href=<?php echo $end ?>admin/logoff.php><font color="#FF0000">Sair</font></A>
<?php } ?>
<BR>
<BR><BR>

<?php if ( isset($titulo) ) { ?><p class=titulo><?php echo $titulo ?></p><?php } ?>
