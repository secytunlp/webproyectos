<?php
include '../includes/include.php';
require '../includes/chequeo.php';
include '../includes/datosSession.php';

//verifico si tiene permiso para la acción
if (PermisoQuery::permisosDeUsuario( $cd_usuario, "Cambiar Horas" )) {
	
	
	if ((isset ( $_GET ['cd_proyecto'] ))&&(isset ( $_GET ['cd_docente'] )))  {
		$oIntegrante = new Integrante();
		$oIntegrante->setCd_docente($_GET ['cd_docente']);
		$oIntegrante->setCd_proyecto($_GET ['cd_proyecto']);
		IntegranteQuery::getIntegrantePorId($oIntegrante);
		if ($oIntegrante->getCd_estado()==8) {
		
			$oIntegrante->setDt_cambioHS('0000-00-00');
			$oIntegrante->setDs_reduccionHS('');
			$oIntegrante->setNu_horasinv($oIntegrante->getNu_horasinvAnt());
			$oIntegrante->setNu_horasinvAnt(0);
			$oIntegrante->setCd_estado(3);
			$exito=IntegranteQuery::cambioHS($oIntegrante);
			
			header ( 'Location: ../proyectos/verproyecto.php?id='.$oIntegrante->getCd_proyecto() ); 
		} else
			header ( 'Location:../includes/accesodenegado.php' );
		
	}
} else {
	header ( 'Location:../includes/accesodenegado.php' );
}
?>