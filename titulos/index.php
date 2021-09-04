<?php
include_once '../includes/include.php';
require '../includes/chequeo.php';
include '../includes/datosSession.php';

if (PermisoQuery::permisosDeUsuario ( $cd_usuario, "Listar titulo" )) {
	
	$xtpl = new XTemplate ( 'index.html' );
	
	include APP_PATH . 'includes/cargarmenu.php';
	
	if (isset ( $_GET ['filtro'] ))
		$filtro = $_GET ['filtro']; else
		$filtro = "";
	if (isset ( $_GET ['filtroUniversidad'] ))
		$filtroUniversidad = $_GET ['filtroUniversidad']; else
		$filtroUniversidad = "";
		
	if (isset ( $_GET ['filtroNivel'] ))
		$filtroNivel = $_GET ['filtroNivel']; else
		$filtroNivel = 0;
	if (isset ( $_GET ['page'] ))
		$page = $_GET ['page']; else
		$page = 1;
	
	if (isset ( $_GET ['orden'] ))
		$orden = $_GET ['orden']; else
		$orden = 'ASC';
	
	if (isset ( $_GET ['campo'] ))
		$campo = $_GET ['campo']; else
		$campo = 'ds_titulo';
	
	$query_string = "?filtro=$filtro&filtroUniversidad=$filtroUniversidad&filtroNivel=$filtroNivel&";
	$xtpl->assign ( 'query_string', $query_string );
	
	if (isset ( $_GET ['er'] ))
		$er = $_GET ['er'];
	if ($er == 1) {
		
		$xtpl->assign ( 'classMsj', 'msjerror' );
		$msj = "Error: No se pudo eliminar el Titulo";
		$xtpl->assign ( 'msj', 'onLoad ="mensajeError(\''.$msj.'\')"' );
		$xtpl->parse ( 'main.msj' );
	
	}
	if ($er == 2) {
		
		$xtpl->assign ( 'classMsj', 'msjerror' );
		$msj = "Error: No se pudo eliminar el Titulo, tiene Docentes relacionados";
		$xtpl->assign ( 'msj', 'onLoad ="mensajeError(\''.$msj.'\')"' );
		$xtpl->parse ( 'main.msj' );
	
	}
	$xtpl->assign ( 'titulo', 'Administración de Títulos' );
	
	$row_per_page = 25;
	//$page=1;
	$titulos = TituloQuery::getTitulos ( $campo, $orden, $filtro, $filtroUniversidad, $filtroNivel, $page, $row_per_page );
	$count = count ( $titulos );
	for($i = 0; $i < $count; $i ++) {
		$titulos [$i] ['ds_nivel'] = ($titulos [$i] ['nu_nivel']==1)?"Grado":"Posgrado";
		$titulos [$i] ['ds_tituloElim'] = addslashes($titulos [$i] ['ds_titulo']);
		$titulos [$i]['linkeditar'] = (PermisoQuery::permisosDeUsuario( $cd_usuario, "Modificar titulo" ))?'<a href="../titulos/modificartitulo.php?cd_titulo='.$titulos [$i]['cd_titulo'].'"><img class="hrefImg" src="../img/edit.jpg" title="Editar titulo" /></a>&nbsp;':'';
		$titulos [$i]['linkeliminar'] = (PermisoQuery::permisosDeUsuario( $cd_usuario, "Baja titulo" ))?'<a href="" onclick="confirmaElim(\''.$titulos [$i]['ds_tituloElim'].'\', this,\'../titulos/eliminartitulo.php?cd_titulo='.$titulos [$i]['cd_titulo'].'\')"><img class="hrefImg" src="../img/del_.jpg" title="Eliminar titulo" /></a>&nbsp;':'';
		
		$xtpl->assign ( 'DATOS', $titulos [$i] );
		$xtpl->parse ( 'main.row' );
	}
	
	/***************************************************
	 * PAGINADOR
	 **************************************************/
	
	$num_rows = TituloQuery::getCantTitulos ( $filtro, $filtroUniversidad, $filtroNivel );
	$num_pages = ceil ( $num_rows / $row_per_page );
	
	$url = 'index.php?orden=' . $orden . '&campo=' . $campo . '&filtro=' . $filtro .'&filtroUniversidad=' . $filtroUniversidad.'&filtroNivel=' . $filtroNivel;
	$cssclassotherpage = 'paginadorOtraPagina';
	$cssclassactualpage = 'paginadorPaginaActual';
	$ds_pag_anterior = 0; //$gral['pag_ant'];
	$ds_pag_siguiente = 2; //$gral['pag_sig'];
	$imp_pag = new Paginador ( $url, $num_pages, $page, $cssclassotherpage, $cssclassactualpage, $num_rows );
	$paginador = $imp_pag->imprimirPaginado ();
	$resultados = $imp_pag->imprimirResultados ();
	$imgDSAsc = (($campo=='ds_titulo')&&($orden=='ASC'))?'<img class="hrefImg" title="Ordenar por titulo asc" src="../img/asc.jpg" />':'';
	$imgDSDesc = (($campo=='ds_titulo')&&($orden=='DESC'))?'<img class="hrefImg" title="Ordenar por titulo desc" src="../img/desc.jpg" />':'';
	
	$imgUNIAsc = (($campo=='ds_universidad')&&($orden=='ASC'))?'<img class="hrefImg" title="Ordenar por universidad asc" src="../img/asc.jpg" />':'';
	$imgUNIDesc = (($campo=='ds_universidad')&&($orden=='DESC'))?'<img class="hrefImg" title="Ordenar por universidad desc" src="../img/desc.jpg" />':'';
	
	$imgNIVAsc = (($campo=='nu_nivel')&&($orden=='ASC'))?'<img class="hrefImg" title="Ordenar por nivel asc" src="../img/asc.jpg" />':'';
	$imgNIVDesc = (($campo=='nu_nivel')&&($orden=='DESC'))?'<img class="hrefImg" title="Ordenar por nivel desc" src="../img/desc.jpg" />':'';
	
	
	
	$imgDS=($imgDSAsc!='')?$imgDSAsc:(($imgDSDesc!='')?$imgDSDesc:'');
	$imgUNI=($imgUNIAsc!='')?$imgUNIAsc:(($imgUNIDesc!='')?$imgUNIDesc:'');
	$imgNIV=($imgNIVAsc!='')?$imgNIVAsc:(($imgNIVDesc!='')?$imgNIVDesc:'');
	
	
	$inverso=($orden=='DESC')?'ASC':'DESC';
	$xtpl->assign ( 'imgDS', $imgDS );
	$xtpl->assign ( 'imgUNI', $imgUNI );
	$xtpl->assign ( 'imgNIV', $imgNIV );
	
	$xtpl->assign ( 'orden', $inverso );
	$xtpl->assign ( 'resultado', $resultados );
	$xtpl->parse ( 'main.resultado' );
	
	$xtpl->assign ( 'PAG', $paginador );
	$xtpl->parse ( 'main.PAG' );
	$xtpl->parse ( 'main' );
	$xtpl->out ( 'main' );
} else
	header ( 'Location:../includes/accesodenegado.php' );
?>