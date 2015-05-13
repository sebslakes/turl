<?php
 require_once 'conexion.php';
 require_once 'funciones.php';
	
 $x=URL();
 if(isset($x)){
 	redireccionador($x);
 }
?>