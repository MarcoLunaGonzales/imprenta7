<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Usuarios</title>
<link rel="STYLESHEET" type="text/css" href="pagina.css" />
<script language='Javascript'>
function objetoAjax(){
	var xmlhttp=false;
	try {
		xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	} catch (e) {
		try {
		   xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		} catch (E) {
			xmlhttp = false;
  		}
	}

	if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
		xmlhttp = new XMLHttpRequest();
	}
	return xmlhttp;
}
function buscar()
{	
		var param="?";
		param+='clienteContactoB='+document.form1.clienteContactoB.value;
		param+='&nro_filas_show='+document.form1.nro_filas_show.value;	
		
		divResultado = document.getElementById('resultados');
		ajax=objetoAjax();
			ajax.open("GET",'searchClientes.php'+param);
			ajax.onreadystatechange=function() {
				if (ajax.readyState==4) {
					divResultado.innerHTML = ajax.responseText
				}
			}
				ajax.send(null)	

}


function paginar(f)
{	

		var param="?";
		param+='clienteContactoB='+document.form1.clienteContactoB.value;
		param+='&nro_filas_show='+document.form1.nro_filas_show.value;
		param+='&pagina='+document.form1.pagina1.value;
	
		divResultado = document.getElementById('resultados');
		ajax=objetoAjax();
			ajax.open("GET",'searchClientes.php'+param);
			ajax.onreadystatechange=function() {
				if (ajax.readyState==4) {
					divResultado.innerHTML = ajax.responseText
				}
			}
		ajax.send(null)	
}
function paginar1(f,pagina)
{	
		document.form1.pagina1.value=pagina*1;
		var param="?";
		param+='clienteContactoB='+document.form1.clienteContactoB.value;
		param+='&nro_filas_show='+document.form1.nro_filas_show.value;
		param+='&pagina='+document.form1.pagina1.value;
	
		divResultado = document.getElementById('resultados');
		ajax=objetoAjax();
			ajax.open("GET",'searchClientes.php'+param);
			ajax.onreadystatechange=function() {
				if (ajax.readyState==4) {
					divResultado.innerHTML = ajax.responseText
				}
			}
		ajax.send(null)	
}
function paginar2(f)
{	
		var param="?";
		param+='clienteContactoB='+document.form1.clienteContactoB.value;
		param+='&nro_filas_show='+document.form1.nro_filas_show.value;
		param+='&pagina='+document.form1.pagina2.value;
	
			divResultado = document.getElementById('resultados');
		ajax=objetoAjax();
			ajax.open("GET",'searchClientes.php'+param);
			ajax.onreadystatechange=function() {
				if (ajax.readyState==4) {
					divResultado.innerHTML = ajax.responseText
				}
			}
		ajax.send(null)
}

function registrar(f){
	f.submit();
}
function editar(cliente){

		izquierda = (screen.width) ? (screen.width-600)/2 : 100;

	    arriba = (screen.height) ? (screen.height-400)/2 : 100;

		
		url="editarCliente.php?cod_cliente="+cliente;

		opciones='toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=0,width=600,height=400,left='+izquierda+',top=' + arriba + '';

	   	window.open(url, 'popUp', opciones);
}

</script>

</head>
<body  bgcolor="#FFFFFF">
<!---Autor:Gabriela Quelali Si�ani
02 de Julio de 2008
-->
<h3 align="center" style="background:#FFF;font-size: 14px;color: #E78611;font-weight:bold;">LISTADO DE USUARIOS</h3>
<form name="form1" id="form1" method="post" >
<?php 
	require("conexion.inc");
	include("funciones.php");

?>

<table border="0" align="center">
<tr>
<td><strong>Buscar por Usuario</strong></td>
<td colspan="3"><input type="text" name="usuarioB" id="usuarioB" size="60" class="textoform" value="<?php echo $clienteContactoB;?>" onkeyup="buscar()" ></td>
</tr>
</table>
<table border="0" align="center" width="89%">
<tr><td align="right">
<div align="right"><a href="registrarCliente.php"><img src="img/clientes_nuevo.gif" border="0" width="25" height="25">[Click Nuevo Usuario]</a></div>
</td>
</tr>
</table>

