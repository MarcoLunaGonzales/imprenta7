<?php
date_default_timezone_set('America/Caracas');
if(!function_exists('register_globals')){
	include('register_globals.php');
	register_globals();
}else{
	
}

require_once 'config.php';


$enlaceCon=mysqli_connect(DATABASE_HOST,DATABASE_USER,DATABASE_PASSWORD,DATABASE_NAME);
if (mysqli_connect_errno())
{
	echo "Error en la conexión: " . mysqli_connect_error();
}
mysqli_set_charset($enlaceCon,"utf8");

if (!function_exists('mysqli_result')) {
    function mysqli_result($result, $number, $field=0) {
        mysqli_data_seek($result, $number);
        $row = mysqli_fetch_array($result);
        return $row[$field];
    }
}


if(!isset($_GET['cod_modulo'])){
   include("librerias_ajax_iframe.php"); 
}
?>
