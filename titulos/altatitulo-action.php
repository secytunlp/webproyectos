<?
include '../includes/include.php';
require '../includes/chequeo.php';
include '../includes/datosSession.php';

/*******************************************************
 * La variable er por GET indica el tipo de error por el
 * que se redireccionó al login
 *******************************************************/
if (PermisoQuery::permisosDeUsuario( $cd_usuario, "Alta titulo" )) {
	
	$oTitulo = new Titulo();
	
	
	
	if (isset ( $_POST ['ds_titulo'] ))
		$oTitulo->setDs_titulo ( $_POST ['ds_titulo'] ); else
		$oTitulo->setDs_titulo ( '' );
		
	if (isset ( $_POST ['nu_nivel'] ))
		$oTitulo->setNu_nivel ( $_POST ['nu_nivel'] ); else
		$oTitulo->setNu_nivel ( '' );
	
	if (isset ( $_POST ['cd_universidad'] ))
		$oTitulo->setCd_universidad  ( $_POST ['cd_universidad']  );
	if ((!$oTitulo->getCd_universidad())&&(isset ( $_POST ['ds_universidad'] ))) {
		$oUniversidad= new Universidad() ;
		$oUniversidad->setDs_universidad($_POST ['ds_universidad']);
		if (!UniversidadQuery::existe($oUniversidad)) {
			UniversidadQuery::insertUniversidad($oUniversidad);
		}
		$oTitulo->setCd_universidad($oUniversidad->getCd_universidad());
	}
	
		
	$exito = TituloQuery::insertTitulo ( $oTitulo );
	
	if ($exito){
		$oFuncion = new Funcion();
		$oFuncion -> setDs_funcion("Alta titulo");
		FuncionQuery::getFuncionPorDs($oFuncion);
		$oMovimiento = new Movimiento();
		$oMovimiento->setCd_funcion($oFuncion->getCd_funcion());
		$oMovimiento->setCd_usuario($cd_usuario);
		$oMovimiento->setDs_movimiento('Titulo: '.$oTitulo->getDs_titulo().' Universidad: '.$oTitulo->getCd_universidad().' Nivel: '.$oTitulo->getNu_nivel());
		MovimientoQuery::insertarMovimiento($oMovimiento);
		header ( 'Location: index.php ' ); 
	}
		else
		header ( 'Location: altatitulo.php?er=1' );

} else
	header ( 'Location:../includes/accesodenegado.php' );
	