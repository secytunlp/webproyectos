<?php
include '../includes/include.php';
require '../includes/chequeo.php';
include '../includes/datosSession.php';

//verifico si tiene permiso para la acción
if (PermisoQuery::permisosDeUsuario( $cd_usuario, "Eliminar integrante" )) {
	
	
	if ((isset ( $_GET ['cd_proyecto'] ))&&(isset ( $_GET ['cd_docente'] )))  {
		$oIntegrante = new Integrante();
		$oIntegrante->setCd_docente($_GET ['cd_docente']);
		$oIntegrante->setCd_proyecto($_GET ['cd_proyecto']);
		IntegranteQuery::getIntegrantePorId($oIntegrante);
		$oDocente = new Docente();
		$oDocente->setCd_docente($oIntegrante->getCd_docente());
		DocenteQuery::getDocentePorId($oDocente);
		$dir = APP_PATH.'pdfs/'.$_SESSION ["nu_yearSessionP"].'/'.$_SESSION ["nu_mesSessionP"].'/'.$oIntegrante->getCd_proyecto().'/'.$oDocente->getNu_documento().'/';
		if ($oIntegrante->getDs_curriculum()){
			if (file_exists($dir.$oIntegrante->getDs_curriculum())) unlink($dir.$oIntegrante->getDs_curriculum());
		}
		if ($oIntegrante->getDs_actividades()){
			if (file_exists($dir.$oIntegrante->getDs_actividades())) unlink($dir.$oIntegrante->getDs_actividades());	
		}
		$exito=IntegranteQuery::eliminarIntegrante($oIntegrante);
		if ($exito){
			
			$oFuncion = new Funcion();
			$oFuncion -> setDs_funcion("Eliminar integrante");
			FuncionQuery::getFuncionPorDs($oFuncion);
			$oMovimiento = new Movimiento();
			$oMovimiento->setCd_funcion($oFuncion->getCd_funcion());
			$oMovimiento->setCd_usuario($cd_usuario);
			$oMovimiento->setDs_movimiento('Proyecto: '.$oIntegrante->getCd_proyecto().' Docente: '.$oIntegrante->getCd_docente());
			MovimientoQuery::insertarMovimiento($oMovimiento);
			header ( 'Location: ../proyectos/verproyecto.php?id='.$oIntegrante->getCd_proyecto() ); 
		}else
			header ( 'Location:../proyectos/verproyecto.php?er=1&id='.$oIntegrante->getCd_proyecto() );
	}
} else 
	header ( 'Location:../includes/accesodenegado.php' );

?>