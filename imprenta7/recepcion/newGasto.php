<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>MODULO DE ADMINISTRACI&Oacute;N</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<script language='Javascript'>
	function guardar(f)
	{	
		if(f.desc_gasto.value==""){
			alert("El campo Gasto se encuentra vacio.")
			f.desc_gasto.focus();
		 	return(false);
			
		}
		f.submit();
	}	


</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<!---Autor:Gabriela Quelali Si�ani
	02 de Julio de 2008
-->
<form   method="post" action="saveGasto.php">
<?php 
	require("conexion.inc");
	$cod_estado_registro=1;
	$sql2=" select nombre_estado_registro from estados_referenciales where cod_estado_registro='".$cod_estado_registro."'";
    $resp2 = mysqli_query($enlaceCon,$sql2);	
	$nombre_estado_registro="";
	$dat2=mysqli_fetch_array($resp2);
	$nombre_estado_registro=$dat2[0];

?>
<h3 align="center" style="background:#FFF;font-size: 14px;color: #E78611;font-weight:bold;">Registro de Gasto</h3>


	<table align="center"class="text" cellSpacing="1" cellPadding="4" width="70%" bgColor="#cccccc" border="0">
		<tbody>
		 <tr class="titulo_tabla">
		   <td  colSpan="2" align="center">Introduzca Datos</td>
		 </tr>
	
		 <tr bgcolor="#FFFFFF">
     		<td>Gasto</td>
      		<td><input type="text"  class="textoform" size="50" name="desc_gasto" ></td>
    	</tr>
		 <tr bgcolor="#FFFFFF">
     		<td>Observaciones</td>
      		<td><textarea name="obs_gasto" id="obs_gasto" class="textoform" cols="50"></textarea></td>
    	</tr>        

		<tr bgcolor="#FFFFFF">
     		<td>Estado de Registro</td>
      		<td><?php echo $nombre_estado_registro;?></td>
    	</tr>		
										
		</tbody>
	</table>	
	<br>
<div align="center">
<input type="button" class="boton" name="btn_guardar" value="Guardar Registro" onClick="guardar(this.form);"  >
<input type="reset"  class="boton"  name="btn_limpiar" value="Limpiar" >
<input type="reset"  class="boton"  name="btn_cancelar" value="Cancelar" onClick="javascript:history.back(-1);">
</div>
</form>
<?php require("cerrar_conexion.inc");?>

</body>
</html>
