<?php
class ProyectoQuery {

	function getProyectoPorId(Proyecto $obj) {
		$db = Db::conectar ();
		$cd_proyecto = $obj->getCd_proyecto ();
		$sql = "SELECT P.cd_proyecto, ds_titulo, P.ds_codigo, I.cd_docente, CONCAT(ds_apellido, ', ', ds_nombre) as ds_director, dt_ini, dt_fin, F.cd_facultad, F.ds_facultad, nu_duracion, bl_altapendiente, bl_bajapendiente, ds_abstract1, ds_clave1, ds_clave2, ds_clave3, ds_clave4, ds_clave5, ds_clave6, ds_abstracteng, ds_claveeng1, ds_claveeng2, ds_claveeng3, ds_claveeng4, ds_claveeng5, ds_claveeng6, CONCAT(C.ds_codigo,' - ',C.ds_campo) as ds_campo, Dis.ds_disciplina, E.ds_especialidad, ds_linea, ds_tipo FROM proyecto P";
		$sql .= " LEFT JOIN facultad F ON P.cd_facultad = F.cd_facultad INNER JOIN integrante I ON P.cd_proyecto = I.cd_proyecto INNER JOIN docente D ON I.cd_docente = D.cd_docente ";
		$sql .= " LEFT JOIN disciplina Dis ON P.cd_disciplina = Dis.cd_disciplina ";
		$sql .= " LEFT JOIN especialidad E ON P.cd_especialidad = E.cd_especialidad ";
		$sql .= " LEFT JOIN campo C ON P.cd_campo = C.cd_campo ";
		$sql .= " WHERE I.cd_tipoinvestigador = 1 AND P.cd_proyecto = $cd_proyecto";
		

		$result = $db->sql_query ( $sql );
		if ($db->sql_numrows () > 0) {
			$tc = $db->sql_fetchassoc ( $result );
			$obj->setCd_proyecto ( $tc ['cd_proyecto'] );
			$obj->setCd_facultad ( $tc ['cd_facultad'] );
			$obj->setDs_facultad ( $tc ['ds_facultad'] );
			$obj->setDs_codigo ( $tc ['ds_codigo'] );
			$obj->setDs_titulo ( $tc ['ds_titulo'] );
			$obj->setDt_fin ( $tc ['dt_fin'] );
			$obj->setDt_ini ( $tc ['dt_ini'] );
			$obj->setCd_director ( $tc ['cd_docente'] );
			$obj->setDs_director ( $tc ['ds_director'] );
			$obj->setNu_duracion( $tc ['nu_duracion'] );
			$obj->setBl_altapendiente( $tc ['bl_altapendiente'] );
			$obj->setBl_bajapendiente( $tc ['bl_bajapendiente'] );
			$obj->setDs_abstract1($tc ['ds_abstract1']);
			$obj->setDs_clave1($tc ['ds_clave1']);
			$obj->setDs_clave2($tc ['ds_clave2']);
			$obj->setDs_clave3($tc ['ds_clave3']);
			$obj->setDs_clave4($tc ['ds_clave4']);
			$obj->setDs_clave5($tc ['ds_clave5']);
			$obj->setDs_clave6($tc ['ds_clave6']);
			$obj->setDs_abstracteng($tc ['ds_abstracteng']);
			$obj->setDs_claveeng1($tc ['ds_claveeng1']);
			$obj->setDs_claveeng2($tc ['ds_claveeng2']);
			$obj->setDs_claveeng3($tc ['ds_claveeng3']);
			$obj->setDs_claveeng4($tc ['ds_claveeng4']);
			$obj->setDs_claveeng5($tc ['ds_claveeng5']);
			$obj->setDs_claveeng6($tc ['ds_claveeng6']);
			$obj->setDs_campo($tc ['ds_campo']);
			$obj->setDs_disciplina($tc ['ds_disciplina']);
			$obj->setDs_especialidad($tc ['ds_especialidad']);
			$obj->setDs_linea($tc ['ds_linea']);
			$obj->setDs_tipo($tc ['ds_tipo']);
		}
		$db->sql_close;
		return ($result);
	}
	
