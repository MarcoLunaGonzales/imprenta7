<?php
require("conexion.inc");
include("funciones.php");

$nombre_cliente=$_POST['nombre_cliente'];
$nit_cliente=$_POST['nit_cliente'];
$cod_categoria=$_POST['cod_categoria'];
$cod_ciudad=$_POST['cod_ciudad'];
$direccion_cliente=$_POST['direccion_cliente'];
$telefono_cliente=$_POST['telefono_cliente'];
$celular_cliente=$_POST['celular_cliente'];
$fax_cliente=$_POST['fax_cliente'];
$email_cliente=$_POST['email_cliente'];
//$obs_cliente=$_POST['obs_cliente'];
$cod_usuario_registro=$_POST['cod_usuario_registro'];
$fecha_registro=$_POST['fecha_registro'];
$cod_usuario_modifica=$_POST['cod_usuario_modifica'];
$fecha_modifica=$_POST['fecha_modifica'];
$cod_estado_registro=$_POST['cod_estado_registro'];

$cod_estado_registro=1;

$sql=" select max(cod_cliente) from clientes ";
$cod_cliente=obtenerCodigo($sql);

$sql="insert into clientes set ";
$sql.=" cod_cliente='".$cod_cliente."',"; 
$sql.=" nombre_cliente='".htmlentities($nombre_cliente)."',"; 
$sql.=" nit_cliente='".$nit_cliente."',";
$sql.=" cod_categoria='".$cod_categoria."',";
$sql.=" cod_ciudad='".$cod_ciudad."',";
$sql.=" direccion_cliente='".htmlentities($direccion_cliente)."',";
$sql.=" telefono_cliente='".$telefono_cliente."',";
$sql.=" celular_cliente='".$celular_cliente."',";
$sql.=" fax_cliente='".$fax_cliente."',";
$sql.=" email_cliente='".$email_cliente."',";
$sql.=" cod_usuario_comision='".$_POST['cod_usuario_comision']."',";
$sql.=" cod_usuario_registro=".$_COOKIE['usuario_global'].",";
$sql.=" fecha_registro='".date('Y-m-d', time())."',";
$sql.=" cod_estado_registro='".$cod_estado_registro."'";
$resp=mysqli_query($enlaceCon,$sql);
require("cerrar_conexion.inc");


?>
<script language="JavaScript">
			//url="ajax_listaClientes.php?cod_cliente=<?php echo $cod_cliente;?>";
			window.close();
			window.opener.setClientes('<?php echo $cod_cliente;?>','<?php echo $nombre_cliente;?>','<?php echo $_POST['cod_usuario_comision'];?>');
</script> 