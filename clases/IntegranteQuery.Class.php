<?php
class IntegranteQuery {

	function getIntegrantePorId(Integrante $obj) {
		$db = Db::conectar ();
		$cd_proyecto = $obj->getCd_proyecto ();
		$cd_docente = $obj->getCd_docente ();
		$sql = "SELECT * FROM integrante WHERE cd_proyecto = $cd_proyecto and cd_docente = $cd_docente";
		$result = $db->sql_query ( $sql );
		if ($db->sql_numrows () > 0) {
			$tc = $db->sql_fetchassoc ( $result );
			$obj->setCd_tipoinvestigador ( $tc ['cd_tipoinvestigador'] );
			$obj->setCd_estado( $tc ['cd_estado'] );
			$obj->setDt_alta ( $tc ['dt_alta'] );
			$obj->setDt_baja ( $tc ['dt_baja'] );
			$obj->setDt_altapendiente ( $tc ['dt_altapendiente'] );
			$obj->setDt_bajapendiente ( $tc ['dt_bajapendiente'] );
			$obj->setNu_horasinv ( $tc ['nu_horasinv'] );
			$obj->setNu_horasinvAnt ( $tc ['nu_horasinvAnt'] );
			$obj->setBl_insertado ( $tc ['bl_insertado'] );
			$obj->setDs_actividades ( $tc ['ds_actividades'] );
			$obj->setDs_curriculum ( $tc ['ds_curriculum'] );
			$obj->setDs_consecuencias ( $tc ['ds_consecuencias'] );
			$obj->setDs_motivos ( $tc ['ds_motivos'] );
			$obj->setDt_cambioHS ( $tc ['dt_cambioHS'] );
			$obj->setDs_reduccionHS ( $tc ['ds_reduccionHS'] );
		}
		$db->sql_close;
		return ($result);
	}
	
	function getIntegrantes($attr, $orden, $filtro, $page, $row_per_page, $cd_proyecto){
		
		$limitInf = (($page - 1) * $row_per_page);
		$limitSup = ($page * $row_per_page);
		$sql = "SELECT I.cd_proyecto, I.cd_docente, CONCAT(nu_precuil,'-',nu_documento,'-', nu_postcuil) AS nu_cuil, CONCAT(ds_apellido, ', ', ds_nombre) as ds_investigador, ds_categoria, nu_dedinv, ds_deddoc, dt_alta, dt_baja, dt_altapendiente, dt_bajapendiente, F.ds_facultad, I.cd_tipoinvestigador, ds_tipoinvestigador, I.nu_horasinv, nu_documento, I.cd_estado, EI.ds_estado, I.nu_horasinv, CAR.ds_cargo, CASE  WHEN beca.cd_beca IS NULL THEN (CASE D.bl_becario WHEN '1' THEN CONCAT(D.ds_tipobeca, '-', D.ds_orgbeca) ELSE '' END) ELSE CONCAT(beca.ds_tipobeca, '-UNLP') END as becario, CASE WHEN (D.cd_carrerainv IS NULL OR D.cd_carrerainv = 11) THEN ''  ELSE CONCAT(carrerainv.ds_carrerainv, '-', organismo.ds_codigo) END carrera FROM integrante I";
		$sql .= " INNER JOIN docente D ON I.cd_docente = D.cd_docente LEFT JOIN categoria C ON D.cd_categoria = C.cd_categoria LEFT JOIN facultad F ON D.cd_facultad = F.cd_facultad INNER JOIN deddoc DD ON D.cd_deddoc = DD.cd_deddoc LEFT JOIN tipoinvestigador TI ON I.cd_tipoinvestigador = TI.cd_tipoinvestigador INNER JOIN estadointegrante EI ON I.cd_estado = EI.cd_estado LEFT JOIN cargo CAR ON D.cd_cargo = CAR.cd_cargo LEFT JOIN beca ON D.cd_docente = beca.cd_docente AND beca.dt_hasta >= '".date('Y-m-d')."' LEFT JOIN carrerainv ON D.cd_carrerainv = carrerainv.cd_carrerainv LEFT JOIN organismo ON D.cd_organismo = organismo.cd_organismo";
		$sql .= " WHERE  CONCAT(ds_apellido, ', ', ds_nombre) LIKE '%$filtro%' AND I.cd_proyecto = $cd_proyecto";
		
		$sql .= " ORDER BY $attr $orden LIMIT $limitInf,$row_per_page"; 
		$db = Db::conectar ();
		$result = $db->sql_query ( $sql );
		$res = array ( );
		$i = 0;
		if ($db->sql_numrows () > 0) {
			while ( $usr = $db->sql_fetchassoc ( $result ) ) {
				$res [$i] = array ('cd_proyecto' => $usr ['cd_proyecto'], 'cd_docente' => $usr ['cd_docente'], 'nu_cuil' => $usr ['nu_cuil'], 'ds_investigador' => $usr ['ds_investigador'], 'ds_categoria' => $usr ['ds_categoria'], 'ds_facultad' => $usr ['ds_facultad'], 'dt_alta' => $usr ['dt_alta'], 'dt_baja' => $usr ['dt_baja'], 'dt_altapendiente' => $usr ['dt_altapendiente'], 'dt_bajapendiente' => $usr ['dt_bajapendiente'], 'nu_dedinv' => $usr ['nu_dedinv'], 'ds_deddoc' => $usr ['ds_deddoc'], 'cd_tipoinvestigador' => $usr ['cd_tipoinvestigador'], 'ds_tipoinvestigador' => $usr ['ds_tipoinvestigador'], 'nu_horasinv' => $usr ['nu_horasinv'], 'nu_documento' => $usr ['nu_documento'], 'cd_estado' => $usr ['cd_estado'], 'ds_estado' => $usr ['ds_estado'], 'nu_horasinv' => $usr ['nu_horasinv'], 'ds_cargo' => $usr ['ds_cargo'], 'becario' => $usr ['becario'], 'carrera' => $usr ['carrera'] );
				$i ++;
			}
		}
		$db->sql_close;
		return ($res);
	}
	
