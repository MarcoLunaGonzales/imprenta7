<?php
require("conexion.inc");
include("funciones.php");






$sql="update  proveedores_contactos set ";
$sql.=" nombre_contacto='".$_POST['nombre_contacto']."',";
$sql.=" ap_paterno_contacto='".$_POST['ap_paterno_contacto']."',";
$sql.=" ap_materno_contacto='".$_POST['ap_materno_contacto']."',";

$sql.=" telefono_contacto='".$_POST['telefono_contacto']."',";
$sql.=" celular_contacto='".$_POST['celular_contacto']."',";

$sql.=" email_contacto='".$_POST['email_contacto']."',";
$sql.=" cargo_contacto='".$_POST['cargo_contacto']."',";
$sql.=" cod_usuario_modifica=".$_COOKIE['usuario_global'].",";
$sql.=" fecha_modifica='".date('Y-m-d', time())."',";
$sql.=" cod_estado_registro='".$_POST['cod_estado_registro']."'";
$sql.=" where cod_contacto_proveedor='".$_POST['cod_contacto_proveedor']."'"; 
$resp=mysqli_query($enlaceCon,$sql);
require("cerrar_conexion.inc");

?>
<script language="JavaScript">
	location.href="listContactosProveedor.php?cod_proveedor=<?php echo $_POST['cod_proveedor'];?>";
</script> 