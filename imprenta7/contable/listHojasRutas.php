<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta name="tipo_contenido"  content="text/html;" http-equiv="content-type" charset="utf-8">
<title>Hojas de Ruta</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script language='Javascript'>
function objetoAjax(){
	var xmlhttp=false;
	try {
		xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	} catch (e) {
		try {
		   xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		} catch (E) {
			xmlhttp = false;
  		}
	}

	if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
		xmlhttp = new XMLHttpRequest();
	}
	return xmlhttp;
}

function resultados_ajax(datos){
	divResultado = document.getElementById('resultados');
	ajax=objetoAjax();
	ajax.open("GET", datos);
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
			divResultado.innerHTML = ajax.responseText;
			cargarClasesFrame();	
			agregarTablaReporteClase();
		}
	}
	ajax.send(null)
}

function buscar()
{	
if(document.form1.codActivoFecha.checked){
	valorchecked="on";
}else{
	valorchecked="off";
}

resultados_ajax('searchHojasRutas.php?nrocotizacionB='+document.form1.nrocotizacionB.value+'&nombreClienteB='+document.form1.nombreClienteB.value+'&nroHojaRutaB='+document.form1.nroHojaRutaB.value+'&codActivoFecha='+valorchecked+'&fechaInicioB='+document.form1.fechaInicioB.value+'&fechaFinalB='+document.form1.fechaFinalB.value);

}
function paginar(f)
{	
if(document.form1.codActivoFecha.checked){
	valorchecked="on";
}else{
	valorchecked="off";
}
	
		location.href='listHojasRutas.php?nrocotizacionB='+document.form1.nrocotizacionB.value+'&nombreClienteB='+document.form1.nombreClienteB.value+'&nroHojaRutaB='+document.form1.nroHojaRutaB.value+'&codActivoFecha='+valorchecked+'&fechaInicioB='+document.form1.fechaInicioB.value+'&fechaFinalB='+document.form1.fechaFinalB.value+'&pagina='+document.form1.pagina.value;
}
function paginar1(f,pagina)
{		
if(document.form1.codActivoFecha.checked){
	valorchecked="on";
}else{
	valorchecked="off";
}
		f.pagina.value=pagina*1;		
		location.href='listHojasRutas.php?nrocotizacionB='+document.form1.nrocotizacionB.value+'&nombreClienteB='+document.form1.nombreClienteB.value+'&nroHojaRutaB='+document.form1.nroHojaRutaB.value+'&codActivoFecha='+valorchecked+'&fechaInicioB='+document.form1.fechaInicioB.value+'&fechaFinalB='+document.form1.fechaFinalB.value+'&pagina='+document.form1.pagina.value;	
}








</script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor="#F7F5F3">
<form name="form1" method="post"  id="form1">
<?php
	require("conexion.inc");
	include("funciones.php");
	
	$nrocotizacionB=$_GET['nrocotizacionB'];
	$nombreClienteB=$_GET['nombreClienteB'];
	$nroHojaRutaB=$_GET['nroHojaRutaB'];
	$codActivoFecha=$_GET['codActivoFecha'];
	$fechaInicioB=$_GET['fechaInicioB'];
	$fechaFinalB=$_GET['fechaFinalB'];

?>
<h3 align="center" style="background:#F7F5F3;font-size: 14px;color: #E78611;font-weight:bold;">LISTADO DE HOJAS DE RUTA 
  <a class="btn btn-warning btn-lg float-right text-white boton-filtro-iframe" href="#" data-toggle="modal" data-target="#filtroModal">
       <i class="fa fa-search"></i> BUSCAR REGISTROS
    </a>
</h3>



<div id="resultados">
<?php 


	//Paginador
	
	
	$nro_filas_show=50;	
	$pagina=$_GET['pagina'];
	//echo $pagina;
	if ($pagina==""){
		$pagina = 1;
		$fila_inicio=0;
		$fila_final=$nro_filas_show;
	}else{
		$fila_inicio=(($pagina*$nro_filas_show)-$nro_filas_show);
		$fila_final=($fila_inicio+$nro_filas_show);
	}	
	

	
	$sql=" select count(*) ";
	$sql.=" from hojas_rutas hr, gestiones g, estados_hojas_rutas ehr, cotizaciones c, clientes cli ";
	$sql.=" where hr.cod_gestion=g.cod_gestion ";
	$sql.=" and hr.cod_estado_hoja_ruta=ehr.cod_estado_hoja_ruta ";
	$sql.=" and hr.cod_cotizacion=c.cod_cotizacion ";
	$sql.=" and c.cod_cliente=cli.cod_cliente ";
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
		$sql.=" hr.fecha_modifica, hr.cod_usuario_modifica";
		$sql.=" from hojas_rutas hr, gestiones g, estados_hojas_rutas ehr, cotizaciones c, clientes cli ";
		$sql.=" where hr.cod_gestion=g.cod_gestion ";
		$sql.=" and hr.cod_estado_hoja_ruta=ehr.cod_estado_hoja_ruta ";
		$sql.=" and hr.cod_cotizacion=c.cod_cotizacion ";
		$sql.=" and c.cod_cliente=cli.cod_cliente ";
		
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
	//Fin Busqueda/////////////////	
	$sql.=" order by  hr.cod_hoja_ruta desc";	
		$sql.=" limit 50";
		//	echo $sql;
		$resp = mysqli_query($enlaceCon,$sql);
		$cont=0;
