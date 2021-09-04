<?php
include '../includes/include.php';
require '../includes/chequeo.php';
include '../includes/datosSession.php';


if (PermisoQuery::permisosDeUsuario( $cd_usuario, "Modificar integrante" )) {
	
	$xtpl = new XTemplate ( 'modificarintegrante.html' );
	include APP_PATH.'includes/cargarmenu.php';
	
	if ((isset ( $_GET ['cd_proyecto'] ))&&(isset ( $_GET ['cd_docente'] )))  {
		$cd_proyecto = $_GET ['cd_proyecto'];
		$oProyecto = new Proyecto ( );
		$oProyecto->setCd_proyecto ( $cd_proyecto );
		ProyectoQuery::getProyectoPorid ( $oProyecto );
		$xtpl->assign ( 'cd_proyecto',  ( $oProyecto->getCd_proyecto () ) );
		$xtpl->assign ( 'ds_codigo',  ( ($oProyecto->getDs_codigo ()) ) );
		
		$cd_docente = $_GET ['cd_docente'];
		$oDocente = new Docente ( );
		$oDocente->setCd_docente ( $cd_docente );
		DocenteQuery::getDocentePorid ( $oDocente );
		$xtpl->assign ( 'cd_docente',  ( $oDocente->getCd_docente () ) );
		$xtpl->assign ( 'ds_nombre',  ( ($oDocente->getDs_nombre ()) ) );
		$xtpl->assign ( 'ds_apellido',  ( ($oDocente->getDs_apellido()) ) );
		$xtpl->assign ( 'nu_precuil',  ( $oDocente->getNu_precuil() ) );
		$xtpl->assign ( 'nu_documento',  ( $oDocente->getNu_documento() ) );
		$xtpl->assign ( 'nu_postcuil',  ( $oDocente->getNu_postcuil() ) );
		$xtpl->assign ( 'dt_nacimiento',  ( FuncionesComunes::fechaMysqlaPHP($oDocente->getDt_nacimiento() ) ));
		$xtpl->assign ( 'ds_calle',  ( ($oDocente->getDs_calle()) ) );
		$xtpl->assign ( 'nu_nro',  ( ($oDocente->getNu_nro()) ) );
		$xtpl->assign ( 'nu_piso',  ( ($oDocente->getNu_piso()) ) );
		$xtpl->assign ( 'ds_depto',  ( ($oDocente->getDs_depto()) ) );
		$xtpl->assign ( 'ds_localidad',  ( ($oDocente->getDs_localidad()) ) );
		$xtpl->assign ( 'nu_cp',  ( ($oDocente->getNu_cp())) );
		$xtpl->assign ( 'nu_telefono',  ( ($oDocente->getNu_telefono()) ) );
		$xtpl->assign ( 'ds_mail',  ( $oDocente->getDs_mail() ) );
		$oIntegrante = new Integrante ( );
		$oIntegrante->setCd_docente ( $cd_docente );
		$oIntegrante->setCd_proyecto ( $cd_proyecto );
		IntegranteQuery::getIntegrantePorId($oIntegrante);
		if ($oIntegrante->getCd_estado()==1) {
			
			
			$disabled = (PermisoQuery::permisosDeUsuario( $cd_usuario, "Modificar docente" ))?'':'disabled="disabled"';
			$disabled1 = (PermisoQuery::permisosDeUsuario( $cd_usuario, "Modificar docente" ))?'':(($oDocente->getCd_docente()>=90000)?'':'disabled="disabled"');
			$discod = ($oIntegrante->getCd_tipoinvestigador()!=1)?'':'disabled="disabled"';
			$xtpl->assign ( 'disabled',  $disabled );
			$xtpl->assign ( 'disabled1',  $disabled1 );
			$xtpl->assign ( 'discod',  $discod );
			$ds_curriculum=(strstr($oIntegrante->getDs_curriculum(),'_P'.$_SESSION ["nu_mesSessionP"].$_SESSION ["nu_yearSessionP"]))?$oIntegrante->getDs_curriculum():'';
			$xtpl->assign ( 'ds_curriculumH',  $ds_curriculum );
			$cvcargado = ( $ds_curriculum ) ? 'Cargado' : '';
	   		 $xtpl->assign('cvcargado', $cvcargado);
	   		 $ds_actividades=(strstr($oIntegrante->getDs_actividades(),'_P'.$_SESSION ["nu_mesSessionP"].$_SESSION ["nu_yearSessionP"]))?$oIntegrante->getDs_actividades():'';
	   		 $xtpl->assign ( 'ds_actividadesH',  $ds_actividades );
			$iacargado = (( $ds_actividades ) ) ? 'Cargado' : '';
	   		 $xtpl->assign('iacargado', $iacargado);
		}
		
		
		
			
		$categorias = CategoriaQuery::listar ($oDocente->getCd_categoria ());
		$rowsize = count ( $categorias );
		
		for($i = 0; $i < $rowsize; $i ++) {
			$xtpl->assign ( 'DATA', $categorias [$i] );
			$xtpl->parse ( 'main.categoria' );
		}
		
		$cargos = CargoQuery::listar ($oDocente->getCd_cargo ());
		$rowsize = count ( $cargos );
		
		for($i = 0; $i < $rowsize; $i ++) {
			$xtpl->assign ( 'DATA', $cargos [$i] );
			$xtpl->parse ( 'main.cargo' );
		}
		
		$provincias = ProvinciaQuery::listar ($oDocente->getCd_provincia ());
		$rowsize = count ( $provincias );
		
		for($i = 0; $i < $rowsize; $i ++) {
			$xtpl->assign ( 'DATA', $provincias [$i] );
			$xtpl->parse ( 'main.provincia' );
		}
		
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
		
		$xtpl->assign ( 'cd_unidad',  stripslashes( ($oDocente->getCd_unidad()) ) );
		$nu_nivelunidad = $oDocente->getNu_nivelunidad();
		$xtpl->assign ( 'nu_nivelunidad',  stripslashes( ($nu_nivelunidad) ) );
		$oUnidad = new Unidad();
			$oUnidad->setCd_unidad($oDocente->getCd_unidad());
			UnidadQuery::getUnidadPorId($oUnidad);
		
		$xtpl->assign ( 'ds_unidad',  stripslashes( ($oUnidad->getDs_unidad()) ) );
		
		//$tipoinvestigadores = TipoinvestigadorQuery::listar ($oIntegrante->getCd_tipoinvestigador(), ($oIntegrante->getCd_tipoinvestigador()!=1)?1:0);
		$tipoinvestigadores = TipoinvestigadorQuery::listar ($oIntegrante->getCd_tipoinvestigador());
		$rowsize = count ( $tipoinvestigadores );
		
		for($i = 0; $i < $rowsize; $i ++) {
			$xtpl->assign ( 'DATA', $tipoinvestigadores [$i] );
			$xtpl->parse ( 'main.tipoinvestigador' );
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
		$xtpl->assign ( 'ds_tipobeca',  stripslashes( ($oDocente->getDs_tipobeca()) ) );
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
		$xtpl->assign ( 'ds_universidad',  stripslashes( ($oDocente->getDs_universidad()) ) );
		$xtpl->assign ( 'cd_universidad',  $oDocente->getCd_universidad() );
		$oTitulo = new Titulo();
			$oTitulo->setCd_titulo($oDocente->getCd_titulo());
			TituloQuery::getTituloPorId($oTitulo);
			$ds_titulogrado = $oTitulo->getDs_titulo();
		$xtpl->assign ( 'ds_titulogrado',  stripslashes( ($ds_titulogrado) ) );
		$xtpl->assign ( 'cd_titulogrado',  stripslashes( ($oTitulo->getCd_titulo()) ) );
		
		$oTitulo = new Titulo();
			$oTitulo->setCd_titulo($oDocente->getCd_titulopost());
			TituloQuery::getTituloPorId($oTitulo);
			$ds_titulogrado = $oTitulo->getDs_titulo();
		$xtpl->assign ( 'ds_titulopost',  stripslashes( ($ds_titulogrado) ) );
		$xtpl->assign ( 'cd_titulopost',  stripslashes( ($oTitulo->getCd_titulo()) ) );
		
		$bl_estudiante = $oDocente->getBl_estudiante();
		if ($bl_estudiante==1){		
				$xtpl->assign ( 'chksiE',  "checked='checked'" );
				
			}
		if ($bl_estudiante==0){		
			$xtpl->assign ( 'chknoE',  "checked='checked'" );
			
		}
		$xtpl->assign ( 'nu_materias',  stripslashes( ($oDocente->getNu_materias()) ) );
		
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
			$proyectos [$i]['nu_horasinv'] = ($proyectos [$i]['nu_horasinv'])?$proyectos[$i]['nu_horasinv']:'0';
			$proyectos [$i]['disabled']=(($proyectos [$i]['nu_horasinv'])&&($proyectos [$i]['cd_proyecto']!=$oProyecto->getCd_proyecto()))?'readonly':'';
			$xtpl->assign ( 'DATOS', $proyectos [$i] );
			$xtpl->parse ( 'main.row' );
		}
		
		if (isset ( $_GET ['er'] )) {
			if ($_GET ['er'] == 1) {
				$xtpl->assign ( 'classMsj', 'msjerror' );
				$msj = "Error: No se han modificado los datos del docente";
				$xtpl->assign ( 'msj', 'onLoad ="mensajeError(\''.$msj.'\')"' );
			}
			if ($_GET ['er'] == 3) {
				$xtpl->assign ( 'classMsj', 'msjerror' );
				$msj = "Error: El docente ya es integrante de 2 proyectos en ejecuci&oacute;n o no tiene dedicaci&oacute;n suficiente para ser integrante de m&aacute;s de un proyecto";
				$xtpl->assign ( 'msj', 'onLoad ="mensajeError(\''.$msj.'\')"' );
			}
			if ($_GET ['er'] == 4) {
				$xtpl->assign ( 'classMsj', 'msjerror' );
				$msj = "Error: La categor&iacute;a del codirector debe ser I, II o III o debe tener Cargo en la Carrera del Investigador con lugar de trabajo en la U.N.L.P.";
				$xtpl->assign ( 'msj', 'onLoad ="mensajeError(\''.$msj.'\')"' );
			}
		if ($_GET ['er'] == 6) {
				$xtpl->assign ( 'classMsj', 'msjerror' );
				$msj = "Error al Subir el Archivo ".$_GET['dir'];
				$xtpl->assign ( 'msj', 'onLoad ="mensajeError(\''.$msj.'\')"' );
			}
			
		} else {
			$xtpl->assign ( 'classMsj', '' );
			$xtpl->assign ( 'msj', '' );
		}
		$xtpl->parse ( 'main.msj' );
		
		$xtpl->assign ( 'titulo', 'SeCyT - Modificaci&oacute;n de integrante' );
		
		$xtpl->parse ( 'main' );
		$xtpl->out ( 'main' );
	} else
		header ( 'Location:../includes/accesodenegado.php' );
} else
	header ( 'Location:../includes/finsolicitud.php' );
?>