	function getProyectoPorCodigo(Proyecto $obj) {
		$db = Db::conectar (  );
		$ds_codigo = $obj->getDs_codigo();
		if ($ds_codigo){
			$sql = "SELECT cd_proyecto FROM proyecto WHERE ds_codigo = '$ds_codigo'";
			$result = $db->sql_query ( $sql );
			$i = 0;
			if ($db->sql_numrows () > 0) {
				while ( $usr = $db->sql_fetchassoc ( $result ) ) {
					$obj->setCd_proyecto ( $usr ['cd_proyecto'] );
					$i ++;
				}
			}
		}
		$db->sql_close;
		return ($result);
	}
	
	
	function getProyectos($attr, $orden, $filtro, $filtroFacultad, $filtroDir, $page, $row_per_page, $cd_usuario, $pendientes){
		
		$limitInf = (($page - 1) * $row_per_page);
		$limitSup = ($page * $row_per_page);
		$sql = "SELECT P.cd_proyecto, ds_titulo, ds_codigo, CONCAT(ds_apellido, ', ', ds_nombre) as ds_director, dt_ini, dt_fin, bl_bajapendiente, bl_altapendiente, F.ds_facultad, E.ds_estado FROM proyecto P";
		$sql .= " LEFT JOIN facultad F ON P.cd_facultad = F.cd_facultad LEFT JOIN integrante I ON P.cd_proyecto = I.cd_proyecto INNER JOIN docente D ON I.cd_docente = D.cd_docente LEFT JOIN estadoproyecto E ON P.cd_estado = E.cd_estado ";
		$sql .= (PermisoQuery::permisosDeUsuario( $cd_usuario, "Proyectos propios" ))?' LEFT JOIN usuarioproyecto U ON U.nu_documento = D.nu_documento':'';
		$year = Date("Y");
		//$year = $_SESSION ['nu_yearSessionP'];
		$sql .= " WHERE I.cd_tipoinvestigador = 1 AND ds_codigo LIKE '%$filtro%' ";
		$sql .= (PermisoQuery::permisosDeUsuario( $cd_usuario, "Alta perfil" ))?"":" AND P.cd_estado = 5";
		$sql .= (PermisoQuery::permisosDeUsuario( $cd_usuario, "Todos los proyectos" ))?"":" AND dt_fin > '".(($year)-1)."-12-31'";
		if (($filtroFacultad != 0)) {
			$sql .= " AND F.cd_facultad='$filtroFacultad'";
		}
		if (($filtroDir != '')) {
			$sql .= " AND CONCAT(ds_apellido, ', ', ds_nombre) LIKE '%$filtroDir%'";
		}
		$sql .=(PermisoQuery::permisosDeUsuario( $cd_usuario, "Todos los proyectos" ))?'':((PermisoQuery::permisosDeUsuario( $cd_usuario, "Proyectos propios" ))?' AND U.cd_usuario = '.$cd_usuario:' AND F.cd_facultad = '.$_SESSION ["cd_facultadSessionP"]);
		if ($pendientes) {
			$sql .= " AND ((bl_altapendiente=1) OR (bl_bajapendiente=1))";
		}
		$sql .= " ORDER BY $attr $orden LIMIT $limitInf,$row_per_page"; 
		$db = Db::conectar ();
		$result = $db->sql_query ( $sql );
		$res = array ( );
		$i = 0;
		if ($db->sql_numrows () > 0) {
			while ( $usr = $db->sql_fetchassoc ( $result ) ) {
				$res [$i] = array ('cd_proyecto' => $usr ['cd_proyecto'], 'ds_codigo' => $usr ['ds_codigo'], 'ds_titulo' => $usr ['ds_titulo'], 'ds_director' => $usr ['ds_director'], 'ds_facultad' => $usr ['ds_facultad'], 'dt_ini' => $usr ['dt_ini'], 'dt_fin' => $usr ['dt_fin'], 'bl_altapendiente' => $usr ['bl_altapendiente'], 'bl_bajapendiente' => $usr ['bl_bajapendiente'], 'ds_estado' => $usr ['ds_estado'] );
				$i ++;
			}
		}
		$db->sql_close;
		return ($res);
	}

