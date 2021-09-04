<?php
include_once '../includes/include.php';
require '../includes/chequeo.php';
include '../includes/datosSession.php';


if (PermisoQuery::permisosDeUsuario ( $cd_usuario, 'Exportar pendientes' )) {
	$xtpl = new XTemplate ( 'index_pendientes.html' );
	
	include APP_PATH . 'includes/cargarmenu.php';
		
	if (isset ( $_GET ['filtroEstado'] ))
		$filtroEstado = $_GET ['filtroEstado']; else
		$filtroEstado = 0;
	
	if (isset ( $_GET ['filtroFacultad'] ))
		$filtroFacultad = $_GET ['filtroFacultad']; else
		$filtroFacultad = 0;
		
	if (( $_GET ['filtroDesde'] !='')&&( $_GET ['filtroDesde'] != '//'))
		$filtroDesde = FuncionesComunes::fechaPHPaMysql1($_GET ['filtroDesde']); else
		$filtroDesde = "";
		
	if (( $_GET ['filtroHasta'] != '')&&( $_GET ['filtroHasta'] != '//'))
		$filtroHasta = FuncionesComunes::fechaPHPaMysql1($_GET ['filtroHasta']); else
		$filtroHasta = "";		
		
	if (isset ( $_GET ['page'] ))
		$page = $_GET ['page']; else
		$page = 1;
	
	if (isset ( $_GET ['orden'] ))
		$orden = $_GET ['orden']; else
		$orden = 'ASC';
	
	if (isset ( $_GET ['campo'] ))
		$campo = $_GET ['campo']; else
		$campo = 'ds_codigo';
	
	$query_string = "?filtroEstado=$filtroEstado&filtroFacultad=$filtroFacultad&filtroDesde=".FuncionesComunes::fechaMysqlaPHP1($filtroDesde)."&filtroHasta=".FuncionesComunes::fechaMysqlaPHP1($filtroHasta)."&";
	$xtpl->assign ( 'query_string', $query_string );
	
	if (isset ( $_GET ['er'] ))
		$er = $_GET ['er'];
	if ($er == 1) {
		$msj = 'Datos exportados con &eacute;xito';
		
		$xtpl->assign ( 'msj', 'onLoad ="mensajeError(\''.$msj.'\')"' );
	}
	
	
	
	$estados = EstadoQuery::listar ($filtroEstado);
	$rowsize = count ( $estados );
	
	for($i = 0; $i < $rowsize; $i ++) {
		$xtpl->assign ( 'DATA', $estados [$i] );
		$xtpl->parse ( 'main.estado' );
	}
	
	$facultades = FacultadQuery::listar ($filtroFacultad);
	$rowsize = count ( $facultades );
	
	for($i = 0; $i < $rowsize; $i ++) {
		$xtpl->assign ( 'DATA', $facultades [$i] );
		$xtpl->parse ( 'main.facultad' );
	}
	
	$xtpl->assign ( 'filtroDesde', ($filtroDesde)?FuncionesComunes::fechaMysqlaPHP1($filtroDesde):'' );
	$xtpl->assign ( 'filtroHasta', ($filtroHasta)?FuncionesComunes::fechaMysqlaPHP1($filtroHasta):'' );
	
	$xtpl->assign ( 'titulo', 'Pendientes' );
	
	$row_per_page = 1000;
	$pendientes = IntegranteQuery::getPendientes( $campo, $orden, $filtroEstado, $filtroFacultad, $page, $row_per_page, $cd_usuario);
	$count = count ( $pendientes );
	$num_rows=0;
	for($i = 0; $i < $count; $i ++) {	
		$dt_fecha = MovimientoQuery::pendientes($filtroDesde, $filtroHasta, $pendientes [$i]['nu_documento'], $pendientes [$i]['cd_usuario'], $pendientes [$i]['cd_estado'], $pendientes [$i]['cd_proyecto'], $pendientes [$i]['ds_codigo']);
		//if ((($dt_fecha)&&($filtroDesde))||(!$filtroDesde)) {
		if($dt_fecha){
			$num_rows++;
			$pendientes [$i]['dt_fecha']= FuncionesComunes::fechaHoraMysqlaPHP($dt_fecha);
			$pendientes [$i]['dt_alta'] = FuncionesComunes::fechaMysqlaPHP($pendientes [$i]['dt_alta']);
			$pendientes [$i]['dt_baja'] = ((FuncionesComunes::fechaMysqlaPHP($pendientes [$i]['dt_baja'])!='00/00/0000')&&(FuncionesComunes::fechaMysqlaPHP($pendientes [$i]['dt_baja'])!='//'))?FuncionesComunes::fechaMysqlaPHP($pendientes [$i]['dt_baja']):'';
			$xtpl->assign ( 'DATOS', $pendientes [$i] );
			$xtpl->parse ( 'main.row' );
		}
	}
	
	/***************************************************
	 * PAGINADOR
	 **************************************************/
	
	//$num_rows = IntegranteQuery::getCountModificados($filtroEstado);
	
	/*$num_pages = ceil ( $num_rows / $row_per_page );
	
	$url = 'index.php?orden=' . $orden . '&campo=' . $campo . '&filtroEstado=' . $filtroEstado. '&filtroFacultad=' . $filtroFacultad. '&filtroDesde=' . $filtroDesde. '&filtroHasta=' . $filtroHasta;
	$cssclassotherpage = 'paginadorOtraPagina';
	$cssclassactualpage = 'paginadorPaginaActual';
	$ds_pag_anterior = 0; //$gral['pag_ant'];
	$ds_pag_siguiente = 2; //$gral['pag_sig'];
	$imp_pag = new Paginador ( $url, $num_pages, $page, $cssclassotherpage, $cssclassactualpage, $num_rows );
	$paginador = $imp_pag->imprimirPaginado ();
	$resultados = $imp_pag->imprimirResultados ();
	
	
	$xtpl->assign ( 'filtroEstado', $filtroEstado );
	$xtpl->assign ( 'filtroFacultad', $filtroFacultad );
	$xtpl->assign ( 'resultado', $resultados );
	$xtpl->parse ( 'main.resultado' );
	
	$xtpl->assign ( 'PAG', $paginador );
	$xtpl->parse ( 'main.PAG' );*/
	$xtpl->parse ( 'main' );
	$xtpl->out ( 'main' );

} else
	header ( 'Location:../includes/accesodenegado.php' );
?>