<?
header("Cache-Control: no-store, no-cache, must-revalidate");

//coneccion a la Base de Datos
require("conexion.inc");
include("funciones.php");
$nrocotizacionB=$_GET['nrocotizacionB'];
$nombreClienteB=$_GET['nombreClienteB'];
$nroHojaRutaB=$_GET['nroHojaRutaB'];
$codActivoFecha=$_GET['codActivoFecha'];
$fechaInicioB=$_GET['fechaInicioB'];
$fechaFinalB=$_GET['fechaFinalB'];
$cod_estado_pago_docB=$_GET['cod_estado_pago_docB'];
//para sacar los datos de la busqueda
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="pagina.css" rel="stylesheet" type="text/css" />
</head>

<body bgcolor="#FFFFFF">
<?php 

	$nro_filas_show=50;	
	$pagina=$_GET['pagina'];

	if ($pagina==""){
		$pagina = 1;
		$fila_inicio=0;
		$fila_final=$nro_filas_show;
	}else{
		$fila_inicio=(($pagina*$nro_filas_show)-$nro_filas_show);
		$fila_final=($fila_inicio+$nro_filas_show);
	}	
	

	
	$sql=" select count(*) ";
	$sql.=" from hojas_rutas hr, gestiones g, estados_hojas_rutas ehr, cotizaciones c, clientes cli, estado_pago_documento ephr ";
	$sql.=" where hr.cod_gestion=g.cod_gestion ";
	$sql.=" and hr.cod_estado_hoja_ruta=ehr.cod_estado_hoja_ruta ";
	$sql.=" and hr.cod_cotizacion=c.cod_cotizacion ";
	$sql.=" and c.cod_cliente=cli.cod_cliente ";
	$sql.=" and hr.cod_estado_pago_doc=ephr.cod_estado_pago_doc ";
////Busqueda//////////////////
	if($nroHojaRutaB<>""){
		$sql.=" and CONCAT(hr.nro_hoja_ruta,'/',g.gestion) LIKE '%".$nroHojaRutaB."%' ";
	}
	if($nombreClienteB<>""){
		$sql.=" and cli.nombre_cliente like '%".$nombreClienteB."%' ";	
	}
	if($codActivoFecha=="on"){
		$fechaInicioB=$_GET['fechaInicioB'];
		$fechaFinalB=$_GET['fechaFinalB'];
		if($fechaInicioB<>"" and $fechaFinalB<>""){
				list($dI,$mI,$aI)=explode("/",$fechaInicioB);
				list($dF,$mF,$aF)=explode("/",$fechaFinalB);
				
				$sql.=" and hr.fecha_hoja_ruta>='".$aI."-".$mI."-".$dI."' and hr.fecha_hoja_ruta<='".$aF."-".$mF."-".$dF."' ";

		}
	}
	if($nrocotizacionB<>""){
		$sql.=" and c.cod_cotizacion in(select coti.cod_cotizacion from cotizaciones coti, gestiones ge  ";
		$sql.=" where coti.cod_gestion=ge.cod_gestion and CONCAT(COTI.nro_cotizacion,'/',ge.gestion) LIKE '%".$nrocotizacionB."%') ";
	}
	if($cod_estado_pago_docB<>0){
		$sql.=" and hr.cod_estado_pago_doc=".$cod_estado_pago_docB; 
	}	
	//Fin Busqueda/////////////////	
	//echo $sql;
	$resp_aux = mysqli_query($enlaceCon,$sql);
	while($dat_aux=mysqli_fetch_array($resp_aux)){
		$nro_filas_sql=$dat_aux[0];
	}

		//Calculo de Nro de Paginas
			$nropaginas=1;
			if($nro_filas_sql<$nro_filas_show){
				$nropaginas=1;
			}else{
				$nropag_aux=round($nro_filas_sql/$nro_filas_show);

				if($nro_filas_sql>($nropag_aux*$nro_filas_show)){
					$nropaginas=$nropag_aux+1;
				}else{
					$nropaginas=$nropag_aux;
				}
			}					
		//Fin de calculo de paginas
		$sql=" select hr.cod_hoja_ruta, hr.cod_gestion, hr.nro_hoja_ruta, g.gestion , hr.fecha_hoja_ruta, hr.cod_cotizacion, ";
		$sql.=" c.cod_cliente, cli.nombre_cliente,";
		$sql.=" hr.cod_estado_hoja_ruta, ehr.nombre_estado_hoja_ruta, hr.factura_si_no, hr.cod_usuario_comision,  ";
		$sql.=" hr.cod_usuario_anular, hr.fecha_anular, hr.obs_anular, hr.fecha_registro, hr.cod_usuario_registro, ";
		$sql.=" hr.fecha_modifica, hr.cod_usuario_modifica, hr.obs_hoja_ruta, hr.cod_estado_pago_doc,";
		$sql.=" ephr.desc_estado_pago_doc ";
		$sql.=" from hojas_rutas hr, gestiones g, estados_hojas_rutas ehr, cotizaciones c, clientes cli,estado_pago_documento ephr ";
		$sql.=" where hr.cod_gestion=g.cod_gestion ";
		$sql.=" and hr.cod_estado_hoja_ruta=ehr.cod_estado_hoja_ruta ";
		$sql.=" and hr.cod_cotizacion=c.cod_cotizacion ";
		$sql.=" and c.cod_cliente=cli.cod_cliente ";
		$sql.=" and hr.cod_estado_pago_doc=ephr.cod_estado_pago_doc ";
		
