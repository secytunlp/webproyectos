<?php
include '../includes/include.php';
require '../includes/chequeo.php';
include '../includes/datosSession.php';

//verifico si tiene permiso para la acción
if (PermisoQuery::permisosDeUsuario( $cd_usuario, "Baja titulo" )) {
	
	$oTitulo = new Titulo ( );
	
	if (isset ( $_GET ['cd_titulo'] )) {
		$cd_titulo = $_GET ['cd_titulo'];
		if (!DocenteQuery::tieneAsignadoDocentes($cd_titulo)) {
			$oTitulo->setCd_titulo ( $cd_titulo );
			TituloQuery::getTituloPorId($oTitulo);
			$exito = TituloQuery::eliminarTitulo ( $oTitulo );
			if (!TituloQuery::tieneAsignadoTitulos($oTitulo->getCd_universidad())) {
				$oUniversidad = new Universidad();
				$oUniversidad->setCd_universidad($oTitulo->getCd_universidad());
				$exito = UniversidadQuery::eliminarUniversidad ( $oUniversidad );
			}
			$oFuncion = new Funcion();
			$oFuncion -> setDs_funcion("Baja titulo");
			FuncionQuery::getFuncionPorDs($oFuncion);
			$oMovimiento = new Movimiento();
			$oMovimiento->setCd_funcion($oFuncion->getCd_funcion());
			$oMovimiento->setCd_usuario($cd_usuario);
			$oMovimiento->setDs_movimiento('Titulo: '.$oTitulo->getCd_titulo());
			MovimientoQuery::insertarMovimiento($oMovimiento);
		}
		else {header ( 'Location:index.php?er=2' ); exit;}
		if ($exito)
			header ( 'Location: index.php' ); else
			header ( 'Location:index.php?er=1' );
	}
} else {
	header ( 'Location:../includes/accesodenegado.php' );
}
?>