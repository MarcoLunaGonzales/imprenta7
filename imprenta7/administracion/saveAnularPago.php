<?php
require("conexion.inc");
include("funciones.php");

	$cod_pago=$_GET['cod_pago'];
	
	$sql="update pagos set ";
	$sql.=" cod_estado_pago=2,";
	$sql.=" obs_anulacion='".$_GET['obs_anulacion']."',"; 
	$sql.=" fecha_anulacion='".date('Y-m-d', time())."',"; 
	$sql.=" cod_usuario_anulacion='".$_COOKIE['usuario_global']."'"; 
	$sql.=" where cod_pago='".$_GET['cod_pago']."'"; 	
	mysqli_query($enlaceCon,$sql);

	
	$sql="select cod_cliente from pagos where cod_pago='".$_GET['cod_pago']."'"; 
	$resp= mysqli_query($enlaceCon,$sql);
	while($dat=mysqli_fetch_array($resp)){
		 $cod_cliente=$dat['cod_cliente'];
	}
	$sql="select cod_cbte from pagos where cod_pago=".$_GET['cod_pago'];
	$resp= mysqli_query($enlaceCon,$sql);
	while($dat=mysqli_fetch_array($resp)){
		$cod_cbte=$dat['cod_cbte'];
	}	
	
	$sql="update comprobante set cod_estado_cbte=2 where cod_cbte=".$cod_cbte;
	//echo $sql;
	mysqli_query($enlaceCon,$sql);
	
	///////////////////////ACTUALIZACION DE ESTADOS ///////////////////////
	$sql=" select codigo_doc";
	$sql.=" from pagos_detalle ";
	$sql.=" where cod_pago=".$cod_pago;
	$sql.=" and cod_tipo_doc=1";
	$resp= mysqli_query($enlaceCon,$sql);
	while($dat=mysqli_fetch_array($resp)){
		 $cod_hoja_ruta=$dat['codigo_doc'];
	
	$monto_hojaruta=0;
	$sql2=" select sum(cd.IMPORTE_TOTAL) ";
	$sql2.=" from hojas_rutas_detalle hrd, cotizaciones_detalle cd ";
	$sql2.=" where hrd.cod_hoja_ruta=".$cod_hoja_ruta;
    $sql2.=" and hrd.cod_cotizacion=cd.cod_cotizacion ";
	$sql2.=" and hrd.cod_cotizaciondetalle=cd.cod_cotizaciondetalle ";
	$resp2 = mysqli_query($enlaceCon,$sql2);
	while($dat2=mysqli_fetch_array($resp2)){
		$monto_hojaruta=$dat2[0];
    }
	//////////////////////////
	$descuento_cotizacion=0;
	$sql2=" select c.descuento_cotizacion ";
	$sql2.=" from hojas_rutas hr, cotizaciones c ";
	$sql2.=" where hr.cod_cotizacion=c.cod_cotizacion ";
	$sql2.=" and hr.cod_hoja_ruta=".$cod_hoja_ruta;
	$resp2 = mysqli_query($enlaceCon,$sql2);
	while($dat2=mysqli_fetch_array($resp2)){
		$descuento_cotizacion=$dat2['descuento_cotizacion'];
	}
	$incremento_cotizacion=0;
	$sql2=" select c.incremento_cotizacion ";
	$sql2.=" from hojas_rutas hr, cotizaciones c ";
	$sql2.=" where hr.cod_cotizacion=c.cod_cotizacion ";
	$sql2.=" and hr.cod_hoja_ruta=".$cod_hoja_ruta;
	$resp2 = mysqli_query($enlaceCon,$sql2);
	while($dat2=mysqli_fetch_array($resp2)){
		$incremento_cotizacion=$dat2['incremento_cotizacion'];
	}	
	///////////////////////////
	$monto_hojaruta=(($monto_hojaruta+$incremento_cotizacion)-$descuento_cotizacion);	
	$sql2=" select  pd.monto_pago_detalle ";
	$sql2.=" from pagos_detalle pd, pagos p";
	$sql2.=" where pd.cod_pago=p.cod_pago";
	$sql2.=" and p.cod_estado_pago<>2";
	$sql2.=" and pd.codigo_doc=".$cod_hoja_ruta;
	$sql2.=" and pd.cod_tipo_doc=1";
	$sql2.=" and pd.cod_pago<>".$cod_pago;

	$resp2 = mysqli_query($enlaceCon,$sql2);
	$acuenta_hojaruta=0;
	while($dat2=mysqli_fetch_array($resp2)){
					
					$monto_pago_detalle=$dat2['monto_pago_detalle'];
					$acuenta_hojaruta=$acuenta_hojaruta+$monto_pago_detalle;					
	}				

		 if($acuenta_hojaruta==0){
				$sql4=" update hojas_rutas set ";
				$sql4.=" cod_estado_pago_doc=1";
				$sql4.=" where cod_hoja_ruta=".$cod_hoja_ruta;	
				
				mysqli_query($enlaceCon,$sql4);
		 }else{
		 	 if(($monto_hojaruta-$acuenta_hojaruta)>0){
					$sql4=" update hojas_rutas set ";
					$sql4.=" cod_estado_pago_doc=2";
					$sql4.=" where cod_hoja_ruta=".$cod_hoja_ruta;	
					mysqli_query($enlaceCon,$sql4);
			 }
			 if(($monto_hojaruta-$acuenta_hojaruta)==0){
					$sql4=" update hojas_rutas set ";
					$sql4.=" cod_estado_pago_doc=3";
					$sql4.=" where cod_hoja_ruta=".$cod_hoja_ruta;	
					mysqli_query($enlaceCon,$sql4);
			 }
		 }

		///////////////////////FIN ACTUALIZACION DE ESTADOS ///////////////////////
	}

	
