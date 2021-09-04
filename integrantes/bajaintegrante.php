<?php
include '../includes/include.php';
require '../includes/chequeo.php';
include '../includes/datosSession.php';


if (PermisoQuery::permisosDeUsuario( $cd_usuario, "Baja integrante" )) {
	
	$xtpl = new XTemplate ( 'bajaintegrante.html' );
	include APP_PATH.'includes/cargarmenu.php';
	
	if ((isset ( $_GET ['cd_proyecto'] ))&&(isset ( $_GET ['cd_docente'] )))  {
		$cd_proyecto = $_GET ['cd_proyecto'];
		$oProyecto = new Proyecto ( );
		$oProyecto->setCd_proyecto ( $cd_proyecto );
		ProyectoQuery::getProyectoPorid ( $oProyecto );
		$xtpl->assign ( 'cd_proyecto',  ( $oProyecto->getCd_proyecto () ) );
		$xtpl->assign ( 'ds_codigo',  ( $oProyecto->getDs_codigo () ) );
		$xtpl->assign ( 'ds_titulo',  ( $oProyecto->getDs_titulo () ) );
		$xtpl->assign ( 'minhstotales',  $minhstotales );
		$xtpl->assign ( 'mincategorizados',  $mincategorizados );
		
		$cd_docente = $_GET ['cd_docente'];
		$oDocente = new Docente ( );
		$oDocente->setCd_docente ( $cd_docente );
		DocenteQuery::getDocentePorid ( $oDocente );
		$xtpl->assign ( 'cd_docente',  ( $oDocente->getCd_docente () ) );
		$xtpl->assign ( 'ds_integrante',  ( $oDocente->getDs_apellido().', '.$oDocente->getDs_nombre () ) );
		$oIntegrante = new Integrante ( );
		$oIntegrante->setCd_docente ( $cd_docente );
		$oIntegrante->setCd_proyecto ( $cd_proyecto );
		IntegranteQuery::getIntegrantePorId($oIntegrante);
		if (($oIntegrante->getCd_estado()==4)||($oIntegrante->getCd_estado()==3)) {
			$dt=(FuncionesComunes::fechaMysqlaPHP($oIntegrante->getDt_baja ())!='00/00/0000')?FuncionesComunes::fechaMysqlaPHP($oIntegrante->getDt_baja ()):'';
			$xtpl->assign ( 'dt_baja',  $dt );
			$xtpl->assign ( 'ds_consecuencias',  $oIntegrante->getDs_consecuencias() );
			$xtpl->assign ( 'ds_motivos',  $oIntegrante->getDs_motivos() );
		} else
			header ( 'Location:../includes/accesodenegado.php' );
	}
	
	
	if (isset ( $_GET ['err'] )){
		$err = FuncionesComunes::array_recibe($_GET ['err']);
		$msjerror = '';
		foreach ($err as $error)
			$msjerror .= $error.'<br>';
		$xtpl->assign ( 'msj', 'onLoad ="mensajeError(\''.$msjerror.'\')"' );
		$xtpl->assign ( 'classMsj', 'msjerror' );
		$xtpl->parse ( 'main.msj' );
	}
	
	 else {
		$xtpl->assign ( 'classMsj', '' );
		$xtpl->assign ( 'msj', '' );
	}
	$xtpl->parse ( 'main.msj' );
	
	$xtpl->assign ( 'titulo', 'Baja de integrante' );
	
	$xtpl->parse ( 'main' );
	$xtpl->out ( 'main' );
} else
	header ( 'Location:../includes/finsolicitud.php' );
?>