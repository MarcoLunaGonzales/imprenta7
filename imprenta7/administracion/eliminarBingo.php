<?php
require("conexion.inc");
include("funciones.php");

$sql=" delete from bingo_detalle ";
mysqli_query($enlaceCon,$sql);
$sql=" delete from bingo ";
mysqli_query($enlaceCon,$sql);

require("cerrar_conexion.inc");
?>
<script language="JavaScript">
location.href="listBingo.php";
</script>