<?php

header("Cache-Control: no-store, no-cache, must-revalidate");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
</head>

<body>


<?php


require("conexion.inc");




		$sql=" select count(*) ";
		$sql.=" from clientes ";
		if($_GET['nombreClienteB']<>""){
			$sql.=" where nombre_cliente LIKE '%".$_GET['nombreClienteB']."%'";
		}
		$sql.=" order by nombre_cliente asc ";

		$resp = mysql_query($sql);
		$numRows=0;
		while($dat=mysql_fetch_array($resp)){
			$numRows=$dat[0];			
		}
		if($numRows==0){
			
		?>
	<table width="98%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">
	    <tr height="20px" align="center"  class="titulo_tabla">
			  <td>Cliente</td>
              <td>Direccion</td>
              <td>Telf.</td>
              <td>Fax</td>
              <td>Celular</td>	   																		
		</tr>
		<tr bgcolor="#FFFFFF" align="center" ><th colspan="5">No Existen registros</th></tr>
        </table>        
        <?php
		}else{
		?>

<h3 align="center" style="background:#F7F5F3;font-size: 10px;color: #E78611;font-weight:bold;"><?php echo "Nro de Registros :".$numRows;?></h3>
<?php

			$sql=" select  cod_cliente, nombre_cliente,direccion_cliente, ";
			$sql.=" telefono_cliente, celular_cliente, fax_cliente  ";
			$sql.=" from clientes ";
			if($_GET['nombreClienteB']<>""){
				$sql.=" where nombre_cliente LIKE '%".$_GET['nombreClienteB']."%'";
			}
			$sql.=" order by nombre_cliente asc ";
			$resp = mysql_query($sql);

?>	
	<table width="98%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">
	    <tr height="20px" align="center"  class="titulo_tabla">
			  <td>Cliente</td>
              <td>Direccion</td>
              <td>Telf.</td>
              <td>Fax</td>
              <td>Celular</td>	
              <td>Contactos</td>																			
		</tr>

<?php   
	$cont=0;
		while($dat=mysql_fetch_array($resp)){	

				$cod_cliente=$dat['cod_cliente']; 
				$nombre_cliente=$dat['nombre_cliente']; 
				$direccion_cliente=$dat['direccion_cliente'];
				$telefono_cliente=$dat['telefono_cliente'];
				$celular_cliente=$dat['celular_cliente'];
				$fax_cliente=$dat['fax_cliente'];
											

?> 
		<tr bgcolor="#FFFFFF">	
			<td align="left"><a href="javascript:enviarDatos('<?php echo $cod_cliente;?>','<?php echo $nombre_cliente;?>')"><?php echo $nombre_cliente;?></a></td>
			<td align="left"><?php echo $direccion_cliente;?></td>					
    		<td align="left"><?php echo $telefono_cliente;?></td>
			<td align="left"><?php echo $fax_cliente;?></td>
			<td align="left"><?php echo $celular_cliente;?></td>	
<td>
            	<table border="0"c cellpadding="0" cellspacing="1">
				<?php
	          	$sqlAux=" select cod_contacto, nombre_contacto, ap_paterno_contacto, ap_materno_contacto, cargo_contacto,";
				$sqlAux.=" telefono_contacto, celular_contacto";
				$sqlAux.=" from clientes_contactos ";
				$sqlAux.=" where cod_cliente=".$cod_cliente;
				$sqlAux.=" order by ap_paterno_contacto, ap_materno_contacto, nombre_contacto asc ";
				$respAux= mysql_query($sqlAux);
				while($datAux=mysql_fetch_array($respAux)){
					$cod_contacto=$datAux['cod_contacto'];
					$nombre_contacto=$datAux['nombre_contacto'];
					$ap_paterno_contacto=$datAux['ap_paterno_contacto'];
					$ap_materno_contacto=$datAux['ap_materno_contacto'];
					$cargo_contacto=$datAux['cargo_contacto'];
					$telefono_contacto=$datAux['telefono_contacto'];
					$celular_contacto=$datAux['celular_contacto'];
				?>
                <tr class="text">
                <td><?php echo $ap_paterno_contacto." ".$nombre_contacto;?></td>
                <td><?php echo $cargo_contacto;?></td>
                <td><?php echo $telefono_contacto." ".$celular_contacto;?></td>
                </tr>
                <?php
				}	
				
			?>
            </table>
            </td>            		

    	 </tr>
<?php
		 } 
?>			


</table>
<?php
		 } 
?>

</body>
</html>


