<?php
include '../includes/include.php';
require '../includes/chequeo.php';
include '../includes/datosSession.php';

//verifico si tiene permiso para la acción
if (PermisoQuery::permisosDeUsuario( $cd_usuario, "Baja integrante" )) {
	
	
	if ((isset ( $_GET ['cd_proyecto'] ))&&(isset ( $_GET ['cd_docente'] )))  {
		$oIntegrante = new Integrante();
		$oIntegrante->setCd_docente($_GET ['cd_docente']);
		$oIntegrante->setCd_proyecto($_GET ['cd_proyecto']);
		IntegranteQuery::getIntegrantePorId($oIntegrante);
		$oIntegrante->setDt_baja('0000-00-00');
		$oIntegrante->setDs_consecuencias('');
		$oIntegrante->setCd_estado(3);
		$exito=IntegranteQuery::modificarIntegrante($oIntegrante);
		
		header ( 'Location: ../proyectos/verproyecto.php?id='.$oIntegrante->getCd_proyecto() ); 
		
	}
} else {
	header ( 'Location:../includes/accesodenegado.php' );
}
?>