<?php
include '../includes/include.php';
require '../includes/chequeo.php';
include '../includes/datosSession.php';

if (PermisoQuery::permisosDeUsuario( $cd_usuario, "Ver proyecto" )) {
	
	//include APP_PATH . 'includes/menu.php';
	/*******************************************************
	 * La variable er por GET indica el tipo de error por el
	 * que se redireccion� al login
	 *******************************************************/
	
	$xtpl = new XTemplate ( 'verproyecto.html' );
	
	include APP_PATH.'includes/cargarmenu.php';
	
	if (isset ( $_GET ['id'] )) {
		$cd_proyecto = $_GET ['id'];
		$oProyecto = new Proyecto ( );
		$oProyecto->setCd_proyecto ( $cd_proyecto );
		ProyectoQuery::getProyectoPorid ( $oProyecto );
		$xtpl->assign ( 'cd_proyecto',  ( $oProyecto->getCd_proyecto () ) );
		$xtpl->assign ( 'ds_codigo',  ( $oProyecto->getDs_codigo () ) );
		$xtpl->assign ( 'ds_titulo',  ( $oProyecto->getDs_titulo () ) );
		$xtpl->assign ( 'ds_director',  ( $oProyecto->getDs_director () ) );
		$xtpl->assign ( 'dt_ini',  FuncionesComunes::fechaMysqlaPHP( $oProyecto->getDt_ini () ) );
		$xtpl->assign ( 'dt_fin',  FuncionesComunes::fechaMysqlaPHP( $oProyecto->getDt_fin () ) );
		$xtpl->assign ( 'ds_facultad',  ( $oProyecto->getDs_facultad () ) );
		//$xtpl->assign ( 'ds_abstract',  ( $oProyecto->getDs_abstract1()) );
		//$xtpl->assign ( 'ds_claves',   $oProyecto->getDs_clave1().' - '.$oProyecto->getDs_clave2().' - '.$oProyecto->getDs_clave3().' - '.$oProyecto->getDs_clave4().' - '.$oProyecto->getDs_clave5().' - '.$oProyecto->getDs_clave6() );
		//$xtpl->assign ( 'ds_abstracteng',  ( $oProyecto->getDs_abstracteng()) );
		//$xtpl->assign ( 'ds_claveseng',   $oProyecto->getDs_claveeng1().' - '.$oProyecto->getDs_claveeng2().' - '.$oProyecto->getDs_claveeng3().' - '.$oProyecto->getDs_claveeng4().' - '.$oProyecto->getDs_claveeng5().' - '.$oProyecto->getDs_claveeng6() );
		//$xtpl->assign ( 'ds_campo',  ( $oProyecto->getDs_campo()) );
		//$xtpl->assign ( 'ds_disciplina',  ( $oProyecto->getDs_disciplina()) );
		//$xtpl->assign ( 'ds_especialidad',  ( $oProyecto->getDs_disciplina().' - '.$oProyecto->getDs_especialidad()) );
		//$xtpl->assign ( 'ds_linea',  ( $oProyecto->getDs_linea()) );
		
		if ($oProyecto->getDs_tipo()=='B'){		
				$ds_tipo =  "BASICA";
		}
		
		if ($oProyecto->getDs_tipo()=='A'){		
			$ds_tipo =  "APLICADA" ;
		}
		
		if ($oProyecto->getDs_tipo()=='D'){		
			$ds_tipo =  "DESARROLLO" ;
		}
		
		if ($oProyecto->getDs_tipo()=='C'){		
			$ds_tipo =  "CREACION" ;
		}
		//$xtpl->assign ( 'ds_tipo',  ( $ds_tipo) );
		$ds_detalles .= (PermisoQuery::permisosDeUsuario( $cd_usuario, "Todos los proyectos" ))?'<table class="tablaListado" border="1">			 <tr><td>Abstract</td><td colspan="9">'.nl2br($oProyecto->getDs_abstract1()).'</td></tr><tr><td>Abstract Ingl&eacute;s</td><td colspan="9">'.nl2br($oProyecto->getDs_abstracteng()).'</td></tr>		<tr><td>Palabras claves</td><td colspan="4">'.$oProyecto->getDs_clave1().' - '.$oProyecto->getDs_clave2().' - '.$oProyecto->getDs_clave3().' - '.$oProyecto->getDs_clave4().' - '.$oProyecto->getDs_clave5().' - '.$oProyecto->getDs_clave6().'</td><td>P. claves Ingl&eacute;s</td><td colspan="4">'.$oProyecto->getDs_claveeng1().' - '.$oProyecto->getDs_claveeng2().' - '.$oProyecto->getDs_claveeng3().' - '.$oProyecto->getDs_claveeng4().' - '.$oProyecto->getDs_claveeng5().' - '.$oProyecto->getDs_claveeng6().'</td></tr>			<tr><td>Especialidad</td><td colspan="4">'.$oProyecto->getDs_disciplina().' - '.$oProyecto->getDs_especialidad().'</td><td>Tipo de Investigaci&oacute;n</td><td colspan="4">'.$ds_tipo.'</td></tr>			<tr><td>Campo</td><td colspan="4">'.$oProyecto->getDs_campo().'</td><td>L&iacute;nea</td><td colspan="4">'.$oProyecto->getDs_linea().'</td></tr></table>':"";
		
		$xtpl->assign ( 'ds_detalles',  ( $ds_detalles) );
	}
	
	if (isset ( $_GET ['filtro'] ))
		$filtro = $_GET ['filtro']; else
		$filtro = "";
		
	if (isset ( $_GET ['page'] ))
		$page = $_GET ['page']; else
		$page = 1;
	
	if (isset ( $_GET ['orden'] ))
		$orden = $_GET ['orden']; else
		$orden = 'ASC';
	
	if (isset ( $_GET ['campo'] ))
		$campo = $_GET ['campo']; else
		$campo = 'ds_investigador';
	
	$query_string = "?filtro=$filtro&id=$cd_proyecto&";
	$xtpl->assign ( 'query_string', $query_string );
	
	if (isset ( $_GET ['err'] )){
		$err = FuncionesComunes::array_recibe($_GET ['err']);
		$msjerror = '';
		foreach ($err as $error)
			$msjerror .= $error.'<br>';
		$xtpl->assign ( 'msj', 'onLoad ="mensajeError(\''.$msjerror.'\')"' );
		$xtpl->assign ( 'classMsj', 'msjerror' );
		$xtpl->parse ( 'main.msj' );
	}
	
	
	$nuevoIntegrante = ((PermisoQuery::permisosDeUsuario( $cd_usuario, "Alta integrante" ))&&($oProyecto->getDt_fin()!=($_SESSION ['nu_yearSessionP']-1).'-12-31'))?'<a href="../integrantes/altaintegrante.php?cd_proyecto='.$cd_proyecto.'" title="Agregar Integrante"><img src="../img/add.jpg" class="imgAlta">Nuevo integrante</a>':'';
	$xtpl->assign ( 'nuevoIntegrante', $nuevoIntegrante );
	
	
	$xtpl->assign ( 'titulo', 'Detalle de proyecto' );
	$row_per_page = 100;
	$integrantes = IntegranteQuery::getIntegrantes( $campo, $orden, $filtro, $page, $row_per_page, $cd_proyecto );
	$count = count ( $integrantes );
	for($i = 0; $i < $count; $i ++) {
		$integrantes [$i]['ds_investigadorElim']=addslashes($integrantes [$i]['ds_investigador']);
		$campos = array('nu_cuil','ds_investigador','ds_categoria','ds_tipoinvestigador','ds_estado','ds_deddoc','ds_facultad', 'nu_horasinv', 'ds_cargo','becario','carrera');
		foreach ($campos as $camp){
			$integrantes [$i][$camp]=($integrantes [$i]['cd_tipoinvestigador']==1)?'<span class="Director">'.$integrantes [$i][$camp].'</span>':(($integrantes [$i]['cd_tipoinvestigador']==2)?'<span class="Codirector">'.$integrantes [$i][$camp].'</span>':((($integrantes [$i]['cd_estado']==1)||($integrantes [$i]['cd_estado']==4)||($integrantes [$i]['cd_estado']==6)||($integrantes [$i]['cd_estado']==8))?'<span class="Creada">'.$integrantes [$i][$camp].'</span>':(($integrantes [$i]['cd_estado']==2)?'<span class="Alta">'.$integrantes [$i][$camp].'</span>':(($integrantes [$i]['cd_estado']==5)?'<span class="Baja">'.$integrantes [$i][$camp].'</span>':(($integrantes [$i]['cd_estado']==7)?'<span class="Cambio">'.$integrantes [$i][$camp].'</span>':(($integrantes [$i]['cd_estado']==9)?'<span class="CambioHS">'.$integrantes [$i][$camp].'</span>':$integrantes [$i][$camp]))))));
		}
		/*$integrantes [$i]['ds_investigador']=($integrantes [$i]['cd_tipoinvestigador']==1)?'<span class="Director">'.$integrantes [$i]['ds_investigador'].'</span>':(($integrantes [$i]['cd_tipoinvestigador']==2)?'<span class="Codirector">'.$integrantes [$i]['ds_investigador'].'</span>':((($integrantes [$i]['cd_estado']==1)||($integrantes [$i]['cd_estado']==4)||($integrantes [$i]['cd_estado']==6))?'<span class="Creada">'.$integrantes [$i]['ds_investigador'].'</span>':(($integrantes [$i]['cd_estado']==2)?'<span class="Alta">'.$integrantes [$i]['ds_investigador'].'</span>':(($integrantes [$i]['cd_estado']==5)?'<span class="Baja">'.$integrantes [$i]['ds_investigador'].'</span>':$integrantes [$i]['ds_investigador']))));
		$integrantes [$i]['ds_investigador']=($integrantes [$i]['cd_tipoinvestigador']==1)?'<span class="Director">'.$integrantes [$i]['ds_investigador'].'</span>':(($integrantes [$i]['cd_tipoinvestigador']==2)?'<span class="Codirector">'.$integrantes [$i]['ds_investigador'].'</span>':((($integrantes [$i]['cd_estado']==1)||($integrantes [$i]['cd_estado']==4)||($integrantes [$i]['cd_estado']==6))?'<span class="Creada">'.$integrantes [$i]['ds_investigador'].'</span>':(($integrantes [$i]['cd_estado']==2)?'<span class="Alta">'.$integrantes [$i]['ds_investigador'].'</span>':(($integrantes [$i]['cd_estado']==5)?'<span class="Baja">'.$integrantes [$i]['ds_investigador'].'</span>':$integrantes [$i]['ds_investigador']))));
		$integrantes [$i]['ds_categoria']=($integrantes [$i]['cd_tipoinvestigador']==1)?'<span class="Director">'.$integrantes [$i]['ds_categoria'].'</span>':(($integrantes [$i]['cd_tipoinvestigador']==2)?'<span class="Codirector">'.$integrantes [$i]['ds_categoria'].'</span>':((($integrantes [$i]['cd_estado']==1)||($integrantes [$i]['cd_estado']==4)||($integrantes [$i]['cd_estado']==6))?'<span class="Creada">'.$integrantes [$i]['ds_categoria'].'</span>':(($integrantes [$i]['cd_estado']==2)?'<span class="Alta">'.$integrantes [$i]['ds_categoria'].'</span>':(($integrantes [$i]['cd_estado']==5)?'<span class="Baja">'.$integrantes [$i]['ds_categoria'].'</span>':$integrantes [$i]['ds_categoria']))));
		$integrantes [$i]['ds_tipoinvestigador']=($integrantes [$i]['cd_tipoinvestigador']==1)?'<span class="Director">'.$integrantes [$i]['ds_tipoinvestigador'].'</span>':(($integrantes [$i]['cd_tipoinvestigador']==2)?'<span class="Codirector">'.$integrantes [$i]['ds_tipoinvestigador'].'</span>':((($integrantes [$i]['cd_estado']==1)||($integrantes [$i]['cd_estado']==4)||($integrantes [$i]['cd_estado']==6))?'<span class="Creada">'.$integrantes [$i]['ds_tipoinvestigador'].'</span>':(($integrantes [$i]['cd_estado']==2)?'<span class="Alta">'.$integrantes [$i]['ds_tipoinvestigador'].'</span>':(($integrantes [$i]['cd_estado']==5)?'<span class="Baja">'.$integrantes [$i]['ds_tipoinvestigador'].'</span>':$integrantes [$i]['ds_tipoinvestigador']))));
		$integrantes [$i]['ds_estado']=($integrantes [$i]['cd_tipoinvestigador']==1)?'<span class="Director">'.$integrantes [$i]['ds_estado'].'</span>':(($integrantes [$i]['cd_tipoinvestigador']==2)?'<span class="Codirector">'.$integrantes [$i]['ds_estado'].'</span>':((($integrantes [$i]['cd_estado']==1)||($integrantes [$i]['cd_estado']==4)||($integrantes [$i]['cd_estado']==6))?'<span class="Creada">'.$integrantes [$i]['ds_estado'].'</span>':(($integrantes [$i]['cd_estado']==2)?'<span class="Alta">'.$integrantes [$i]['ds_estado'].'</span>':(($integrantes [$i]['cd_estado']==5)?'<span class="Baja">'.$integrantes [$i]['ds_estado'].'</span>':$integrantes [$i]['ds_estado']))));
		$integrantes [$i]['ds_deddoc']=($integrantes [$i]['cd_tipoinvestigador']==1)?'<span class="Director">'.$integrantes [$i]['ds_deddoc'].'</span>':(($integrantes [$i]['cd_tipoinvestigador']==2)?'<span class="Codirector">'.$integrantes [$i]['ds_deddoc'].'</span>':((($integrantes [$i]['cd_estado']==1)||($integrantes [$i]['cd_estado']==4)||($integrantes [$i]['cd_estado']==6))?'<span class="Creada">'.$integrantes [$i]['ds_deddoc'].'</span>':(($integrantes [$i]['cd_estado']==2)?'<span class="Alta">'.$integrantes [$i]['ds_deddoc'].'</span>':(($integrantes [$i]['cd_estado']==5)?'<span class="Baja">'.$integrantes [$i]['ds_deddoc'].'</span>':$integrantes [$i]['ds_deddoc']))));
		*/
		$dt=(FuncionesComunes::fechaMysqlaPHP($integrantes [$i]['dt_alta'])!='00/00/0000')?FuncionesComunes::fechaMysqlaPHP($integrantes [$i]['dt_alta']):'';
		if (($integrantes[$i]['cd_estado']==6)||($integrantes[$i]['cd_estado']==7)) {
			$dt=(FuncionesComunes::fechaMysqlaPHP($integrantes [$i]['dt_altapendiente'])!='00/00/0000')?FuncionesComunes::fechaMysqlaPHP($integrantes [$i]['dt_altapendiente']):'';;
		}
		
		$integrantes [$i]['dt_alta']=($integrantes [$i]['cd_tipoinvestigador']==1)?'<span class="Director">'.$dt.'</span>':(($integrantes [$i]['cd_tipoinvestigador']==2)?'<span class="Codirector">'.$dt.'</span>':((($integrantes [$i]['cd_estado']==1)||($integrantes [$i]['cd_estado']==4)||($integrantes [$i]['cd_estado']==6))?'<span class="Creada">'.$dt.'</span>':(($integrantes [$i]['cd_estado']==2)?'<span class="Alta">'.$dt.'</span>':(($integrantes [$i]['cd_estado']==5)?'<span class="Baja">'.$dt.'</span>':(($integrantes [$i]['cd_estado']==7)?'<span class="Cambio">'.$dt.'</span>':$dt)))));
		$dt=((FuncionesComunes::fechaMysqlaPHP($integrantes [$i]['dt_baja'])!='00/00/0000')&&(FuncionesComunes::fechaMysqlaPHP($integrantes [$i]['dt_baja'])!='//'))?FuncionesComunes::fechaMysqlaPHP($integrantes [$i]['dt_baja']):'';
		
		$integrantes [$i]['dt_baja']=($integrantes [$i]['cd_tipoinvestigador']==1)?'<span class="Director">'.$dt.'</span>':(($integrantes [$i]['cd_tipoinvestigador']==2)?'<span class="Codirector">'.$dt.'</span>':((($integrantes [$i]['cd_estado']==1)||($integrantes [$i]['cd_estado']==4)||($integrantes [$i]['cd_estado']==6))?'<span class="Creada">'.$dt.'</span>':(($integrantes [$i]['cd_estado']==2)?'<span class="Alta">'.$dt.'</span>':(($integrantes [$i]['cd_estado']==5)?'<span class="Baja">'.$dt.'</span>':(($integrantes [$i]['cd_estado']==7)?'<span class="Cambio">'.$dt.'</span>':$dt)))));
		//$integrantes [$i]['ds_facultad']=($integrantes [$i]['cd_tipoinvestigador']==1)?'<span class="Director">'.$integrantes [$i]['ds_facultad'].'</span>':(($integrantes [$i]['cd_tipoinvestigador']==2)?'<span class="Codirector">'.$integrantes [$i]['ds_facultad'].'</span>':((($integrantes [$i]['cd_estado']==1)||($integrantes [$i]['cd_estado']==4)||($integrantes [$i]['cd_estado']==6))?'<span class="Creada">'.$integrantes [$i]['ds_facultad'].'</span>':(($integrantes [$i]['cd_estado']==2)?'<span class="Alta">'.$integrantes [$i]['ds_facultad'].'</span>':(($integrantes [$i]['cd_estado']==5)?'<span class="Baja">'.$integrantes [$i]['ds_facultad'].'</span>':$integrantes [$i]['ds_facultad']))));
		$integrantes [$i]['linkeditar'] = (($integrantes [$i]['cd_estado']==1)&&(((PermisoQuery::permisosDeUsuario( $cd_usuario, "Modificar integrante" )))||(PermisoQuery::permisosDeUsuario( $cd_usuario, "Modificar docente" ))))?'<a href="../integrantes/modificarintegrante.php?cd_proyecto='.$cd_proyecto.'&cd_docente='.$integrantes [$i]['cd_docente'].'"><img class="hrefImg" src="../img/edit.jpg" title="Editar integrante" /></a>&nbsp;':'';
		$integrantes [$i]['linkeliminar'] = (($integrantes [$i]['cd_estado']==1)&&(($integrantes [$i]['cd_tipoinvestigador']!=1)&&(((PermisoQuery::permisosDeUsuario( $cd_usuario, "Modificar integrante" ))))||(PermisoQuery::permisosDeUsuario( $cd_usuario, "Modificar docente" ))))?'<a href="" onclick="confirmaElim(\''.$integrantes [$i]['ds_investigadorElim'].'\', this,\'../integrantes/eliminarintegrante.php?cd_proyecto='.$cd_proyecto.'&cd_docente='.$integrantes [$i]['cd_docente'].'\')"><img class="hrefImg" src="../img/del_.jpg" title="Eliminar integrante" /></a>&nbsp;':'';
		$integrantes [$i]['linkcambiar'] = ((($integrantes [$i]['cd_estado']==3)||($integrantes [$i]['cd_estado']==6))&&(($integrantes [$i]['cd_tipoinvestigador']==6)||($integrantes [$i]['cd_estado']==6))&&((PermisoQuery::permisosDeUsuario( $cd_usuario, "Cambiar colaborador" ))))?'<a href="../integrantes/cambiarintegrante.php?cd_proyecto='.$cd_proyecto.'&cd_docente='.$integrantes [$i]['cd_docente'].'"><img class="hrefImg" src="../img/cambiar.gif" title="Cambiar a integrante" /></a>&nbsp;':'';
		$integrantes [$i]['linkebajar'] = (($integrantes [$i]['cd_estado']!=1)&&($integrantes [$i]['cd_estado']!=2)&&($integrantes [$i]['cd_estado']!=5)&&($integrantes [$i]['cd_estado']!=6)&&($integrantes [$i]['cd_estado']!=7)&&($integrantes [$i]['cd_estado']!=8)&&($integrantes [$i]['cd_estado']!=9)&&($integrantes [$i]['cd_tipoinvestigador']!=2)&&($integrantes [$i]['cd_tipoinvestigador']!=1)&&((PermisoQuery::permisosDeUsuario( $cd_usuario, "Baja integrante" ))))?'<a href="../integrantes/bajaintegrante.php?cd_proyecto='.$cd_proyecto.'&cd_docente='.$integrantes [$i]['cd_docente'].'"><img class="hrefImg" src="../img/del.jpg" title="Baja integrante" /></a>&nbsp;':'';
		$integrantes [$i]['linkcambiarHS'] = ((($integrantes [$i]['cd_estado']==3)||($integrantes [$i]['cd_estado']==8))&&($integrantes [$i]['cd_tipoinvestigador']!=6)&&((PermisoQuery::permisosDeUsuario( $cd_usuario, "Cambiar Horas" ))))?'<a href="../integrantes/cambiarhoras.php?cd_proyecto='.$cd_proyecto.'&cd_docente='.$integrantes [$i]['cd_docente'].'"><img class="hrefImg" src="../img/clock.png" title="Cambiar horas" /></a>&nbsp;':'';
		//$tipo = (($integrantes [$i]['cd_estado']==1)||($integrantes [$i]['cd_estado']==2))?1:((($integrantes [$i]['cd_estado']==4)||($integrantes [$i]['cd_estado']==5))?2:(((($integrantes [$i]['cd_estado']==6)||($integrantes [$i]['cd_estado']==7))?3:0)));
		switch ($integrantes [$i]['cd_estado']) {
			case 1:
				$tipo = 1;
			break;
			case 2:
				$tipo = 1;
			break;
			case 4:
				$tipo = 2;
			break;
			case 5:
				$tipo = 2;
			break;
			case 6:
				$tipo = 3;
			break;
			case 7:
				$tipo = 3;
			break;
			case 8:
				$tipo = 4;
			break;
			case 9:
				$tipo = 4;
			break;
			default:
				$tipo = 0;
			break;
		}
		$integrantes [$i]['linkanularB'] = (($integrantes [$i]['cd_estado']==4)&&(PermisoQuery::permisosDeUsuario( $cd_usuario, "Baja integrante")))?'<a href="" onclick="confirmaAnular(\''.$integrantes [$i]['ds_investigadorElim'].'\', this,\'../integrantes/anularbaja.php?cd_proyecto='.$cd_proyecto.'&cd_docente='.$integrantes [$i]['cd_docente'].'\')"><img class="hrefImg"	src="../img/restore.gif" title="Anular Baja" /></a>&nbsp;':'';
		$integrantes [$i]['linkanular'] = (($integrantes [$i]['cd_estado']==6)&&(PermisoQuery::permisosDeUsuario( $cd_usuario, "Cambiar colaborador")))?'<a href="" onclick="confirmaCambio(\''.$integrantes [$i]['ds_investigadorElim'].'\', this,\'../integrantes/anularcambio.php?cd_proyecto='.$cd_proyecto.'&cd_docente='.$integrantes [$i]['cd_docente'].'\')"><img class="hrefImg"	src="../img/restore.gif" title="Anular Cambio" /></a>&nbsp;':'';
		$integrantes [$i]['linkanularHS'] = (($integrantes [$i]['cd_estado']==8)&&(PermisoQuery::permisosDeUsuario( $cd_usuario, "Cambiar Horas")))?'<a href="" onclick="confirmaCambioHS(\''.$integrantes [$i]['ds_investigadorElim'].'\', this,\'../integrantes/anularcambioHS.php?cd_proyecto='.$cd_proyecto.'&cd_docente='.$integrantes [$i]['cd_docente'].'\')"><img class="hrefImg"	src="../img/restore.gif" title="Anular Cambio" /></a>&nbsp;':'';
		$integrantes [$i]['linkpdf'] = ($integrantes [$i]['cd_estado']!=3)?'<a href="verPDF.php?cd_docente='.$integrantes [$i]['cd_docente'].'&cd_proyecto='.$integrantes [$i]['cd_proyecto'].'&tipo='.$tipo.'" target="_blank"><img class="hrefImg" src="../img/pdf.jpg" title="Ver PDF"/></a>&nbsp;':'';
		$integrantes [$i]['linkenviar'] = ((($integrantes [$i]['cd_estado']==1) || ($integrantes [$i]['cd_estado']==4)|| ($integrantes [$i]['cd_estado']==6)|| ($integrantes [$i]['cd_estado']==8))&&((PermisoQuery::permisosDeUsuario( $cd_usuario, "Enviar baja")||(PermisoQuery::permisosDeUsuario( $cd_usuario, "Enviar alta" ))||(PermisoQuery::permisosDeUsuario( $cd_usuario, "Enviar cambio" ))||(PermisoQuery::permisosDeUsuario( $cd_usuario, "Enviar cambio Horas" )))))?'<a href="" onclick="confirmaEnviar(this,\'verPDF.php?enviar=1&cd_docente='.$integrantes [$i]['cd_docente'].'&cd_proyecto='.$integrantes [$i]['cd_proyecto'].'&tipo='.$tipo.'\')"><img class="hrefImg" src="../img/send.jpg"	title="Enviar solicitud"/></a>&nbsp;':'';
		$integrantes [$i]['linkconfirmar'] = ((($integrantes [$i]['cd_estado']==2) || ($integrantes [$i]['cd_estado']==5)|| ($integrantes [$i]['cd_estado']==7)|| ($integrantes [$i]['cd_estado']==9))&&(PermisoQuery::permisosDeUsuario( $cd_usuario, "Confirmar alta/baja" )))?'<a href="" onclick="confirmaConfir(this, \'../integrantes/confirmar.php?cd_proyecto='.$cd_proyecto.'&cd_docente='.$integrantes [$i]['cd_docente'].'&tipo='.$tipo.'\')"><img class="hrefImg" src="../img/chk_on.png" title="Confirmar alta/baja" /></a>':'';
		$integrantes [$i]['linkrechazar'] = ((($integrantes [$i]['cd_estado']==2) || ($integrantes [$i]['cd_estado']==5)|| ($integrantes [$i]['cd_estado']==7)|| ($integrantes [$i]['cd_estado']==9))&&(PermisoQuery::permisosDeUsuario( $cd_usuario, "Rechazar alta/baja" )))?'<a href="../integrantes/rechazar.php?cd_proyecto='.$cd_proyecto.'&cd_docente='.$integrantes [$i]['cd_docente'].'&tipo='.$tipo.'"><img class="hrefImg" src="../img/chk_off.png" title="Rechazar alta/baja" /></a>':'';
		$dir = APP_PATH.'pdfs/'.$_SESSION ["nu_yearSessionP"].'/'.$_SESSION ["nu_mesSessionP"].'/'.$oProyecto->getCd_proyecto().'/'.$integrantes [$i]['nu_documento'].'/';
		$dirREL = 'pdfs/'.$_SESSION ["nu_yearSessionP"].'/'.$_SESSION ["nu_mesSessionP"].'/'.$oProyecto->getCd_proyecto().'/'.$integrantes [$i]['nu_documento'].'/';
		$adjuntos = '';
		if (file_exists($dir)){
				
		      
		     $handle=opendir($dir);
				while ($archivo = readdir($handle))
				{
			        if (strchr($archivo,$integrantes [$i]['nu_documento']))
			         {
			         	//if ((is_file($dir.$archivo))&&(!strchr($archivo,'ALTA_')&&(!strchr($archivo,'BAJA_'))&&(!strchr($archivo,'CAMBIO_'))))
			         	if ((is_file($dir.$archivo))&&(strchr($archivo,'_P'.$_SESSION ["nu_mesSessionP"].$_SESSION ["nu_yearSessionP"])))
				         {
					         	//$adjuntos .= $dir.$archivo;
					         	$adjuntos .='<a href="../'.$dirREL.$archivo.'" target="_blank"><img class="hrefImg" src="../img/file.jpg"
				title="'.$archivo.'" /></a>&nbsp;';
				         }
				      }
						
				}
			closedir($handle);
			}
			
			
		$integrantes [$i]['adjuntos']=$adjuntos;
		
		
		$xtpl->assign ( 'DATOS', $integrantes [$i] );
		$xtpl->parse ( 'main.row' );
	}
	
	/***************************************************
	 * PAGINADOR
	 **************************************************/
	
	
	
	$url = 'index.php?orden=' . $orden . '&campo=' . $campo . '&filtro=' . $filtro. '&filtroFacultad=' . $filtroFacultad;
	$cssclassotherpage = 'paginadorOtraPagina';
	$cssclassactualpage = 'paginadorPaginaActual';
	$ds_pag_anterior = 0; //$gral['pag_ant'];
	$ds_pag_siguiente = 2; //$gral['pag_sig'];
	$imp_pag = new Paginador ( $url, $num_pages, $page, $cssclassotherpage, $cssclassactualpage, $num_rows );
	$paginador = $imp_pag->imprimirPaginado ();
	$resultados = $imp_pag->imprimirResultados ();
	
	$imgCUILAsc = (($campo=='nu_cuil')&&($orden=='ASC'))?'<img class="hrefImg" title="Ordenar por CUIL asc" src="../img/asc.jpg" />':'';
	$imgCUILDesc = (($campo=='nu_cuil')&&($orden=='DESC'))?'<img class="hrefImg" title="Ordenar por CUIL desc" src="../img/desc.jpg" />':'';
	
	$imgINVAsc = (($campo=='ds_investigador')&&($orden=='ASC'))?'<img class="hrefImg" title="Ordenar por investigador asc" src="../img/asc.jpg" />':'';
	$imgINVDesc = (($campo=='ds_investigador')&&($orden=='DESC'))?'<img class="hrefImg" title="Ordenar por investigador desc" src="../img/desc.jpg" />':'';
	
	$imgESTAsc = (($campo=='ds_estado')&&($orden=='ASC'))?'<img class="hrefImg" title="Ordenar por estado asc" src="../img/asc.jpg" />':'';
	$imgESTDesc = (($campo=='ds_estado')&&($orden=='DESC'))?'<img class="hrefImg" title="Ordenar por estado desc" src="../img/desc.jpg" />':'';
	
	$imgCATAsc = (($campo=='ds_categoria')&&($orden=='ASC'))?'<img class="hrefImg" title="Ordenar por categoria asc" src="../img/asc.jpg" />':'';
	$imgCATDesc = (($campo=='ds_categoria')&&($orden=='DESC'))?'<img class="hrefImg" title="Ordenar por categoria desc" src="../img/desc.jpg" />':'';
	
	$imgDCARAsc = (($campo=='ds_tipoinvestigador')&&($orden=='ASC'))?'<img class="hrefImg" title="Ordenar por ded inv asc" src="../img/asc.jpg" />':'';
	$imgDCARDesc = (($campo=='ds_tipoinvestigador')&&($orden=='DESC'))?'<img class="hrefImg" title="Ordenar por ded inv desc" src="../img/desc.jpg" />':'';
	
	$imgDINVAsc = (($campo=='ds_tipoinvestigador')&&($orden=='ASC'))?'<img class="hrefImg" title="Ordenar por ded inv asc" src="../img/asc.jpg" />':'';
	$imgDINVDesc = (($campo=='ds_tipoinvestigador')&&($orden=='DESC'))?'<img class="hrefImg" title="Ordenar por ded inv desc" src="../img/desc.jpg" />':'';
	
	$imgDDOCAsc = (($campo=='ds_deddoc')&&($orden=='ASC'))?'<img class="hrefImg" title="Ordenar por ded doc asc" src="../img/asc.jpg" />':'';
	$imgDDOCDesc = (($campo=='ds_deddoc')&&($orden=='DESC'))?'<img class="hrefImg" title="Ordenar por ded doc desc" src="../img/desc.jpg" />':'';
	
	$imgALTAAsc = (($campo=='dt_alta')&&($orden=='ASC'))?'<img class="hrefImg" title="Ordenar por alta asc" src="../img/asc.jpg" />':'';
	$imgALTADesc = (($campo=='dt_alta')&&($orden=='DESC'))?'<img class="hrefImg" title="Ordenar por alta desc" src="../img/desc.jpg" />':'';
	
	$imgBAJAAsc = (($campo=='dt_baja')&&($orden=='ASC'))?'<img class="hrefImg" title="Ordenar por baja asc" src="../img/asc.jpg" />':'';
	$imgBAJADesc = (($campo=='dt_baja')&&($orden=='DESC'))?'<img class="hrefImg" title="Ordenar por baja desc" src="../img/desc.jpg" />':'';
	
	$imgFACAsc = (($campo=='ds_facultad')&&($orden=='ASC'))?'<img class="hrefImg" title="Ordenar por facultad asc" src="../img/asc.jpg" />':'';
	$imgFACDesc = (($campo=='ds_facultad')&&($orden=='DESC'))?'<img class="hrefImg" title="Ordenar por facultad desc" src="../img/desc.jpg" />':'';
	
	$imgHORAsc = (($campo=='nu_horasinv')&&($orden=='ASC'))?'<img class="hrefImg" title="Ordenar por horas asc" src="../img/asc.jpg" />':'';
	$imgHORDesc = (($campo=='nu_horasinv')&&($orden=='DESC'))?'<img class="hrefImg" title="Ordenar por horas desc" src="../img/desc.jpg" />':'';
	
	$imgCUIL=($imgCUILAsc!='')?$imgCUILAsc:(($imgCUILDesc!='')?$imgCUILDesc:'');
	$imgINV=($imgINVAsc!='')?$imgINVAsc:(($imgINVDesc!='')?$imgINVDesc:'');
	$imgCAR=($imgCARAsc!='')?$imgCARAsc:(($imgCARDesc!='')?$imgCARDesc:'');
	$imgCAT=($imgCATAsc!='')?$imgCATAsc:(($imgCATDesc!='')?$imgCATDesc:'');
	$imgEST=($imgESTAsc!='')?$imgESTAsc:(($imgESTDesc!='')?$imgESTDesc:'');
	$imgDINV=($imgDINVAsc!='')?$imgDINVAsc:(($imgDINVDesc!='')?$imgDINVDesc:'');
	$imgDDOC=($imgDDOCAsc!='')?$imgDDOCAsc:(($imgDDOCDesc!='')?$imgDDOCDesc:'');
	$imgALTA=($imgALTAAsc!='')?$imgALTAAsc:(($imgALTADesc!='')?$imgALTADesc:'');
	$imgBAJA=($imgBAJAAsc!='')?$imgBAJAAsc:(($imgBAJADesc!='')?$imgBAJADesc:'');
	$imgFAC=($imgFACAsc!='')?$imgFACAsc:(($imgFACDesc!='')?$imgFACDesc:'');
	$imgHOR=($imgHORAsc!='')?$imgHORAsc:(($imgHORDesc!='')?$imgHORDesc:'');
	
	$inverso=($orden=='DESC')?'ASC':'DESC';
	
	$xtpl->assign ( 'imgCUIL', $imgCUIL );
	$xtpl->assign ( 'imgINV', $imgINV );
	$xtpl->assign ( 'imgCAR', $imgCAR );
	$xtpl->assign ( 'imgCAT', $imgCAT );
	$xtpl->assign ( 'imgEST', $imgEST );
	$xtpl->assign ( 'imgDINV', $imgDINV );
	$xtpl->assign ( 'imgDDOC', $imgDDOC );
	$xtpl->assign ( 'imgALTA', $imgALTA );
	$xtpl->assign ( 'imgBAJA', $imgBAJA );
	$xtpl->assign ( 'imgFAC', $imgFAC );
	$xtpl->assign ( 'imgHOR', $imgHOR );
	$xtpl->assign ( 'orden', $inverso );
	$xtpl->assign ( 'filtro', $filtro );
	$xtpl->assign ( 'filtroDir', $filtroDir );
	$xtpl->assign ( 'resultado', $resultados );
	$xtpl->parse ( 'main.resultado' );
	
	$xtpl->assign ( 'PAG', $paginador );
	$xtpl->parse ( 'main.PAG' );
	$xtpl->parse ( 'main' );
	$xtpl->out ( 'main' );
} else
	header ( 'Location:../includes/accesodenegado.php' );
?>
