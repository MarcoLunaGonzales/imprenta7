<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Registro de Grado Academico</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<script language='Javascript'>
	function guardar(f)
	{	
		if(f.nombre_grado.value==""){
			alert("El campo Grado Academico se encuentra vacio.")
			f.nombre_grado.focus();
		 	return(false);
			
		}
		f.submit();
	}	
	function cancelar(){
			window.location="navegador_grados.php";
	}

</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<!---Autor:Gabriela Quelali Si�ani
	02 de Julio de 2008
-->
<form   method="post" action="guarda_registrar_grado.php">
<?php 
	require("conexion.inc");
	$cod_estado_registro=1;
	$sql2=" select nombre_estado_registro from estados_referenciales where cod_estado_registro='".$cod_estado_registro."'";
    $resp2 = mysql_query($sql2);	
	$nombre_estado_registro="";
	$dat2=mysql_fetch_array($resp2);
	$nombre_estado_registro=$dat2[0];

?>
<h3 align="center" style="background:white;font-size: 14px;color: #d20000;font-weight:bold;">Registro de Grado Academico</h3>


	<table align="center"class="text" cellSpacing="1" cellPadding="4" width="60%" bgColor="#cccccc" border="0">
		<tbody>
		 <tr class="titulo_tabla">
		   <td  colSpan="2" align="center">Introduzca Datos</td>
		 </tr>
	
		 <tr bgcolor="#FFFFFF">
     		<td>Grado Academico</td>
      		<td><input type="text"  class="textoform" size="50" name="nombre_grado" ></td>
    	</tr>
		 <tr bgcolor="#FFFFFF">
     		<td>Abreviatura</td>
      		<td><input type="text"  class="textoform" size="50" name="abrev_grado" ></td>
    	</tr>
		<tr bgcolor="#FFFFFF">
     		<td>Estado de Registro</td>
      		<td><?php echo $nombre_estado_registro;?></td>
    	</tr>		
										
		</tbody>
	</table>	
	<br>
<div align="center">
<INPUT type="button" class="boton" name="btn_guardar" value="Guardar" onClick="guardar(this.form);"  >
<INPUT type="button"  class="boton"  name="btn_limpiar" value="Cancelar" onClick="cancelar();"  >
</div>
</form>
<?php require("cerrar_conexion.inc");?>

</body>
</html>