////Busqueda//////////////////
	if($nroHojaRutaB<>""){
		$sql.=" and CONCAT(hr.nro_hoja_ruta,'/',g.gestion) LIKE '%".$nroHojaRutaB."%' ";
	}
	if($nombreClienteB<>""){
		$sql.=" and cli.nombre_cliente like '%".$nombreClienteB."%' ";	
	}
	if($codActivoFecha=="on"){
		$fechaInicioB=$_GET['fechaInicioB'];
		$fechaFinalB=$_GET['fechaFinalB'];
		if($fechaInicioB<>"" and $fechaFinalB<>""){
				list($dI,$mI,$aI)=explode("/",$fechaInicioB);
				list($dF,$mF,$aF)=explode("/",$fechaFinalB);
				
				$sql.=" and hr.fecha_hoja_ruta>='".$aI."-".$mI."-".$dI."' and hr.fecha_hoja_ruta<='".$aF."-".$mF."-".$dF."' ";

		}
	}

	if($nrocotizacionB<>""){
		$sql.=" and c.cod_cotizacion in(select coti.cod_cotizacion from cotizaciones coti, gestiones ge  ";
		$sql.=" where coti.cod_gestion=ge.cod_gestion and CONCAT(COTI.nro_cotizacion,'/',ge.gestion) LIKE '%".$nrocotizacionB."%') ";
	}
	if($cod_estado_pago_docB<>0){
		$sql.=" and hr.cod_estado_pago_doc=".$cod_estado_pago_docB; 
	}
	//Fin Busqueda/////////////////	
	$sql.=" order by hr.cod_hoja_ruta desc";	
	//echo $sql;
		//$sql.=" limit ".$fila_inicio." , ".$nro_filas_show;
		//	echo $sql;
		$resp = mysqli_query($enlaceCon,$sql);
		$cont=0;
?>	
	<table width="95%" align="center" cellpadding="1" id="cotizacion" cellspacing="1" bgColor="#cccccc" class="tablaReporte" style="width:100% !important;">
        <thead>    
	    <tr height="20px" align="center"  class="bg-success text-white">
			<th>Nro Hoja Ruta</th>            
    		<th>Fecha</th>
            <th>Cliente</th>	
            <!--th>Monto Bs.</th>
			<th>Desc. Bs.</th>
            <th>Inc. Bs.</th>
			<th>Total Monto Bs.</th>
            <th>A cuenta Bs.</th>
            <th>Saldo Bs.</th>
			<th>Monto Gastos Bs.</th-->             														    		
			<th>Estado HR</th>      
            <th>Estado de Pago</th>                
			<th>Ref. Cotizacion</th>
            <th>Notas de Remision</th>
            <th>Facturas</th>
            <!--th>&nbsp;</th>
            <th>Informe</th-->   
		</tr>
		</thead>
		<tbody>
