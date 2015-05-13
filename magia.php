<?php
error_reporting(0);
header ('Content-type: text/html; charset=utf-8');
require_once 'conexion.php';
require_once 'funciones.php';
	

$server="http://turl.cl";

if(isset($_GET['urllarga'])){
	$corta = consultador($_GET['urllarga']);
  if($corta != "0"){
	  echo "$server/$corta";
		echo "&nbsp&nbsp&nbsp<a title='Compartelo en Facebook' target='_blank' href='https://www.facebook.com/sharer.php?u=$server/$corta'&t=$server/$corta><img src='http://www.merlinlinea.com/imagenes/icono_facebook.png'></a> ";
		echo "&nbsp<a target='_blank' href='http://twitter.com/home?status=Ingresa a $server/$corta' class='btwitter' title='Compartelo en Twitter'><img width='25' height='25' src='http://www.merlinlinea.com/imagenes/icono_twitter.png'></a>";
		echo "&nbsp<iframe src='http://www.facebook.com/plugins/like.php?href=$server/$corta&amp;layout=button_count&amp;show_faces=true&amp;width=100&amp;action=like&amp;font=arial&amp;colorscheme=light&amp;height=25' scrolling='no' frameborder='0' style='border:none; overflow:hidden; width:100px; height:21px;' allowTransparency='true'></iframe>";
	}else{
		echo "No pusiste una url valida";
	}
}

	


?>