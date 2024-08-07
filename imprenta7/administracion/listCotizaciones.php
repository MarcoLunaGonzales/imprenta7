<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta name="tipo_contenido"  content="text/html;" http-equiv="content-type" charset="utf-8">
<title>Cotizaciones</title>
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

resultados_ajax('searchCotizaciones.php?nrocotizacionB='+document.form1.nrocotizacionB.value+'&codEstadoCotizacionB='+document.form1.codEstadoCotizacionB.value+'&codTipoCotizacionB='+document.form1.codTipoCotizacionB.value+'&nombreClienteB='+document.form1.nombreClienteB.value+'&descItemB='+document.form1.descItemB.value+'&codActivoFecha='+valorchecked+'&fechaInicioB='+document.form1.fechaInicioB.value+'&fechaFinalB='+document.form1.fechaFinalB.value);

}
function paginar(f)
{	
if(document.form1.codActivoFecha.checked){
	valorchecked="on";
}else{
	valorchecked="off";
}
	
		location.href='listCotizaciones.php?nrocotizacionB='+document.form1.nrocotizacionB.value+'&codEstadoCotizacionB='+document.form1.codEstadoCotizacionB.value+'&codTipoCotizacionB='+document.form1.codTipoCotizacionB.value+'&nombreClienteB='+document.form1.nombreClienteB.value+'&descItemB='+document.form1.descItemB.value+'&codActivoFecha='+valorchecked+'&fechaInicioB='+document.form1.fechaInicioB.value+'&fechaFinalB='+document.form1.fechaFinalB.value+'&pagina='+document.form1.pagina.value;
}
function paginar1(f,pagina)
{		
if(document.form1.codActivoFecha.checked){
	valorchecked="on";
}else{
	valorchecked="off";
}
		f.pagina.value=pagina*1;		
		location.href='listCotizaciones.php?nrocotizacionB='+document.form1.nrocotizacionB.value+'&codEstadoCotizacionB='+document.form1.codEstadoCotizacionB.value+'&codTipoCotizacionB='+document.form1.codTipoCotizacionB.value+'&nombreClienteB='+document.form1.nombreClienteB.value+'&descItemB='+document.form1.descItemB.value+'&codActivoFecha='+valorchecked+'&fechaInicioB='+document.form1.fechaInicioB.value+'&fechaFinalB='+document.form1.fechaFinalB.value+'&pagina='+document.form1.pagina.value;	
}

function openPopup(url){
	window.open(url,'COPIAR','top=50,left=200,width=800,height=600,scrollbars=1,resizable=1');
}

function anular(cod_registro)
{
	
			if(confirm("Esta seguro de anular.")){
				window.location="anularRegistrarCotizacion.php?codCotizacion="+cod_registro;
			}else{
				return false;
			}

}

</script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor="#FFFFFF">
<form name="form1" method="post"  id="form1">
<?php
	require("conexion.inc");
	include("funciones.php");
	
	$nrocotizacionB=$_GET['nrocotizacionB'];
	$codEstadoCotizacionB=$_GET['codEstadoCotizacionB'];
	$codTipoCotizacionB=$_GET['codTipoCotizacionB'];
	$nombreClienteB=$_GET['nombreClienteB'];
	$descItemB=$_GET['descItemB'];
	$codActivoFecha=$_GET['codActivoFecha'];
	$fechaInicioB=$_GET['fechaInicioB'];
	$fechaFinalB=$_GET['fechaFinalB'];

?>
<h3 align="center" style="background:#FFF;font-size: 14px;color: #E78611;font-weight:bold;">LISTADO DE COTIZACIONES 
   <a class="btn btn-warning btn-lg float-right text-white boton-filtro-iframe" href="#" data-toggle="modal" data-target="#filtroModal">
       <i class="fa fa-search"></i> BUSCAR REGISTROS
    </a>
</h3>

<div id="resultados">
<?php 


	//Paginador
	
	
	$nro_filas_show=100;	
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
	$sql.=" from cotizaciones c, gestiones g, estados_cotizacion ec, tipos_cotizacion tc, tipos_pago tp, clientes cli ";
	$sql.=" where c.cod_gestion=g.cod_gestion ";
	$sql.=" and c.cod_estado_cotizacion=ec.cod_estado_cotizacion ";
	$sql.=" and c.cod_tipo_cotizacion=tc.cod_tipo_cotizacion ";
	$sql.=" and c.cod_tipo_pago=tp.cod_tipo_pago ";
	$sql.=" and c.cod_cliente=cli.cod_cliente ";
