<?php
/*
* Listener encargada de recibir peticiones get
* Implementa clase Turl para redireccionar url
* @author sebslakes - twitter.com/sebslakes
*/

 // Incluyo clase
 include('turl.php');

 // Instancio clase
 $turl= new Turl();

 // Redirecciono (Logica de redirección interna dentro del metodo)
 $turl->redirect();
 
 ?>