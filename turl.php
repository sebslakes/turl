<?php
/*
* Clase encargada de recibir peticiones para 
* acortar url's, lo que hace es una abreviación
* asigna una uri de tres caracteres de manera aleatoria 
* a una url posteriormente esto se guarda en base de datos
* @author sebslakes - twitter.com/sebslakes
*
* Ej. de uso:
* $webtozip = new Turl();
*
*/
require_once 'conexion.php';

class Turl {

  
    /* Metodo encargado de proporcionar 3 caracteres de forma aletoria retorna string*/
    function newUri(){ 
        $letters = array('0','1','2','3','4','5','6','7','8','9','a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
        $numbers = array('0','1','2','3','4','5','6','7','8','9', '10','11','12','13','14','15','16','17','18','19', '20','21','22','23','24','25','26','27','28','29', '30','31','32','33','34','35');

        $random = rand(0, 35).";".rand(0, 35).";".rand(0, 35);

        $uri = str_replace($numbers, $letters, $random);
        $uri = str_replace(";", "", $uri);
    
        return $uri;
    }

    // Metodo encargado de entregar una respuesta. retorna string
    function response($uri){
        echo "http://turl.cl/$uri";
        echo "&nbsp&nbsp&nbsp<a title='Compartelo en Facebook' target='_blank' href='https://www.facebook.com/sharer.php?u=http://turl.cl/$uri'&t=http://turl.cl/$uri><img src='http://www.merlinlinea.com/imagenes/icono_facebook.png'></a> ";
        echo "&nbsp<a target='_blank' href='http://twitter.com/home?status=Ingresa a http://turl.cl/$uri' class='btwitter' title='Compartelo en Twitter'><img width='25' height='25' src='http://www.merlinlinea.com/imagenes/icono_twitter.png'></a>&nbsp&nbsp&nbsp";
    }


    // Consulta, si url existe en base de datos devuelvo uri almacenada en db, en caso contrario newUri*/
    function shortened($url){

        //Valido si el string es realmente una url
        if(!filter_var($url, FILTER_VALIDATE_URL)){
            echo "No pusiste una url valida";
            return "0";
        }


        $sql = "SELECT uri FROM shortened WHERE url='$url'";
        $result=mysql_query($sql);

        while($acortado = mysql_fetch_array($result) ){
            $uri=$acortado['uri'];
            $this->response($uri);
            return "1";
        }

        //Se ejecuta hasta encontrar una uri valida para asignarla a la url
        while(1){
            $uri = $this->newUri();
            $sql = "SELECT count(*) as total FROM shortened WHERE uri='$uri'";
            $result = mysql_query($sql);
            $url_en_bd = mysql_fetch_assoc($result);

            if($url_en_bd['total']==0){
                $insertarsql = "INSERT INTO shortened (uri, url) VALUES ('$uri', '$url')";
                mysql_query($insertarsql);

                $this->response($uri);
                return "1";
            }      
        }
    }

    function redirect(){

        $uri=$this->uri();
        $sql = "SELECT * FROM shortened WHERE uri='$uri'";
    
        $result=mysql_query($sql);
        while($row= mysql_fetch_array($result)){
            $longurl = $row['url'];
            $ip = $_SERVER['REMOTE_ADDR'];
            $fecha = date("Y-m-d H:i:s");
            $sql = "INSERT INTO contador(urlcorta, ip, fecha) VALUES ('$uri', '$ip', '$fecha')";
            mysql_query($sql);
            header("Location: $longurl");
            return true;
        }

        $response=array(
            'code'=>'404',
            'description'=>'Not found'
        );

        echo json_encode($response);
    }

    function uri(){

        $uri_final = $_SERVER['REQUEST_URI'];
        $uri_final = str_replace("\"", "", $uri_final);
        $uri_final = str_replace("'", "", $uri_final);
        $uri_final = str_replace("/", "", $uri_final);
        
        return $uri_final; 
    }


}

?>