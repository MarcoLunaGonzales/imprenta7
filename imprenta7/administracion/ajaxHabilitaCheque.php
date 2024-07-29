
<?php
require("conexion.inc");
include("funciones.php");
$numero=$_GET['numero'];
$sql=" select banco, cheque, cuenta  from forma_pago where cod_forma_pago=".$_GET['codFormaPago'];
$resp=mysqli_query($enlaceCon,$sql);
while($dat=mysqli_fetch_array($resp)){
	$banco=$dat['banco'];	
	$cheque=$dat['cheque'];
	$cuenta=$dat['cuenta'];	
}
if($cheque=='SI'){
?>

<input type="text" class="textoform"   id="nro_cheque<?php echo $numero;?>" name="nro_cheque<?php echo $numero;?>" size="12" >

<?php }?>