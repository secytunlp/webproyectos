<?php
class FuncionesComunes {
	
	/********************************************************
	 *	Convierte una fecha con formato "20/06/2008 
	 *   al formato con el que se almacena en la BD 20080620
	 *********************************************************/
	function fechaPHPaMysql($fechaPHP) {
		$nuevaFecha = explode ( "/", $fechaPHP );
		//invierto los campos
		$fechaMySql [0] = $nuevaFecha [2];
		$fechaMySql [1] = $nuevaFecha [1];
		$fechaMySql [2] = $nuevaFecha [0];
		$fechaMySql = implode ( "-", $fechaMySql );
		return ($fechaMySql);
	}
	
	function fechaPHPaMysql1($fechaPHP) {
		$nuevaFecha = explode ( "/", $fechaPHP );
		//invierto los campos
		$fechaMySql [0] = $nuevaFecha [2];
		$fechaMySql [1] = $nuevaFecha [1];
		$fechaMySql [2] = $nuevaFecha [0];
		$fechaMySql = implode ( "", $fechaMySql );
		return ($fechaMySql);
	}
	
	function fechaMysqlaPHP($fechaMysql) {
		//2008-06-18
		$nuevaFecha = explode ( "-", $fechaMysql );
		$arrayFecha [0] = $nuevaFecha [2];
		$arrayFecha [1] = $nuevaFecha [1];
		$arrayFecha [2] = $nuevaFecha [0];
		$fechaPHP = implode ( "/", $arrayFecha );
		return $fechaPHP;
	}
	
	function fechaMysqlaPHP1($fechaMysql) {
		//20080618
		$arrayFecha [0] = substr ( $fechaMysql, - 2 );
		$arrayFecha [1] = substr ( $fechaMysql, 4, 2 );
		$arrayFecha [2] = substr ( $fechaMysql, 0, 4 );
		$fechaPHP = implode ( "/", $arrayFecha );
		return $fechaPHP;
	}
	
	function fechaHoraMysqlaPHP($fechaMysql) {
		//20080618
		$arrayHora [0] = substr ( $fechaMysql, 8, 2 );
		$arrayHora [1] = substr ( $fechaMysql, 10, 2 );
		$arrayHora [2] = substr ( $fechaMysql, - 2 );
		$horaPHP = implode ( ":", $arrayHora );
		$arrayFecha [0] = substr ( $fechaMysql, 6, 2 );
		$arrayFecha [1] = substr ( $fechaMysql, 4, 2 );
		$arrayFecha [2] = substr ( $fechaMysql, 0, 4 );
		$fechaPHP = implode ( "/", $arrayFecha );
		return $fechaPHP.' '.$horaPHP;
	}
	
	function horaMySQLaPHP($horaMySQL) {
		$arrayHora [0] = substr ( $horaMySQL, 0, 2 );
		$arrayHora [1] = substr ( $horaMySQL, 2, 2 );
		$horaPHP = implode ( ":", $arrayHora );
		return $horaPHP;
	}
	
	function horaPHPaMySQL($horaPHP) {
		$horaMySQL = implode ( "", explode ( ":", $horaPHP ) );
		return $horaMySQL;
	}
	
	function _log($str, $_Log) {
		$dt = date('Y-m-d H:i:s');
		fputs($_Log, $dt." --> ".$str."\n");
	}
	
	function generar_clave($cantidad)
	{
		$clave = "";
		srand((double)microtime()*date("YmdGis"));

		  
		for($cnt = 0; $cnt < $cantidad; $cnt++)
		 {
		  $clave .= rand(0,9); 
		 }
	return $clave;
	}
	
	function array_envia($array) {

	    $tmp = serialize($array);
	    $tmp = urlencode($tmp);
	
	    return $tmp;
	} 
	
	
	function array_recibe($url_array) {
	    $tmp = stripslashes($url_array);
	    $tmp = urldecode($tmp);
	    $tmp = unserialize($tmp);
	
	   return $tmp;
	} 
	
	Function stripAccents($String)
	{
	    $String = ereg_replace("[äáàâãª]","a",$String);
	    $String = ereg_replace("[ÁÀÂÃÄ]","A",$String);
	    $String = ereg_replace("[ÍÌÎÏ]","I",$String);
	    $String = ereg_replace("[íìîï]","i",$String);
	    $String = ereg_replace("[éèêë]","e",$String);
	    $String = ereg_replace("[ÉÈÊË]","E",$String);
	    $String = ereg_replace("[óòôõöº]","o",$String);
	    $String = ereg_replace("[ÓÒÔÕÖ]","O",$String);
	    $String = ereg_replace("[úùûü]","u",$String);
	    $String = ereg_replace("[ÚÙÛÜ]","U",$String);
	    $String = ereg_replace("[´`]","",$String);
	    $String = str_replace("ç","c",$String);
	    $String = str_replace("Ç","C",$String);
	    $String = str_replace("ñ","n",$String);
	    $String = str_replace("Ñ","N",$String);
	    $String = str_replace("Ý","Y",$String);
	    $String = str_replace("ý","y",$String);
	    return $String;
	}
}
?>