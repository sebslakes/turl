<?php
include('url.php');
$data=file_get_contents('php://input');

$url = new Url();
$url->consultador($data);


?>