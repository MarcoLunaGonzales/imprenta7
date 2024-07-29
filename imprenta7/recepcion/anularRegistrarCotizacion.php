<?php
require("conexion.inc");
include("funciones.php");

$codCotizacion=$_GET['codCotizacion'];
$sql = "update cotizaciones set COD_ESTADO_COTIZACION=2";
$sql .= " where cod_cotizacion=" .$codCotizacion. "";
mysqli_query($enlaceCon,$sql);
?>
<script language="JavaScript">				
		location.href="navegadorCotizaciones.php";
</script>
