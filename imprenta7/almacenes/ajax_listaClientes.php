<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>

<link rel="STYLESHEET" type="text/css" href="pagina.css" />

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<!---Autor:Gabriela Quelali Si�ani
	02 de Octubre de 2008
-->

<?php require("conexion.inc");
$codcliente=$_GET['cod_cliente'];
?>

			
			<select name="cod_cliente" id="cod_cliente" class="textoform" >
				<option value="0">Seleccione un Cliente</option>
				<?php
					$sql2="select cod_cliente,nombre_cliente from clientes order by  nombre_cliente asc";
					$resp2=mysqli_query($enlaceCon,$sql2);
						while($dat2=mysqli_fetch_array($resp2))
						{
							$cod_cliente=$dat2[0];	
			  		 		$nombre_cliente=$dat2[1];	
				 ?>
				 <?php if($codcliente==$cod_cliente){?>
					 <option value="<?php echo $cod_cliente;?>" selected="selected"><?php echo $nombre_cliente;?></option>		
				 <?php }else{?>
 					 <option value="<?php echo $cod_cliente;?>"><?php echo $nombre_cliente;?></option>		
				 <?php }?>		
				<?php		
					}
				?>						
			</select>
			<a  href="javascript:cargar_cliente();">[ Nuevo Cliente]</a>
			&nbsp;<a  href="javascript:datosCliente(this.form)"> [Datos Cliente]</a>
</body>
</html>
