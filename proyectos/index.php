<?php
include_once '../includes/include.php';
require '../includes/chequeo.php';
include '../includes/datosSession.php';
$funcion = (($_GET['pendiente']==1)||($_POST['pendiente']==1))?'Confirmar alta/baja':'Listar proyecto';

if (PermisoQuery::permisosDeUsuario ( $cd_usuario, $funcion )) {
	$xtpl = new XTemplate ( 'index.html' );
	
	include APP_PATH . 'includes/cargarmenu.php';
	
	/*$unidades = UnidadQuery::listarTodas();
	$count = count ( $unidades );
	for($i = 0; $i < $count; $i ++) {		
		$j=0;
		$oUnidad = new Unidad();
		$oUnidad->setCd_unidad($unidades[$i]['cd_unidad']);
		UnidadQuery::getUnidadPorId($oUnidad);
		while($oUnidad->getCd_padre()!=0){
			$oUnidad->setCd_unidad($oUnidad->getCd_padre());
			UnidadQuery::getUnidadPorId($oUnidad);
			$j++;
			}
		
		$oUnidad->setCd_unidad($unidades[$i]['cd_unidad']);
		UnidadQuery::getUnidadPorId($oUnidad);
		$oUnidad->setBl_hijos($j);
		UnidadQuery::modificarUnidad($oUnidad);
	}*/
	
	/*$fp = fopen ("../datos/proyectos.csv","r");
	while ($data = fgetcsv ($fp, 1000, ",")) {
	    $num = count ($data);
	    $oProyecto = new Proyecto ( );
		$oProyecto->setCd_proyecto ( intval($data[0]) );
		ProyectoQuery::getProyectoPorId ( $oProyecto );
	    $insertar=($oProyecto->getDs_codigo())?0:1;
	    $oProyecto->setCd_facultad(intval($data[6]));
	    $oProyecto->setDs_codigo(addslashes($data[1]));
	    $oProyecto->setDs_titulo(addslashes($data[2]));
	    $oProyecto->setDt_fin(FuncionesComunes::fechaPHPaMysql($data[4]));
	    $oProyecto->setDt_ini(FuncionesComunes::fechaPHPaMysql($data[3]));
	    $oProyecto->setDt_inc(FuncionesComunes::fechaPHPaMysql($data[5]));
		if ($insertar){
			ProyectoQuery::insertarProyecto ( $oProyecto );			
		}
		else ProyectoQuery::modificarProyecto ( $oProyecto );	
				
				
				
	
	}
	fclose ($fp);*/
	///ojoooooooooooooooooooooooo!!!!!!!! actualizar los doc en 0
	/*$fp = fopen ("../datos/docentes.txt","r");
	while ($data = fgetcsv ($fp, 1000, ",")) {
	    $num = count ($data);
	    $oDocente = new Docente ( );
		$oDocente->setCd_docente ( intval($data[0]) );
		$oDocente->setNu_documento(intval($data[5]));
		DocenteQuery::getDocentePorDocumento ( $oDocente );
	    $insertar=($oDocente->getNu_ident())?0:1;
	    $oDocente->setNu_ident(intval($data[1]));
	    $oDocente->setDs_nombre(addslashes($data[2]));
	    $oDocente->setDs_apellido(addslashes($data[3]));
	    $oDocente->setNu_precuil(intval($data[4]));
	    $oDocente->setNu_postcuil(intval($data[6]));
	    $oDocente->setDt_nacimiento(FuncionesComunes::fechaPHPaMysql($data[7]));
	    $oDocente->setDs_sexo($data[8]);
	    $oDocente->setCd_categoria(intval($data[9]));
	    $oDocente->setNu_dedinv(intval($data[10]));
	    $oDocente->setCd_carrerainv((intval($data[12])==7)?11:intval($data[12]));
	    $oDocente->setCd_organismo((intval($data[12])==7)?7:intval($data[11]));
	    $oDocente->setNu_horasinv(intval($data[13]));
	    $oDocente->setNu_semanasinv(intval($data[14]));
	    $oDocente->setNu_horasspu(intval($data[15]));
	    $oDocente->setNu_semanasspu(intval($data[16]));
	    $oDocente->setCd_facultad(intval($data[17]));
	    $oCargo = new Cargo();
	    $oCargo->setCd_cargo($oDocente->getCd_cargo());
	    CargoQuery::getCargoSipiPorCd($oCargo);
	    if ($oCargo->getCd_cargosipi()!=intval($data[18])) {//si no se modificÃ³ desde el SIPI no se le carga el CARGO
	    	$oDocente->setCd_cargo(intval($data[18]));
	    }
	    $oDocente->setCd_deddoc(intval($data[19]));
	    $oDocente->setNu_horasdoc2c(intval($data[20]));
	    $oDocente->setNu_horasdoc1c(intval($data[21]));
	    $oDocente->setNu_semanasdoc1c(intval($data[22]));
	    $oDocente->setNu_semanasdoc2c(intval($data[23]));
	    $oDocente->setCd_titulo(intval($data[24]));
	    $oDocente->setDs_calle(addslashes($data[25]));
	    $oDocente->setNu_nro($data[26]);
	    $oDocente->setNu_piso($data[27]);
	    $oDocente->setDs_depto(addslashes($data[28]));
	    $oDocente->setDs_localidad(addslashes($data[29]));
	    $oDocente->setNu_cp($data[30]);
	    $oDocente->setDs_mail($data[31]);
	    $oDocente->setNu_telefono($data[32]);
	    $oDocente->setCd_provincia(intval($data[33]));
	    //$oDocente->setCd_titulopost(intval($data[34]));
	    $oDocente->setBl_becario((trim($data[35])=='S')?1:0);
	    if (intval($data[12])==7){
	    	$oDocente->setBl_becario(1);
	    	$oOrganismo = new Organismo();
	    	$oOrganismo->setCd_organismo(intval($data[11]));
	    	OrganismoQuery::getOrganismoPorCd($oOrganismo);
	    	$oDocente->setDs_orgbeca(addslashes($oOrganismo->getDs_organismo()));
	    }
	 
	    
		if ($insertar){
			DocenteQuery::insertarDocente ( $oDocente );			
		}
		else DocenteQuery::modificarDocente ( $oDocente );	
				
				
				
	
	}
	fclose ($fp);*/
	
/*	
  // ojooooooooo con las fechas de bajas en las solicitudes pendientes
 $fp = fopen ("../datos/Integrantes.txt","r");
	while ($data = fgetcsv ($fp, 1000, ",")) {
	    $num = count ($data);
	    $oDocente = new Docente ( );
		$oDocente->setNu_documento ( intval($data[0]) );
		DocenteQuery::getDocentePorDocumento ( $oDocente );
		$oProyecto = new Proyecto ( );
		$oProyecto->setDs_codigo ( $data[1] );
		ProyectoQuery::getProyectoPorCodigo ( $oProyecto );
		if (($oDocente->getNu_ident())&&($oProyecto->getCd_proyecto())){
	    	$oIntegrante = new Integrante ( );
	    	$oIntegrante->setCd_docente ( $oDocente->getCd_docente() );
			$oIntegrante->setCd_proyecto ( $oProyecto->getCd_proyecto() );
			IntegranteQuery::getIntegrantePorId ( $oIntegrante );
		    $insertar=($oIntegrante->getDt_alta())?0:1;
		    //if ($insertar){
			    //$tipo = ($data[4]==1)?1:0;
			    // ojooooooooo controlar si cambió de tipo de investigador 
			    $oIntegrante->setCd_tipoinvestigador(intval($data[4]));
		    //}
		    $oIntegrante->setDt_alta(FuncionesComunes::fechaPHPaMysql($data[2]));
		    $oIntegrante->setDt_baja(FuncionesComunes::fechaPHPaMysql($data[3]));
		    
			if ($insertar){
				IntegranteQuery::insertarIntegrante ( $oIntegrante );			
			}
			else IntegranteQuery::modificarIntegrante ( $oIntegrante );
		}	
				
				
				
	
	}
	fclose ($fp);*/

	/*
	ojooooooooo con las fechas de bajas en las solicitudes pendientes
	$_Log = fopen("../datos/codir_no_encontrados1.log", "w+") or die("Operation Failed!");
	$_LogB = fopen("../datos/borrar_docentes1.log", "w+") or die("Operation Failed!");		
			
	$fp = fopen ("../datos/Codirectores.txt","r");
	while ($data = fgetcsv ($fp, 1000, ",")) {
	    $num = count ($data);
	    $oDocente = new Docente ( );
		$oDocente->setNu_documento ( intval($data[0]) );
		DocenteQuery::getDocentePorDocumento ( $oDocente );
		$oIntegrante = new Integrante ( );
	    $oIntegrante->setCd_docente ( $oDocente->getCd_docente() );
	    $oIntegrante->setCd_tipoinvestigador( intval($data[9]) );
	    if ($oIntegrante->getCd_tipoinvestigador()!=0){
			$oProyecto = new Proyecto ( );
			$oProyecto->setDs_codigo ( $data[1] );
			ProyectoQuery::getProyectoPorCodigo ( $oProyecto );
			if (($oDocente->getNu_ident())&&($oProyecto->getCd_proyecto())){
			
		    	
				$oIntegrante->setCd_proyecto ( $oProyecto->getCd_proyecto() );
				IntegranteQuery::getIntegrantePorId ( $oIntegrante );
				$oIntegrante->setCd_tipoinvestigador( intval($data[9]) );
				$insertar=($oIntegrante->getDt_alta())?0:1;
				 //if($oIntegrante->getCd_tipoinvestigador()==2){
				$oIntegrante->setDt_alta(FuncionesComunes::fechaPHPaMysql($data[7]));
			    $oIntegrante->setDt_baja(FuncionesComunes::fechaPHPaMysql($data[8]));		
						if ($insertar){
							//IntegranteQuery::insertarIntegrante ( $oIntegrante );		
							FuncionesComunes::_log('INSERTADO Proyecto: '.$oProyecto->getDs_codigo().' - Investigador: '.$data[2].', '.$data[3].' - DNI: '.$data[0].' - Tipo: '.$data[9]. ' - Univ: '.$data[4].' - Obs: '.$data[5].' - Categoria: '.$data[6].' - Alta: '.$data[7].' - Baja: '.$data[8],$_Log);	
						}
						else {
							FuncionesComunes::_log('MODIFICADO Proyecto: '.$oProyecto->getDs_codigo().' - Investigador: '.$data[2].', '.$data[3].' - DNI: '.$data[0].' - Tipo: '.$data[9]. ' - Univ: '.$data[4].' - Obs: '.$data[5].' - Categoria: '.$data[6].' - Alta: '.$data[7].' - Baja: '.$data[8],$_Log);	
							IntegranteQuery::modificarIntegrante ( $oIntegrante );
						}
				//  }
			    
			}
			elseif ($oProyecto->getCd_proyecto())	{
				FuncionesComunes::_log('no se encontro el docente Proyecto: '.$oProyecto->getDs_codigo().' - Investigador: '.$data[2].', '.$data[3].' - DNI: '.$data[0].' - Tipo: '.$data[9]. ' - Univ: '.$data[4].' - Obs: '.$data[5].' - Categoria: '.$data[6].' - Alta: '.$data[7].' - Baja: '.$data[8],$_Log);
				$oCategoria = new Categoria();
				$oCategoria->setDs_categoria($data[6]);
				CategoriaQuery::getCategoriaPorDs($oCategoria);
				$cd_categoria = ($oCategoria->getCd_categoria())?$oCategoria->getCd_categoria():1;
				$db = Db::conectar ();
				$id = DocenteQuery::insert_id ( $db );
				$db->sql_close;
				$id = ($id>=90000)?$id+1:90000;
				$oDocente->setNu_ident($id);
				$oDocente->setCd_docente($id);
				$oDocente->setCd_categoria($cd_categoria);
				$oDocente->setDs_nombre(addslashes($data[3]));
			    $oDocente->setDs_apellido(addslashes($data[2]));
			    DocenteQuery::insertarDocente($oDocente); 
			    $oIntegrante->setCd_docente($id);
			    $oIntegrante->setCd_proyecto($oProyecto->getCd_proyecto());
			    $oIntegrante->setDt_alta(FuncionesComunes::fechaPHPaMysql($data[7]));
			    $oIntegrante->setDt_baja(FuncionesComunes::fechaPHPaMysql($data[8]));
			    IntegranteQuery::insertarIntegrante($oIntegrante);
			    if($oIntegrante->getCd_tipoinvestigador()==2){
					FuncionesComunes::_log('Proyecto: '.$oProyecto->getDs_codigo().' - Investigador: '.$data[2].', '.$data[3].' - DNI: '.$data[0].' - Tipo: '.$data[9]. ' - Univ: '.$data[4].' - Obs: '.$data[5].' - Categoria: '.$data[6].' - Alta: '.$data[7].' - Baja: '.$data[8],$_Log);
					FuncionesComunes::_log('DELETE FROM DOCENTE WHERE nu_documento = '.$data[0].';',$_LogB);
			    }
				
			}
	    }
		
				
				
				
	
	}
	fclose ($fp);
	fclose ($_Log);
	fclose ($_LogB);*/
	
	/*$_Log = fopen("../datos/no_cat_ingresados.log", "w+") or die("Operation Failed!");
	$fp = fopen ("../datos/integrantes_no_cat.txt","r");
	while ($data = fgetcsv ($fp, 1000, ",")) {
	    $num = count ($data);
	    $oDocente = new Docente ( );
		$oDocente->setNu_documento ( intval($data[0]) );
		DocenteQuery::getDocentePorDocumento ( $oDocente );
		$oProyecto = new Proyecto ( );
		$oProyecto->setDs_codigo ( $data[1] );
		ProyectoQuery::getProyectoPorCodigo ( $oProyecto );
		if (($oDocente->getNu_ident())&&($oProyecto->getCd_proyecto())){
	    	
		}
		elseif ($oProyecto->getCd_proyecto())	{
			$oCategoria = new Categoria();
			$oCategoria->setDs_categoria($data[6]);
			CategoriaQuery::getCategoriaPorDs($oCategoria);
			$cd_categoria = ($oCategoria->getCd_categoria())?$oCategoria->getCd_categoria():1;
			$db = Db::conectar ();
			$id = DocenteQuery::insert_id ( $db );
			$db->sql_close;
			$id = ($id>=90000)?$id+1:90000;
			$oDocente->setNu_ident($id);
			$oDocente->setCd_docente($id);
			$oDocente->setCd_categoria($cd_categoria);
			$oDocente->setDs_nombre($data[3]);
		    $oDocente->setDs_apellido($data[2]);
		    DocenteQuery::insertarDocente($oDocente); 
		   	$oIntegrante = new Integrante();
		   	$oIntegrante->setCd_tipoinvestigador(0);
		    $oIntegrante->setCd_docente($id);
		    $oIntegrante->setCd_proyecto($oProyecto->getCd_proyecto());
		    $oIntegrante->setDt_alta(FuncionesComunes::fechaPHPaMysql($data[7]));
		    $oIntegrante->setDt_baja(FuncionesComunes::fechaPHPaMysql($data[8]));
		    IntegranteQuery::insertarIntegrante($oIntegrante);
			FuncionesComunes::_log('Proyecto: '.$oProyecto->getDs_codigo().' - ID: '.$oDocente->getCd_docente().' - Investigador: '.$data[2].', '.$data[3]. ' - Univ: '.$data[4].' - Obs: '.$data[5].' - Categoria: '.$data[6].' - Alta: '.$data[7].' - Baja: '.$data[8],$_Log);
			
		}
		
				
				
				
	
	}
	fclose ($fp);
	fclose ($_Log);*/
	
	
	if (isset ( $_GET ['filtro'] ))
		$filtro = $_GET ['filtro']; else
		$filtro = "";
		
	if (isset ( $_GET ['filtroDir'] ))
		$filtroDir = $_GET ['filtroDir']; else
		$filtroDir = "";
		
	if (isset ( $_GET ['filtroFacultad'] ))
		$filtroFacultad = $_GET ['filtroFacultad']; else
		$filtroFacultad = 0;
	
	if (isset ( $_GET ['page'] ))
		$page = $_GET ['page']; else
		$page = 1;
	
	if (isset ( $_GET ['orden'] ))
		$orden = $_GET ['orden']; else
		$orden = 'ASC';
	
	if (isset ( $_GET ['campo'] ))
		$campo = $_GET ['campo']; else
		$campo = 'ds_codigo';
	
	$query_string = "?filtro=$filtro&filtroFacultad=$filtroFacultad&filtroDir=$filtroDir&";
	$xtpl->assign ( 'query_string', $query_string );
	
	if (isset ( $_GET ['er'] ))
		$er = $_GET ['er'];
	if ($er == 1) {
		$xtpl->assign ( 'msj', 'Error: No se pudo eliminar el proyecto seleccionado.' );
		$xtpl->assign ( 'classMsj', 'msjerror' );
		$xtpl->parse ( 'main.msj' );
		
	}
	
	$facultades = FacultadQuery::listar ($filtroFacultad);
	$rowsize = count ( $facultades );
	
	for($i = 0; $i < $rowsize; $i ++) {
		$xtpl->assign ( 'DATA', $facultades [$i] );
		$xtpl->parse ( 'main.facultad' );
	}
	
	
	
	$xtpl->assign ( 'titulo', 'Administraci&oacute;n de proyectos' );
	$pendientes = (($_GET['pendiente']==1)||($_POST['pendiente']==1))?1:0;
	$row_per_page = 25;
	$proyectos = ProyectoQuery::getProyectos( $campo, $orden, $filtro, $filtroFacultad, $filtroDir, $page, $row_per_page, $cd_usuario, $pendientes );
	$count = count ( $proyectos );
	for($i = 0; $i < $count; $i ++) {		
		$proyectos [$i]['ds_codigo']=(($proyectos [$i]['bl_bajapendiente'])&&(($proyectos [$i]['bl_altapendiente'])))?'<span class="BajaAlta">'.$proyectos [$i]['ds_codigo'].'</span>':(($proyectos [$i]['bl_bajapendiente'])?'<span class="Baja">'.$proyectos [$i]['ds_codigo'].'</span>':(($proyectos [$i]['bl_altapendiente'])?'<span class="Alta">'.$proyectos [$i]['ds_codigo'].'</span>':$proyectos [$i]['ds_codigo']));
		$proyectos [$i]['ds_titulo']=(($proyectos [$i]['bl_bajapendiente'])&&(($proyectos [$i]['bl_altapendiente'])))?'<span class="BajaAlta">'.$proyectos [$i]['ds_titulo'].'</span>':(($proyectos [$i]['bl_bajapendiente'])?'<span class="Baja">'.$proyectos [$i]['ds_titulo'].'</span>':(($proyectos [$i]['bl_altapendiente'])?'<span class="Alta">'.$proyectos [$i]['ds_titulo'].'</span>':$proyectos [$i]['ds_titulo']));
		$proyectos [$i]['ds_director']=(($proyectos [$i]['bl_bajapendiente'])&&(($proyectos [$i]['bl_altapendiente'])))?'<span class="BajaAlta">'.$proyectos [$i]['ds_director'].'</span>':(($proyectos [$i]['bl_bajapendiente'])?'<span class="Baja">'.$proyectos [$i]['ds_director'].'</span>':(($proyectos [$i]['bl_altapendiente'])?'<span class="Alta">'.$proyectos [$i]['ds_director'].'</span>':$proyectos [$i]['ds_director']));
		$proyectos [$i]['dt_ini']=(($proyectos [$i]['bl_bajapendiente'])&&(($proyectos [$i]['bl_altapendiente'])))?'<span class="BajaAlta">'.FuncionesComunes::fechaMysqlaPHP($proyectos [$i]['dt_ini']).'</span>':(($proyectos [$i]['bl_bajapendiente'])?'<span class="Baja">'.FuncionesComunes::fechaMysqlaPHP($proyectos [$i]['dt_ini']).'</span>':(($proyectos [$i]['bl_altapendiente'])?'<span class="Alta">'.FuncionesComunes::fechaMysqlaPHP($proyectos [$i]['dt_ini']).'</span>':FuncionesComunes::fechaMysqlaPHP($proyectos [$i]['dt_ini'])));
		$proyectos [$i]['dt_fin']=(($proyectos [$i]['bl_bajapendiente'])&&(($proyectos [$i]['bl_altapendiente'])))?'<span class="BajaAlta">'.FuncionesComunes::fechaMysqlaPHP($proyectos [$i]['dt_fin']).'</span>':(($proyectos [$i]['bl_bajapendiente'])?'<span class="Baja">'.FuncionesComunes::fechaMysqlaPHP($proyectos [$i]['dt_fin']).'</span>':(($proyectos [$i]['bl_altapendiente'])?'<span class="Alta">'.FuncionesComunes::fechaMysqlaPHP($proyectos [$i]['dt_fin']).'</span>':FuncionesComunes::fechaMysqlaPHP($proyectos [$i]['dt_fin'])));
		$proyectos [$i]['ds_facultad']=(($proyectos [$i]['bl_bajapendiente'])&&(($proyectos [$i]['bl_altapendiente'])))?'<span class="BajaAlta">'.$proyectos [$i]['ds_facultad'].'</span>':(($proyectos [$i]['bl_bajapendiente'])?'<span class="Baja">'.$proyectos [$i]['ds_facultad'].'</span>':(($proyectos [$i]['bl_altapendiente'])?'<span class="Alta">'.$proyectos [$i]['ds_facultad'].'</span>':$proyectos [$i]['ds_facultad']));

		$xtpl->assign ( 'DATOS', $proyectos [$i] );
		$xtpl->parse ( 'main.row' );
	}
	
	/***************************************************
	 * PAGINADOR
	 **************************************************/
	
	$num_rows = ProyectoQuery::getCountProyectos ( $filtro, $filtroFacultad, $filtroDir, $cd_usuario, $pendientes );
	$num_pages = ceil ( $num_rows / $row_per_page );
	
	$url = 'index.php?orden=' . $orden . '&campo=' . $campo . '&filtro=' . $filtro. '&filtroFacultad=' . $filtroFacultad;
	$cssclassotherpage = 'paginadorOtraPagina';
	$cssclassactualpage = 'paginadorPaginaActual';
	$ds_pag_anterior = 0; //$gral['pag_ant'];
	$ds_pag_siguiente = 2; //$gral['pag_sig'];
	$imp_pag = new Paginador ( $url, $num_pages, $page, $cssclassotherpage, $cssclassactualpage, $num_rows );
	$paginador = $imp_pag->imprimirPaginado ();
	$resultados = $imp_pag->imprimirResultados ();
	
	$imgCODAsc = (($campo=='ds_codigo')&&($orden=='ASC'))?'<img class="hrefImg" title="Ordenar por codigo asc" src="../img/asc.jpg" />':'';
	$imgCODDesc = (($campo=='ds_codigo')&&($orden=='DESC'))?'<img class="hrefImg" title="Ordenar por codigo desc" src="../img/desc.jpg" />':'';
	
	$imgTITAsc = (($campo=='ds_titulo')&&($orden=='ASC'))?'<img class="hrefImg" title="Ordenar por titulo asc" src="../img/asc.jpg" />':'';
	$imgTITDesc = (($campo=='ds_titulo')&&($orden=='DESC'))?'<img class="hrefImg" title="Ordenar por titulo desc" src="../img/desc.jpg" />':'';
	
	$imgDIRAsc = (($campo=='ds_director')&&($orden=='ASC'))?'<img class="hrefImg" title="Ordenar por director asc" src="../img/asc.jpg" />':'';
	$imgDIRDesc = (($campo=='ds_director')&&($orden=='DESC'))?'<img class="hrefImg" title="Ordenar por director desc" src="../img/desc.jpg" />':'';
	
	$imgINIAsc = (($campo=='dt_ini')&&($orden=='ASC'))?'<img class="hrefImg" title="Ordenar por inicio asc" src="../img/asc.jpg" />':'';
	$imgINIDesc = (($campo=='dt_ini')&&($orden=='DESC'))?'<img class="hrefImg" title="Ordenar por inicio desc" src="../img/desc.jpg" />':'';
	
	$imgFINAsc = (($campo=='dt_fin')&&($orden=='ASC'))?'<img class="hrefImg" title="Ordenar por fin asc" src="../img/asc.jpg" />':'';
	$imgFINDesc = (($campo=='dt_fin')&&($orden=='DESC'))?'<img class="hrefImg" title="Ordenar por fin desc" src="../img/desc.jpg" />':'';
	
	$imgFACAsc = (($campo=='ds_facultad')&&($orden=='ASC'))?'<img class="hrefImg" title="Ordenar por facultad asc" src="../img/asc.jpg" />':'';
	$imgFACDesc = (($campo=='ds_facultad')&&($orden=='DESC'))?'<img class="hrefImg" title="Ordenar por facultad desc" src="../img/desc.jpg" />':'';
	
	$imgCOD=($imgCODAsc!='')?$imgCODAsc:(($imgCODDesc!='')?$imgCODDesc:'');
	$imgTIT=($imgTITAsc!='')?$imgTITAsc:(($imgTITDesc!='')?$imgTITDesc:'');
	$imgDIR=($imgDIRAsc!='')?$imgDIRAsc:(($imgDIRDesc!='')?$imgDIRDesc:'');
	$imgINI=($imgINIAsc!='')?$imgINIAsc:(($imgINIDesc!='')?$imgINIDesc:'');
	$imgFIN=($imgFINAsc!='')?$imgFINAsc:(($imgFINDesc!='')?$imgFINDesc:'');
	$imgFAC=($imgFACAsc!='')?$imgFACAsc:(($imgFACDesc!='')?$imgFACDesc:'');
	
	$inverso=($orden=='DESC')?'ASC':'DESC';
	
	$xtpl->assign ( 'imgCOD', $imgCOD );
	$xtpl->assign ( 'imgTIT', $imgTIT );
	$xtpl->assign ( 'imgDIR', $imgDIR );
	$xtpl->assign ( 'imgINI', $imgINI );
	$xtpl->assign ( 'imgFIN', $imgFIN );
	$xtpl->assign ( 'imgFAC', $imgFAC );
	$xtpl->assign ( 'orden', $inverso );
	$xtpl->assign ( 'filtro', $filtro );
	$xtpl->assign ( 'pendiente', $pendientes );
	$xtpl->assign ( 'filtroDir', $filtroDir );
	$xtpl->assign ( 'resultado', $resultados );
	$xtpl->parse ( 'main.resultado' );
	
	$xtpl->assign ( 'PAG', $paginador );
	$xtpl->parse ( 'main.PAG' );
	$xtpl->parse ( 'main' );
	$xtpl->out ( 'main' );

} else
	header ( 'Location:../includes/accesodenegado.php' );
?>