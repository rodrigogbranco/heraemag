<title>E-GOV</title>
<body>
<p>Testando Site</p>
<p>&nbsp;</p>

<?php
$bd_senha = "hera";
$bd_usuario = "hera";
$bd_servidor = "localhost";
$bd_base = "hera";

function conecta() {
   $conexao = mysql_connect($GLOBALS["bd_servidor"], $GLOBALS["bd_usuario"], $GLOBALS["bd_senha"])
       or die("Não pude conectar: " . mysql_error());
   mysql_select_db($GLOBALS["bd_base"]) or die("Não pude selecionar o banco de dados");
}

conecta();


?>
<?php
$row = 1;
$handle = fopen ("municipios.txt","r");
while ($data = fgetcsv ($handle, 1000, ";")) {
   $num = count ($data);
   print "<p> $num campos na linha $row: <br>";
   $row++;
   
   $estado = $data[1];
   $cidade = $data[2];
   
   $pieces = explode(" ", $cidade);
   $cid = implode("", $pieces);

   $endereco = "www." . strtolower($cid) . "." . strtolower($estado) . ".gov.br";   

   $sql = "insert into municipio values('$estado', '$cidade', '$endereco')";

   if (mysql_query($sql)) echo "Inseriu $cidade <Br>";   
   
}
fclose ($handle);
?> 


</body>