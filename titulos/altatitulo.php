<?php
include '../includes/include.php';
require '../includes/chequeo.php';
include '../includes/datosSession.php';


if (PermisoQuery::permisosDeUsuario( $cd_usuario, "Alta titulo" )) {
	//include APP_PATH . 'includes/menu.php';
	$xtpl = new XTemplate ( 'altatitulo.html' );
	
	include APP_PATH.'includes/cargarmenu.php';
	
	if (isset ( $_GET ['er'] )) {
		if ($_GET ['er'] == 1) {
			$xtpl->assign ( 'classMsj', 'msjerror' );
			$msj = "Error: El titulo no se ha dado de alta. Ya existe";
			$xtpl->assign ( 'msj', 'onLoad ="mensajeError(\''.$msj.'\')"' );
		}
	} else {
		$xtpl->assign ( 'classMsj', '' );
		$xtpl->assign ( 'msj', '' );
	}
	$xtpl->parse ( 'main.msj' );
	
	$xtpl->assign ( 'titulo', 'SeCyT - Alta t&iacute;tulo' );
	
	
	
	$xtpl->parse ( 'main' );
	$xtpl->out ( 'main' );
}
else 
	header('Location:../includes/accesodenegado.php');
?>