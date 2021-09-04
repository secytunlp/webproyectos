<?php

class TipoinvestigadorQuery {
	
	
	function getTipoinvestigadorPorDs(Tipoinvestigador $obj) {
		$db = Db::conectar (  );
		$ds_tipoinvestigador = $obj->getDs_tipoinvestigador ();
		if ($ds_tipoinvestigador){
			$sql = "SELECT cd_tipoinvestigador FROM tipoinvestigador WHERE ds_tipoinvestigador = '$ds_tipoinvestigador'";
			$result = $db->sql_query ( $sql );
			$i = 0;
			if ($db->sql_numrows () > 0) {
				while ( $usr = $db->sql_fetchassoc ( $result ) ) {
					$obj->setCd_tipoinvestigador ( $usr ['cd_tipoinvestigador'] );
					$i ++;
				}
			}
		}
		$db->sql_close;
		return ($result);
	}
	
	function getTipoinvestigadorPorId(Tipoinvestigador $obj) {
		$db = Db::conectar (  );
		$cd_tipoinvestigador = $obj->getCd_tipoinvestigador ();
		if ($cd_tipoinvestigador){
			$sql = "SELECT ds_tipoinvestigador FROM tipoinvestigador WHERE cd_tipoinvestigador = '$cd_tipoinvestigador'";
			$result = $db->sql_query ( $sql );
			$i = 0;
			if ($db->sql_numrows () > 0) {
				while ( $usr = $db->sql_fetchassoc ( $result ) ) {
					$obj->setDs_tipoinvestigador ( $usr ['ds_tipoinvestigador'] );
					$i ++;
				}
			}
		}
		$db->sql_close;
		return ($result);
	}
	
	function listar($cd_tipoinvestigador = "", $condirector=0) {
		$db = Db::conectar (  );
		$sql = "SELECT cd_tipoinvestigador, ds_tipoinvestigador FROM tipoinvestigador ";
		$sql .=($condirector==1)?"":(($condirector==2)?" WHERE cd_tipoinvestigador > 2 AND cd_tipoinvestigador < 6":" WHERE cd_tipoinvestigador > 2 ");
		$sql .=" ORDER BY cd_tipoinvestigador";
		$result = $db->sql_query ( $sql );
		$res = array ( );
		$i = 0;
		if ($db->sql_numrows () > 0) {
			while ( $usr = $db->sql_fetchassoc ( $result ) ) {
				if ($usr ['cd_tipoinvestigador'] == $cd_tipoinvestigador) {
					$res [$i] = array ('cd_tipoinvestigador' => "'" . $usr ['cd_tipoinvestigador'] . "' selected='selected'", 'ds_tipoinvestigador' => $usr ['ds_tipoinvestigador'] );
				} else {
					$res [$i] = array ('cd_tipoinvestigador' => $usr ['cd_tipoinvestigador'], 'ds_tipoinvestigador' => $usr ['ds_tipoinvestigador'] );
				}
				$i ++;
			}
		}
		$db->sql_close ();
		
		return $res;
	}
	
	
}
?>