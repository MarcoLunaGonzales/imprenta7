<?php 
require("conexion.inc");

	$datosEliminar=$_POST['datosEliminar'];
	$vector_datos=explode(",",$datosEliminar);	
	$n=sizeof($vector_datos);
	for($i=0;$i<$n;$i++){			
		$cod_cargo=$vector_datos[$i];
		$sql=" delete from cargos where cod_cargo='".$cod_cargo."'";
		mysqli_query($enlaceCon,$sql);				
	}	
	
require("cerrar_conexion.inc");
?>
<script language="JavaScript">				
		location.href="navegador_cargos.php";
</script>
