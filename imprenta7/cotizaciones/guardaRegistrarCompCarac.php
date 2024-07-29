<?php
require("conexion.inc");
include("funciones.php");
$codItemF=$_POST['codItemF'];
$codCompItemF=$_POST['codCompItemF'];

$resp=mysqli_query($enlaceCon,$sql);
	$datos=$_POST['datos'];
	$vector_datos=explode(",",$datos);	
	$n=sizeof($vector_datos);
	for($i=0;$i<$n;$i++){			
		$cod_carac=$vector_datos[$i];
		$sql=" insert into componentes_caracteristica set";
		$sql.="  cod_compitem='".$codCompItemF."',";
		$sql.="  cod_carac='".$cod_carac."'";
		mysqli_query($enlaceCon,$sql);				
	}	
require("cerrar_conexion.inc");
?>
<script language="JavaScript">
location.href="navegadorCompCarac.php?codItem="+<?php echo $codItemF;?>+"&codComp="+<?php echo $codCompItemF;?>;
</script>