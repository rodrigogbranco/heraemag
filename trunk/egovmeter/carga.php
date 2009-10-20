<?php

  $filename = "egovmeter_monitoramento.sql" ;
  $dataFile = fopen( $filename, "r" ) ;

  if ( $dataFile )
  {
   while (!feof($dataFile)) 
   {
       $buffer = fgets($dataFile, 4096);
       echo $buffer;
   }

   fclose($dataFile);
  }
  else
  {
   die( "fopen failed for $filename" ) ;
  }
?>