?>	
	<table width="95%" align="center" cellpadding="1" id="cotizacion" cellspacing="1" bgColor="#cccccc" class="tablaReporte" style="width:100% !important;">
		<thead>
	    <tr height="20px" align="center"  class="bg-success text-white">
			<th>Nro Hoja Ruta</th>
    		<th>Fecha</th>	
			<th>Usuario</th>														
    		<th>Estado</th>
			<th>Observaciones</th>	            
			<th>Ref. Cotizacion</th>
            <th>Notas de Remision</th>
            <th>Facturas</th> 
            <th>&nbsp;</th>   
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

		
								
		?> 
		<tr bgcolor="#FFFFFF" valign="middle" >	
    		<td align="right"><a href="../reportes/impresionHojaRuta.php?cod_hoja_ruta=<?php echo $cod_hoja_ruta; ?>" target="_blank"> <?php echo $nro_hoja_ruta."/".$gestion; ?></a></td>	
			<td><?php echo strftime("%d/%m/%Y",strtotime($fecha_hoja_ruta));?></td>	
			<td><?php echo $usuarioHojaRuta; ?></td>											
    		<td class="colh1"><?php echo $nombre_estado_hoja_ruta;?>
				<?php if($cod_estado_hoja_ruta==2){ ?>
					<?php echo "\n".$obs_anular; ?>
				<?php }?>			
          </td>
          <td>&nbsp;</td>
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
            
            <a href="../reportes/impresionCotizacion.php?cod_cotizacion=<?php echo $cod_cotizacion; ?>" target="_blank">
			<?php echo $nro_cotizacion."/".$gestion_cotizacion." (".$nombre_cliente.")";?></a>
            
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
                	<td align="right"><?php echo "Nro".$nro_factura." NIT:". $nit_factura." Monto:".$monto_factura ?></td>
                </tr>

			<?php
				}
			?>
            </table>
            <?php
			 }	
			?>
          </td>
            <td>
            <?php if($cod_estado_hoja_ruta<>2){?>
            <a href="newFacturaHojaRuta.php?cod_hoja_ruta=<?php echo $cod_hoja_ruta; ?>"><strong>+</strong>Factura</a>
             <?php }?>
            </td>								
							            
   	  </tr>
<?php
		 } 
?>			
  			</tbody>
		</table>
		
</div>

<!-- MODAL FILTRO-->
  <div class="modal fade modal-arriba" id="filtroModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Buscar</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">x</span>
          </button>
        </div>
        <div class="modal-body">
<table border="0" align="center">
<tr>
<td><strong>Nro de Cotizacion</strong></td>
<td colspan="3"><input type="text" name="nrocotizacionB" id="nrocotizacionB" size="10" class="textoform" onkeyup="buscar()" value="<?php echo $nrocotizacionB;?>" ></td>
</tr>
<tr><td><strong>Clientes</strong></td>
<td colspan="3">
 <input name="nombreClienteB" id="nombreClienteB" size="30" class="textoform" value="<?php echo $nombreClienteB; ?>" onkeyup="buscar()">
	</td>
	<td rowspan="2">&nbsp;</td>
</tr>

<tr>
<td><strong>Nro de Hoja de Ruta</strong></td>
<td colspan="3"><input type="text" name="nroHojaRutaB" id="nroHojaRutaB" size="10" value="<?php echo $nroHojaRutaB;?>" class="textoform" onkeyup="buscar()" ></td>
</tr>
<tr >
     		<td>&nbsp;<b>Rango de Fecha</b>&nbsp;</td>			
     		<td>De&nbsp;<span id="sprytextfield1">
                <label for="fechaInicioB"></label>
                <input type="text" name="fechaInicioB" id="fechaInicioB" class="textoform" value="<?php echo $fechaInicioB; ?>">
<span class="textfieldInvalidFormatMsg">Formato no válido.</span></span>
        &nbsp;Hasta&nbsp;<span id="sprytextfield2">
        <label for="fechaFinalB"></label>
        <input type="text" name="fechaFinalB" id="fechaFinalB" class="textoform" value="<?php echo $fechaFinalB; ?>" >
<span class="textfieldInvalidFormatMsg">Formato no válido.</span></span>
<input type="checkbox" name="codActivoFecha" id="codActivoFecha" <?php if($codActivoFecha=="on"){?>checked="checked"<?php }?> onClick="buscar()" >
			</td>
    	</tr>
</table>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
        </div>
      </div>
    </div>
  </div>	 		
<?php require("cerrar_conexion.inc");
?>
<br>

</form>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "date", {format:"dd/mm/yyyy", isRequired:false, validateOn:["change"]});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "date", {format:"dd/mm/yyyy", isRequired:false, validateOn:["change"]});
</script>
</body>
</html>
