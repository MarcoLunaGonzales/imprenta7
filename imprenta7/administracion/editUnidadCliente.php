<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>

<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<script language='Javascript'>
	function guardar(f)
	{	
			if(f.nombre_unidad.value==""){
			 	alert('El campo Unidad se encuentra vacio.'); 
			 	f.nombre_unidad.focus();
		 	 	return(false);
			}	
			if(f.direccion_unidad.value==""){
			 	alert('El campo Direccion se encuentra vacio.'); 
			 	f.direccion_unidad.focus();
		 	 	return(false);
			}			
		
			if(confirm("¿Esta seguro de guardar los datos?")){
					f.submit();
			}

	}	
	
	function cancelar(f)
	{	
			window.location="listUnidadesClientes.php?cod_cliente="+f.cod_cliente.value;
	}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body bgcolor="#FFFFFF">
<!---Autor:Gabriela Quelali Siñani
	02 de Julio de 2008
-->
<form   method="post" action="saveEditUnidadCliente.php">
<input type="hidden" name="cod_unidad" id="cod_unidad" value="<?php echo $_GET['cod_unidad'];?>">
<?php 	require("conexion.inc");



	$sql=" select  cod_cliente, nombre_unidad, direccion_unidad, telf_unidad ";
	$sql.=" from clientes_unidades ";
	$sql.=" where  cod_unidad=".$_GET['cod_unidad'];
	$resp= mysql_query($sql);
	
	while($dat=mysql_fetch_array($resp)){	
		
		$cod_cliente=$dat['cod_cliente'];
		$nombre_unidad=$dat['nombre_unidad'];
		$direccion_unidad=$dat['direccion_unidad'];
		$telf_unidad=$dat['telf_unidad'];
					
	}
	
	$sql2="select nombre_cliente from clientes where cod_cliente=".$cod_cliente;
	$resp2= mysql_query($sql2);
	while($dat2=mysql_fetch_array($resp2)){
		$nombre_cliente=$dat2[0];
	}	


?>
<input type="hidden" name="cod_cliente" id="cod_cliente" value="<?php echo $cod_cliente;?>">
<h3 align="center" style="background:white;font-size: 14px;color:#E78611;font-weight:bold;">EDICION DE DATOS DE UNIDAD <br/> CLIENTE:<?PHP echo $nombre_cliente;?></h3>


	<table align="center"class="text" cellSpacing="1" cellPadding="4" width="60%" bgColor="#cccccc" border="0">
		 <tr class="titulo_tabla">
		   <td  colSpan="2" align="center">FORMULARIO DE REGISTRO </td>
		 </tr>
		 <tr bgcolor="#FFFFFF">
     		<td>Unidad</td>
      		<td><input type="text"  class="textoform" size="55" name="nombre_unidad" id="nombre_unidad" value="<?php echo $nombre_unidad; ?>" ></td>
    	</tr>
		 <tr bgcolor="#FFFFFF">
     		<td>Direccion</td>
      		<td><input type="text"  class="textoform" size="55" value="<?php echo $direccion_unidad;?>" name="direccion_unidad" id="direccion_unidad" ></td>
    	</tr>		
				<tr bgcolor="#FFFFFF">
     		<td>Telefono</td>
      		<td><input type="text"  class="textoform" size="55" name="telf_unidad" id="telf_unidad" value="<?php echo $telf_unidad;?>" ></td>
    	</tr>			
		
	</table>	

<br>
<div align="center">
	<input type="button" class="boton" name="btn_guardar" value="GUARDAR CAMBIOS" onClick="guardar(this.form);"  >
	<input type="reset"  class="boton"  name="btn_cancelar" value="IR A LISTADO DE UNIDADES" onClick="cancelar(this.form)"  >
</div>
</form>
<?php require("cerrar_conexion.inc");
?>

</body>
</html>

