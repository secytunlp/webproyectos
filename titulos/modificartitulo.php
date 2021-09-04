<?php
include '../includes/include.php';
require '../includes/chequeo.php';
include '../includes/datosSession.php';

if (PermisoQuery::permisosDeUsuario( $cd_usuario, "Modificar titulo" )) {
	
	$xtpl = new XTemplate ( 'modificartitulo.html' );
	
	include APP_PATH.'includes/cargarmenu.php';
	
	if (isset ( $_GET ['cd_titulo'] )) {
		$cd_titulo = $_GET ['cd_titulo'];
		$oTitulo = new Titulo ( );
		$oTitulo->setCd_titulo ( $cd_titulo );
		TituloQuery::getTituloPorId ( $oTitulo );
		$xtpl->assign ( 'ds_titulo',  ( htmlspecialchars($oTitulo->getDs_titulo()) ) );
		$xtpl->assign ( 'ds_universidad',  ( htmlspecialchars($oTitulo->getDs_universidad()) ) );
		$xtpl->assign ( 'cd_titulo',  ( $oTitulo->getCd_titulo() ) );
		$xtpl->assign ( 'cd_universidad',  ( $oTitulo->getCd_universidad() ) );
		$selectedGrado = ($oTitulo->getNu_nivel()==1)?' Selected="selected"':'';
		$selectedPosgrado = ($oTitulo->getNu_nivel()==2)?' Selected="selected"':'';
		$xtpl->assign ( 'selectedGrado',  $selectedGrado );
		$xtpl->assign ( 'selectedPosgrado',  $selectedPosgrado );
	}
	
	if (isset ( $_GET ['er'] )) {
		if ($_GET ['er'] == 1) {
			$xtpl->assign ( 'classMsj', 'msjerror' );
			
			$msj = "Error: No se han modificado los datos del titulo";
			$xtpl->assign ( 'msj', 'onLoad ="mensajeError(\''.$msj.'\')"' );
		}
	} else {
		$xtpl->assign ( 'classMsj', '' );
		$xtpl->assign ( 'msj', '' );
	}
	$xtpl->parse ( 'main.msj' );
	
	$xtpl->assign ( 'titulo', 'SeCyT - Modificar t&iacute;tulo' );
	
	
	
	$xtpl->parse ( 'main' );
	$xtpl->out ( 'main' );
} else
	header ( 'Location:../includes/accesodenegado.php' );
?>