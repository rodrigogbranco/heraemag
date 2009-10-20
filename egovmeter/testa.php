<title>E-GOV</title>
<body>
<p>Testando Site</p>
<p>&nbsp;</p>
<?php
set_time_limit(5500);


$bd_senha = "hera";
$bd_usuario = "hera";
$bd_servidor = "localhost";
$bd_base = "hera";

//MySQL
/*
$bd_senha = "t180481bittar";
$bd_usuario = "e_democracia";
$bd_servidor = "mysql164.locaweb.com.br";
$bd_base = "e_democracia";
*/
function conecta() {
   $conexao = mysql_connect($GLOBALS["bd_servidor"], $GLOBALS["bd_usuario"], $GLOBALS["bd_senha"])
       or die("Não pude conectar: " . mysql_error());
   mysql_select_db($GLOBALS["bd_base"]) or die("Não pude selecionar o banco de dados");
}

conecta();

$consulta = mysql_query("select * from municipio");

 while($result = mysql_fetch_array($consulta, MYSQL_ASSOC))
 { 
    testipaddress($result["url"], $result["municipio"], $result["estado"]);
 }


?>



<?php
function testipaddress ($nametotest, $municipio, $estado) {
   $ipaddress = $nametotest;
   $ipaddress = gethostbyname($nametotest);
   if ($ipaddress == $nametotest) {
       echo "Não tem site: $nametotest<br>";
	   mysql_query("update municipio set tem_site = 0, ip = '' where municipio = '$municipio' and estado = '$estado'");	   
   }
   else {
       echo "Tem Site: $nametotest,  IP = $ipaddress<br>";
	   mysql_query("update municipio set tem_site = 1, ip = '$ipaddress' where municipio = '$municipio' and estado = '$estado'");	   
   }
}
?>
</body>