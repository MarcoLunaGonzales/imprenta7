<?php 
require("conexion.inc");

	$datosEliminar=$_POST['datosEliminar'];
	$vector_datos=explode(",",$datosEliminar);	
	$n=sizeof($vector_datos);
	for($i=0;$i<$n;$i++){			
		$cod_almacen=$vector_datos[$i];
		$sql=" delete from almacenes where cod_almacen='".$cod_almacen."'";
		mysqli_query($enlaceCon,$sql);				
	}	
	
require("cerrar_conexion.inc");
?>
<script language="JavaScript">				
		location.href="navegadorAlmacenes.php";
</script>