<?php   
		while($dat=mysqli_fetch_array($resp)){
				
			 $cod_hoja_ruta=$dat['cod_hoja_ruta'];
			 $cod_gestion=$dat['cod_gestion'];
			 $nro_hoja_ruta=$dat['nro_hoja_ruta'];
			 $gestion=$dat['gestion'];
			 $fecha_hoja_ruta=$dat['fecha_hoja_ruta'];
			 $cod_cotizacion=$dat['cod_cotizacion'];
			 $cod_cliente=$dat['cod_cliente'];
			 $nombre_cliente=$dat['nombre_cliente'];
			 $cod_estado_hoja_ruta=$dat['cod_estado_hoja_ruta'];
			 $nombre_estado_hoja_ruta=$dat['nombre_estado_hoja_ruta'];
			 $factura_si_no=$dat['factura_si_no'];
			 $cod_usuario_comision=$dat['cod_usuario_comision'];
			 $cod_usuario_anular=$dat['cod_usuario_anular'];
			 $fecha_anular=$dat['fecha_anular'];
			 $obs_anular=$dat['obs_anular']; 
			 $fecha_registro=$dat['fecha_registro'];
			 $cod_usuario_registro=$dat['cod_usuario_registro']; 
			 $fecha_modifica=$dat['fecha_modifica'];
			 $cod_usuario_modifica=$dat['cod_usuario_modifica'];
			 $obs_hoja_ruta=$dat['obs_hoja_ruta'];
			 $cod_estado_pago_doc=$dat['cod_estado_pago_doc'];
			 $desc_estado_pago_doc=$dat['desc_estado_pago_doc'];

		
								
		?> 
		<tr bgcolor="#FFFFFF" valign="middle" >	
    		<td align="right"><a href="../reportes/impresionHojaRuta.php?cod_hoja_ruta=<?php echo $cod_hoja_ruta; ?>" target="_blank"> <?php echo $nro_hoja_ruta."/".$gestion; ?></a></td>	
			<td><?php echo strftime("%d/%m/%Y",strtotime($fecha_hoja_ruta))." ".$usuarioHojaRuta; ?></td>
            <td><?php echo $nombre_cliente;?></td>

            <!--td align="right" bgcolor="#FFFFCC">
				<?php
							$monto_hojaruta=0;				
							$sqlAux=" select sum(cd.IMPORTE_TOTAL) ";
							$sqlAux.=" from hojas_rutas_detalle hrd, cotizaciones_detalle cd ";
							$sqlAux.=" where hrd.cod_hoja_ruta=".$cod_hoja_ruta;
							$sqlAux.=" and hrd.cod_cotizacion=cd.cod_cotizacion ";
							$sqlAux.=" and hrd.cod_cotizaciondetalle=cd.cod_cotizaciondetalle ";
							$respAux = mysqli_query($enlaceCon,$sqlAux);
							while($datAux=mysqli_fetch_array($respAux)){
								$monto_hojaruta=$datAux[0];
							}
							echo $monto_hojaruta;
				 ?>
             </td-->	
            <!--td align="right" bgcolor="#FFFFCC" >
				<?php  
					$descuento_cotizacion=0;
					$sqlAux="select descuento_cotizacion from cotizaciones where cod_cotizacion=".$cod_cotizacion;
					$respAux = mysqli_query($enlaceCon,$sqlAux);
					while($datAux=mysqli_fetch_array($respAux)){
							$descuento_cotizacion=$datAux[0];
					}
					
					if($descuento_cotizacion>0){
						echo $descuento_cotizacion;
					}else{
						$descuento_cotizacion=0;
						echo "0";
					}	
				?>
             </td-->	
            <!--td align="right" bgcolor="#FFFFCC" >
				<?php  
					$incremento_cotizacion=0;
					$sqlAux="select incremento_cotizacion from cotizaciones where cod_cotizacion=".$cod_cotizacion;
					$respAux = mysqli_query($enlaceCon,$sqlAux);
					while($datAux=mysqli_fetch_array($respAux)){
							$incremento_cotizacion=$datAux[0];
					}
					
					if($incremento_cotizacion>0){
						echo $incremento_cotizacion;
					}else{
						$incremento_cotizacion=0;
						echo "0";
					}	
				?>
             </td-->             
            <!--td align="right" bgcolor="#FFFFCC">
				<?php	echo (($monto_hojaruta+$incremento_cotizacion)-$descuento_cotizacion); ?>
             </td-->	
             <!--td align="right" bgcolor="#FFFFCC"><?php 
			 	$sql2=" select pd.cod_moneda, pd.monto_pago_detalle, p.fecha_pago ";
			 	$sql2.=" from pagos_detalle pd, pagos p";
			 	$sql2.=" where pd.cod_pago=p.cod_pago";
			 	$sql2.=" and p.cod_estado_pago<>2";
			 	$sql2.=" and pd.codigo_doc=".$cod_hoja_ruta;
				$sql2.=" and pd.cod_tipo_doc=1";
				$resp2 = mysqli_query($enlaceCon,$sql2);
				$acuenta_hojaruta=0;
				while($dat2=mysqli_fetch_array($resp2)){
					$cod_moneda=$dat2['cod_moneda'];
					$monto_pago_detalle=$dat2['monto_pago_detalle'];
					$fecha_pago=$dat2['fecha_pago'];

					if($cod_moneda==1){
						$acuenta_hojaruta=$acuenta_hojaruta+$monto_pago_detalle;
					}else{
							$sql3=" select cambio_bs from tipo_cambio";
							$sql3.=" where fecha_tipo_cambio='".$fecha_pago."'";
							$sql3.=" and cod_moneda=".$cod_moneda;

							$resp3=mysqli_query($enlaceCon,$sql3);
							$cambio_bs=0;
							while($dat3=mysqli_fetch_array($resp3)){
								$cambio_bs=$dat3['cambio_bs'];
							}
							if($cambio_bs<>0){
								$acuenta_hojaruta=$acuenta_hojaruta+($monto_pago_detalle*$cambio_bs);
							
							}
						
					}
				}				
			 echo $acuenta_hojaruta;

			 
			 ?></td-->	
			<!--td align="right" bgcolor="#FFFFCC"><?php echo ((($monto_hojaruta+$incremento_cotizacion)-$descuento_cotizacion)-$acuenta_hojaruta);?></td-->	 			 			 
            <!--td align="right">
			<?php
					$monto_gasto=0;
					$sqlAux="select count(*) from gastos_hojasrutas where cod_hoja_ruta=".$cod_hoja_ruta;
					$respAux = mysqli_query($enlaceCon,$sqlAux);
					$swGasto=0;
					while($datAux=mysqli_fetch_array($respAux)){
								$swGasto=$datAux[0];
					}
					if($swGasto>0){
							$sqlAux="select sum(monto_gasto) from gastos_hojasrutas where cod_hoja_ruta=".$cod_hoja_ruta;
							$respAux = mysqli_query($enlaceCon,$sqlAux);
							while($datAux=mysqli_fetch_array($respAux)){
								$monto_gasto=$datAux[0];
							}										
					}
					echo $monto_gasto;
            ?>
            </td--> 
                       											
    		<td class="colh1"><?php echo $nombre_estado_hoja_ruta;?>
				<?php if($cod_estado_hoja_ruta==2){ ?>
					<?php echo "\n".$obs_anular; ?>
				<?php }?>			
          </td>
          <td><?php echo $desc_estado_pago_doc; ?></td>
			<td><?php 
				//Datos de Cotizacion////
			 	$sqlCotizacion=" select c.nro_cotizacion, g.gestion ";
				$sqlCotizacion.=" from cotizaciones c, gestiones g";
				$sqlCotizacion.=" where c.cod_gestion=g.cod_gestion";
				$sqlCotizacion.=" and c.cod_cotizacion=".$cod_cotizacion;
				$resp2 = mysqli_query($enlaceCon,$sqlCotizacion);
				while($dat2=mysqli_fetch_array($resp2)){
					$nro_cotizacion=$dat2['nro_cotizacion'];
					$gestion_cotizacion=$dat2['gestion'];
				}
			 ///Fin Datos de Cotizacion///
			 
			 ?>
            
            <a href="../reportes/impresionCotizacionFormato.php?cod_cotizacion=<?php echo $cod_cotizacion; ?>" target="_blank">
			<?php echo $nro_cotizacion."/".$gestion_cotizacion;?></a>
            
          </td>
            
		  <td>
			<?php 
				$numNotasRemision=0;
				$sql3=" select count(*) from notas_remision  where cod_hoja_ruta='".$cod_hoja_ruta."'";
				$resp3= mysqli_query($enlaceCon,$sql3);
				while($dat3=mysqli_fetch_array($resp3)){
					$numNotasRemision=$dat3[0];
				}
				
				if($numNotasRemision>0){

					$sql3=" select cod_nota_remision, nro_nota_remision, cod_gestion,";
					$sql3.=" fecha_nota_remision, cod_usuario_nota_remision,";
					$sql3.=" obs_nota_remision, cod_estado_nota_remision ";
					$sql3.=" from notas_remision  where cod_hoja_ruta='".$cod_hoja_ruta."'";
					$resp3= mysqli_query($enlaceCon,$sql3);
					while($dat3=mysqli_fetch_array($resp3)){
						
						$cod_nota_remision=$dat3[0];
						$nro_nota_remision=$dat3[1];
						$cod_gestion_nota_remision=$dat3[2];
						$fecha_nota_remision=$dat3[3];
						$cod_usuario_nota_remision=$dat3[4];
						$obs_nota_remision=$dat3[5];
						$cod_estado_nota_remision=$dat3[6];
						
						$sql4=" select nombres_usuario, ap_paterno_usuario, ap_materno_usuario  ";
						$sql4.=" from usuarios where cod_usuario='".$cod_usuario_nota_remision."'";
						$UsuarioNotaRemision="";
						$resp4= mysqli_query($enlaceCon,$sql4);
						while($dat4=mysqli_fetch_array($resp4)){
							$UsuarioNotaRemision=$dat4[0]." ".$dat4[1];
						}
						$sql2="select gestion from gestiones where cod_gestion='".$cod_gestion_nota_remision."'";
						$resp2= mysqli_query($enlaceCon,$sql2);
						$gestionNotaRemision="";
						while($dat2=mysqli_fetch_array($resp2)){
							$gestionNotaRemision=$dat2[0];
						}

			?>

				 <a href="../reportes/impresionNotaRemision.php?cod_nota_remision=<?php echo $cod_nota_remision; ?>" target="_blank"><?php echo $nro_nota_remision."/".$gestionNotaRemision."; ";?></a>


				
			<?php	}
			 }	?>
 			
</td>		
			<td align="left">
            
            <?php 
				$numFacturas=0;
				$sql3=" select count(*) from factura_hojaruta  where cod_hoja_ruta='".$cod_hoja_ruta."'";
				//echo $sql3;
				$resp3= mysqli_query($enlaceCon,$sql3);
				while($dat3=mysqli_fetch_array($resp3)){
					$numFacturas=$dat3[0];
				}
				
				if($numFacturas>0){
			?>
             <table border="0" align="left">
			<?php
				$sqlFactura=" select f.cod_factura, f.nro_factura, f.nombre_factura, ";
				$sqlFactura.=" f.nit_factura, f.fecha_factura, f.detalle_factura,f.obs_factura, f.cod_est_fac,  ";
				$sqlFactura.=" ef.desc_est_fac, f.monto_factura, f.cod_usuario_registro,   ";
				$sqlFactura.=" f.fecha_registro, f.cod_usuario_modifica, f.fecha_modifica  ";
				$sqlFactura.=" from facturas f, estado_factura ef  ";
				$sqlFactura.=" where f.cod_est_fac=ef.cod_est_fac ";
				$sqlFactura.=" and f.cod_factura in(select cod_factura from factura_hojaruta where cod_hoja_ruta=".$cod_hoja_ruta.")";
				
					$resp3= mysqli_query($enlaceCon,$sqlFactura);
					while($dat3=mysqli_fetch_array($resp3)){
						
						$cod_factura=$dat3['cod_factura'];
						$nro_factura=$dat3['nro_factura'];
						$nombre_factura=$dat3['nombre_factura'];
						$nit_factura=$dat3['nit_factura'];
						$fecha_factura=$dat3['fecha_factura'];
						$detalle_factura=$dat3['detalle_factura'];
						$obs_factura=$dat3['obs_factura'];
						$cod_est_fac=$dat3['cod_est_fac'];
						$desc_est_fac=$dat3['desc_est_fac'];
						$monto_factura=$dat3['monto_factura'];
						$cod_usuario_registro=$dat3['cod_usuario_registro'];
						$fecha_registro=$dat3['fecha_registro'];
						$cod_usuario_modifica=$dat3['cod_usuario_modifica'];
						$fecha_modifica=$dat3['fecha_modifica'];		
			?>
				<tr>
                	<td align="right"><a><?php echo "Nro".$nro_factura." NIT:". $nit_factura." Monto:".$monto_factura ?></a></td>
                </tr>

			<?php
				}
			?>
            </table>
            <?php
			 }	
			?>
          </td>
          <!--td align="justify">
          	<?php
				$sql3=" select count(*) ";
				$sql3.=" from gastos_hojasrutas ghr, gastos g";
				$sql3.=" where ghr.cod_gasto=g.cod_gasto";
				$sql3.=" and ghr.cod_hoja_ruta=".$cod_hoja_ruta;
				$resp3 = mysqli_query($enlaceCon,$sql3);
				while($dat3=mysqli_fetch_array($resp3)){
					$nro_filas=$dat3[0];
				}
            ?>     
            <?php if($nro_filas>0){?>
            <table cellpadding="0" cellspacing="0" border="0">
            <?php
            	$sql3=" select ghr.cod_gasto, g.desc_gasto, ghr.monto_gasto ";
				$sql3.=" from gastos_hojasrutas ghr, gastos g";
				$sql3.=" where ghr.cod_gasto=g.cod_gasto";
				$sql3.=" and ghr.cod_hoja_ruta=".$cod_hoja_ruta;
				$resp3 = mysqli_query($enlaceCon,$sql3);
				while($dat3=mysqli_fetch_array($resp3)){
					$desc_gasto=$dat3['desc_gasto'];
					$monto_gasto=$dat3['monto_gasto'];

			?>
	            <tr>
                <td><?php echo $desc_gasto;?></td>
                <td align="right"><?php echo $monto_gasto;?></td>
                </tr>
            <?php }?>
            </table>            
			<?php }?>     
          </td-->
            <!--td>
            <?php if($cod_estado_hoja_ruta<>2){?><a href="listGastoHojaRuta.php?cod_hoja_ruta=<?php echo $cod_hoja_ruta;?>"> + Gastos</a>
             <?php }?>
            </td>
            <td>
<a href="../reportes/infHojaRuta.php?cod_hoja_ruta=<?php echo $cod_hoja_ruta; ?>" target="_blank">Informe</a>
            </td-->            								
							            
   	  </tr>
<?php
		 } 
?>			
          </tbody>
		</table>
		
</body>
</html>