////Busqueda//////////////////
	if($nrocotizacionB<>""){
		$sql.=" and CONCAT(c.nro_cotizacion,'/',g.gestion) LIKE '%".$nrocotizacionB."%' ";
	}
	if($codEstadoCotizacionB<>0){
		$sql.=" and c.cod_estado_cotizacion =".$codEstadoCotizacionB;
	}	
	if($codTipoCotizacionB<>0){
		$sql.=" and c.cod_tipo_cotizacion =".$codTipoCotizacionB;
	}	

	if($nombreClienteB<>""){
		$sql.=" and cli.nombre_cliente like '%".$nombreClienteB."%' ";	
	}
	if($descItemB<>""){
		$sql.=" and c.cod_cotizacion in ( select cod_cotizacion from cotizaciones_detalle where cod_item in(select cod_item from items where desc_item like '%".$descItemB."%')) ";	
	}	

	if($codActivoFecha=="on"){
		$fechaInicioB=$_GET['fechaInicioB'];
		$fechaFinalB=$_GET['fechaFinalB'];
		if($fechaInicioB<>"" and $fechaFinalB<>""){
				list($dI,$mI,$aI)=explode("/",$fechaInicioB);
				list($dF,$mF,$aF)=explode("/",$fechaFinalB);
				
				$sql.=" and c.fecha_cotizacion>='".$aI."-".$mI."-".$dI."' and c.fecha_cotizacion<='".$aF."-".$mF."-".$dF."' ";

		}
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
		$sql=" select c.cod_cotizacion, c.cod_tipo_cotizacion, tc.nombre_tipo_cotizacion, c.cod_estado_cotizacion, ";
		$sql.=" ec.nombre_estado_cotizacion, c.nro_cotizacion,c.cod_cliente,c.cod_unidad, c.cod_contacto, ";
		$sql.=" cli.nombre_cliente, cli.direccion_cliente, cli.telefono_cliente, cli.celular_cliente,  c.fecha_cotizacion,"; 
		$sql.=" c.obs_cotizacion, c.cod_tipo_pago, tp.nombre_tipo_pago,  c.cod_gestion, g.gestion, g.gestion_nombre,c.cod_sumar,";
		$sql.=" c.considerar_precio_unitario, c.fecha_registro, c.cod_usuario_registro, c.fecha_modifica, c.cod_usuario_modifica,  ";
		$sql.=" c.cod_usuario_aprobacion, c.fecha_aprobacion, c.obs_cotizacion_impresion, c.cod_usuario_firma, c.cod_usuario_comision ";
		$sql.=" from cotizaciones c, gestiones g, estados_cotizacion ec, tipos_cotizacion tc, tipos_pago tp, clientes cli ";
		$sql.=" where c.cod_gestion=g.cod_gestion ";
		$sql.=" and c.cod_estado_cotizacion=ec.cod_estado_cotizacion ";
		$sql.=" and c.cod_tipo_cotizacion=tc.cod_tipo_cotizacion ";
		$sql.=" and c.cod_tipo_pago=tp.cod_tipo_pago ";
		$sql.=" and c.cod_cliente=cli.cod_cliente ";

////Busqueda//////////////////
	if($nrocotizacionB<>""){
		$sql.=" and CONCAT(c.nro_cotizacion,'/',g.gestion) LIKE '%".$nrocotizacionB."%' ";
	}
	if($codEstadoCotizacionB<>0){
		$sql.=" and c.cod_estado_cotizacion =".$codEstadoCotizacionB;
	}	
	if($codTipoCotizacionB<>0){
		$sql.=" and c.cod_tipo_cotizacion =".$codTipoCotizacionB;
	}	

	if($nombreClienteB<>""){
		$sql.=" and cli.nombre_cliente like '%".$nombreClienteB."%' ";	
	}
	if($descItemB<>""){
		$sql.=" and c.cod_cotizacion in ( select cod_cotizacion from cotizaciones_detalle where cod_item in(select cod_item from items where desc_item like '%".$descItemB."%')) ";	
	}	

	if($codActivoFecha=="on"){
		$fechaInicioB=$_GET['fechaInicioB'];
		$fechaFinalB=$_GET['fechaFinalB'];
		if($fechaInicioB<>"" and $fechaFinalB<>""){
				list($dI,$mI,$aI)=explode("/",$fechaInicioB);
				list($dF,$mF,$aF)=explode("/",$fechaFinalB);
				
				$sql.=" and c.fecha_cotizacion>='".$aI."-".$mI."-".$dI."' and c.fecha_cotizacion<='".$aF."-".$mF."-".$dF."' ";

		}
	}

	//Fin Busqueda/////////////////	
			$sql.=" order by  c.cod_cotizacion desc ";
		//$sql.=" limit ".$fila_inicio." , ".$nro_filas_show;
		$sql.=" limit 50";	//CORREGIDO
		//	echo $sql;
		$resp = mysqli_query($enlaceCon,$sql);
		$cont=0;
?>	
	<table align="center" cellpadding="1" cellspacing="1" bgColor="#CCCCCC" id="cotizacion" class="tablaReporte" style="width:100% !important;">   
		<thead>
	    <tr height="20px" align="center"  class="bg-success text-white">
            <th>&nbsp;</th> 
            <th>&nbsp;</th> 
            <th>&nbsp;</th> 
			<th>Nro de Cotizacion</th>
    		<th>Fecha</th>	
            <th>Usuario</th>	
			<th>Cliente</th>														
    		<th>Tipo de Pago</th>
			<th>Tipo de Cotizacion</th>	            
			<th>Observaciones</th>
            <th>Estado</th>
            <th>&nbsp;</th> 
            <th>&nbsp;</th>
            <th>&nbsp;</th> 
            <th>&nbsp;</th> 
		</tr>
	</thead>
	<tbody>
<?php   
		while($dat=mysqli_fetch_array($resp)){
				
			 $cod_cotizacion=$dat['cod_cotizacion'];
			 $cod_tipo_cotizacion=$dat['cod_tipo_cotizacion'];
			 $nombre_tipo_cotizacion=$dat['nombre_tipo_cotizacion'];
			 $cod_estado_cotizacion=$dat['cod_estado_cotizacion'];
			 $nombre_estado_cotizacion=$dat['nombre_estado_cotizacion'];
			 $nro_cotizacion=$dat['nro_cotizacion'];
			 $cod_cliente=$dat['cod_cliente'];
			 $cod_unidad=$dat['cod_unidad'];
			 $cod_contacto=$dat['cod_contacto'];
			 $nombre_cliente=$dat['nombre_cliente'];
			 $direccion_cliente=$dat['direccion_cliente'];
			 $telefono_cliente=$dat['telefono_cliente'];
			 $celular_cliente=$dat['celular_cliente'];
			 $fecha_cotizacion=$dat['fecha_cotizacion'];
			 $obs_cotizacion=$dat['obs_cotizacion'];
			 $cod_tipo_pago=$dat['cod_tipo_pago'];
			 $nombre_tipo_pago=$dat['nombre_tipo_pago'];
			 $cod_gestion=$dat['cod_gestion'];
			 $gestion=$dat['gestion'];
			 $gestion_nombre=$dat['gestion_nombre'];
			 $cod_sumar=$dat['cod_sumar'];
			 $considerar_precio_unitario=$dat['considerar_precio_unitario'];
			 $fecha_registro=$dat['fecha_registro'];
			 $cod_usuario_registro=$dat['cod_usuario_registro'];
			 $fecha_modifica=$dat['fecha_modifica'];
			 $cod_usuario_modifica=$dat['cod_usuario_modifica'];
			 $cod_usuario_aprobacion=$dat['cod_usuario_aprobacion'];
			 $fecha_aprobacion=$dat['fecha_aprobacion'];
			 $obs_cotizacion_impresion=$dat['obs_cotizacion_impresion'];
			 $cod_usuario_firma=$dat['cod_usuario_firma'];
			 $cod_usuario_comision=$dat['cod_usuario_comision'];

            	$sql2="  select count(*) swHojasRuta from hojas_rutas ";
				$sql2.=" where cod_cotizacion='".$cod_cotizacion."' and (cod_estado_hoja_ruta=1 or cod_estado_hoja_ruta=3)";
				$resp2= mysqli_query($enlaceCon,$sql2);
				$swHojasRuta=0;
				while($dat2=mysqli_fetch_array($resp2)){
					$swHojasRuta=$dat2[0];
				}
					$contacto="";
					if($cod_contacto<>"" and $cod_contacto<>0 and $cod_contacto<>NULL){
					  $sql5="  select nombre_contacto, ap_paterno_contacto, ap_materno_contacto, telefono_contacto, celular_contacto, ";
					  $sql5.=" email_contacto, cargo_contacto ";
					  $sql5.="  from clientes_contactos ";
					  $sql5.=" where cod_contacto=".$cod_contacto;
					  $resp5= mysqli_query($enlaceCon,$sql5);
					  while($dat5=mysqli_fetch_array($resp5)){
							$contacto=$dat5['nombre_contacto']." ".$dat5['ap_paterno_contacto']." ".$dat5['ap_materno_contacto'];
							$telefono_contacto=$dat5['telefono_contacto'];
							$celular_contacto=$dat5['celular_contacto'];
					  		$email_contacto=$dat5['email_contacto']; 
							$cargo_contacto=$dat5['cargo_contacto'];
					  }
					}		
					$nombre_unidad="";
					if($cod_unidad<>"" and $cod_unidad<>0 and $cod_unidad<>NULL){
					  $sql2="  select nombre_unidad,direccion_unidad, telf_unidad  from clientes_unidades ";
					  $sql2.=" where cod_unidad=".$cod_unidad;
					  $resp2= mysqli_query($enlaceCon,$sql2);
					  while($dat2=mysqli_fetch_array($resp2)){
							$nombre_unidad=$dat2['nombre_unidad'];
							$direccion_unidad=$dat2['direccion_unidad'];
							$telf_unidad=$dat2['telf_unidad'];
					  }
					}		
					$nombre_usuario_comision="";				
					$sql2="select nombres_usuario, ap_paterno_usuario, ap_materno_usuario from usuarios";
					$sql2.=" where cod_usuario='".$cod_usuario_comision."'";	
					$resp2= mysqli_query($enlaceCon,$sql2);
					while($dat2=mysqli_fetch_array($resp2)){
						$nombre_usuario_comision=$dat2['nombres_usuario']." ".$dat2['ap_paterno_usuario']." ".$dat2['ap_materno_usuario'];
					}							
				
		?> 
<tr bgcolor="<?php if($cod_usuario_comision==2){ echo '#FFFFFF';}else{echo '#FFFF66';}?>" class="text"  title="<?php echo "De: ".$nombre_usuario_comision;?>" valign="middle">
             <td><a href="../reportes/impresionCotizacionFormato.php?cod_cotizacion=<?php echo $cod_cotizacion; ?>" target="_blank">FP</a></td>
             <td><a href="../reportes/impresionCotizacion.php?cod_cotizacion=<?php echo $cod_cotizacion; ?>" target="_blank">CF</a></td>
            <td></td>
    		<td align="right"><?php echo $nro_cotizacion."/".$gestion_nombre; ?></td>	
			<td><?php echo strftime("%d/%m/%Y",strtotime($fecha_cotizacion));?></td>	
			<td>&nbsp;</td>											    		
	        <td><?php echo "<strong>".$nombre_cliente."</strong>";
					echo "<br/><strong>Direccion:</strong>".$direccion_cliente;
					echo "<br/><strong>Telf:</strong>".$telefono_cliente." ".$celular_cliente;
			if($nombre_unidad<>""){
					echo "<br/><strong>UNIDAD:</strong>".$nombre_unidad;
					echo "<br/><strong>Direccion:</strong> ".$direccion_unidad;
					echo "<br/><strong>Telf:</strong>".$telf_unidad;
				}
				if($contacto<>""){
					echo "<br/><strong>CONTACTO:</strong> ".$contacto;
					echo "<br/><strong>Cargo:</strong> ".$cargo_contacto;					
					echo "<br/><strong>Telefono:</strong> ".$telefono_contacto." ".$celular_contacto;

				}			
			?></td>
		    <td><?php echo $nombre_tipo_pago;?></td>
            <td><?php echo $nombre_tipo_cotizacion;?></td>
            <td><?php echo $obs_cotizacion;?></td>
            <td><?php echo $nombre_estado_cotizacion;?></td>		
            <td>
			<?php if($cod_estado_cotizacion==2){?>
            	Editar
            <?php }else{?>
				<?php if($swHojasRuta==0){?>
					<a href="modificarCotizacion.php?codCotizacion=<?php echo $cod_cotizacion;?>">Editar</a>
				<?php }else{?>
					Editar
				<?php }?>
            <?php }?>
            </td>            
            <td>
			<?php if($cod_estado_cotizacion==2){?>
            Anular
            <?php }else{?>            
           		<?php if($swHojasRuta==0){?>
					<a onclick="anular(<?php echo $cod_cotizacion;?>)">Anular</a>
				<?php }else{?>
					Anular
				<?php }?>
            <?php }?>            
              </td>	
            <td>
            <a onclick="openPopup('replicarCotizacion.php?codigo=<?php echo $cod_cotizacion;?>');" title="Click para Copiar">Copiar</a></td>
            <td>
          			<?php if($cod_estado_cotizacion==2){?>
           			 Genera Hoja Ruta
            <?php }else{?>  
            
				<?php if($swHojasRuta==0){?>
					<a href="generarHojaRuta.php?cod_cotizacion=<?php echo $cod_cotizacion;?>">Genera Hoja Ruta</a>
				<?php }else{?>
					Genera Hoja Ruta
				<?php }?>
            <?php }?>
            </td>	      							
							            
   	  </tr>
<?php
		 } 
?>			
        </tbody>
        <!--<tfoot>
	    <tr height="20px" align="center"  class="bg-success">
            <th>&nbsp;</th> 
            <th>&nbsp;</th> 
            <th>&nbsp;</th> 
			<th>Nro de Cotizacion</th>
    		<th>Fecha</th>	
            <th>Usuario</th>	
			<th>Cliente</th>														
    		<th>Tipo de Pago</th>
			<th>Tipo de Cotizacion</th>	            
			<th>Observaciones</th>
            <th>Estado</th>
            <th>&nbsp;</th> 
            <th>&nbsp;</th>
            <th>&nbsp;</th> 
            <th>&nbsp;</th> 
		</tr>
	   </tfoot>-->
		</table>
		

</div>


<br>
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
<tr>
  <td><strong>Estado de Cotizacion</strong></td>
<td colspan="3">
<select name="codEstadoCotizacionB" id="codEstadoCotizacionB" class="textoform" onChange="buscar()" >
				<option value="0">Seleccione una Opcion</option>
				<?php
					$sql2="select cod_estado_cotizacion, nombre_estado_cotizacion from estados_cotizacion";
					$resp2=mysqli_query($enlaceCon,$sql2);
						while($dat2=mysqli_fetch_array($resp2))
						{
							$cod_estado_cotizacion=$dat2['cod_estado_cotizacion'];	
			  		 		$nombre_estado_cotizacion=$dat2['nombre_estado_cotizacion'];	
				 ?>
				  <option value="<?php echo $cod_estado_cotizacion;?>" <?php if($cod_estado_cotizacion==$codEstadoCotizacionB){?> selected="selected" <?php }?>><?php echo $nombre_estado_cotizacion;?></option>				
				<?php		
					}
				?>						
</select></td>
</tr>
<tr>
  <td><strong>Tipo de Cotizacion</strong></td>
<td colspan="3">
<select name="codTipoCotizacionB" id="codTipoCotizacionB" class="textoform" onChange="buscar()">
				<option value="0">Seleccione una Opcion</option>
				<?php
					$sql2="select cod_tipo_cotizacion, nombre_tipo_cotizacion from tipos_cotizacion";
					$resp2=mysqli_query($enlaceCon,$sql2);
						while($dat2=mysqli_fetch_array($resp2))
						{
							$cod_tipo_cotizacion=$dat2['cod_tipo_cotizacion'];	
			  		 		$nombre_tipo_cotizacion=$dat2['nombre_tipo_cotizacion'];	
				 ?>
				  <option value="<?php echo $cod_tipo_cotizacion;?>" <?php if($cod_tipo_cotizacion==$codTipoCotizacionB){?> selected="selected" <?php }?>><?php echo $nombre_tipo_cotizacion;?></option>				
				<?php		
					}
				?>						
</select></td>
</tr>
<tr><td><strong>Clientes</strong></td>
<td colspan="3">
 <input name="nombreClienteB" id="nombreClienteB" size="40" class="textoform" value="<?php echo $nombreClienteB; ?>" onkeyup="buscar()">
	</td>
	<td rowspan="2">&nbsp;</td>
</tr>

<tr>
<td><strong>Item</strong></td>
<td colspan="3"><input type="text" name="descItemB" id="descItemB" size="40" value="<?php echo $descItemB;?>" class="textoform" onkeyup="buscar()" ></td>
</tr>
<tr >
     		<td>&nbsp;<b>Rango de Fecha<br>
   		    (dd/mm/aaaa)</b>&nbsp;</td>			
     		<td><strong>De&nbsp;</strong>
                <input type="text" name="fechaInicioB" id="fechaInicioB" class="textoform" value="<?php echo $fechaInicioB; ?>">

        <strong>&nbsp;Hasta&nbsp;</strong>
        <input type="text" name="fechaFinalB" id="fechaFinalB" class="textoform" value="<?php echo $fechaFinalB; ?>" >

<input type="checkbox" name="codActivoFecha" id="codActivoFecha" <?php if($codActivoFecha=="on"){?>checked="checked"<?php }?> onClick="buscar()" ><strong>Chekear la casilla para buscar por fechas.</strong>
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
</form>

</body>
</html>
