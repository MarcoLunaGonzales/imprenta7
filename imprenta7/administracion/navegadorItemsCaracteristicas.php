<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Items</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<script language='Javascript'>


function paginar(f)
{	
	location.href="navegadorItems.php?pagina="+f.pagina.value;
		
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
			window.location="editar_empresa?cod_empresa="+cod_registro;
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
			window.location ="lista_eliminar_empresas.php?datos="+datos;			
	}
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<!---Autor:Gabriela Quelali Si�ani
02 de Julio de 2008
-->
<h3 align="center" style="background:white;font-size: 14px;color: #d20000;font-weight:bold;">CARACTERISTICAS</h3>
<form name="form1" method="post" action="registrarCliente.php" >
<?php 
	require("conexion.inc");
	include("funciones.php");

?>


<?php	
	//Paginador
	$nro_filas_show=10;	
	$pagina = $_GET['pagina'];

	if ($pagina == ""){
		$pagina = 1;
		$fila_inicio=0;
		$fila_final=$nro_filas_show;
	}else{
		$fila_inicio=(($pagina*$nro_filas_show)-$nro_filas_show);
		$fila_final=($fila_inicio+$nro_filas_show);
	}	
	
	$sql_aux=" select count(*) from items ";
	$resp_aux = mysqli_query($enlaceCon,$sql_aux);
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
		$sql=" select cod_item, desc_item, cod_estado_registro  ";
		$sql.=" from items ";
		$sql.=" order by desc_item asc  ";
		//$sql.=" limit ".$fila_inicio." , ".$fila_final;
		$resp = mysqli_query($enlaceCon,$sql);

?>	
	<table width="70%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc" class="tablaReporte" style="width:100% !important;">
		<thead>
	    <tr height="20px" align="center"  class="bg-success text-white">
			<th>&nbsp;</th>
    		<th>Item</th>
    		<th>Estado de Registro</th>
			<th>Caracteristicas</th>																			
		</tr>
		</thead>
		<tbody>

<?php   
		while($dat=mysqli_fetch_array($resp)){	
		
				$cod_item=$dat[0];
				$desc_item=$dat[1]; 
				$cod_estado_registro=$dat[2];
								//**************************************************************
					$nombre_estado_registro="";				
					$sql2="select nombre_estado_registro from estados_referenciales";
					$sql2.=" where cod_estado_registro='".$cod_estado_registro."'";	
					$resp2= mysqli_query($enlaceCon,$sql2);
					while($dat2=mysqli_fetch_array($resp2)){
						$nombre_estado_registro=$dat2[0];
					}	
				//**************************************************************							
							

				
?> 
		<tr bgcolor="#FFFFFF" valign="middle">	
			<td><input type="checkbox"name="cod_cliente"value="<?php echo $cod_cliente;?>"></td>					
    		<td><?php echo $desc_item;?></td>
    		<td><?php echo $nombre_estado_registro;?></td>
    		<td><ul>
			<?php
					$sql2="select cod_carac from items_caracteristicas where cod_item='".$cod_item."'";
					$resp2= mysqli_query($enlaceCon,$sql2);
					while($dat2=mysqli_fetch_array($resp2)){
						$cod_carac=$dat2[0];
						$sql3="select desc_carac from caracteristicas where cod_carac='".$cod_carac."'";
						$resp3= mysqli_query($enlaceCon,$sql3);
						while($dat3=mysqli_fetch_array($resp3)){
							$desc_carac=$dat3[0];
			?>						
							<li><?php echo $desc_carac;?></li>
			<?php			}
						
					}
			?></ul>
			</td>						
    	 </tr>
<?php
		 } 
?>			

			</tbody>
		</table>
		</div>			
		
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
