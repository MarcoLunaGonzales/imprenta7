<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Eliminaci�n de Unidades de Medida</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<script language='Javascript'>
	function eliminar(f){
		f.submit();
	}
	
	function cancelar(f){
					window.location="navegadorUnidadesMedida.php";
	}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<!---Autor:Gabriela Quelali Si�ani
02 de Julio de 2008
-->
<form name="form1" method="post" action="eliminarUnidadesMedida.php">
<?php 

	require("conexion.inc");
	include("funciones.php");	
	$datos=$_GET["datos"];	

	
?>
<input type="hidden" name="datos" value="<?php echo $datos; ?>">
	<h3 align="center" style="background:white;font-size: 14px;color: #E78611;font-weight:bold;">Confirmacion de Eliminacion de Unidades de Medida </h3>


    <?php

		$datosEliminar="";
		$datosNoEliminar="";
		$vector_datos=explode(",",$datos);	
		$n=sizeof($vector_datos);
		for($i=0;$i<$n;$i++){	
		
				$cod_unidad_medida=$vector_datos[$i];
				$sw=0;			
				$sql=" select  *  from materiales  where cod_unidad_medida='".$cod_unidad_medida."'";	
					
				$resp= mysqli_query($enlaceCon,$sql);
				while($dat=mysqli_fetch_array($resp)){
					$sw=1;
				}
				
				if($sw==0){
					/****************************/
						if($datosEliminar<>""){
							$datosEliminar=$datosEliminar.",".$cod_unidad_medida;
						}else{
							$datosEliminar=$cod_unidad_medida;
						}
					/****************************/
				}else{
					/***************************/
						if($datosNoEliminar<>""){
							$datosNoEliminar=$datosNoEliminar.",".$cod_unidad_medida;
						}else{
							$datosNoEliminar=$cod_unidad_medida;
						}
					/**************************/		
				}
									
		}
						
?>
<?php if($datosNoEliminar<>""){?>
<h3 align="center" style="background:white;font-size: 11px;color:#E78611;">Registros que no pueden ser Elimandos</h3>
	<table width="80%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">
	   	<tr height="20px" align="center"  class="titulo_tabla">
    		<td>Unidad de Medida</td>
    		<td>Abreviarura</td>	
    		<td>Estado</td>				
		</tr>
		<?php
			$vectordatosNoEliminar=explode(",",$datosNoEliminar);	
			$num=sizeof($vectordatosNoEliminar);
			for($j=0;$j<$num;$j++){	
				$cod_unidad_medida=$vectordatosNoEliminar[$j];
				$sql="select nombre_unidad_medida, abrev_unidad_medida, cod_estado_registro";
				$sql.=" from unidades_medidas ";	
				$sql.=" where cod_unidad_medida='".$cod_unidad_medida."'";
			
				$resp = mysqli_query($enlaceCon,$sql);
				while($dat=mysqli_fetch_array($resp)){	
		
					$nombre_unidad_medida=$dat[0];
					$abrev_unidad_medida=$dat[1];
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
			}				
	
		?>		
			<tr bgcolor="#FFFFFF">
    		<td><?php echo $nombre_unidad_medida;?></td>
    		<td><?php echo $abrev_unidad_medida;?></td>
    		<td><?php echo $nombre_estado_registro;?></td>
	    	 </tr>
		<?php
			}
		?>
	 </table>
<?php }?>
<br>

<?php if($datosEliminar<>""){?>
<h3 align="center" style="background:white;font-size: 11px;color:#E78611;">Registros que pueden ser Elimandos</h3>
	<table width="80%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">
	   	<tr height="20px" align="center"  class="titulo_tabla">
    		<td>Unidad de Medida</td>
    		<td>Abreviarura</td>	
    		<td>Estado</td>	
		</tr>
		<?php
			$vectordatosEliminar=explode(",",$datosEliminar);	
			$num=sizeof($vectordatosEliminar);
			for($j=0;$j<$num;$j++){	
				$cod_unidad_medida=$vectordatosEliminar[$j];
				$sql="select nombre_unidad_medida, abrev_unidad_medida, cod_estado_registro";
				$sql.=" from unidades_medidas ";	
				$sql.=" where cod_unidad_medida='".$cod_unidad_medida."'";
				$resp = mysqli_query($enlaceCon,$sql);
				while($dat=mysqli_fetch_array($resp)){	
						
						$nombre_unidad_medida=$dat[0];
						$abrev_unidad_medida=$dat[1];
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

			}					
		?>
		<tr bgcolor="#FFFFFF">		
    		<td><?php echo $nombre_unidad_medida;?></td>
    		<td><?php echo $abrev_unidad_medida;?></td>
    		<td><?php echo $nombre_estado_registro;?></td>
	    	 </tr>
		<?php
			}
		?>
	 </table>
<?php }?>
</div>			

<br>
<input type="hidden" name="datosEliminar" value="<?php echo $datosEliminar;?>">
<div align="center">

<INPUT type="button" class="boton" name="btn_eliminar"  value="Confirmar Eliminaci�n" onClick="eliminar(this.form);">
<INPUT type="button" class="boton" name="btn_eliminar"  value="Cancelar" onClick="cancelar(this.form);">

</div>
		
<?php require("cerrar_conexion.inc");
?>


</form>
</body>
</html>