	function getCountProyectos($filtro, $filtroFacultad, $filtroDir, $cd_usuario, $pendientes) {
		
		$sql = "SELECT count(*) FROM proyecto P";
		$sql .= " LEFT JOIN facultad F ON P.cd_facultad = F.cd_facultad INNER JOIN integrante I ON P.cd_proyecto = I.cd_proyecto INNER JOIN docente D ON I.cd_docente = D.cd_docente ";
		$sql .= (PermisoQuery::permisosDeUsuario( $cd_usuario, "Proyectos propios" ))?' LEFT JOIN usuarioproyecto U ON U.nu_documento = D.nu_documento':'';
		$year = Date("Y");
		//$year = $_SESSION ['nu_yearSessionP'];
		$sql .= " WHERE I.cd_tipoinvestigador = 1 AND ds_codigo LIKE '%$filtro%' ";
		$sql .= (PermisoQuery::permisosDeUsuario( $cd_usuario, "Alta perfil" ))?"":" AND P.cd_estado = 5";
		$sql .= (PermisoQuery::permisosDeUsuario( $cd_usuario, "Todos los proyectos" ))?"":" AND dt_fin > '".(($year)-1)."-12-31'";
		if (($filtroFacultad != 0)) {
			$sql .= " AND P.cd_facultad='$filtroFacultad'";
		}
		if (($filtroDir != '')) {
			$sql .= " AND CONCAT(ds_apellido, ', ', ds_nombre) LIKE '%$filtroDir%'";
		}
		$sql .=(PermisoQuery::permisosDeUsuario( $cd_usuario, "Todos los proyectos" ))?'':((PermisoQuery::permisosDeUsuario( $cd_usuario, "Proyectos propios" ))?' AND U.cd_usuario = '.$cd_usuario:' AND F.cd_facultad = '.$_SESSION ["cd_facultadSessionP"]);
		if ($pendientes) {
			$sql .= " AND ((bl_altapendiente=1) OR (bl_bajapendiente=1))";
		}
		$db = Db::conectar ();
		$result = $db->sql_query ( $sql );
		$cant = $db->sql_result ( $result, 0 );
		$db->sql_close;
		return (( int ) $cant);
	}
	
	function getProyectosDocentes($cd_docente){
		
		
		$sql = " SELECT P.cd_proyecto, ds_titulo, ds_codigo, CONCAT( DOCDIR.ds_apellido, ', ', DOCDIR.ds_nombre ) AS ds_director, dt_ini, dt_fin, I.nu_horasinv, I.nu_horasinvAnt, I.cd_tipoinvestigador, ds_tipoinvestigador
FROM proyecto P";
		$sql .= " LEFT JOIN integrante I ON P.cd_proyecto = I.cd_proyecto LEFT JOIN docente D ON I.cd_docente = D.cd_docente LEFT JOIN integrante DIR ON P.cd_proyecto = DIR.cd_proyecto
LEFT JOIN docente DOCDIR ON DIR.cd_docente = DOCDIR.cd_docente LEFT JOIN tipoinvestigador TI ON I.cd_tipoinvestigador = TI.cd_tipoinvestigador";
		$dt_fecha = date('Y-m-d');
		$year = Date("Y");
		//$year = $_SESSION ['nu_yearSessionP'];
		$sql .= " WHERE DIR.cd_tipoinvestigador = 1 AND P.cd_estado <> 4 AND P.cd_estado <> 7 AND I.cd_docente = ".$cd_docente." AND dt_fin > '".(($year )-1)."-12-31' AND (I.dt_baja IS NULL OR I.dt_baja = '0000-00-00' OR I.dt_baja > '$dt_fecha') AND P.dt_ini < '".($year )."-12-31'";
		
		$sql .= " ORDER BY ds_codigo"; 
		$db = Db::conectar ();
		$result = $db->sql_query ( $sql );
		$res = array ( );
		$i = 0;
		if ($db->sql_numrows () > 0) {
			while ( $usr = $db->sql_fetchassoc ( $result ) ) {
				$res [$i] = array ('cd_proyecto' => $usr ['cd_proyecto'], 'ds_codigo' => $usr ['ds_codigo'], 'ds_titulo' => $usr ['ds_titulo'], 'ds_director' => $usr ['ds_director'], 'ds_facultad' => $usr ['ds_facultad'], 'dt_ini' => $usr ['dt_ini'], 'dt_fin' => $usr ['dt_fin'], 'nu_horasinv' => $usr ['nu_horasinv'], 'nu_horasinvAnt' => $usr ['nu_horasinvAnt'], 'ds_tipoinvestigador' => $usr ['ds_tipoinvestigador'], 'cd_tipoinvestigador' => $usr ['cd_tipoinvestigador']);
				$i ++;
			}
		}
		$db->sql_close;
		return ($res);
	}
	
	function insertarProyecto(Proyecto $obj) {
		$db = Db::conectar ();
		$ds_titulo = $obj->getDs_titulo ();
		$ds_codigo = $obj->getDs_codigo ();
		$cd_facultad = $obj->getCd_facultad();
		$cd_proyecto = $obj->getCd_proyecto();
		$dt_ini = $obj->getDt_ini();
		$dt_fin = $obj->getDt_fin();
		$dt_inc = $obj->getDt_inc();
		$nu_duracion = $obj->getNu_duracion();
		$bl_altapendiente = $obj->getBl_altapendiente();
		$bl_bajapendiente = $obj->getBl_bajapendiente();
		$sql = "INSERT INTO proyecto (cd_proyecto, ds_codigo, ds_titulo, dt_ini, dt_fin, dt_inc, cd_facultad, nu_duracion, bl_altapendiente, bl_bajapendiente) VALUES ('$cd_proyecto', '$ds_codigo', '$ds_titulo', '$dt_ini', '$dt_fin', '$dt_inc', '$cd_facultad', '$nu_duracion', '$bl_altapendiente', '$bl_bajapendiente') ";
		$result = $db->sql_query ( $sql );
		$db->sql_close;
		return $result;
	}
	
