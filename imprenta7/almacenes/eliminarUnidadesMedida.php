<?php 
require("conexion.inc");

	$datosEliminar=$_POST['datosEliminar'];
	$vector_datos=explode(",",$datosEliminar);	
	$n=sizeof($vector_datos);
	for($i=0;$i<$n;$i++){			
		$cod_unidad_medida=$vector_datos[$i];
		$sql=" delete from unidades_medida where cod_unidad_medida='".$cod_unidad_medida."'";
		mysql_query($sql);				
	}	
	
require("cerrar_conexion.inc");
?>
<script language="JavaScript">				
		location.href="navegadorUnidadesMedida.php";
</script>