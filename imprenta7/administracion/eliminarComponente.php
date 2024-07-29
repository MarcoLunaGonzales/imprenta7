<?php 
require("conexion.inc");

	$datosEliminar=$_POST['datosEliminar'];
	$codItemF=$_POST['codItemF'];	
	$vector_datos=explode(",",$datosEliminar);	
	$n=sizeof($vector_datos);
	for($i=0;$i<$n;$i++){			
		$cod_item=$vector_datos[$i];
		$sql=" delete from componentes_caracteristica where cod_compitem='".$cod_item."'";
		mysqli_query($enlaceCon,$sql);
		$sql=" delete from componente_items where cod_compitem=".$cod_item." and cod_item=".$codItemF;
		mysqli_query($enlaceCon,$sql);
	}	
	
require("cerrar_conexion.inc");
?>
<script language="JavaScript">				
		location.href="navegadorItems.php";
</script>