	function getInsertados($cd_tipoacreditacion){
		
		
		$sql = "SELECT I.cd_proyecto, I.cd_docente, nu_documento, dt_alta, dt_baja, P.ds_codigo, I.nu_horasinv, I.cd_tipoinvestigador FROM integrante I";
		$sql .= " INNER JOIN docente D ON I.cd_docente = D.cd_docente INNER JOIN proyecto P ON I.cd_proyecto = P.cd_proyecto";
		$sql .= " WHERE (dt_alta >= '".$_SESSION ['nu_yearSessionP']."-01-01' OR dt_baja >= '".$_SESSION ['nu_yearSessionP']."-01-01') AND I.cd_estado = 3 AND P.cd_tipoacreditacion = $cd_tipoacreditacion";
		
		$db = Db::conectar ();
		$result = $db->sql_query ( $sql );
		$res = array ( );
		$i = 0;
		if ($db->sql_numrows () > 0) {
			while ( $usr = $db->sql_fetchassoc ( $result ) ) {
				$res [$i] = array ('cd_proyecto' => $usr ['cd_proyecto'], 'cd_docente' => $usr ['cd_docente'], 'nu_documento' => $usr ['nu_documento'], 'dt_alta' => $usr ['dt_alta'], 'dt_baja' => $usr ['dt_baja'], 'ds_codigo' => $usr ['ds_codigo'], 'nu_horasinv' => $usr ['nu_horasinv'], 'cd_tipoinvestigador' => $usr ['cd_tipoinvestigador']);
				$i ++;
			}
		}
		//echo $sql;
		$db->sql_close;
		return ($res);
	}
	
	function getModificados($attr, $orden, $filtroModificacion, $page, $row_per_page){
		
		$limitInf = (($page - 1) * $row_per_page);
		$limitSup = ($page * $row_per_page);
		$sql = "SELECT I.cd_proyecto, I.cd_docente, CONCAT(nu_precuil,'-',nu_documento,'-', nu_postcuil) AS nu_cuil, CONCAT(ds_apellido, ', ', ds_nombre) as ds_investigador, dt_alta, P.ds_codigo, TM.ds_tipomodificacion FROM integrante I";
		$sql .= " INNER JOIN docente D ON I.cd_docente = D.cd_docente INNER JOIN tipomodificacion TM ON D.cd_tipomodificacion = TM.cd_tipomodificacion INNER JOIN proyecto P ON I.cd_proyecto = P.cd_proyecto";
		$sql .= " WHERE D.cd_tipomodificacion <> 0 AND dt_alta >= '".$_SESSION ['nu_yearSessionP']."-01-01' AND I.bl_insertado = 1 AND I.cd_estado = 3";
		if (($filtroModificacion != 0)) {
			$sql .= " AND D.cd_tipomodificacion='$filtroModificacion'";
		}
		$sql .= " ORDER BY $attr $orden LIMIT $limitInf,$row_per_page"; 
		$db = Db::conectar ();
		$result = $db->sql_query ( $sql );
		$res = array ( );
		$i = 0;
		if ($db->sql_numrows () > 0) {
			while ( $usr = $db->sql_fetchassoc ( $result ) ) {
				$res [$i] = array ('cd_proyecto' => $usr ['cd_proyecto'], 'cd_docente' => $usr ['cd_docente'], 'nu_cuil' => $usr ['nu_cuil'], 'ds_investigador' => $usr ['ds_investigador'], 'ds_tipomodificacion' => $usr ['ds_tipomodificacion'], 'dt_alta' => $usr ['dt_alta'], 'ds_codigo' => $usr ['ds_codigo']);
				$i ++;
			}
		}
		$db->sql_close;
		return ($res);
	}
	
