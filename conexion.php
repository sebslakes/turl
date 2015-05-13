<?php
$mysql_host = "localhost";
$mysql_database = "turl";
$mysql_user = "root";
$mysql_password = "";
#Inicio coneccion a base de datos
   if (!($link=mysql_connect($mysql_host, $mysql_user, $mysql_password))) 
   { 
      echo "Error conectando a la base de datos."; 
      exit(); 
   } 
   if (!mysql_select_db($mysql_database,$link)) 
   { 
      echo "Error seleccionando la base de datos."; 
      exit(); 
   } 
   #Cierre de conecciom a base de datos
   
?>