<?php

class UniversidadQuery {
	
	
	function getUniversidadPorDs(Universidad $obj) {
		$db = Db::conectar (  );
		$ds_universidad = $obj->getDs_universidad ();
		if ($ds_universidad){
			$sql = "SELECT cd_universidad FROM universidad WHERE ds_universidad = '$ds_universidad'";
			$result = $db->sql_query ( $sql );
			$i = 0;
			if ($db->sql_numrows () > 0) {
				while ( $usr = $db->sql_fetchassoc ( $result ) ) {
					$obj->setCd_universidad ( $usr ['cd_universidad'] );
					$i ++;
				}
			}
		}
		$db->sql_close;
		return ($result);
	}
	
	function listar($cd_universidad = "") {
		$db = Db::conectar (  );
		$sql = "SELECT cd_universidad, ds_universidad FROM universidad ORDER BY ds_universidad";
		$result = $db->sql_query ( $sql );
		$res = array ( );
		$i = 0;
		if ($db->sql_numrows () > 0) {
			while ( $usr = $db->sql_fetchassoc ( $result ) ) {
				if ($usr ['cd_universidad'] == $cd_universidad) {
					$res [$i] = array ('cd_universidad' => "'" . $usr ['cd_universidad'] . "' selected='selected'", 'ds_universidad' => $usr ['ds_universidad'] );
				} else {
					$res [$i] = array ('cd_universidad' => $usr ['cd_universidad'], 'ds_universidad' => $usr ['ds_universidad'] );
				}
				$i ++;
			}
		}
		$db->sql_close ();
		
		return $res;
	}
	
    function listarPorDs($ds_universidad) {
		$db = Db::conectar (  );
		$sql = "SELECT cd_universidad, ds_universidad FROM universidad where ds_universidad LIKE '%$ds_universidad%' ORDER BY ds_universidad";
		$result = $db->sql_query ( $sql );
		$res = array ( );
		$i = 0;
		if ($db->sql_numrows () > 0) {
			while ( $usr = $db->sql_fetchassoc ( $result ) ) {
					$res [$i] = array ('cd_universidad' => $usr ['cd_universidad'], 'ds_universidad' => $usr ['ds_universidad'] );
				$i ++;
			}
		}
		$db->sql_close ();

		return $res;
	}
	
	function existe(Universidad $universidad) {
		$db = Db::conectar (  );
		$ds_universidad = $universidad->getDs_universidad();
		$cd_universidad=0;
		$sql = "Select cd_universidad FROM universidad WHERE ds_universidad LIKE '%$ds_universidad'%";
		$result = $db->sql_query ( $sql );
		if ($db->sql_numrows () > 0) {
			while ( $usr = $db->sql_fetchassoc ( $result ) ) {
				$cd_universidad=$usr ['cd_universidad'];
				$universidad->setCd_universidad ( $usr ['cd_universidad'] );
				
			}
		}
		return ($cd_universidad > 0);
	}
	
	function insertUniversidad(Universidad $obj) {
		$db = Db::conectar ();
		$ds_universidad = $obj->getDs_universidad();
		$cd_universidad = UniversidadQuery::insert_id($db)+1;
		
		$sql = "INSERT INTO universidad (cd_universidad, ds_universidad) VALUES ('$cd_universidad', '$ds_universidad') ";
		$result = $db->sql_query ( $sql );
		
		
		$obj->setCd_universidad($cd_universidad);
		$db->sql_close;
		return $result;
	}
	
	function insert_id($db) {
		$sql = "SELECT MAX(`cd_universidad`) FROM universidad ";
		$result = $db->sql_query ( $sql );
		$id = $db->sql_fetchrow ( $result, 0 );
		return ($id [0]);
	}
	
	
	
	function eliminarUniversidad(Universidad $obj) {
		$db = Db::conectar ();
		$cd_universidad = $obj->getCd_universidad ();
		$sql = "DELETE FROM universidad WHERE cd_universidad = $cd_universidad";
		$result = $db->sql_query ( $sql );
		$db->sql_close;
		return $result;
	}
}
?>