<div align="center" class="text">Nro de Registros Mostrados por Pagina
	<select name="nro_filas_show" id="nro_filas_show" class="text" onchange="paginar1(this.form,1)" >
		<option value="20" <?php if($_GET['nro_filas_show']==20){ ?> selected="true"<?php }?> >20</option>
	    <option value="50" <?php if($_GET['nro_filas_show']==50){ ?> selected="true"<?php }?> >50</option>
    	<option value="100" <?php if($_GET['nro_filas_show']==100){ ?> selected="true"<?php }?> >100</option>
	    <option value="200" <?php if($_GET['nro_filas_show']==200){ ?> selected="true"<?php }?> >200</option>
    	<option value="300"<?php if($_GET['nro_filas_show']==300){ ?> selected="true"<?php }?> >300</option>
        <option value="400"<?php if($_GET['nro_filas_show']==400){ ?> selected="true"<?php }?> >400</option>
    </select>
</div>

<div id="resultados">


<?php	
	//Paginador
	if($_GET['$nro_filas_show']==""){
		$nro_filas_show=20;
	}
	$pagina = $_GET['pagina'];

	if ($pagina == ""){
		$pagina = 1;
		$fila_inicio=0;
		$fila_final=$nro_filas_show;
	}else{
		$fila_inicio=(($pagina*$nro_filas_show)-$nro_filas_show);
		$fila_final=($fila_inicio+$nro_filas_show);
	}	
	
		$sql=" select count(*) ";
		$sql.=" from usuarios ";
		if($_GET['usuarioB']<>""){
		$sql.="where CONCAT(ap_paterno_usuario,' ',ap_materno_usuario,' ',nombres_pila,' ',nombres_usuario,' ',nombres_usuario2) like '%".$_GET['usuarioB']."%'";
		}
		$resp_aux = mysqli_query($enlaceCon,$sql);
		while($dat_aux=mysqli_fetch_array($resp_aux)){
			$nro_filas_sql=$dat_aux[0];
		}
		if($nro_filas_sql==0){
?>
	<table width="80%" align="center" cellpadding="1" cellspacing="1" bgColor="#cccccc">
	    <tr height="20px" align="center"  class="titulo_tabla">
    		<td>Usuario</td>
    		<td>CI</td>
    		<td>Ciudad</td>
    		<td>Telf</td>
    		<td>Area</td>
    		<td>Cargo</td>
    		<td>Grado</td>
            <td>User</td>			
    		<td>Password</td>					
    		<td>Estado</td>			
    		<td>Modulos</td>	
            <td>Usuario Interno</td>
            <td>Autorizado Firma Cotizacion</td>	             										
		</tr>
		<tr><th colspan="13" class="fila_par" align="center">&iexcl;No existen Registros!</th></tr>
	</table>
	
<?php	
	}else{
		//Calculo de Nro de Paginas
			$nropaginas=1;
			if($nro_filas_sql<$nro_filas_show){
				$nropaginas=1;
			}else{
				$nropag_aux=round($nro_filas_sql/$nro_filas_show);

				if($nro_filas_sql>($nropag_aux*$nro_filas_show)){
					$nropaginas=$nropag_aux+1;
				}else{
					$nropaginas=$nropag_aux;
				}
			}					
		//Fin de calculo de paginas
		$sql=" select cod_usuario, cod_area, cod_cargo, cod_grado, usuario, contrasenia,  ";
		$sql.=" nombres_usuario,nombres_usuario2, nombres_pila,  ap_paterno_usuario, ap_materno_usuario, ";
		$sql.=" ci_usuario,cod_ciudad, telf_usuario, email_usuario, cod_estado_registro, usuario_interno, cod_perfil ";
		$sql.=" from usuarios  ";
		if($_GET['usuarioB']<>""){
		$sql.="where CONCAT(ap_paterno_usuario,' ',ap_materno_usuario,' ',nombres_pila,' ',nombres_usuario,' ',nombres_usuario2) like '%".$_GET['usuarioB']."%'";
		}		
		$sql.=" order by ap_paterno_usuario asc, ap_materno_usuario asc, nombres_pila asc,nombres_usuario asc ";
		$sql.=" limit ".$fila_inicio." , ".$nro_filas_show;
		$resp = mysqli_query($enlaceCon,$sql);

?>	
<h3 align="center" style="background:#FFF;font-size: 10px;color: #000;font-weight:bold;">Total Registro:<?php echo $nro_filas_sql;?></h3>
	<table width="89%" align="center" cellpadding="1" cellspacing="1" bgColor="#CCCCCC">
    <tr bgcolor="#FFFFFF" align="center">
    			<td colSpan="13">
						<p align="center">						
						<b><?php if($pagina>1){ ?>
							<a href="#" onclick="paginar1(form1,<?php echo $pagina-1; ?>)" ><--Anterior</a>
							<?php }?>
						</b>
						<b> Pagina <?php echo $pagina; ?> de <?php echo $nropaginas; ?> </b>
						<b><?php if($nropaginas>$pagina){ ?> 
							<a href="#" onclick="paginar1(form1,<?php echo $pagina+1; ?>)" >Siguiente--></a>
						<?php }?></b>
						</p>
                        <?php if($nropaginas>1){ ?>
                      <p align="center">				
						Ir a Pagina<input type="text" name="pagina1" class="texto" id="pagina1" size="5" value="<?php echo $pagina;?>" onkeypress="return validar(event)"><input  type="button" size="8"  value="Ir" onClick="paginar(this.form)"  >	
				  </p>
						<?php }?>
</td>
			</tr>    
	    <tr height="20px" align="center"  class="titulo_tabla">
    		<td>Usuario</td>
    		<td>CI</td>
    		<td>Ciudad</td>
    		<td>Telf</td>
    		<td>Area</td>
    		<td>Cargo</td>
    		<td>Grado</td>
            <td>User</td>			
    		<td>Password</td>					
    		<td>Estado</td>			
    		<td>Modulos</td>
            <td>Usuario Interno</td>
            <td> Firma Cotizacion</td>	        															
		</tr>

<?php   
	$cont=0;
		while($dat=mysqli_fetch_array($resp)){	
		
			$cod_usuario=$dat['cod_usuario'];
			$cod_area=$dat['cod_area'];
			$cod_cargo=$dat['cod_cargo'];
			$cod_grado=$dat['cod_grado'];
			$usuario=$dat['usuario'];
			$contrasenia=$dat['contrasenia'];
			$nombres_usuario=$dat['nombres_usuario'];
			$nombres_usuario2=$dat['nombres_usuario2'];
			$nombres_pila=$dat['nombres_pila'];
			$ap_paterno_usuario=$dat['ap_paterno_usuario'];
			$ap_materno_usuario=$dat['ap_materno_usuario'];
			$ci_usuario=$dat['ci_usuario'];
			$cod_ciudad=$dat['cod_ciudad'];
			$telf_usuario=$dat['telf_usuario'];
			$email_usuario=$dat['email_usuario'];
			$cod_estado_registro=$dat['cod_estado_registro'];
			$usuario_interno=$dat['usuario_interno'];
			$cod_perfil=$dat['cod_perfil'];

			//**************************************************************
				$desc_ciudad="";				
				$sql2="select desc_ciudad from ciudades where cod_ciudad='".$cod_ciudad."'";	
				$resp2= mysqli_query($enlaceCon,$sql2);
				while($dat2=mysqli_fetch_array($resp2)){
					$desc_ciudad=$dat2['desc_ciudad'];
				}	
				$nombre_area="";				
				$sql2="select nombre_area from areas where cod_area='".$cod_area."'";	
				$resp2= mysqli_query($enlaceCon,$sql2);
				while($dat2=mysqli_fetch_array($resp2)){
					$nombre_area=$dat2['nombre_area'];
				}	
				$desc_cargo="";				
				$sql2="select desc_cargo from cargos where cod_cargo='".$cod_cargo."'";	
				$resp2= mysqli_query($enlaceCon,$sql2);
				while($dat2=mysqli_fetch_array($resp2)){
					$desc_cargo=$dat2['desc_cargo'];
				}	
				$desc_grado="";				
				$sql2="select desc_grado from grado_academico where cod_grado='".$cod_grado."'";	
				$resp2= mysqli_query($enlaceCon,$sql2);
				while($dat2=mysqli_fetch_array($resp2)){
					$desc_grado=$dat2['desc_grado'];
				}	
				
			$nombre_estado_registro="";				
			$sql2="select nombre_estado_registro from estados_referenciales where cod_estado_registro='".$cod_estado_registro."'";	
			$resp2= mysqli_query($enlaceCon,$sql2);
			while($dat2=mysqli_fetch_array($resp2)){
				$nombre_estado_registro=$dat2['nombre_estado_registro'];
			}													
			//**************************************************************
			$autorizadoFirmaCotizacion="";				
			$sql2="select count(*) from autorizados_firma_cotizacion";
			$sql2.=" where cod_usuario='".$cod_usuario."'";	
			$resp2= mysqli_query($enlaceCon,$sql2);
			while($dat2=mysqli_fetch_array($resp2)){
					$var=$dat2[0];
			}	
			if($var>0){
					$autorizadoFirmaCotizacion="OK";
			}								
													

				
?> 

		<tr bgcolor="#FFFFFF" class="text">	
			<td><?php echo $ap_paterno_usuario." ".$ap_materno_usuario." ".$nombres_usuario." ".$nombres_usuario2;?></td>		
    		<td><?php echo $ci_usuario;?></td>
            <td><?php echo $desc_ciudad;?></td>
             <td><?php echo $telf_usuario;?></td>
            <td><?php echo $nombre_area;?></td>
            <td><?php echo $desc_cargo;?></td>
            <td><?php echo $desc_grado;?></td>
            <td><?php echo $usuario;?></td>
            <td><?php echo $contrasenia;?></td>
            <td><?php echo $nombre_estado_registro;?></td>
            <td>
	            <table border="0" cellspacing="1" cellpadding="1">
			<?php 
				$sql2=" select  um.cod_modulo, m.nombre_modulo ";
				$sql2.=" from usuarios_modulos um, modulos m ";
				$sql2.=" where um.cod_usuario=".$cod_usuario;
				$sql2.=" and um.cod_modulo=m.cod_modulo";
				$resp2= mysqli_query($enlaceCon,$sql2);
				while($dat2=mysqli_fetch_array($resp2)){
					$cod_modulo=$dat2['cod_modulo'];
					$nombre_modulo=$dat2['nombre_modulo'];
			?>
            	<tr><td><?php echo $nombre_modulo;?></td></tr>
            <?php
				}
 
			
			?>
            </table>
            </td>
			<td>&nbsp;</td>
            <td><?php echo $autorizadoFirmaCotizacion;?></td>

         </tr>


<?php

		}
?>
				
	<tr bgcolor="#FFFFFF" align="center">
    			<td colSpan="13">
						<p align="center">						
						<b><?php if($pagina>1){ ?>
							<a href="#" onclick="paginar(form1,<?php echo $pagina-1; ?>)" ><--Anterior</a>
							<?php }?>
						</b>
						<b> Pagina <?php echo $pagina; ?> de <?php echo $nropaginas; ?> </b>
						<b><?php if($nropaginas>$pagina){ ?> 
							<a href="#" onclick="paginar1(form1,<?php echo $pagina+1; ?>)">Siguiente--></a>
						<?php }?></b>
						</p>
                        <?php if($nropaginas>1){ ?>
						<p align="center">				
						Ir a Pagina<input type="text" name="pagina2" size="5"  class="texto" id="pagina2" value="<?php echo $pagina;?>" onkeypress="return validar(event)"><input  type="button" size="8"  value="Ir" onClick="paginar2(this.form)">	</p>
                         <?php } ?>		
</td>
			</tr>
		</table>

<?php
	}
?>
	
</div> 	
<?php require("cerrar_conexion.inc");
?>


</form>
</body>
</html>