	function getCountModificados($filtroModificacion) {
		$db = Db::conectar ( );
		$sql = "SELECT count(*) FROM integrante I";
		$sql .= " INNER JOIN docente D ON I.cd_docente = D.cd_docente INNER JOIN tipomodificacion TM ON D.cd_tipomodificacion = TM.cd_tipomodificacion INNER JOIN proyecto P ON I.cd_proyecto = P.cd_proyecto";
		$sql .= " WHERE D.cd_tipomodificacion <> 0 AND dt_alta >= '".$_SESSION ['nu_yearSessionP']."-01-01' AND I.bl_insertado = 1 AND I.cd_estado = 3";
		if (($filtroModificacion != 0)) {
			$sql .= " AND D.cd_tipomodificacion='$filtroModificacion'";
		}
		$result = $db->sql_query ( $sql );
		$cant = $db->sql_result ( $result, 0 );
		$db->sql_close;
		return (( int ) $cant);
	}
	
	function getPendientes($attr, $orden, $filtroEstado, $filtroFacultad, $page, $row_per_page, $cd_usuario){
		
		$limitInf = (($page - 1) * $row_per_page);
		$limitSup = ($page * $row_per_page);
		$sql = "SELECT I.cd_docente, P.cd_proyecto, P.ds_codigo,CONCAT(DOCDIR.ds_apellido,', ',DOCDIR.ds_nombre) as ds_director, F.ds_facultad, E.ds_estado, CONCAT(D.ds_apellido,', ',D.ds_nombre) as ds_investigador,  D.nu_documento,  I.dt_alta, I.dt_baja, U.cd_usuario, E.cd_estado, I.ds_tipoinvestigador  FROM docente D INNER JOIN `integrante` I ON D.cd_docente = I.cd_docente";
		$sql .= " INNER JOIN proyecto P ON I.cd_proyecto = P.cd_proyecto INNER JOIN estadointegrante E ON I.cd_estado = E.cd_estado INNER JOIN facultad F ON P.cd_facultad = F.cd_facultad ";
		$sql .= " INNER JOIN integrante DIR ON P.cd_proyecto = DIR.cd_proyecto INNER JOIN docente DOCDIR ON DIR.cd_docente = DOCDIR.cd_docente INNER JOIN usuarioproyecto U ON DOCDIR.nu_documento = U.nu_documento LEFT JOIN tipoinvestigador TI ON I.cd_tipoinvestigador = TI.cd_tipoinvestigador
		";
		$sql .= " WHERE I.`cd_estado` != 3 AND DIR.cd_tipoinvestigador = 1";
		if (($filtroEstado != 0)) {
			$sql .= " AND I.cd_estado='$filtroEstado'";
		}
		if (($filtroFacultad != 0)) {
			$sql .= " AND P.cd_facultad='$filtroFacultad'";
		}
		$sql .=(PermisoQuery::permisosDeUsuario( $cd_usuario, "Todos los proyectos" ))?'':' AND F.cd_facultad = '.$_SESSION ["cd_facultadSessionP"];
		$sql .= " ORDER BY $attr $orden LIMIT $limitInf,$row_per_page"; 
		//echo $sql;
		$db = Db::conectar ();
		$result = $db->sql_query ( $sql );
		$res = array ( );
		$i = 0;
		if ($db->sql_numrows () > 0) {
			while ( $usr = $db->sql_fetchassoc ( $result ) ) {
				$res [$i] = array ('cd_proyecto' => $usr ['cd_proyecto'], 'cd_docente' => $usr ['cd_docente'], 'ds_codigo' => $usr ['ds_codigo'], 'ds_director' => $usr ['ds_director'], 'ds_facultad' => $usr ['ds_facultad'], 'ds_estado' => $usr ['ds_estado'], 'ds_investigador' => $usr ['ds_investigador'], 'nu_documento' => $usr ['nu_documento'], 'dt_alta' => $usr ['dt_alta'], 'dt_baja' => $usr ['dt_baja'], 'cd_usuario' => $usr ['cd_usuario'], 'cd_estado' => $usr ['cd_estado'], 'ds_tipoinvestigador' => $usr ['ds_tipoinvestigador']);
				$i ++;
			}
		}
		$db->sql_close;
		return ($res);
	}
	
