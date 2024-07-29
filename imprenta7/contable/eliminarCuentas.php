<?php 
require("conexion.inc");

		

	$sql=" delete from cuentas where cod_cuenta='".$_POST['cod_cuenta']."'";
	mysqli_query($enlaceCon,$sql);				

	
require("cerrar_conexion.inc");
?>
<script language="JavaScript">				
		location.href="listCuentas.php";
</script>
