<?php
require("conexion.inc");
include("funciones.php");


$codCliente = $_POST['codCliente'];

$fechaCotizacionF = $_POST['fechaCotizacionF'];

$codTipoCotizacionF = $_POST['codTipoCotizacionF'];

$codTipoPagoF = $_POST['codTipoPagoF'];

$obsF = $_POST['obsF'];


$codItemF = $_POST['codItemF'];

$cantidadUnitariaF = $_POST['cantidadUnitariaF'];

$precioVentaF = $_POST['precioVentaF'];

$descuentoF = $_POST['descuentoF'];


$codCaracF = $_POST['codCaracF'];

$descCaracF = $_POST['descCaracF'];

$descItemF = $_POST['descItemF'];

$chkSumarF = $_POST['chkSumarF'];

$chkConsiderarPrecioUnitarioF = $_POST['chkConsiderarPrecioUnitarioF'];

$codUsuarioFirmaF= $_POST['codUsuarioFirmaF'];


$codItemVector = explode(",", $codItemF);
$cantidadUnitariaVector = explode(",", $cantidadUnitariaF);
$precioVentaVector = explode(",", $precioVentaF);
$descuentoVector = explode(",", $descuentoF); 
$importeVector = explode(",", $importeF);

$codCaracVector=explode(",", $codCaracF);
$descCaracVector=explode(",", $descCaracF);
$descItemVector=explode(",", $descItemF);



$vectorFecha = explode("/", $fechaCotizacionF);
$fechaCotizacionF = $vectorFecha[2] . "-" . $vectorFecha[1] . "-" . $vectorFecha[0];

$sql = "select max(COD_COTIZACION) from cotizaciones";
$codCotizacion = obtenerCodigo($sql);
$codGestionActiva = gestionActiva();

$sql= "select max(NRO_COTIZACION) from cotizaciones where cod_gestion='".$codGestionActiva."'";
$nroCotizacion = obtenerCodigo($sql);

$fechaRegistro=date('Y/m/d h:i:s', time());

$sql = "insert into cotizaciones set ";
$sql .= " COD_COTIZACION=" . $codCotizacion . ",";
$sql .= " COD_TIPO_COTIZACION=" . $codTipoCotizacionF . ",";
$sql .= " COD_ESTADO_COTIZACION=1,";
$sql .= " cod_gestion=" . $codGestionActiva . ",";
$sql .= " NRO_COTIZACION=" . $nroCotizacion . ",";
$sql .= " COD_CLIENTE=" . $codCliente . ",";
$sql .= " cod_unidad=" .$_POST['cod_unidad']. ",";
$sql .= " cod_contacto=" .$_POST['cod_contacto']. ",";
if($_POST['dias_validez']>0){
	$sql .= " dias_validez=".$_POST['dias_validez']. ",";
}else{
	$sql .= " dias_validez=15,";
}
if($_POST['tiempo_entrega']==""){
	$sql .= " tiempo_entrega=0,";
}else{
	$sql .= " tiempo_entrega=".$_POST['tiempo_entrega']. ",";
}
$sql .= " forma_pago='".$_POST['tiempo_entrega']. "',";
$sql .= " cod_usuario_comision='".$_POST['cod_usuario_comision']. "',";
$sql .= " FECHA_COTIZACION='" . $fechaCotizacionF . "',";
$sql .= " OBS_COTIZACION='" . $obsF . "',";
$sql .= " COD_TIPO_PAGO='" . $codTipoPagoF . "',";
$sql .= " cod_usuario_registro=" .$_COOKIE['usuario_global'] . ",";
$sql .= " COD_SUMAR=" .$chkSumarF. ",";
$sql .= " considerar_precio_unitario=" .$chkConsiderarPrecioUnitarioF. ",";
$sql .= " cod_usuario_modifica=0, ";
$sql .= " cod_usuario_aprobacion=0, ";
$sql .= " fecha_registro='".$fechaRegistro."',";
$sql .= " cod_usuario_firma='".$codUsuarioFirmaF."'";

mysqli_query($enlaceCon,$sql);
$cont=0;

