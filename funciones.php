<?php

require_once 'conexion.php';



function URL(){

$url=$_SERVER['REQUEST_URI'];

$url=str_replace('/','',$url); 

return $url; 

}



function acortador(){ 



 $letras 	= array('0','1','2','3','4','5','6','7','8','9',

 			'a','b','c','d','e','f','g','h','i','j',

			'k','l','m','n','o','p','q','r','s','t',

			'u','v','w','x','y','z');

								

 $numeros	= array('0','1','2','3','4','5','6','7','8','9', 

 '10','11','12','13','14','15','16','17','18','19', 

 '20','21','22','23','24','25','26','27','28','29', 

 '30','31','32','33','34','35');

		

 //Combinaciones posibles 35^7 = 78364164096

 $aleatorio = rand(0, 35);

 $aleatorio.= ";".rand(0, 35);

 $aleatorio.= ";".rand(0, 35);

 //$aleatorio.= ";".rand(0, 35);

 //$aleatorio.= ";".rand(0, 35);

 //$aleatorio.= ";".rand(0, 35);

 //$aleatorio.= ";".rand(0, 35);

					

 $final = str_replace($numeros, $letras, $aleatorio);

 $final = str_replace(";", "", $final);

 return $final;

 }

	

function consultador($url){

	$url=str_replace(" ", "+",$url);

	$url=str_replace("sebastian123456789", "&",$url);

	

	//valido si es de la mierda de google maps xD

	$google=0;

	if( substr($url,0,26)=="http://maps.google.cl/maps"){

		$google=1;

		}

		

 	if(filter_var($url, FILTER_VALIDATE_URL) || $google==1)

	{

		$sql = "SELECT * FROM acortados WHERE urllarga='$url'";

		$result=mysql_query($sql);

		

		do{

				if($row = mysql_fetch_array($result)){

					$urlcorta=$row['urlcorta'];

  				$existeurlcorta="si";

					$terminar=0;

				}

				 else{

			 		$terminar=0;

			 		$existeurlcorta="no";

				}

		}while($terminar=0);

		

		if($existeurlcorta=="no")

		{

				do{

		 	    $urlcorta = acortador();

		      $sql = "SELECT * FROM acortados WHERE urlcorta='$urlcorta'";

		      $result=mysql_query($sql);

		    

		     		do{

							if($row = mysql_fetch_array($result)){

			  			//echo"<br>la web existe no puedo escibirla";		

			  			$ingreso=0;

			  			$ingresado=0;

							}

				 			else{

							$insertarsql = "INSERT INTO acortados	(urlcorta, urllarga) 

							VALUES ('$urlcorta', '$url')";

							mysql_query($insertarsql);

							$ingreso=0;

							$ingresado=1;

							}

		    		}while($ingreso=0);

		 		}while($ingresado < 1 );	

		}

	return $urlcorta;

	}

	else{

		return "0";

		}

 

 

	

}

 

function redireccionador($urlcorta){

 	$sql = "SELECT * FROM acortados WHERE urlcorta='$urlcorta'";
  $result=mysql_query($sql);
  do{
		if($row = mysql_fetch_array($result)){
	 		$ingreso=0;
  		$redireccionar="si";
  		$longurl = $row['urllarga'];
  	}else{
			$redireccionar="no";
		}
	}while($ingreso=0);

  if($redireccionar=="si"){
   	$ip = $_SERVER['REMOTE_ADDR'];
 	  $fecha = date("Y-m-d H:i:s");
 	  $sql = "INSERT INTO contador(urlcorta, ip, fecha) VALUES ('$urlcorta', '$ip', '$fecha')";
    $result=mysql_query($sql);
		//echo "<meta http-equiv='refresh' content='5;url=\"$longurl\"' />\n";
		header("Location: $longurl");
  }else{
 		echo "<?xml version='1.0' encoding='UTF-8' ?>\n";
		echo " <response>\n";
		echo "    <mensaje>Web no existe</mensaje>\n";
		echo " </response>\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n";
  }
return true;
}

	

// ESTADISTICAS PARA DISPONIBLES.PHP---------- //	



function cantidades($var){

$forvar=36;

for ($j=2;$j<=$var;$j++){

	$forvar=$forvar*36;

	}

$consulta = "SELECT * FROM `acortados` WHERE OCTET_LENGTH(urlcorta)=$var";

$ocupados=mysql_query($consulta);

while($recorredor = mysql_fetch_array($ocupados))

			{

			$i++;

			}



$i+=7500;

$resto=$forvar-$i;

echo "<br>Combinaciones con [ $var ] caracteres<br>";

echo "<table align ='center'><tr>";

echo "<td align ='left'>Posibles: </td><td align ='right'> $forvar</td>"; 

echo "<tr>";

echo "<td align ='left'>Ocupados: </td><td align ='right'> $i</td>";

echo "<tr>";

echo "<td align ='left'>Disponibles :</td><td align ='right'> ".$resto."</td>";

echo "<tr></table>";

echo "<h2><meter value='$i' min='0' max='$forvar'>usa chrome</meter></h2>";

echo "**************************************************************************************<br>";





}



//webservise rest

function consultadorws($url){

	$sql = "SELECT * FROM acortados WHERE urllarga='$url'";

	$result=mysql_query($sql);

		

		do{

			if($row = mysql_fetch_array($result)){

				$urlcorta=$row['urlcorta'];

  				$existeurlcorta="si";

				$terminar=0;

			}

			else{

				$terminar=0;

				$existeurlcorta="no";

			}

		}while($terminar=0);

		

		if($existeurlcorta=="no")

		{

			do{

				$urlcorta = acortador();

				$sql = "SELECT * FROM acortados WHERE urlcorta='$urlcorta'";

				$result=mysql_query($sql);

		    

		     	do{

					if($row = mysql_fetch_array($result)){

			  		//echo"<br>la web existe no puedo escibirla";		

						$ingreso=0;

			  			$ingresado=0;

					}

				 	else{

						$insertarsql = "INSERT INTO acortados	(urlcorta, urllarga) 

						VALUES ('$urlcorta', '$url')";

						mysql_query($insertarsql);

						$ingreso=0;

						$ingresado=1;

					}

		    	}while($ingreso=0);

		 	}while($ingresado < 1 );	

		}

		return $urlcorta;	

}

?>