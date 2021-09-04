<?php

class TituloQuery {
	
	
	function getTituloPorDs(Titulo $obj) {
		$db = Db::conectar (  );
		$ds_titulo = $obj->getDs_titulo ();
		if ($ds_titulo){
			$sql = "SELECT cd_titulo FROM titulo WHERE ds_titulo = '$ds_titulo'";
			$result = $db->sql_query ( $sql );
			$i = 0;
			if ($db->sql_numrows () > 0) {
				while ( $usr = $db->sql_fetchassoc ( $result ) ) {
					$obj->setCd_titulo ( $usr ['cd_titulo'] );
					$i ++;
				}
			}
		}
		$db->sql_close;
		return ($result);
	}
	
	function getTituloPorId(Titulo $obj) {
		$db = Db::conectar (  );
		$cd_titulo = $obj->getCd_titulo ();
		if ($cd_titulo){
			$sql = "SELECT T.*, ds_universidad FROM titulo T INNER JOIN universidad U ON T.cd_universidad = U.cd_universidad WHERE cd_titulo = '$cd_titulo'";
			$result = $db->sql_query ( $sql );
			$i = 0;
			if ($db->sql_numrows () > 0) {
				while ( $usr = $db->sql_fetchassoc ( $result ) ) {
					$obj->setDs_titulo ( $usr ['ds_titulo'] );
					$obj->setDs_universidad ( $usr ['ds_universidad'] );
					$obj->setCd_universidad ( $usr ['cd_universidad'] );
					$obj->setNu_nivel ( $usr ['nu_nivel'] );
					$i ++;
				}
			}
		}
		$db->sql_close;
		return ($result);
	}
	
	function listar($nu_nivel, $ds_titulo = "", $todos=0) {
		$db = Db::conectar (  );
		$titulo = explode ( ",", $ds_titulo );
		if (count($titulo)==1) {
			 $ds_titulo = str_replace(' ','%',$ds_titulo);
			 $ds_universidad ='%%';
		}
		else{
			 $ds_titulo = str_replace(' ','%',$titulo[0]);
			 $ds_universidad = str_replace(' ','%',$titulo[1]);
		}
		$sql = "SELECT cd_titulo, ds_titulo, ds_universidad FROM titulo t INNER JOIN universidad u ON t.cd_universidad = u.cd_universidad Where nu_nivel = ".$nu_nivel." AND ds_titulo LIKE '%$ds_titulo%' AND ds_universidad LIKE '%$ds_universidad%' ORDER BY nu_orden DESC, ds_titulo ASC";
		$result = $db->sql_query ( $sql );
		$res = array ( );
		$i = 0;
		$anterior='';
		$todos=1;
		if ($db->sql_numrows () > 0) {
			while ( $usr = $db->sql_fetchassoc ( $result ) ) {
				if (($anterior!= trim($usr ['ds_titulo']))||($todos)){
					
						$res [$i] = array ('cd_titulo' => $usr ['cd_titulo'], 'ds_titulo' => $usr ['ds_titulo'], 'ds_universidad' => $usr ['ds_universidad'] );
					
					$i ++;
					$anterior= trim($usr ['ds_titulo']);
				}
			}
		}
		$db->sql_close ();
		
		return $res;
	}
	
	function listarSelect($nu_nivel, $cd_titulo = "") {
		$db = Db::conectar (  );
		$sql = "SELECT cd_titulo, ds_titulo FROM titulo ORDER BY ds_titulo";
		$result = $db->sql_query ( $sql );
		$res = array ( );
		$i = 0;
		if ($db->sql_numrows () > 0) {
			while ( $usr = $db->sql_fetchassoc ( $result ) ) {
				if ($usr ['cd_titulo'] == $cd_titulo) {
					$res [$i] = array ('cd_titulo' => "'" . $usr ['cd_titulo'] . "' selected='selected'", 'ds_titulo' => $usr ['ds_titulo'] );
				} else {
					$res [$i] = array ('cd_titulo' => $usr ['cd_titulo'], 'ds_titulo' => $usr ['ds_titulo'] );
				}
				$i ++;
			}
		}
		$db->sql_close ();
		
		return $res;
	}
	
