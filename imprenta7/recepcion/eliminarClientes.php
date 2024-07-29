<?php 
require("conexion.inc");

	$datosEliminar=$_POST['datosEliminar'];
	$vector_datos=explode(",",$datosEliminar);	
	$n=sizeof($vector_datos);
	for($i=0;$i<$n;$i++){			
		$cod_cliente=$vector_datos[$i];
		$sql=" delete from clientes where cod_cliente='".$cod_cliente."'";
		mysqli_query($enlaceCon,$sql);				
	}	
	
require("cerrar_conexion.inc");
?>
<script language="JavaScript">				
		location.href="navegadorClientes.php";
</script>
