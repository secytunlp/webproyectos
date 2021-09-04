<?php
include '../includes/include.php';
require '../includes/chequeo.php';
include '../includes/datosSession.php';

if (PermisoQuery::permisosDeUsuario( $cd_usuario, "Exportar pendientes" )) {
	
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
			$contenido[$i] = 
			array($pendientes [$i]['ds_codigo'],$pendientes [$i]['ds_director'],$pendientes [$i]['ds_facultad'],$pendientes [$i]['dt_fecha'],$pendientes [$i]['ds_estado'],$pendientes [$i]['ds_investigador'],$pendientes [$i]['ds_tipoinvestigador'],$pendientes [$i]['dt_alta'],$pendientes [$i]['dt_baja']);
	
		}
	}
	
	$titulos = Array('Proyecto','Director','Facultad','Fecha','Estado','Investigador','Tipo','Alta','Baja');
	$oExportar = new Exportexcel('Pendientes');
	$oExportar->GetHTMLPreview($titulos,$contenido);
} else
	header ( 'Location:../includes/accesodenegado.php' );
	