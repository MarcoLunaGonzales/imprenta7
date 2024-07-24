<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta name="tipo_contenido"  content="text/html;" http-equiv="content-type" charset="utf-8">
<title>Tipos de Pago</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<script language='Javascript'>

function paginar(f)
{	
var param="?nombretipopagoB="+f.nombretipopagoB.value;
	param+="&pagina="+f.pagina.value;
		location.href='navegadorTiposPago.php'+param;		
}
function paginar1(f,pagina)
{		

		f.pagina.value=pagina*1;
var param="?nombretipopagoB="+f.nombretipopagoB.value;
	param+="&pagina="+f.pagina.value;
		location.href='navegadorTiposPago.php'+param;	
}

function buscar(f){

var param="?nombretipopagoB="+f.nombretipopagoB.value;
	param+="&pagina="+f.pagina.value;
		location.href='navegadorTiposPago.php'+param;

}

function registrar(f){
	f.submit();
}
function editar(f)
{	
	var i;
	var j=0;
	var cod_registro;
	for(i=0;i<=f.length-1;i++)
	{
		if(f.elements[i].type=='checkbox')
		{	if(f.elements[i].checked==true)
			{	cod_registro=f.elements[i].value;
				j=j+1;
			}
		}
	}
	if(j>1)
	{	alert('Debe seleccionar solamente un registro para modificar.');
	}
	else
	{
		if(j==0)
		{
			alert('Debe seleccionar un registro para modificar.');
		}
		else
		{
			window.location="editarTipoPago.php?cod_tipo_pago="+cod_registro;
		}
	}
}


function eliminar(f)
{
	var i;
	var j=0;
	datos=new Array();
	for(i=0;i<=f.length-1;i++)
	{
		if(f.elements[i].type=='checkbox')
		{	if(f.elements[i].checked==true)
			{	datos[j]=f.elements[i].value;
				j=j+1;
			}
		}
	}
	if(j==0)
	{	alert('Debe seleccionar al menos un registro para eliminarlo.');
		return(false);
	}
	else
	{
			window.location ="listaEliminarTiposPago.php?datos="+datos;			
	}
}
</script></head>
<body bgcolor="#F7F5F3">
<!---Autor:Gabriela Quelali Siñani
02 de Julio de 2008
-->
<h3 align="center" style="background:#F7F5F3;font-size: 14px;color: #E78611;font-weight:bold;"> TIPOS DE PAGO </h3>
<form name="form1" method="post" action="registrarTipoPago.php">
<?php 
	require("conexion.inc");
	include("funciones.php");
	$nombretipopagoB=$_GET['nombretipopagoB'];

?>

<table border="0" align="center">
<tr>
<td><strong>Tipo de Pago </strong></td>
<td colspan="3"><input type="text" name="nombretipopagoB" id="nombretipopagoB" size="30" class="textoform" value="<?php echo $nombretipopagoB;?>" ></td>
<td rowspan="2"><a  onClick="buscar(form1)"><img src="images/buscar_header.jpg" border="0" alt="Buscar"></a></td>
</tr>
</table>



