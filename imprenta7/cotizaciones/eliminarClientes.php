<?php 
require("conexion.inc");

		

	$sql=" delete from clientes where cod_cliente='".$_POST['cod_cliente']."'";
	mysqli_query($enlaceCon,$sql);				

	
require("cerrar_conexion.inc");
?>
<script language="JavaScript">				
		location.href="navegadorClientes.php?clienteContactoB=<?php echo $_POST['nombre_cliente'];?>";
</script>