	function getTitulos($attr, $orden, $filtro, $filtroUniversidad, $filtroNivel, $page, $row_per_page) {
		$db = Db::conectar ();
		$limitInf = (($page - 1) * $row_per_page);
		$limitSup = ($page * $row_per_page);
		$sql = "SELECT U.cd_titulo, U.ds_titulo, U.nu_nivel, P.cd_universidad, ds_universidad FROM titulo U";
		$sql .= " LEFT JOIN universidad P ON (P.cd_universidad=U.cd_universidad) WHERE U.ds_titulo LIKE '%$filtro%' ";
		if (($filtroNivel != 0)) {
			$sql .= " AND U.nu_nivel='$filtroNivel'";
		}
		if (($filtroUniversidad != '')) {
			$sql .= " AND P.ds_universidad LIKE '%$filtroUniversidad%'";
		}
		
		$sql .= " ORDER BY $attr $orden LIMIT $limitInf,$row_per_page"; 
		
		$result = $db->sql_query ( $sql );
		$res = array ( );
		$i = 0;
		if ($db->sql_numrows () > 0) {
			while ( $usr = $db->sql_fetchassoc ( $result ) ) {
				$res [$i] = array ('cd_titulo' => $usr ['cd_titulo'], 'ds_titulo' => $usr ['ds_titulo'], 'cd_universidad' => $usr ['cd_universidad'], 'ds_universidad' => $usr ['ds_universidad'], 'nu_nivel' => $usr ['nu_nivel']);
				$i ++;
			}
		}
		$db->sql_close;
		return ($res);
	}
	
	function getCantTitulos($filtro, $filtroUniversidad, $filtroNivel) {
		$db = Db::conectar ();
		$sql = "SELECT count(*) FROM titulo U";
		$sql .= " LEFT JOIN universidad P ON (P.cd_universidad=U.cd_universidad) WHERE U.ds_titulo LIKE '%$filtro%' ";
		if (($filtroNivel != 0)) {
			$sql .= " AND U.nu_nivel='$filtroNivel'";
		}
		if (($filtroUniversidad != '')) {
			$sql .= " AND P.ds_universidad LIKE '%$filtroUniversidad%'";
		}
		
		$result = $db->sql_query ( $sql );
		$cant = $db->sql_result ( $result, 0 );
		$db->sql_close;
		return (( int ) $cant);
	}
	
	function insertTitulo(Titulo $titulo) {
		$db = Db::conectar ();
		if (! TituloQuery::existe( $titulo, $db )) {
			$cd_titulo = TituloQuery::insert_id($db)+1;
			$nu_nivel = $titulo->getNu_nivel();
			$ds_titulo = $titulo->getDs_titulo();
			$cd_universidad = $titulo->getCd_universidad();
			$sql = "INSERT INTO titulo (cd_titulo, nu_nivel, ds_titulo,cd_universidad) VALUES ('$cd_titulo', '$nu_nivel', '$ds_titulo','$cd_universidad') ";
			$result = $db->sql_query ( $sql );
		} else {
			$result = false;
		}
		
		$db->sql_close;
		return $result;
	}
	
	function insert_id($db) {
		$sql = "SELECT MAX(`cd_titulo`) FROM titulo ";
		$result = $db->sql_query ( $sql );
		$id = $db->sql_fetchrow ( $result, 0 );
		return ($id [0]);
	}
	
	function existe(Titulo $titulo, $db) {
		$cd_titulo = $titulo->getCd_titulo();
		$ds_titulo = $titulo->getDs_titulo();
		$cd_universidad = $titulo->getCd_universidad();
		$nu_nivel = $titulo->getNu_nivel();
		$sql = "Select count(*) FROM titulo WHERE ds_titulo ='$ds_titulo' AND cd_universidad ='$cd_universidad' AND nu_nivel ='$nu_nivel' AND cd_titulo <> '$cd_titulo'";
		$result = $db->sql_query ( $sql );
		$cant = $db->sql_result ( $result, 0 );
		return ($cant > 0);
	}
	
	function modificarTitulo(Titulo $titulo) {
		$db = Db::conectar ();
		if (! TituloQuery::existe( $titulo, $db )) {
			$cd_titulo = $titulo->getCd_titulo();
			$nu_nivel = $titulo->getNu_nivel();
			$ds_titulo = $titulo->getDs_titulo();
			$cd_universidad = $titulo->getCd_universidad();
			$sql = "UPDATE titulo SET nu_nivel='$nu_nivel', ds_titulo='$ds_titulo', cd_universidad='$cd_universidad' WHERE cd_titulo = '$cd_titulo'";
			$result = $db->sql_query ( $sql );
		} else {
			$result = false;
		}
		
		$db->sql_close;
		return $result;
	}
	
	function eliminarTitulo(Titulo $obj) {
		$db = Db::conectar ();
		$cd_titulo = $obj->getCd_titulo ();
		$sql = "DELETE FROM titulo WHERE cd_titulo = $cd_titulo";
		$result = $db->sql_query ( $sql );
		$db->sql_close;
		return $result;
	}
	
	function tieneAsignadoTitulos ( $cd_universidad){
		
		$db = DB::conectar ();
		$sql = "Select count(*) FROM titulo WHERE cd_universidad = '$cd_universidad'";
		$result = $db->sql_query ( $sql );
		$count = $db->sql_fetchrow ( $result );
		$cant = $count[0];
		return ($cant > 0);
	}
	
	
}
?>