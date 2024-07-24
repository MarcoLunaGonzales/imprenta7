<?php
date_default_timezone_set('America/Caracas');
if(!function_exists('register_globals')){
	include('register_globals.php');
	register_globals();
}else{
	
}

$con=mysql_connect("localhost","mysql_imprenta","4879531Gabriela");
$bd=mysql_select_db("imprenta_test");

if(!isset($_GET['cod_modulo'])){
   include("librerias_ajax_iframe.php"); 
}
?>
