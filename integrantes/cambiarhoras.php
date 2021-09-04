<?php
include '../includes/include.php';
require '../includes/chequeo.php';
include '../includes/datosSession.php';


if (PermisoQuery::permisosDeUsuario( $cd_usuario, "Cambiar Horas" )) {
	
	$xtpl = new XTemplate ( 'cambiarhoras.html' );
	include APP_PATH.'includes/cargarmenu.php';
	
	if ((isset ( $_GET ['cd_proyecto'] ))&&(isset ( $_GET ['cd_docente'] )))  {
		$cd_proyecto = $_GET ['cd_proyecto'];
		$oProyecto = new Proyecto ( );
		$oProyecto->setCd_proyecto ( $cd_proyecto );
		ProyectoQuery::getProyectoPorid ( $oProyecto );
		$xtpl->assign ( 'cd_proyecto',  ( $oProyecto->getCd_proyecto () ) );
		$xtpl->assign ( 'ds_codigo',  ( htmlspecialchars($oProyecto->getDs_codigo ()) ) );
		
		$cd_docente = $_GET ['cd_docente'];
		$oDocente = new Docente ( );
		$oDocente->setCd_docente ( $cd_docente );
		DocenteQuery::getDocentePorid ( $oDocente );
		$xtpl->assign ( 'cd_docente',  ( $oDocente->getCd_docente () ) );
		$xtpl->assign ( 'ds_nombre',  ( htmlspecialchars($oDocente->getDs_nombre ()) ) );
		$xtpl->assign ( 'ds_apellido',  ( htmlspecialchars($oDocente->getDs_apellido()) ) );
		$xtpl->assign ( 'nu_precuil',  ( $oDocente->getNu_precuil() ) );
		$xtpl->assign ( 'nu_documento',  ( $oDocente->getNu_documento() ) );
		$xtpl->assign ( 'nu_postcuil',  ( $oDocente->getNu_postcuil() ) );
		
		$oIntegrante = new Integrante ( );
		$oIntegrante->setCd_docente ( $cd_docente );
		$oIntegrante->setCd_proyecto ( $cd_proyecto );
		IntegranteQuery::getIntegrantePorId($oIntegrante);
		
		
		$disabled = (PermisoQuery::permisosDeUsuario( $cd_usuario, "Modificar docente" ))?'':'disabled="disabled"';
		$disabled1 = (PermisoQuery::permisosDeUsuario( $cd_usuario, "Modificar docente" ))?'':(($oDocente->getCd_docente()>=90000)?'':'disabled="disabled"');
		
		$xtpl->assign ( 'disabled',  $disabled );
		$xtpl->assign ( 'disabled1',  $disabled1 );
		$xtpl->assign ( 'cd_tipoinvestigador',  $oIntegrante->getCd_tipoinvestigador() );
		
	}
	
	
	
		
	
	
	$cargos = CargoQuery::listar ($oDocente->getCd_cargo ());
	$rowsize = count ( $cargos );
	
	for($i = 0; $i < $rowsize; $i ++) {
		$xtpl->assign ( 'DATA', $cargos [$i] );
		$xtpl->parse ( 'main.cargo' );
	}
	
	$xtpl->assign ( 'dt_cargo',  ( (($oDocente->getDt_cargo()=='')||($oDocente->getDt_cargo()=='0000-00-00'))?'':FuncionesComunes::fechaMysqlaPHP($oDocente->getDt_cargo() ) ));
	$xtpl->assign ( 'dt_cambioHS',  ( (($oIntegrante->getDt_cambioHS()=='')||($oIntegrante->getDt_cambioHS()=='0000-00-00'))?date('d/m/Y'):FuncionesComunes::fechaMysqlaPHP($oIntegrante->getDt_cambioHS() ) ));
	
	
	
	$deddocs = DeddocQuery::listar ($oDocente->getCd_deddoc ());
	$rowsize = count ( $deddocs );
	
	for($i = 0; $i < $rowsize; $i ++) {
		$xtpl->assign ( 'DATA', $deddocs [$i] );
		$xtpl->parse ( 'main.deddoc' );
	}
	
	$facultades = FacultadQuery::listar ($oDocente->getCd_facultad ());
	$rowsize = count ( $facultades );
	
	for($i = 0; $i < $rowsize; $i ++) {
		$xtpl->assign ( 'DATA', $facultades [$i] );
		$xtpl->parse ( 'main.facultad' );
	}
	
	$bl_becario = $oDocente->getBl_becario();
	if ($bl_becario==1){		
			$xtpl->assign ( 'chksi',  "checked='checked'" );
			$xtpl->assign ( 'dt_beca_enabled',  "" );
		}
	if ($bl_becario==0){		
		$xtpl->assign ( 'chkno',  "checked='checked'" );
		$xtpl->assign ( 'dt_beca_enabled',  "disabled='disabled'" );
		
	}
	$displayBeca = ($bl_becario)?'block':'none';
	$xtpl->assign ( 'displayBeca',  $displayBeca);
	$xtpl->assign ( 'dt_beca',  ( (($oDocente->getDt_beca()=='')||($oDocente->getDt_beca()=='0000-00-00'))?'':FuncionesComunes::fechaMysqlaPHP($oDocente->getDt_beca() ) ));
	$xtpl->assign ( 'ds_tipobeca',  stripslashes( htmlspecialchars($oDocente->getDs_tipobeca()) ) );
	switch (strtoupper($oDocente->getDs_orgbeca())) {
			case 'ANPCYT':
				$ds_orgbeca='ANPCyT';
			break;
			case 'AGENCIA':
				$ds_orgbeca='ANPCyT';
			break;
			case 'AGENCIA NACIONAL DE PROMOCIÓN CIENTÍFICA':
				$ds_orgbeca='ANPCyT';
			break;
			case 'AGENCIA NACIONAL DE PROMOCION CIENTIFICA Y TECNOLOGICA':
				$ds_orgbeca='ANPCyT';
			break;
			case 'CIC':
				$ds_orgbeca='CIC';
			break;
			case 'CIC PROVINCIA DE BUENOS AIRES':
				$ds_orgbeca='CIC';
			break;
			case 'CIC-PBA':
				$ds_orgbeca='CIC';
			break;
			case 'CICBA':
				$ds_orgbeca='CIC';
			break;
			case 'CICPBA':
				$ds_orgbeca='CIC';
			break;
			case 'COMISION DE INVESTIGACIONES CIENTIFICAS BS AS':
				$ds_orgbeca='CIC';
			break;
			case 'COMISIÓN DE INVESTIGACIONES CIENTIFICAS BUENOS AIRES':
				$ds_orgbeca='CIC';
			break;
			case 'COMISIÓN DE INVESTIGACIONES CIENTÍFICAS DE BS.AS.':
				$ds_orgbeca='CIC';
			break;
			case 'COMISION DE INVESTIGACIONES CIENTIFICAS DE LA PROVINCIA':
				$ds_orgbeca='CIC';
			break;
			case 'COMISIÓN DE INVESTIGACIONES CIENTÍFICAS DE LA PROVINCIA DE BUENOS AIRES':
				$ds_orgbeca='CIC';
			break;
			case 'COMISION DE INVESTIGACIONES CIENTIFICAS DE LA PROVINCIA DE BUENOS AIRES (CIC)':
				$ds_orgbeca='CIC';
			break;
			case 'COMISIÓN DE INVESTIGACIONES CIENTÍFICAS. PCIA. DE BUENOS AIRES.':
				$ds_orgbeca='CIC';
			break;
			case 'COMISIÓN INVESTIGACIONES CIENTÍFICAS PCIA BUENOS AIRES':
				$ds_orgbeca='CIC';
			break;
			
			case 'CONSEJO DE INVEST. CIENTÍFICAS DE LA PROVINCIA DE BS AS':
				$ds_orgbeca='CIC';
			break;
			case 'CONSEJO DE INVESTIGACIÓN CIENTÍFICAS DE LA PROVINCIA DE BUENOS AIRES':
				$ds_orgbeca='CIC';
			break;
			case 'CONSEJO DE INVESTIGACIONES CIENTÍFICAS DE LA PROV DE BS. AS.':
				$ds_orgbeca='CIC';
			break;
			case 'CONICET':
				$ds_orgbeca='CONICET';
			break;
			case 'CONSEJO NAC. INVEST. CIENT':
				$ds_orgbeca='CONICET';
			break;
			case 'CONSEJO NAC. INVEST. CIENTÍFICAS Y TÉCNICAS':
				$ds_orgbeca='CONICET';
			break;
			case 'CONSEJO NACIONAL DE INEVSTIGACIONES CIENTIFICAS Y TECNICAS':
				$ds_orgbeca='CONICET';
			break;
			case 'CONSEJO NACIONAL DE INVESTIGACIONES CIENTÍFICAS':
				$ds_orgbeca='CONICET';
			break;
			case 'CONSEJO NACIONAL DE INVESTIGACIONES CIENTÍFICAS Y TÉCNICAS':
				$ds_orgbeca='CONICET';
			break;
			case 'CONSEJO NACIONAL DE INVESTIGACIONES CIENTÍFICAS Y TÉCNICAS (CONICET)':
				$ds_orgbeca='CONICET';
			break;
			case 'CONSEJO NACIONAL DE INVESTIGACIONES CIENTÍFICAS Y TECNOLÓGICAS':
				$ds_orgbeca='CONICET';
			break;
			case 'UNLP':
				$ds_orgbeca='UNLP';
			break;
			case 'U.N.L.P.':
				$ds_orgbeca='UNLP';
			break;
			case 'UNIVERSIDAD NACIONAL DE LA PLATA':
				$ds_orgbeca='UNLP';
			break;
		}
		$selectedANPCyT = ($ds_orgbeca=='ANPCyT')?"selected='selected'":"";
		$selectedCIC = ($ds_orgbeca=='CIC')?"selected='selected'":"";
		$selectedCONICET = ($ds_orgbeca=='CONICET')?"selected='selected'":"";
		$selectedUNLP = ($ds_orgbeca=='UNLP')?"selected='selected'":"";
		
		$xtpl->assign ( 'selectedANPCyT',  $selectedANPCyT );
		$xtpl->assign ( 'selectedCIC',  $selectedCIC );
		$xtpl->assign ( 'selectedCONICET',  $selectedCONICET );
		$xtpl->assign ( 'selectedUNLP',  $selectedUNLP );
	
		$selectedAGENCIA_1 = (strtoupper($oDocente->getDs_tipobeca())=='Agencia 1')?"selected='selected'":"";
		$selectedAGENCIA_2 = (strtoupper($oDocente->getDs_tipobeca())=='Agencia 2')?"selected='selected'":"";
		$selectedCIC_1 = (strtoupper($oDocente->getDs_tipobeca())=='CIC 1')?"selected='selected'":"";
		$selectedCIC_2 = (strtoupper($oDocente->getDs_tipobeca())=='CIC 2')?"selected='selected'":"";
		$selectedCONICET_1 = (strtoupper($oDocente->getDs_tipobeca())=='CONICET 1')?"selected='selected'":"";
		$selectedCONICET_2 = (strtoupper($oDocente->getDs_tipobeca())=='CONICET 2')?"selected='selected'":"";
		$selectedUNLP_1 = (strtoupper($oDocente->getDs_tipobeca())=='UNLP 1')?"selected='selected'":"";
		$selectedUNLP_2 = (strtoupper($oDocente->getDs_tipobeca())=='UNLP 2')?"selected='selected'":"";
		$optionsBeca ='';
		switch($ds_orgbeca)
			{
				case "ANPCyT": 
					$optionsBeca .= "<option value='Agencia 1' ".$selectedAGENCIA_1.">Agencia 1</option><option value='Agencia 2' ".$selectedAGENCIA_2.">Agencia 2</option>";
		 
				break;
				case "CIC": 
					$optionsBeca .="<option value='CIC 1' ".$selectedCIC_1.">CIC 1</option><option value='CIC 2' ".$selectedCIC_2.">CIC 2</option>";
		 
				break;
				case "CONICET": 
					$optionsBeca .="<option value='CONICET 1' ".$selectedCONICET_1.">CONICET 1</option><option value='CONICET 2' ".$selectedCONICET_2.">CONICET 2</option>";
		 
				break;
				case "UNLP": 
					$optionsBeca .="<option value='UNLP 1' ".$selectedUNLP_1.">UNLP 1</option><option value='UNLP 2' ".$selectedUNLP_2.">UNLP 2</option>";
		 
				break;
			}
		
		$xtpl->assign ( 'optionsBeca',  $optionsBeca );
		
	$xtpl->assign ( 'ds_universidad',  stripslashes( htmlspecialchars($oDocente->getDs_universidad()) ) );
	$xtpl->assign ( 'cd_universidad',  $oDocente->getCd_universidad() );
	
	
	$carrerainvs = CarrerainvQuery::listar ($oDocente->getCd_carrerainv());
	$rowsize = count ( $carrerainvs );
	
	for($i = 0; $i < $rowsize; $i ++) {
		$xtpl->assign ( 'DATA', $carrerainvs [$i] );
		$xtpl->parse ( 'main.carrerainv' );
	}
	
	$organismos = OrganismoQuery::listar ($oDocente->getCd_organismo());
	$rowsize = count ( $organismos );
	
	for($i = 0; $i < $rowsize; $i ++) {
		$xtpl->assign ( 'DATA', $organismos [$i] );
		$xtpl->parse ( 'main.organismo' );
	}
	
	$proyectos = ProyectoQuery::getProyectosDocentes($oDocente->getCd_docente() );
	$count = count ( $proyectos );
	for($i = 0; $i < $count; $i ++) {
		$proyectos [$i]['dt_ini']=FuncionesComunes::fechaMysqlaPHP($proyectos [$i]['dt_ini']);
		$proyectos [$i]['dt_fin']=FuncionesComunes::fechaMysqlaPHP($proyectos [$i]['dt_fin']);
		$proyectos [$i]['item']=$i;
		$proyectos [$i]['ds_tipoinvestigador']=($proyectos [$i]['cd_proyecto']!=$oProyecto->getCd_proyecto())?$proyectos [$i]['ds_tipoinvestigador']:'';
		$proyectos [$i]['cd_tipoinvestigador']=($proyectos [$i]['cd_proyecto']!=$oProyecto->getCd_proyecto())?$proyectos [$i]['cd_tipoinvestigador']:'';
		$proyectos [$i]['nu_horasinv'] = ($proyectos [$i]['nu_horasinv'])?$proyectos[$i]['nu_horasinv']:'0';
		$proyectos [$i]['nu_horasinvAnt'] = ($proyectos [$i]['nu_horasinvAnt'])?$proyectos[$i]['nu_horasinvAnt']:$proyectos [$i]['nu_horasinv'];
		$proyectos [$i]['disabled']=(($proyectos [$i]['nu_horasinv'])&&($proyectos [$i]['cd_proyecto']!=$oProyecto->getCd_proyecto()))?'readonly':'';
		$proyectos [$i]['onChangeHabilitarReduccion']=(($proyectos [$i]['cd_proyecto']==$oProyecto->getCd_proyecto()))?'onChange = "habilitarReduccion(this, \''.$proyectos [$i]['nu_horasinvAnt'].'\')"':'';
		$xtpl->assign ( 'DATOS', $proyectos [$i] );
		$xtpl->parse ( 'main.row' );
	}
	
	
	$displayReduccion = ($oIntegrante->getNu_horasinvAnt()>$oIntegrante->getNu_horasinv())?'block':'none';
	$xtpl->assign ( 'displayReduccion',  $displayReduccion);
	
	$xtpl->assign ( 'ds_reduccionHS',  $oIntegrante->getDs_reduccionHS() );
	$xtpl->assign ( 'minhstotales',  $minhstotales );
	
	if (isset ( $_GET ['er'] )) {
		if ($_GET ['er'] == 1) {
			$xtpl->assign ( 'classMsj', 'msjerror' );
			$msj = "Error: No se han modificado los datos del docente";
			$xtpl->assign ( 'msj', 'onLoad ="mensajeError(\''.$msj.'\')"' );
		}
		
		
		
	} else {
		$xtpl->assign ( 'classMsj', '' );
		$xtpl->assign ( 'msj', '' );
	}
	$xtpl->parse ( 'main.msj' );
	
	$xtpl->assign ( 'titulo', 'SeCyT - Cambiar dedicaci&oacute;n horaria' );
	
	$xtpl->parse ( 'main' );
	$xtpl->out ( 'main' );
} else
	header ( 'Location:../includes/finsolicitud.php' );
?>