////////////////////////ORDENES DE TRABAJO////////////////////////////////
	$sql=" select codigo_doc";
	$sql.=" from pagos_detalle ";
	$sql.=" where cod_pago=".$cod_pago;
	$sql.=" and cod_tipo_doc=2";
	$resp= mysqli_query($enlaceCon,$sql);
	while($dat=mysqli_fetch_array($resp)){
		
		$cod_orden_trabajo=$dat['codigo_doc'];	
		$monto_orden_trabajo=0;
		$sql2=" select sum(monto_orden_trabajo) ";
		$sql2.=" from ordentrabajo  ";
		$sql2.=" where cod_orden_trabajo=".$cod_orden_trabajo;
		$resp2 = mysqli_query($enlaceCon,$sql2);
		while($dat2=mysqli_fetch_array($resp2)){
			$monto_orden_trabajo=$dat2[0];
	    }
		

		$sql2=" select pd.monto_pago_detalle ";
		$sql2.=" from pagos_detalle pd, pagos p";
		$sql2.=" where pd.cod_pago=p.cod_pago";
		$sql2.=" and p.cod_estado_pago<>2";
		$sql2.=" and pd.codigo_doc=".$cod_orden_trabajo;
		$sql2.=" and pd.cod_tipo_doc=2";
		$sql2.=" and pd.cod_pago<>".$cod_pago;
		$resp2 = mysqli_query($enlaceCon,$sql2);
		$acuenta_ordentrabajo=0;
		while($dat2=mysqli_fetch_array($resp2)){
					
			$monto_pago_detalle=$dat2['monto_pago_detalle'];					
			$acuenta_ordentrabajo=$acuenta_ordentrabajo+$monto_pago_detalle;
					
		}				

		 if($acuenta_ordentrabajo==0){
				$sql4=" update ordentrabajo set ";
				$sql4.=" cod_estado_pago_doc=1";
				$sql4.=" where cod_orden_trabajo=".$cod_orden_trabajo;	
				
				mysqli_query($enlaceCon,$sql4);
		 }else{
		 	 if(($monto_orden_trabajo-$acuenta_ordentrabajo)>0){
					$sql4=" update ordentrabajo set ";
					$sql4.=" cod_estado_pago_doc=2";
					$sql4.=" where cod_orden_trabajo=".$cod_orden_trabajo;	
					mysqli_query($enlaceCon,$sql4);
			 }
			 if(($monto_orden_trabajo-$acuenta_ordentrabajo)==0){
					$sql4=" update ordentrabajo set ";
					$sql4.=" cod_estado_pago_doc=3";
					$sql4.=" where cod_orden_trabajo=".$cod_orden_trabajo;	
					mysqli_query($enlaceCon,$sql4);
			 }
		 }

		///////////////////////FIN ACTUALIZACION DE ESTADOS ///////////////////////
	}
	/////////////////////////////FIN ORDENES DE TRABAJO//////////////////
	
////////////////////////VENTAS////////////////////////////////
	$sql=" select codigo_doc";
	$sql.=" from pagos_detalle ";
	$sql.=" where cod_pago=".$cod_pago;
	$sql.=" and cod_tipo_doc=3";
	$resp= mysqli_query($enlaceCon,$sql);
	while($dat=mysqli_fetch_array($resp)){
		
		$cod_salida=$dat['codigo_doc'];	
		$monto_venta=0;
	 		$monto_venta=0;
			 		$sql2=" select sum(sd.precio_venta*sd.cant_salida) ";
					$sql2.=" from salidas_detalle sd ";
					$sql2.=" where sd.cod_salida=".$cod_salida;
					$resp2 = mysqli_query($enlaceCon,$sql2);
					while($dat2=mysqli_fetch_array($resp2)){
						$monto_venta=$dat2[0];
					}
		

		$sql2=" select pd.monto_pago_detalle ";
		$sql2.=" from pagos_detalle pd, pagos p";
		$sql2.=" where pd.cod_pago=p.cod_pago";
		$sql2.=" and p.cod_estado_pago<>2";
		$sql2.=" and pd.codigo_doc=".$cod_salida;
		$sql2.=" and pd.cod_tipo_doc=3";
		$sql2.=" and pd.cod_pago<>".$cod_pago;
		$resp2 = mysqli_query($enlaceCon,$sql2);
		$acuenta_venta=0;
		while($dat2=mysqli_fetch_array($resp2)){
					$monto_pago_detalle=$dat2['monto_pago_detalle'];
					$acuenta_venta=$acuenta_venta+$monto_pago_detalle;					
		}				

		 if($acuenta_venta==0){
				$sql4=" update salidas set ";
				$sql4.=" cod_estado_pago_doc=1";
				$sql4.=" where cod_salida=".$cod_salida;	
				
				mysqli_query($enlaceCon,$sql4);
		 }else{
		 	 if(($monto_venta-$acuenta_venta)>0){
					$sql4=" update salidas set ";
					$sql4.=" cod_estado_pago_doc=2";
					$sql4.=" where cod_salida=".$cod_salida;	
					mysqli_query($enlaceCon,$sql4);
			 }
			 if(($monto_venta-$acuenta_venta)==0){
					$sql4=" update salidas set ";
					$sql4.=" cod_estado_pago_doc=3";
					$sql4.=" where cod_salida=".$cod_salida;	
					mysqli_query($enlaceCon,$sql4);
			 }
		 }

		///////////////////////FIN ACTUALIZACION DE ESTADOS ///////////////////////
	}
	/////////////////////////////FIN ORDENES DE TRABAJO//////////////////	


require("cerrar_conexion.inc");
?>
<script language="JavaScript">
location.href="viewPago.php?cod_pago=<?php echo $cod_pago;?>";
</script>