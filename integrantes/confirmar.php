<?
include '../includes/include.php';
require '../includes/chequeo.php';
include '../includes/datosSession.php';

if (PermisoQuery::permisosDeUsuario( $cd_usuario, "Confirmar alta/baja" )) {
	
	$cd_proyecto = $_GET ['cd_proyecto'];
	$oProyecto = new Proyecto ( );
	$oProyecto->setCd_proyecto ( $cd_proyecto );
	ProyectoQuery::getProyectoPorId($oProyecto);
	$tipo = $_GET['tipo'];
	$cd_docente = $_GET ['cd_docente'];
	$oDocente = new Docente ( );
	$oDocente->setCd_docente ( $cd_docente );
	DocenteQuery::getDocentePorId($oDocente);
	$oIntegrante = new Integrante();
	$oIntegrante->setCd_docente($cd_docente);
	$oIntegrante->setCd_proyecto($cd_proyecto);
	IntegranteQuery::getIntegrantePorId($oIntegrante);	
	$oIntegrante->setCd_estado(3);
	if ($tipo!=4) {
		$oIntegrante->setBl_insertado(1);
	}
	if ($tipo==3) {
		$oIntegrante->setDt_alta($oIntegrante->getDt_altapendiente());
	}
	
	$exito = IntegranteQuery::modificarIntegrante ( $oIntegrante );	
	
	
	$oFuncion = new Funcion();
	$oFuncion -> setDs_funcion("Confirmar alta/baja");
	FuncionQuery::getFuncionPorDs($oFuncion);
	$oMovimiento = new Movimiento();
	$oMovimiento->setCd_funcion($oFuncion->getCd_funcion());
	$oMovimiento->setCd_usuario($cd_usuario);
	switch ($tipo) {
		case 1:
			$fechaMovimiento = 'Fecha de Alta: '.FuncionesComunes::fechaMysqlaPHP($oIntegrante->getDt_alta());
		break;
		case 2:
			$fechaMovimiento = 'Fecha de Baja: '.FuncionesComunes::fechaMysqlaPHP($oIntegrante->getDt_baja());;
		break;
		case 3:
			$fechaMovimiento = 'Fecha de Cambio: '.FuncionesComunes::fechaMysqlaPHP($oIntegrante->getDt_alta());;
		break;
		case 4:
			$fechaMovimiento = 'Fecha de Cambio: '.FuncionesComunes::fechaMysqlaPHP($oIntegrante->getDt_cambioHS());;
		break;
	}
	$oMovimiento->setDs_movimiento('Docente: '.$oDocente->getNu_precuil().'-'.$oDocente->getNu_documento().'-'.$oDocente->getNu_postcuil().' - Proyecto: '.$oProyecto->getDs_codigo().' - '.$fechaMovimiento);
	MovimientoQuery::insertarMovimiento($oMovimiento);
	if ($exito){
		$altapendiente = (IntegranteQuery::tieneAltasPendientes($cd_proyecto))?1:0;
		$bajapendiente = (IntegranteQuery::tieneBajasPendientes($cd_proyecto))?1:0;
		$oProyecto->setBl_bajapendiente($bajapendiente);
		$oProyecto->setBl_altapendiente($altapendiente);
		$exito = ProyectoQuery::modificarProyecto ( $oProyecto );
		
		
		switch ($tipo) {
			case 1:
				$ds_funcion = 'Alta integrante';
			break;
			case 2:
				$ds_funcion = 'Baja integrante';
			break;
			case 3:
				$ds_funcion = 'Cambio colaborador';
			break;
			case 4:
				$ds_funcion = 'Cambio Dedicaci?n Horaria';
			break;
			
		}
		$ds_funcionMail = $ds_funcion;
		if ($oIntegrante->getCd_tipoinvestigador()==6) $ds_funcionMail = str_replace('integrante','colaborador',$ds_funcionMail);
		$integranteMail = ($oIntegrante->getCd_tipoinvestigador()==6)?'Colaborador':'Integrante';
		$oDirector = new Docente ( );
		$oDirector->setCd_docente ( $oProyecto->getCd_director() );
		DocenteQuery::getDocentePorId($oDirector);
		
		$oUsuario = new Usuario();
		$oUsuario->setNu_documento($oDirector->getNu_documento());
		UsuarioQuery::getUsuarioPorDocumento($oUsuario);
		
		
		$cabeceras="From: ".$nameFrom."<".$mailFrom.">\nReply-To: ".$mailFrom."\n";
		$oUsuarioF = new Usuario();
		$oUsuarioF->setCd_facultad($oProyecto->getCd_facultad());
		$usuarios = UsuarioQuery::getUsuariosPorFac($oUsuarioF);
		$count = count ( $usuarios );
		for($i = 0; $i < $count; $i ++) {
			$cabeceras .="BCC: ".$usuarios [$i]['ds_mail']."\n";
		}
		$cabeceras .="X-Mailer:PHP/".phpversion()."\n";
		$cabeceras .="Mime-Version: 1.0\n";
		$cabeceras .= "Content-type: multipart/mixed; ";
		$cabeceras .= "boundary=\"Message-Boundary\"\n";
		$cabeceras .= "Content-transfer-encoding: 7BIT\n";
		$body_top = "--Message-Boundary\n";
		$body_top .= "Content-type: text/html; charset=iso-8859-1\n";
		$body_top .= "Content-transfer-encoding: 7BIT\n";
		$body_top .= "Content-description: Mail message body\n\n";
		
		$shtml = $body_top. "<html><body><div style='padding-left: 30px; padding-right: 30px; padding-top: 30px ; padding-bottom: 30px; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; color: #666666; background-color:#FFFFFF'><img src=\"".WEB_PATH."img/image002.gif\" alt=\"Logo\" longdesc=\"Logo\"><br>PROYECTOS DE INVESTIGACION<hr style= 'color: #999999; text-decoration: none;'><p><strong>Confirmaci&oacute;n de ".$ds_funcionMail."<br>Proyecto</strong>: ".$oProyecto->getDs_codigo()."<br><strong>".$integranteMail."</strong>: ".$oDocente->getDs_apellido().", ".$oDocente->getDs_nombre()." (".$oDocente->getNu_precuil().'-'.$oDocente->getNu_documento().'-'.$oDocente->getNu_postcuil().")<br>".$fechaMovimiento."</p><hr style= 'color: #999999; text-decoration: none;'></body></html>";
		$shtml .= "\n\n--Message-Boundary\n";
		if (!$test) {
			mail($oUsuario->getDs_mail(),"Confirmaci?n de ".$ds_funcionMail,$shtml,$cabeceras);
		}
		
		header ( 'Location: ../proyectos/verproyecto.php?id='.$oProyecto->getCd_proyecto() ); 
	}else
		header ( 'Location: confirmar.php?er=1&cd_proyecto=' . $oProyecto->getCd_proyecto().'&cd_docente='.$oDocente->getCd_docente() );
} else
	header ( 'Location:../includes/accesodenegado.php' );
	