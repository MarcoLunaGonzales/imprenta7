<?php 
	require("conexion.inc");
	include("funciones.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>INVENTA</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<script language='Javascript'>
	function cancelar(f){
			window.location="listGastoOrdenTrabajo.php?cod_orden_trabajo="+f.cod_orden_trabajo.value;
	}
function validaFloat(numero)
{
  if (!/^([0-9])*[.]?[0-9]*$/.test(numero))
   alert("El valor " + numero + " no es un n�mero");
}
	function guardar(f){
		
		if(f.cod_proveedor.value==0){
				alert("Seleecione el Proveedor.")
				f.cod_proveedor.focus();
			 	return(false);	
		
		}
		if(f.fecha_gasto.value==""){
				alert("El campo Fecha de Gasto se encuentra vacio.")
				f.fecha_gasto.focus();
			 	return(false);	
		
		}
		if(f.monto_gasto.value==""){
				alert("El campo Monto se encuentra vacio.")
				f.monto_gasto.focus();
			 	return(false);			
		}
		f.submit();
	}
	
function nuevoAjax()
{	var xmlhttp=false;
 		try {
 			xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	 	} catch (e) {
 			try {
 				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
 			} catch (E) {
 				xmlhttp = false;
 			}
	  	}
		if (!xmlhttp && typeof XMLHttpRequest!="undefined") {
 			xmlhttp = new XMLHttpRequest();
		}
		return xmlhttp;
}
function cargar_proveedor_ajax(url)
{	var div_proveedor;
		div_proveedor=document.getElementById("div_proveedor");
		ajax=nuevoAjax();
		ajax.open("GET", url,true);
		ajax.onreadystatechange=function()
		{
			if (ajax.readyState==4) {
			div_proveedor.innerHTML=ajax.responseText;
			}
		}
		ajax.send(null)
}	
function cargar_proveedor()
{			
		izquierda = (screen.width) ? (screen.width-600)/2 : 100 
	    arriba = (screen.height) ? (screen.height-400)/2 : 100 
		url="registrarProveedorAjax.php";
		opciones='toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=0,width=600,height=650,left='+izquierda+',top=' + arriba + '' 
	   	window.open(url, 'popUp', opciones);
}	
function datosProveedor(f)
{	 

		var cod_proveedor=document.getElementById("cod_proveedor").value;
		cod_proveedor=cod_proveedor*1;
		if(cod_proveedor!=0){
		
			izquierda = (screen.width) ? (screen.width-600)/2 : 100 
		    arriba = (screen.height) ? (screen.height-400)/2 : 100 
			url="datosProveedorAjax.php?cod_proveedor="+cod_proveedor;
			opciones='toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=0,width=600,height=650,left='+izquierda+',top=' + arriba + '' 
		   	window.open(url, 'popUp', opciones)
			
		}else{
			alert("Seleccione un Proveedor");
			
		}
}	

function cargar_contactoProveedor()
{			
		izquierda = (screen.width) ? (screen.width-600)/2 : 100 
	    arriba = (screen.height) ? (screen.height-400)/2 : 100 
		url="registrarContactoProveedorAjax.php?cod_proveedor="+document.getElementById("cod_proveedor").value;
		opciones='toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=0,width=500,height=400,left='+izquierda+',top=' + arriba + '' 
	   	window.open(url, 'popUp', opciones);
}	
function datosContactoProveedor(f)
{	 

		var cod_contacto_proveedor=document.getElementById("cod_contacto_proveedor").value;
		cod_contacto_proveedor=cod_contacto_proveedor*1;
		if(cod_contacto_proveedor!=0){
		
			izquierda = (screen.width) ? (screen.width-600)/2 : 100 
		    arriba = (screen.height) ? (screen.height-400)/2 : 100 
			url="datosContactoProveedorAjax.php?cod_contacto_proveedor="+cod_contacto_proveedor;
			opciones='toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=0,width=500,height=400,left='+izquierda+',top=' + arriba + '' 
		   	window.open(url, 'popUp', opciones)
			
		}else{
			alert("Seleccione un contacto");
			
		}
}	
function cargar_contactoProveedor_ajax(url)
{	var div_contactoProveedor;
		div_contactoProveedor=document.getElementById("div_contactoProveedor");
		ajax=nuevoAjax();
		ajax.open("GET", url,true);
		ajax.onreadystatechange=function()
		{
			if (ajax.readyState==4) {
			div_contactoProveedor.innerHTML=ajax.responseText;
			}
		}
		ajax.send(null)
}	
function listaContactosProveedor(f)
{	

		var div_contactoProveedor,cod_proveedor;
		div_contactoProveedor=document.getElementById("div_contactoProveedor");			
		cod_proveedor=f.cod_proveedor.value;	
		ajax=nuevoAjax();

	
		ajax.open("GET","ajax_listContactosProveedor.php?cod_proveedor="+cod_proveedor,true);				
		ajax.onreadystatechange=function(){
			if (ajax.readyState==4) {
			div_contactoProveedor.innerHTML=ajax.responseText;
		    }
	    }		
		ajax.send(null)
		
}

</script></head>
<body bgcolor="#FFFFFF" onload="document.form1.recibo_gasto.focus()">
<!---Autor:Gabriela Quelali Si�ani
02 de Julio de 2008
-->


<form name="form1" id="form1" method="post" action="saveEditGastoOrdenTrabajo.php">


<input type="hidden" name="cod_orden_trabajo" id="cod_orden_trabajo" value="<?php echo $_GET['cod_orden_trabajo'];?>">
<input type="hidden" name="cod_gasto_ordentrabajo" id="cod_gasto_ordentrabajo" value="<?php echo $_GET['cod_gasto_ordentrabajo'];?>">
 <?php
$sql=" select nro_orden_trabajo, numero_orden_trabajo, cod_gestion, fecha_orden_trabajo, cod_cliente,";	
		$sql.="  cod_contacto, monto_orden_trabajo,detalle_orden_trabajo,";
		$sql.=" incremento_orden_trabajo, incremento_fecha, incremento_obs,";
		$sql.=" descuento_orden_trabajo, descuento_fecha, descuento_obs ";
		$sql.=" from ordentrabajo";
		$sql.=" where cod_orden_trabajo=".$_GET['cod_orden_trabajo'];
		$resp = mysqli_query($enlaceCon,$sql);
		while($dat=mysqli_fetch_array($resp)){

			$nro_orden_trabajo=$dat['nro_orden_trabajo'];
			$numero_orden_trabajo=$dat['numero_orden_trabajo'];
			$cod_gestion=$dat['cod_gestion'];
			$fecha_orden_trabajo=$dat['fecha_orden_trabajo'];
			$cod_cliente=$dat['cod_cliente'];
			$cod_contacto=$dat['cod_contacto'];
 			$monto_orden_trabajo=$dat['monto_orden_trabajo'];
			$detalle_orden_trabajo=$dat['detalle_orden_trabajo'];
			$incremento_orden_trabajo=$dat['incremento_orden_trabajo'];
			$incremento_fecha=$dat['incremento_fecha'];
			$incremento_obs=$dat['incremento_obs'];
			$descuento_orden_trabajo=$dat['descuento_orden_trabajo'];
			$descuento_fecha=$dat['descuento_fecha'];
			$descuento_obs=$dat['descuento_obs'];

			    $sql2="  select gestion from gestiones ";
				$sql2.=" where cod_gestion=".$cod_gestion;
				$resp2= mysqli_query($enlaceCon,$sql2);
				$gestion="";
				while($dat2=mysqli_fetch_array($resp2)){
					$gestion=$dat2['gestion'];
				}
				

			    $sql2="  select nombre_cliente from clientes ";
				$sql2.=" where cod_cliente=".$cod_cliente;
				$resp2= mysqli_query($enlaceCon,$sql2);
				$nombre_cliente="";
				while($dat2=mysqli_fetch_array($resp2)){
					$nombre_cliente=$dat2['nombre_cliente'];
				}
				if($cod_contacto<>"" and $cod_contacto<>0){
				    $sql2="  select nombre_contacto, ap_paterno_contacto, ap_materno_contacto ";
					$sql2.=" from clientes_contactos ";
					$sql2.=" where cod_contacto=".$cod_contacto;
					$resp2= mysqli_query($enlaceCon,$sql2);
					$nombre_completo_contacto="";
					while($dat2=mysqli_fetch_array($resp2)){
						$nombre_completo_contacto=$dat2['nombre_contacto']." ".$dat2['ap_paterno_contacto']." ".$dat2['ap_materno_contacto'];

					}
				}
	 	}
?>
<h3 align="center" style="background:#FFF;font-size: 14px;color: #E78611;font-weight:bold;">GASTOS DE ORDEN DE TRABAJO<?php echo " Nro. ".$nro_orden_trabajo."/".$gestion." (".$numero_orden_trabajo.")"; ?></br> CLIENTE: <?php echo $nombre_cliente;
if($nombre_completo_contacto<>""){
	echo " (Contacto:".$nombre_completo_contacto.")";
	}
?></h3>
<div align="center"><a href="../reportes/impresionOrdenTrabajo.php?cod_orden_trabajo=<?php echo $_GET['cod_orden_trabajo']; ?>" target="_blank">VER ORDEN DE TRABAJO</a></div>
<?php

$sql=" select cod_gasto, cod_orden_trabajo, descripcion_gasto, monto_gasto, cant_gasto,";
$sql.=" fecha_gasto, cod_proveedor, cod_contacto_proveedor, recibo_gasto, cod_usuario_registro,";
$sql.=" fecha_registro, cod_usuario_modifica, fecha_modifica";
$sql.=" from gastos_ordentrabajo";
$sql.=" where cod_gasto_ordentrabajo=".$_GET['cod_gasto_ordentrabajo'];

		$resp = mysqli_query($enlaceCon,$sql);
		while($dat=mysqli_fetch_array($resp)){

			$cogasto=$dat['cod_gasto'];
			$cod_orden_trabajo=$dat['cod_orden_trabajo'];
			$descripcion_gasto=$dat['descripcion_gasto'];
			$monto_gasto=$dat['monto_gasto'];
			$cant_gasto=$dat['cant_gasto'];
			$fecha_gasto=$dat['fecha_gasto'];
			$codproveedor=$dat['cod_proveedor'];
			$codcontactoproveedor=$dat['cod_contacto_proveedor'];
			$recibo_gasto=$dat['recibo_gasto'];
			$cod_usuario_registro=$dat['cod_usuario_registro'];
			$fecha_registro=$dat['fecha_registro'];
			$cod_usuario_modifica=$dat['cod_usuario_modifica'];
			$fecha_modifica=$dat['fecha_modifica'];
		}


?>
    <table align="center"class="text" cellSpacing="1" cellPadding="4" width="70%" bgColor="#cccccc" border="0">
		<tbody>
		 <tr class="titulo_tabla">
		   <td  colSpan="2" align="center">Introduzca Datos</td>
		 </tr>
	
		 <tr bgcolor="#FFFFFF">
     		<td align="left">Nro Recibo</td>
      		<td align="left"><input type="text"  class="textoform" size="50" name="recibo_gasto" id="recibo_gasto" value="<?php echo $recibo_gasto; ?>"  ></td>
    	</tr>
		 <tr bgcolor="#FFFFFF">
     		<td>Fecha de Gasto</td>
      		<td align="left" class="textoform"><input type="text"  class="textoform" size="50" name="fecha_gasto" id="fecha_gasto" value="<?php echo strftime("%d/%m/%Y",strtotime($fecha_gasto));?>"  />
(dd/mm/aaaa)</td>
    	</tr>        
		 <tr bgcolor="#FFFFFF">
     		<td>Proveedor</td>
      		<td align="left"><div id="div_proveedor">
         <select class="textoform" name="cod_proveedor" id="cod_proveedor" onChange="listaContactosProveedor(this.form)">
            <option value="0">Seleccion un Proveedor</option>
            <?php
            	$sql2="select cod_proveedor, nombre_proveedor";
            	$sql2.=" from proveedores ";
            	$sql2.=" order by nombre_proveedor asc ";
				$resp2 = mysqli_query($enlaceCon,$sql2);
				while($dat2=mysqli_fetch_array($resp2)){
					$cod_proveedor=$dat2['cod_proveedor'];
					$nombre_proveedor=$dat2['nombre_proveedor'];
			?>
            	<option value="<?php echo $cod_proveedor;?>" <?php if($cod_proveedor==$codproveedor){?> selected="true" <?php }?>><?php echo $nombre_proveedor; ?></option>
            <?php
				}				

			?>
            </select> <a  href="javascript:cargar_proveedor();">[ Nuevo Proveedor]</a>
			&nbsp;<a  href="javascript:datosProveedor(this.form);">[Editar Datos de Proveedor]</a></div>
            </td>
    	</tr>     
<tr bgcolor="#FFFFFF">
  <td align="left">Contacto Proveedor</td>
  <td><div id="div_contactoProveedor"><select name="cod_contacto_proveedor" id="cod_contacto_proveedor" class="textoform" >
				<option value="0">------------</option>
				<?php
					$sql2=" select cod_contacto_proveedor,nombre_contacto, ap_paterno_contacto, ap_materno_contacto  ";
					$sql2.=" from proveedores_contactos";
					$sql2.=" where cod_proveedor=".$codproveedor;
					$sql2.=" order by  ap_paterno_contacto asc, ap_materno_contacto asc , nombre_contacto asc ";
					$resp2=mysqli_query($enlaceCon,$sql2);
						while($dat2=mysqli_fetch_array($resp2))
						{
							$cod_contacto_proveedor=$dat2['cod_contacto_proveedor'];
							$nombre_contacto=$dat2['nombre_contacto'];
							$ap_paterno_contacto=$dat2['ap_paterno_contacto'];
							$ap_materno_contacto=$dat2['ap_materno_contacto'];

				 ?>
				 <?php if($cod_contacto_proveedor==$codcontactoproveedor){?>
					 <option value="<?php echo $cod_contacto_proveedor;?>" selected="selected"><?php echo $ap_paterno_contacto." ".$nombre_contacto;?></option>		
				 <?php }else{?>
 					 <option value="<?php echo $cod_contacto_proveedor;?>"><?php echo $ap_paterno_contacto." ".$nombre_contacto;?></option>		
				 <?php }?>		
				<?php		
					}
				?>						
			</select>
			<a  href="javascript:cargar_contactoProveedor();">[ Nuevo Contacto]</a>
			&nbsp;<a  href="javascript:datosContactoProveedor(this.form)"> [Datos Contacto]</a>
</div></td></tr>         
		<tr bgcolor="#FFFFFF">
     		<td>Gasto</td>
      		<td align="left"><select class="textoform" name="cod_gasto" id="cod_gasto">
            <?php
            	$sql2="select cod_gasto, desc_gasto";
            	$sql2.=" from gastos ";
            	$sql2.=" order by desc_gasto asc ";
				$resp2 = mysqli_query($enlaceCon,$sql2);
				while($dat2=mysqli_fetch_array($resp2)){
					$cod_gasto=$dat2['cod_gasto'];
					$desc_gasto=$dat2['desc_gasto'];
			?>
            	<option value="<?php echo $cod_gasto;?>"<?php if($cod_gasto==$codgasto){?> selected="true"<?php }?> ><?php echo $desc_gasto; ?></option>
            <?php
				}				

			?>
            </select></td>
    	</tr>		
		 <tr bgcolor="#FFFFFF">
     		<td>Descripcion</td>
      		<td align="left">
            <textarea id="descripcion_gasto" name="descripcion_gasto" class="textoform" cols="50" rows="3"><?php echo $descripcion_gasto; ?></textarea></td>
    	</tr> 
		 <tr bgcolor="#FFFFFF">
     		<td>Cantidad</td>
      		<td align="left"><input type="text"  class="textoform" size="25" name="cant_gasto"  id="cant_gasto" value="<?php echo $cant_gasto;?>"/></td>
    	</tr> 
		 <tr bgcolor="#FFFFFF">
     		<td>Monto de Gasto</td>
      		<td align="left"><input type="text"  class="textoform" size="25" name="monto_gasto" id="monto_gasto" onKeyUp="validaFloat(this.value)" onChange="validaFloat(this.value)" value="<?php echo $monto_gasto; ?>" /></td>
    	</tr>                 										
		</tbody>
	</table>

	<br>
<div align="center">
<INPUT type="button"  class="boton"  name="btn_atras" value="IR  ATRAS" onClick="cancelar(this.form);"  >
<INPUT type="button" class="boton" name="btn_guardar" onclick="guardar(this.form)" value="GUARDAR"  >

</div>
<?php require("cerrar_conexion.inc");
?>


</form>
</body>
</html>
