<?php
/*
* Listener encargada de recibir peticiones post
* Implementa clase Turl para acortar una url
* @author sebslakes - twitter.com/sebslakes
*/

// Incluyo clase turl.php
include('turl.php');

// Obtengo datos que han sido enviados por petición post
$data=file_get_contents('php://input');

// Instancio clase
$turl = new Turl();

// Acorto url
$turl->shortened($data);


?>