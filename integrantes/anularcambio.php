<?php
include '../includes/include.php';
require '../includes/chequeo.php';
include '../includes/datosSession.php';

//verifico si tiene permiso para la acción
if (PermisoQuery::permisosDeUsuario( $cd_usuario, "Cambiar colaborador" )) {
	
	
	if ((isset ( $_GET ['cd_proyecto'] ))&&(isset ( $_GET ['cd_docente'] )))  {
		$oIntegrante = new Integrante();
		$oIntegrante->setCd_docente($_GET ['cd_docente']);
		$oIntegrante->setCd_proyecto($_GET ['cd_proyecto']);
		IntegranteQuery::getIntegrantePorId($oIntegrante);
		if ($oIntegrante->getCd_estado()==6) {
		
			$oIntegrante->setDt_altapendiente('0000-00-00');
			$oIntegrante->setCd_tipoinvestigador(6);
			$oIntegrante->setNu_horasinv(0);
			$oIntegrante->setCd_estado(3);
			$exito=IntegranteQuery::modificarIntegrante($oIntegrante);
			
			header ( 'Location: ../proyectos/verproyecto.php?id='.$oIntegrante->getCd_proyecto() ); 
		} else
			header ( 'Location:../includes/accesodenegado.php' );
		
	}
} else {
	header ( 'Location:../includes/accesodenegado.php' );
}
?>