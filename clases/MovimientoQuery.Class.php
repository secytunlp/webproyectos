<?php

class MovimientoQuery {
	function insertarMovimiento(Movimiento $obj) {
		$db = Db::conectar ();
		$cd_usuario = $obj->getCd_usuario();
		$cd_funcion = $obj->getCd_funcion();
		$dt_fecha = date('YmdHis');
		$ds_movimiento = $obj->getDs_movimiento ();
		$ds_consecuencia = $obj->getDs_consecuencia();
		$sql = "INSERT INTO movimientoaltabaja (cd_usuario, cd_funcion, dt_fecha, ds_movimiento, ds_consecuencia) VALUES ('$cd_usuario', '$cd_funcion', '$dt_fecha','$ds_movimiento', '$ds_consecuencia') ";
		$result = $db->sql_query ( $sql );
		$id = MovimientoQuery::insert_id ( $db );
		$obj->setCd_movimiento ( $id );
		$db->sql_close;
		return $result;
	}
	
	function insert_id($db) {
		$sql = "SELECT MAX(`cd_movimiento`) FROM movimientoaltabaja ";
		$result = $db->sql_query ( $sql );
		$id = $db->sql_fetchrow ( $result, 0 );
		return ($id [0]);
	}
	
	
	
	function getMovimientoPorid(Movimiento $obj) {
		$db = Db::conectar (  );
		$cd_movimiento = $obj->getCd_movimiento ();
		$sql = "SELECT M.*, ds_funcion, ds_apynom FROM movimientoaltabaja M";
		$sql .= " INNER JOIN funcionproyecto F ON M.cd_funcion = F.cd_funcion INNER JOIN usuarioproyecto U1 ON M.cd_usuario = U1.cd_usuario ";
		$sql .= " WHERE M.cd_movimiento = $cd_movimiento";
		$result = $db->sql_query ( $sql );
		$i = 0;
		if ($db->sql_numrows () > 0) {
			while ( $usr = $db->sql_fetchassoc ( $result ) ) {
				$obj->setCd_movimiento ( $usr ['cd_movimiento'] );
				$obj->setDs_movimiento ( $usr ['ds_movimiento'] );
				$obj->setDs_apynom ( $usr ['ds_apynom'] );
				$obj->setDs_funcion( $usr ['ds_funcion'] );
				$obj->setDs_consecuencia( $usr ['ds_consecuencia'] );
				$obj->setDt_fecha( $usr ['dt_fecha'] );
				$i ++;
			}
		}
		$db->sql_close;
		return ($result);
	}
	
	function getMovimientosPorDs($cd_funcion, $ds_codigo, $nu_cuil) {
		$db = Db::conectar (  );
		$sql = "SELECT DISTINCT cd_usuario  FROM `movimientoaltabaja` WHERE cd_funcion = $cd_funcion AND ds_movimiento like '%$ds_codigo%' AND ds_movimiento like '%$nu_cuil%'";
		$result = $db->sql_query ( $sql );
		$i = 0;
		if ($db->sql_numrows () > 0) {
			while ( $usr = $db->sql_fetchassoc ( $result ) ) {
				$res [$i] = array ('cd_usuario' => $usr ['cd_usuario'] );
				$i ++;
			}
		}
		$db->sql_close;
		return ($res);
	}
	
	
	
