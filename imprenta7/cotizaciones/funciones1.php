<?php
//require("conexion.inc");
/**
 * Funciones 
 * Autor: Gabriela Quelali Si�ani
 * @version $Id$
 * @copyright 2008 
 **/
function obtenerCodigo($sql)
{	require("conexion1.inc");
	$resp=mysqli_query($enlaceCon,$sql);
	$nro_filas_sql = mysqli_num_rows($resp);
	if($nro_filas_sql==0){
		$codigo=1;
	}else{
		while($dat=mysqli_fetch_array($resp))
		{	$codigo =$dat[0];
		}
			$codigo = $codigo+1;
	}
	return($codigo);
}

function ultimoDiaMes($mes,$anio) 
{ 
  for ($dia=28;$dia<=31;$dia++) 
     if(checkdate($mes,$dia,$anio)) $fecha="$dia/$mes/$anio"; 
    return $fecha; 
} 

?>