	function getCountPendientes($filtroEstado) {
		$db = Db::conectar ( );
		$sql = "SELECT count(*) FROM docente D INNER JOIN `integrante` I ON D.cd_docente = I.cd_docente";
		$sql .= " INNER JOIN proyecto P ON I.cd_proyecto = P.cd_proyecto INNER JOIN estadointegrante E ON I.cd_estado = E.cd_estado INNER JOIN facultad F ON P.cd_facultad = F.cd_facultad ";
		$sql .= " INNER JOIN integrante DIR ON P.cd_proyecto = DIR.cd_proyecto INNER JOIN docente DOCDIR ON DIR.cd_docente = DOCDIR.cd_docente INNER JOIN usuarioproyecto U ON DOCDIR.nu_documento = U.nu_documento LEFT JOIN tipoinvestigador TI ON I.cd_tipoinvestigador = TI.cd_tipoinvestigador
		";
		$sql .= " WHERE I.`cd_estado` != 3 AND DIR.cd_tipoinvestigador = 1";
		if (($filtroEstado != 0)) {
			$sql .= " AND I.cd_estado='$filtroEstado'";
		}
		if (($filtroFacultad != 0)) {
			$sql .= " AND P.cd_facultad='$filtroFacultad'";
		}
		$sql .=(PermisoQuery::permisosDeUsuario( $cd_usuario, "Todos los proyectos" ))?'':' AND F.cd_facultad = '.$_SESSION ["cd_facultadSessionP"];
		$result = $db->sql_query ( $sql );
		$cant = $db->sql_result ( $result, 0 );
		$db->sql_close;
		return (( int ) $cant);
	}
	
	
	
	
	function insertarIntegrante(Integrante $obj) {
		$db = Db::conectar ();
		$cd_docente = $obj->getCd_docente();
		$cd_proyecto = $obj->getCd_proyecto();
		$dt_alta =($obj->getDt_alta())?$obj->getDt_alta():'0000-00-00';
		$dt_baja = ($obj->getDt_baja())?$obj->getDt_baja():'0000-00-00';
		$cd_tipoinvestigador = $obj->getCd_tipoinvestigador();
		$cd_estado = $obj->getCd_estado();
		$dt_altapendiente = ($obj->getDt_altapendiente())?$obj->getDt_altapendiente():'0000-00-00';
		$dt_bajapendiente =($obj->getDt_bajapendiente())?$obj->getDt_bajapendiente():'0000-00-00';
		$nu_horasinv = $obj->getNu_horasinv();
		$ds_curriculum = $obj->getDs_curriculum();
		$ds_actividades = $obj->getDs_actividades();
		$ds_consecuencias = $obj->getDs_consecuencias();
		$ds_motivos = $obj->getDs_motivos();
		$bl_insertado = 1;
		$sql = "INSERT INTO integrante (cd_proyecto, dt_alta, dt_baja, cd_tipoinvestigador, cd_docente, dt_altapendiente, dt_bajapendiente, nu_horasinv, bl_insertado, ds_curriculum, ds_actividades, cd_estado, ds_consecuencias, ds_motivos) VALUES ('$cd_proyecto', '$dt_alta', '$dt_baja', '$cd_tipoinvestigador', '$cd_docente', '$dt_altapendiente', '$dt_bajapendiente', '$nu_horasinv', '$bl_insertado', '$ds_curriculum', '$ds_actividades', '$cd_estado', '$ds_consecuencias', '$ds_motivos') ";
		$result = $db->sql_query ( $sql );
		$db->sql_close;
		return $result;
	}
	
	function eliminarIntegrante(Integrante $obj){
		$db = Db::conectar ();
		$cd_docente = $obj->getCd_docente();
		$cd_proyecto = $obj->getCd_proyecto();
		$sql = "DELETE FROM integrante WHERE cd_proyecto = $cd_proyecto and cd_docente = $cd_docente";
		$result = $db->sql_query ( $sql );
		$db->sql_close;
		return $result;
	}

