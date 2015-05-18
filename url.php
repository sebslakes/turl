<?php
require_once 'conexion.php';

class Url {

    var $letras;
    var $numeros;
    
    /* Metodo encargado de proporcionar 3 caracteres de forma aletoria */
    function acortador(){ 
        $this->letras = array('0','1','2','3','4','5','6','7','8','9','a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
        $this->numeros = array('0','1','2','3','4','5','6','7','8','9', '10','11','12','13','14','15','16','17','18','19', '20','21','22','23','24','25','26','27','28','29', '30','31','32','33','34','35');

        $aleatorio = rand(0, 35).";".rand(0, 35).";".rand(0, 35);

        $uri = str_replace($this->numeros, $this->letras, $aleatorio);
        $uri = str_replace(";", "", $uri);
    
        return $uri;
    }

    function respuesta($uri){
        echo "http://turl.cl/$uri";
        echo "&nbsp&nbsp&nbsp<a title='Compartelo en Facebook' target='_blank' href='https://www.facebook.com/sharer.php?u=http://turl.cl/$uri'&t=http://turl.cl/$uri><img src='http://www.merlinlinea.com/imagenes/icono_facebook.png'></a> ";
        echo "&nbsp<a target='_blank' href='http://twitter.com/home?status=Ingresa a http://turl.cl/$uri' class='btwitter' title='Compartelo en Twitter'><img width='25' height='25' src='http://www.merlinlinea.com/imagenes/icono_twitter.png'></a>&nbsp&nbsp&nbsp";
    }


    /* Consulta, si url existe en base de datos devuelvo urlcorta, en caso contrario corta url*/
    function consultador($url){
        if(!filter_var($url, FILTER_VALIDATE_URL)){
            echo "No pusiste una url valida";
            return "0";
        }

        $sql = "SELECT urlcorta FROM acortados WHERE urllarga='$url'";
        $result=mysql_query($sql);

        while($acortado = mysql_fetch_array($result) ){
            $urlcorta=$acortado['urlcorta'];
            $this->respuesta($urlcorta);
            return "1";
        }

        //Se ejecuta hasta encontrar una short_uri valida para asignarla a la url
        while(1){
            $urlcorta = $this->acortador();
            $sql = "SELECT count(*) as total FROM acortados WHERE urlcorta='$urlcorta'";
            $result = mysql_query($sql);
            $url_en_bd = mysql_fetch_assoc($result);

            if($url_en_bd['total']==0){
                $insertarsql = "INSERT INTO acortados (urlcorta, urllarga) VALUES ('$urlcorta', '$url')";
                mysql_query($insertarsql);

                $this->respuesta($urlcorta);
                return "1";
            }      
        }
    }

    function redireccionador(){

        $urlcorta=$this->uri();
        $sql = "SELECT * FROM acortados WHERE urlcorta='$urlcorta'";
    
        $result=mysql_query($sql);
        while($row= mysql_fetch_array($result)){
            $longurl = $row['urllarga'];
            $ip = $_SERVER['REMOTE_ADDR'];
            $fecha = date("Y-m-d H:i:s");
            $sql = "INSERT INTO contador(urlcorta, ip, fecha) VALUES ('$urlcorta', '$ip', '$fecha')";
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

        $url = $_SERVER['REQUEST_URI'];
        $url = str_replace("\"", "", $url);
        $url = str_replace("'", "", $url);
        $url = str_replace("/", "", $url);
        
        return $url; 
    }


}

?>