<?php	
	//Paginador
	$nro_filas_show=50;	
	$pagina = $_GET['pagina'];

	if ($pagina == ""){
		$pagina = 1;
		$fila_inicio=0;
		$fila_final=$nro_filas_show;
	}else{
		$fila_inicio=(($pagina*$nro_filas_show)-$nro_filas_show);
		$fila_final=($fila_inicio+$nro_filas_show);
	}	
	

	
	$sql_aux=" select count(*) from tipos_pago";
	if($nombretipopagoB<>""){
		$sql_aux.=" where nombre_tipo_pago like '%".$nombretipopagoB."%'";
	}
	$resp_aux = mysql_query($sql_aux);
	while($dat_aux=mysql_fetch_array($resp_aux)){
		$nro_filas_sql=$dat_aux[0];
	}
	if($nro_filas_sql==0){
?>
	<table width="80%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">
	    <tr height="20px" align="center"  class="titulo_tabla">
    		<td>Tipo de Cotizaci&oacute;n</td>
			<td>Observaciones</td>				
    		<td>Estado</td>			
    		<td>Registro</td>
			<td>Ultima Edici&oacute;n</td>											
		</tr>
		<tr><th colspan="11" class="fila_par" align="center">&iexcl;No existen Registros!</th></tr>
	</table>
	
<?php	
	}else{
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
		$sql=" select cod_tipo_pago, nombre_tipo_pago, obs_tipo_pago, cod_estado_registro, ";
		$sql.=" cod_usuario_registro, fecha_registro, cod_usuario_modifica, fecha_modifica ";
		$sql.=" from tipos_pago ";
		
		if($nombretipopagoB<>""){
			$sql.=" where nombre_tipo_pago like '%".$nombretipopagoB."%'";
		}		
		$sql.=" order by nombre_tipo_pago asc ";
		$sql.=" limit ".$fila_inicio." , ".$nro_filas_show;
		$resp = mysql_query($sql);

?>	
	<table width="80%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">
	    <tr height="20px" align="center"  class="titulo_tabla">
			<td>&nbsp;</td>
    		<td>Tipo de Pago</td>
			<td>Obsservaciones</td>				
    		<td>Estado</td>			
    		<td>Registro</td>
			<td>Ultima Edici&oacute;n</td>																		
		</tr>

<?php   
	$cont=0;
		while($dat=mysql_fetch_array($resp)){	

				$cod_tipo_pago=$dat[0];
				$nombre_tipo_pago=$dat[1];
				$obs_tipo_pago=$dat[2];
				$cod_estado_registro=$dat[3];
				$cod_usuario_registro=$dat[4];
				$fecha_registro=$dat[5];
				$fechaRegistroFormato="";
				if($fecha_registro<>""){
				$fechaRegistroVector=explode(" ",$fecha_registro);
				$fechaRegistroVector2=explode("-",$fechaRegistroVector[0]);
				$fechaRegistroFormato=$fechaRegistroVector2[2]."/".$fechaRegistroVector2[1]."/".$fechaRegistroVector2[0]." ".$fechaRegistroVector[1];
				}				
				$cod_usuario_modifica=$dat[6];
				$fecha_modifica=$dat[7];
				$fechaModificaFormato="";
				if($fecha_modifica<>""){
					$fechaModificaVector=explode(" ",$fecha_modifica);
					$fechaModificaVector2=explode("-",$fechaModificaVector[0]);
					$fechaModificaFormato=$fechaModificaVector2[2]."/".$fechaModificaVector2[1]."/".$fechaModificaVector2[0]." ".$fechaModificaVector[1];
				}					
				
						

				//**************************************************************
					$nombre_estado_registro="";				
					$sql2="select nombre_estado_registro from estados_referenciales";
					$sql2.=" where cod_estado_registro='".$cod_estado_registro."'";	
					$resp2= mysql_query($sql2);
					while($dat2=mysql_fetch_array($resp2)){
						$nombre_estado_registro=$dat2[0];
					}	
				//**************************************************************	
				//******************************USUARIO REGISTRO********************************
					$usuarioRegistro="";				
					$sql2=" select nombres_usuario, ap_paterno_usuario, ap_materno_usuario from usuarios";
					$sql2.=" where cod_usuario='".$cod_usuario_registro."'";	
					$resp2= mysql_query($sql2);
					$dat2=mysql_fetch_array($resp2);
					$usuarioRegistro=substr($dat2[0],0).substr($dat2[1],0).substr($dat2[2],0);
				//*******************************FIN USUARIO REGISTRO*******************************									
				
				//******************************USUARIO MODIFICA********************************
					$usuarioModifica="";				
					$sql2=" select nombres_usuario, ap_paterno_usuario, ap_materno_usuario from usuarios";
					$sql2.=" where cod_usuario='".$cod_usuario_modifica."'";	
					$resp2= mysql_query($sql2);
					$dat2=mysql_fetch_array($resp2);
					$usuarioModifica=substr($dat2[0],0).substr($dat2[1],0).substr($dat2[2],0);
				//*******************************FIN USUARIO MODIFICA*******************************										
							

				
?> 
		<tr bgcolor="#FFFFFF">	
			<td><input type="checkbox"name="cod_tipo_pago"value="<?php echo $cod_tipo_pago;?>"></td>	
    		<td><?php echo $nombre_tipo_pago;?></td>
    		<td><?php echo $obs_tipo_pago;?></td>
    		<td><?php echo $nombre_estado_registro; ?></td>
			<td><?php echo $usuarioRegistro." ".$fechaRegistroFormato;?></td>
    		<td><?php echo $usuarioModifica." ".$fechaModificaFormato;?></td>			
   	  </tr>
<?php
		 } 
?>			
  			<tr bgcolor="#FFFFFF" align="center">
    			<td colSpan="13">
						<p align="center">						
						<b><?php if($pagina>1){ ?>
							<a href="#" onclick="paginar1(form1,<?php echo $pagina-1; ?>)"><--Anterior</a>
							<?php }?>
						</b>
						<b> Pagina <?php echo $pagina; ?> de <?php echo $nropaginas; ?> </b>
						<b><?php if($nropaginas>$pagina){ ?> 
							<a href="#" onclick="paginar1(form1,<?php echo $pagina+1; ?>)">Siguiente--></a>
						<?php }?></b>
						</p>
						<p align="center">				
						Ir a Pagina<input type="text" name="pagina"  id="pagina" size="5"><input  type="button" size="8"  value="Go" onClick="paginar(this.form)">												
				</td>
			</tr>
  </TABLE>
		</div>			
<?php
	}
?>
		
<?php require("cerrar_conexion.inc");
?>
<br>
<div align="center">
	<INPUT type="button" class="boton" name="btn_editar"  value="Registrar" onClick="registrar(this.form);">
	<INPUT type="button" class="boton" name="btn_eliminar"  value="Editar" onClick="editar(this.form);">	
	<INPUT type="button" class="boton" name="btn_eliminar"  value="Eliminar" onClick="eliminar(this.form);">
</div>

</form>
</body>
</html>