	function eliminarProyecto(Proyecto $obj){
		$db = Db::conectar ();
		$cd_proyecto = $obj->getCd_proyecto ();
		$sql = "DELETE FROM proyecto WHERE cd_proyecto = $cd_proyecto";
		$result = $db->sql_query ( $sql );
		$db->sql_close;
		return $result;
	}

	function modificarProyecto(Proyecto $obj){
		$db = Db::conectar ();
		$ds_titulo = $obj->getDs_titulo ();
		$ds_codigo = $obj->getDs_codigo ();
		$cd_facultad = $obj->getCd_facultad();
		$cd_proyecto = $obj->getCd_proyecto();
		$dt_ini = $obj->getDt_ini();
		$dt_fin = $obj->getDt_fin();
		$dt_inc = $obj->getDt_inc();
		$nu_duracion = $obj->getNu_duracion();
		$bl_altapendiente = $obj->getBl_altapendiente();
		$bl_bajapendiente = $obj->getBl_bajapendiente();
		$sql = "UPDATE proyecto SET cd_proyecto='$cd_proyecto', ds_codigo='$ds_codigo', ds_titulo='$ds_titulo', dt_ini='$dt_ini', dt_fin='$dt_fin', dt_inc='$dt_inc', cd_facultad='$cd_facultad', nu_duracion='$nu_duracion', bl_altapendiente='$bl_altapendiente', bl_bajapendiente='$bl_bajapendiente'";
		$sql .= " WHERE cd_proyecto = $cd_proyecto";
		$result = $db->sql_query ( $sql );
		$db->sql_close;
		return $result;
	}
	
	function listarCodigo($ds_codigo = "") {
		$db = Db::conectar (  );
		$sql = "SELECT ds_codigo FROM proyecto ORDER BY ds_codigo";
		$result = $db->sql_query ( $sql );
		$res = array ( );
		$i = 0;
		$ok=0;
		if ($db->sql_numrows () > 0) {
			while ( $usr = $db->sql_fetchassoc ( $result ) ) {
				if ($usr ['ds_codigo'] == $ds_codigo) {
					$res [$i] = array ('cd_codigo' => "'" . $usr ['ds_codigo'] . "' selected='selected'", 'ds_codigo' => $usr ['ds_codigo'] );
					$ok=1;
				} else {
					$res [$i] = array ('cd_codigo' => $usr ['ds_codigo'], 'ds_codigo' => $usr ['ds_codigo'] );
				}
				$i ++;
			}
		}
		if (($ds_codigo)&&(!$ok)) $res [$i] = array ('cd_codigo' => "'" . $ds_codigo . "' selected='selected'", 'ds_codigo' => $ds_codigo );
		$db->sql_close ();
		
		return $res;
	}
	
	function listarTituloPorCodigo($ds_codigo = "", $ds_titulo="") {
		$db = Db::conectar (  );
		$sql = "SELECT ds_titulo FROM proyecto WHERE ds_codigo = '$ds_codigo' ORDER BY ds_titulo";
		$result = $db->sql_query ( $sql );
		$res = array ( );
		$i = 0;
		$ok=0;
		if ($db->sql_numrows () > 0) {
			while ( $usr = $db->sql_fetchassoc ( $result ) ) {
				if ($usr ['ds_titulo'] == $ds_titulo) {
					$res [$i] = array ('cd_titulo' => "'" . $usr ['ds_titulo'] . "' selected='selected'", 'ds_titulo' => $usr ['ds_titulo'] );
					$ok=1;
				} else {
					$res [$i] = array ('cd_titulo' => "'" . $usr ['ds_titulo'] . "'", 'ds_titulo' => $usr ['ds_titulo'] );
				}
				$i ++;

			}
		}
		if (($ds_titulo)&&(!$ok)) $res [$i] = array ('cd_titulo' => "'" . $ds_titulo . "' selected='selected'", 'ds_titulo' => $ds_titulo );
		$db->sql_close ();
		
		return $res;
	}
	
	
	
}
?>