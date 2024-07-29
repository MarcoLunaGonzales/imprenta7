<?php
date_default_timezone_set('America/Caracas');
if($_COOKIE['usuario_global']==""){
	header("location:../index.html"); 
}else{
	require_once ("../conexion_inicio.inc");
}

?>