	function getMovimientos($attr, $orden, $filtroDesde, $filtroHasta, $filtroFuncion, $filtroUsuario, $page, $row_per_page, $cd_usuario){
		
		$limitInf = (($page - 1) * $row_per_page);
		$limitSup = ($page * $row_per_page);
		
		$sql = "SELECT M.cd_movimiento, U1.ds_apynom, ds_funcion, ds_movimiento, dt_fecha FROM movimientoaltabaja M";
		$sql .= " INNER JOIN funcionproyecto F ON M.cd_funcion = F.cd_funcion ";
		$sql .= (!PermisoQuery::permisosDeUsuario( $cd_usuario, "Alta usuario" ))?"INNER JOIN perfilfuncionproyecto PF ON F.cd_funcion = PF.cd_funcion INNER JOIN usuarioproyecto U ON PF.cd_perfil = U.cd_perfil ":"";
		
		$sql .= "INNER JOIN usuarioproyecto U1 ON M.cd_usuario = U1.cd_usuario ";
		$sql .= (!PermisoQuery::permisosDeUsuario( $cd_usuario, "Alta usuario" ))?" WHERE U.cd_usuario = $cd_usuario":"";
		if (($filtroFuncion != 0)) {
			$sql .= " AND F.cd_funcion='$filtroFuncion'";
		}
		if (($filtroUsuario != '')) {
			$sql .= " AND U1.cd_usuario = '$filtroUsuario'";
		}
		if (($filtroDesde != '')) {
			$filtroDesde .='000000';
			$sql .= " AND dt_fecha >='$filtroDesde'";
		}
		if (($filtroHasta != '')) {
			$filtroHasta .='999999';
			$sql .= " AND dt_fecha <='$filtroHasta'";
		}
		
		$sql .= " ORDER BY $attr $orden LIMIT $limitInf,$row_per_page"; 
		$db = Db::conectar ();
		$result = $db->sql_query ( $sql );
		$res = array ( );
		$i = 0;
		if ($db->sql_numrows () > 0) {
			while ( $usr = $db->sql_fetchassoc ( $result ) ) {
				$res [$i] = array ('cd_movimiento' => $usr ['cd_movimiento'], 'ds_apynom' => stripslashes(htmlspecialchars($usr ['ds_apynom'])), 'ds_funcion' => $usr ['ds_funcion'], 'ds_movimiento' => stripslashes(htmlspecialchars($usr ['ds_movimiento'])), 'dt_fecha' => $usr ['dt_fecha']);
				$i ++;
			}
		}
		$db->sql_close;
		return ($res);
	}
	function getCountMovimientos($filtroDesde, $filtroHasta, $filtroFuncion, $filtroUsuario, $cd_usuario) {
		$sql = "SELECT count(*) FROM movimientoaltabaja M";
		$sql .= " INNER JOIN funcionproyecto F ON M.cd_funcion = F.cd_funcion "; 
		$sql .= (!PermisoQuery::permisosDeUsuario( $cd_usuario, "Alta usuario" ))?"INNER JOIN perfilfuncionproyecto PF ON F.cd_funcion = PF.cd_funcion INNER JOIN usuarioproyecto U ON PF.cd_perfil = U.cd_perfil ":"";
		$sql .= "INNER JOIN usuarioproyecto U1 ON M.cd_usuario = U1.cd_usuario ";
		$sql .= (!PermisoQuery::permisosDeUsuario( $cd_usuario, "Alta usuario" ))?" WHERE U.cd_usuario = $cd_usuario":"";
		
		if (($filtroFuncion != 0)) {
			$sql .= " AND F.cd_funcion='$filtroFuncion'";
		}
		if (($filtroUsuario != '')) {
			$sql .= " AND U1.cd_usuario = '$filtroUsuario'";
		}
		if (($filtroDesde != '')) {
			$filtroDesde .='999999';
			$sql .= " AND dt_fecha >='$filtroDesde'";
		}
		if (($filtroHasta != '')) {
			$filtroHasta .='999999';
			$sql .= " AND dt_fecha <='$filtroHasta'";
		}
		$db = Db::conectar ( );
		$result = $db->sql_query ( $sql );
		$cant = $db->sql_result ( $result, 0 );
		$db->sql_close;
		return (( int ) $cant);
	}
	
	function tieneMovimientos($iniciosistema, $nu_documento) {
		$db = Db::conectar ();
		
		
		$sql = "Select count(*) FROM movimientoaltabaja WHERE dt_fecha >='$iniciosistema' AND (cd_funcion ='35' OR cd_funcion ='36' OR cd_funcion ='40') AND ds_movimiento LIKE '%$nu_documento%'";
		$result = $db->sql_query ( $sql );
		$cant = $db->sql_result ( $result, 0 );
		$db->sql_close ();
		return ($cant > 0);
	}
	
	function pendientes($filtroDesde, $filtroHasta, $nu_documento, $cd_usuario, $cd_estado, $cd_proyecto, $ds_codigo) {
		$db = Db::conectar ();
		$sql = "Select dt_fecha FROM movimientoaltabaja WHERE cd_usuario ='$cd_usuario' AND ds_movimiento LIKE '%$nu_documento%' AND (ds_movimiento LIKE '%$cd_proyecto%' OR ds_movimiento LIKE '%$ds_codigo%')";
		switch ($cd_estado) {
			case 1:
			 $sql .= ' AND cd_funcion = 19';
			break;
			case 2:
			 $sql .= ' AND cd_funcion = 37';
			break;
			case 4:
			 $sql .= ' AND cd_funcion = 15';
			break;
			case 5:
			 $sql .= ' AND cd_funcion = 36';
			break;
			case 6:
			 $sql .= ' AND cd_funcion = 40';
			break;
			case 7:
			 $sql .= ' AND cd_funcion = 41';
			break;
			case 8:
			 $sql .= ' AND cd_funcion = 57';
			break;
			case 9:
			 $sql .= ' AND cd_funcion = 58';
			break;
			default:
				;
			break;
		}
		
		if (($filtroDesde != '')) {
			$filtroDesde .='999999';
			$sql .= " AND dt_fecha >='$filtroDesde'";
		}
		if (($filtroHasta != '')) {
			$filtroHasta .='999999';
			$sql .= " AND dt_fecha <='$filtroHasta'";
		}
		$sql .=" ORDER BY dt_fecha DESC";
		$result = $db->sql_query ( $sql );
		if ($db->sql_numrows () > 0) {
			if ( $usr = $db->sql_fetchassoc ( $result ) ) {
				/*$res [$i] = array ('dt_fecha' => $usr ['dt_fecha']);
				$i ++;*/
				$dt_fecha =  $usr ['dt_fecha'];
			}
		}
		//echo $dt_fecha."<br>";
		$db->sql_close;
		return ($dt_fecha);
	}
	
	
}
?>