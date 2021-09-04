<?php

class CargoQuery {
	
	
	function getCargoPorDs(Cargo $obj) {
		$db = Db::conectar (  );
		$ds_cargo = $obj->getDs_cargo ();
		if ($ds_cargo){
			$sql = "SELECT cd_cargo FROM cargo WHERE ds_cargo = '$ds_cargo'";
			$result = $db->sql_query ( $sql );
			$i = 0;
			if ($db->sql_numrows () > 0) {
				while ( $usr = $db->sql_fetchassoc ( $result ) ) {
					$obj->setCd_cargo ( $usr ['cd_cargo'] );
					$i ++;
				}
			}
		}
		$db->sql_close;
		return ($result);
	}
	
	function getCargoSipiPorCd(Cargo $obj) {
		$db = Db::conectar (  );
		$cd_cargo = $obj->getCd_cargo ();
		if ($cd_cargo){
			$sql = "SELECT cd_cargosipi FROM cargo WHERE cd_cargo = '$cd_cargo'";
			$result = $db->sql_query ( $sql );
			$i = 0;
			if ($db->sql_numrows () > 0) {
				while ( $usr = $db->sql_fetchassoc ( $result ) ) {
					$obj->setCd_cargosipi ( $usr ['cd_cargosipi'] );
					$i ++;
				}
			}
		}
		$db->sql_close;
		return ($result);
	}
	
	function listar($cd_cargo = "") {
		$db = Db::conectar (  );
		$sql = "SELECT cd_cargo, ds_cargo FROM cargo ORDER BY nu_orden";
		$result = $db->sql_query ( $sql );
		$res = array ( );
		$i = 0;
		if ($db->sql_numrows () > 0) {
			while ( $usr = $db->sql_fetchassoc ( $result ) ) {
				if ($usr ['cd_cargo'] == $cd_cargo) {
					$res [$i] = array ('cd_cargo' => "'" . $usr ['cd_cargo'] . "' selected='selected'", 'ds_cargo' => $usr ['ds_cargo'] );
				} else {
					$res [$i] = array ('cd_cargo' => $usr ['cd_cargo'], 'ds_cargo' => $usr ['ds_cargo'] );
				}
				$i ++;
			}
		}
		$db->sql_close ();
		
		return $res;
	}
	
	
}
?>