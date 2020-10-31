<?php 
require_once 'conexiones/conexionpedidos.php';

//****************************************************
//*************************************************** 




//***************************************************
//***************************************************

function desconexionpedidos(){

    global $conexionpedidos ;
    mysqli_close($conexionpedidos);
}    

//***************************************************
//***************************************************

function ObtenerNombreUsuario($idusuario)
{

	global $database_conexionpedidos, $conexionpedidos;

	mysqli_select_db($database_conexionpedidos, $conexionpedidos);
	$query_ConsultaFuncion = sprintf("SELECT strNombre FROM tblusuario WHERE idUsuario = %s", $idusuario);
	$ConsultaFuncion = mysqli_query($query_ConsultaFuncion, $conexionpedidos) or die(mysqli_error());
	$row_ConsultaFuncion = mysqli_fetch_assoc($ConsultaFuncion);
	$totalRows_ConsultaFuncion = mysqli_num_rows($ConsultaFuncion);
	
	return $row_ConsultaFuncion['strNombre']; 
	mysqli_free_result($ConsultaFuncion);
}





?>