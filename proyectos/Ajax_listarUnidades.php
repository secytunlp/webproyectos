<?php
include '../includes/include.php';
include '../includes/datosSession.php';
/*
note:
this is just a static test version using a hard-coded countries array.
normally you would be populating the array out of a database

the returned xml has the following structure
<results>
	<rs>foo</rs>
	<rs>bar</rs>
</results>
*/


	
	
	
	$aInfo = array(Da3);
	//for ($i = 1; $i < 5500; $i++)$aInfo [$i]=ucfirst("" . randVowel() . "" . "" . randConsonant() . "" . randVowel() . "" . "" . randConsonant() . "" . randVowel() . "" . randVowel() . "");

	
	$input = strtolower( utf8_decode($_GET['input']) );
	$aUsers = UnidadQuery::getUnidadesPorDs($input);
	$len = strlen($input);
	$limit = isset($_GET['limit']) ? (int) $_GET['limit'] : 0;
	
	
	/*$aResults = array();
	$count = 0;
	
	if ($len)
	{
		for ($i=0;$i<count($aUsers);$i++)
		{
			// had to use utf_decode, here
			// not necessary if the results are coming from mysql
			//
			if (strtolower(substr(utf8_decode($aUsers[$i]['ds_unidad']),0,$len)) == $input)
			{
				$count++;
				$aResults[] = array( "id"=>($i+1) ,"value"=>htmlentities($aUsers[$i]['ds_unidad']), "info"=>htmlentities($aInfo[$i]) );
			}
			
			if ($limit && $count==$limit)
				break;
		}
	}*/
	
	
	
	
	
	header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
	header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // always modified
	header ("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
	header ("Pragma: no-cache"); // HTTP/1.0
	
	
	
	
		header("Content-Type: text/xml");

		echo "<?xml version=\"1.0\" encoding=\"utf-8\" ?><results>";
		$max = ((count($aUsers)<=20)||(($_GET['UNLP'])))?count($aUsers):20;
		for ($i=0;$i<$max;$i++)
		{
			$cd_padre = 0;
			$oUnidad = new  Unidad();
			$oUnidad->setCd_unidad($aUsers[$i]['cd_unidad']);
			UnidadQuery::getUnidadPorId($oUnidad);
			$encontre=0;
			while($oUnidad->getCd_padre()!=0){
				if ((!$encontre)&&($oUnidad->getCd_unidad()==20419)){
					$cd_padre = $oUnidad->getCd_unidad();
					$encontre = 1;
				}
				$oUnidad->setCd_unidad($oUnidad->getCd_padre());
				UnidadQuery::getUnidadPorId($oUnidad);
				$ds_padre .= $oUnidad->getDs_unidad().' - ';
			}
			if ((!$encontre)&&($oUnidad->getBl_hijos()==0)) {
				$cd_padre = $oUnidad->getCd_unidad();
			}
			
$ds_padre = substr($ds_padre,0,strlen($ds_padre)-3);
			$insertarUnidad=1;
			$nivel = $aUsers[$i]['bl_hijos'];
			if ($_GET['UNLP']){
				
				$insertarUnidad=0;
				$oUnidad = new  Unidad();
				$oUnidad->setCd_unidad($aUsers[$i]['cd_unidad']);
				UnidadQuery::getUnidadPorId($oUnidad);
				while(($oUnidad->getCd_padre()!=0)&&($insertarUnidad==0)){
					$insertarUnidad=(($oUnidad->getCd_padre()==1850)||($oUnidad->getCd_padre()==20419))?1:0;
					$oUnidad->setCd_unidad($oUnidad->getCd_padre());
					UnidadQuery::getUnidadPorId($oUnidad);
					
				}
			}
			//else $nivel = $cd_padre;
			if ($insertarUnidad)
				echo "<rs id=\"".$aUsers[$i]['cd_unidad']."\" info=\"".utf8_encode(str_replace('"',"'",str_replace(" & "," and ",$ds_padre)))."\" nivel=\"".$nivel."\">".utf8_encode(str_replace(" & "," and ",$aUsers[$i]['ds_unidad']))."</rs>";
			$ds_padre = '';
		}
		echo "</results>";
	
?>