	function modificarIntegrante(Integrante $obj){
		$db = Db::conectar ();
		$cd_docente = $obj->getCd_docente();
		$cd_proyecto = $obj->getCd_proyecto();
		$dt_alta = $obj->getDt_alta();
		$dt_baja = $obj->getDt_baja();
		$cd_tipoinvestigador = $obj->getCd_tipoinvestigador();
		$cd_estado = $obj->getCd_estado();
		$dt_altapendiente = $obj->getDt_altapendiente();
		$dt_bajapendiente = $obj->getDt_bajapendiente();
		$nu_horasinv = $obj->getNu_horasinv();
		$bl_insertado = $obj->getBl_insertado();
		$ds_curriculum = $obj->getDs_curriculum();
		$ds_actividades = $obj->getDs_actividades();
		$ds_consecuencias = $obj->getDs_consecuencias();
		$ds_motivos = $obj->getDs_motivos();
		$sql = "UPDATE integrante SET dt_alta='$dt_alta', dt_baja='$dt_baja', cd_tipoinvestigador='$cd_tipoinvestigador', dt_altapendiente='$dt_altapendiente', dt_bajapendiente='$dt_bajapendiente', nu_horasinv='$nu_horasinv', bl_insertado='$bl_insertado', ds_curriculum='$ds_curriculum', ds_actividades='$ds_actividades', cd_estado='$cd_estado', ds_consecuencias='$ds_consecuencias', ds_motivos='$ds_motivos'";
		$sql .= " WHERE cd_proyecto = $cd_proyecto and cd_docente = $cd_docente";
		$result = $db->sql_query ( $sql );
		$db->sql_close;
		return $result;
	}
	
	
		
	function cambioHS(Integrante $obj){
		$db = Db::conectar ();
		$cd_docente = $obj->getCd_docente();
		$cd_proyecto = $obj->getCd_proyecto();
		$cd_estado = $obj->getCd_estado();
		$nu_horasinv = $obj->getNu_horasinv();
		$nu_horasinvAnt = $obj->getNu_horasinvAnt();
		$dt_cambioHS  = $obj->getDt_cambioHS();
		$ds_reduccionHS = $obj->getDs_reduccionHS();
		$sql = "UPDATE integrante SET nu_horasinv='$nu_horasinv', nu_horasinvAnt='$nu_horasinvAnt', dt_cambioHS='$dt_cambioHS', cd_estado='$cd_estado', ds_reduccionHS='$ds_reduccionHS'";
		$sql .= " WHERE cd_proyecto = $cd_proyecto and cd_docente = $cd_docente";
		$result = $db->sql_query ( $sql );
		$db->sql_close;
		return $result;
	}
	
	function tieneAltasPendientes($cd_proyecto) {
		$db = Db::conectar ();
		
		$sql = "SELECT count( * )FROM integrante WHERE cd_proyecto = '$cd_proyecto' AND cd_estado = '2'";
		$result = $db->sql_query ( $sql );
		$cant = $db->sql_result ( $result, 0 );
		$db->sql_close ();
		return ($cant > 0);
	}
	
	function tieneBajasPendientes($cd_proyecto) {
		$db = Db::conectar ();
		
		$sql = "SELECT count( * )FROM integrante WHERE cd_proyecto = '$cd_proyecto' AND cd_estado = '5'";
		$result = $db->sql_query ( $sql );
		$cant = $db->sql_result ( $result, 0 );
		$db->sql_close ();
		return ($cant > 0);
	}
	
	function masDeUnProyecto($cd_docente, $max) {
		$db = Db::conectar ();
		$dt_fecha = date($_SESSION['nu_yearSessionP'].'-'.$_SESSION ["nu_mesSessionP"].'-d');
		$sql = "SELECT count( * )FROM integrante I INNER JOIN proyecto P ON I.cd_proyecto = P.cd_proyecto WHERE P.dt_fin >= '$dt_fecha' AND cd_docente = '$cd_docente' AND cd_tipoinvestigador <> 6 AND (dt_baja IS NULL OR dt_baja = '0000-00-00' OR dt_baja > '".date('Y-m-d')."' OR I.cd_estado = 4 OR I.cd_estado = 5) AND P.dt_ini < '".($_SESSION ['nu_yearSessionP'] )."-12-31'AND P.cd_estado <> 4 AND P.cd_estado <> 7";
		$result = $db->sql_query ( $sql );
		$cant = $db->sql_result ( $result, 0 );
		$db->sql_close ();
		return ($cant > $max);
	}
	
	function masDeTresIntegrantes($cd_proyecto) {
		$db = Db::conectar ();
		
		$sql = "SELECT count( * )FROM integrante WHERE cd_proyecto = '$cd_proyecto' AND (dt_baja IS NULL OR dt_baja = '0000-00-00' AND cd_tipoinvestigador <> 6 AND cd_estado = 3)";
		$result = $db->sql_query ( $sql );
		$cant = $db->sql_result ( $result, 0 );
		$db->sql_close ();
		return ($cant > 3);
	}
	
	
	
	
}
?>