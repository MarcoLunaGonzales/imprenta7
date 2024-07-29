<?php
require("conexion.inc");
include("funciones.php");


	
	$sql2=" select hr.cod_hoja_ruta, hr.cod_cotizacion, c.cod_tipo_pago ";
	$sql2.=" from hojas_rutas hr, cotizaciones c ";
	$sql2.=" where hr.cod_cotizacion=c.cod_cotizacion";
	$sql2.=" order by hr.cod_hoja_ruta asc";

	$resp2= mysqli_query($enlaceCon,$sql2);
	while($dat2=mysqli_fetch_array($resp2)){
		$cod_hoja_ruta=$dat2['cod_hoja_ruta'];
		$cod_cotizacion=$dat2['cod_cotizacion'];
		$cod_tipo_pago=$dat2['cod_tipo_pago'];
		
		$sql="update hojas_rutas set ";
		$sql.=" cod_tipo_pago='".$cod_tipo_pago."'"; 
		$sql.=" where cod_hoja_ruta='".$cod_hoja_ruta."'"; 	
		mysqli_query($enlaceCon,$sql);
		echo "HR: ".$cod_hoja_ruta." COT:".$cod_cotizacion." TP:".$cod_tipo_pago."<br>";
	}
	
	

	
	


require("cerrar_conexion.inc");
?>