for($i = 0;$i <= count($codItemVector)-1;$i++) {



    $sql_01 = "insert into cotizaciones_detalle SET";
	$sql_01 .= " COD_COTIZACIONDETALLE=" . ($i+1) . ",";
    $sql_01 .= " COD_COTIZACION=" . $codCotizacion . ",";
    $sql_01 .= " COD_ITEM=" . $codItemVector[$i] . ",";
	$sql_01 .= " DESCRIPCION_ITEM='" . $descItemVector[$i] . "',";	
    $sql_01 .= " CANTIDAD_UNITARIACOTIZACION=" . $cantidadUnitariaVector[$i] . ",";
    $sql_01 .= " CANTIDAD_UNITARIACOTIZACIONEFECTUADA=0,";
    $sql_01 .= " COD_ESTADO_DETALLECOTIZACIONITEM=1,";
	
	if($chkConsiderarPrecioUnitarioF==1){
    	$sql_01 .= " PRECIO_VENTA=" . $precioVentaVector[$i] . ",";
	    $sql_01 .= " DESCUENTO=" . $descuentoVector[$i] . ",";
    	$montoVentaSinDescuento = floatval($cantidadUnitariaVector[$i]) * floatval($precioVentaVector[$i]);
	    $importeTotal=floatval($montoVentaSinDescuento)-floatval(floatval($montoVentaSinDescuento)*floatval($descuentoVector[$i])/ 100);
   		 $sql_01 .= " IMPORTE_TOTAL=" . $importeTotal."";
	}else{
	    	$sql_01 .= " PRECIO_VENTA=0,";
   	        $sql_01 .= " DESCUENTO=0,";
			$sql_01 .= " IMPORTE_TOTAL=" .$importeVector[$i]."";
	}
 	// echo("$sql_01".$sql_01."<br>");
	 mysqli_query($enlaceCon,$sql_01);
	
	$sql_02="select cod_compitem from componente_items where cod_item='".$codItemVector[$i]."' order by cod_compitem asc";
	$resp_02= mysqli_query($enlaceCon,$sql_02);	
	while($dat_02=mysqli_fetch_array($resp_02)){
		$codCompItem=$dat_02[0];
		$sql_03="SELECT COD_CARAC FROM componentes_caracteristica WHERE  COD_COMPITEM='".$codCompItem."' ORDER BY orden ASC";
		$resp_03= mysqli_query($enlaceCon,$sql_03);
		$orden=1;
		while($dat_03=mysqli_fetch_array($resp_03)){
			$codCarac=$dat_03[0];
			$sql_04="insert into cotizacion_detalle_caracteristica SET";
			$sql_04.=" COD_COTIZACIONDETALLE=".($i+1)."";				
			$sql_04.=" ,COD_COTIZACION=".$codCotizacion;
			$sql_04.=" ,COD_COMPITEM=".$codCompItem;
			$sql_04.=" ,COD_CARAC=".$codCarac;
			$sql_04.=" ,DESC_CARAC='".$descCaracVector[$cont]."'";
			$sql_04.=" ,COD_ESTADO_REGISTRO=".$codCaracVector[$cont]."";		
			$sql_04.=" ,orden=".$orden."";	
		
			mysqli_query($enlaceCon,$sql_04);

			$cont++;
			$orden++;
		}
	}
}

	$sql4="select cod_ppc,desc_ppc, valor_ppc,orden_ppc from parametros_pie_cotizacion order by orden_ppc ";
					$resp4=mysqli_query($enlaceCon,$sql4);
						while($dat4=mysqli_fetch_array($resp4))
						{
							$cod_ppc=$dat4['cod_ppc'];
							
							
							
							if($_POST['cod_ppc'.$cod_ppc]<>Null || $_POST['cod_ppc'.$cod_ppc]<>""){
								
								$sqlInsert="insert into cotizaciones_ppc set";
								$sqlInsert.=" cod_cotizacion=".$codCotizacion."";				
								$sqlInsert.=" ,cod_ppc=".$_POST['cod_ppc'.$cod_ppc];
								$sqlInsert.=" ,desc_cotizacion_ppc='".$_POST['desc_cotizacion_ppc'.$cod_ppc]."'";
									
								mysqli_query($enlaceCon,$sqlInsert);
								
							}
							
							
						}	

?>
<script language="JavaScript">				
		location.href="listCotizaciones.php";
		window.close();
        window.opener.location.reload();
</script>
