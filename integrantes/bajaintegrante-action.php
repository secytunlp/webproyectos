<?
include '../includes/include.php';
require '../includes/chequeo.php';
include '../includes/datosSession.php';

if (PermisoQuery::permisosDeUsuario( $cd_usuario, "Baja integrante" )) {
	
	$err=array();
	$item=0;
	$cd_docente = $_POST ['cd_docente'];
	$cd_proyecto = $_POST ['cd_proyecto'];
	$oDocente = new Docente ( );
	$oDocente->setCd_docente ( $cd_docente );
	DocenteQuery::getDocentePorId($oDocente);
	$oIntegrante = new Integrante();
	$oIntegrante->setCd_docente($oDocente->getCd_docente());
	$oIntegrante->setCd_proyecto($cd_proyecto);
	IntegranteQuery::getIntegrantePorId($oIntegrante);	
	$insertarInt=(($oIntegrante->getCd_estado()==3)&&($oIntegrante->getDt_baja())&&($oIntegrante->getDt_baja()!='0000-00-00'))?0:1;
	$cd_proyecto = $_POST ['cd_proyecto'];
	$oProyecto = new Proyecto ( );
	$oProyecto->setCd_proyecto ( $cd_proyecto );
	ProyectoQuery::getProyectoPorId($oProyecto);
	if (!$insertarInt){
		$err[$item]='El docente ya tiene fecha de baja en el proyecto';
		$item++;
	}
	if (isset ( $_POST ['dt_baja'] ))
			$oIntegrante->setDt_baja (FuncionesComunes::fechaPHPaMysql($_POST ['dt_baja'] ));
	if ((date("Y").'-'.'01-01'>$oIntegrante->getDt_baja())||(date("Y").'-'.'31-12'<$oIntegrante->getDt_baja())){
		$err[$item]='Fecha de baja fuera del per&iacute;odo';
		$item++;
	}
	if ($oIntegrante->getCd_tipoinvestigador()!=6){
		$integrantes = IntegranteQuery::getIntegrantes( 'ds_investigador', 'ASC', '', 1, 50, $oProyecto->getCd_proyecto() );
		$countp = count ( $integrantes );
		$nu_horastotal=0;
		$nu_total=0;
		$nu_categorizados=0;
		$nu_mayordedicacion=0;
		for($j = 0; $j < $countp; $j ++) {
			if (($integrantes [$j]['cd_tipoinvestigador']!=6)&&($integrantes [$j]['cd_docente']!=$oDocente->getCd_docente())&&(($integrantes [$j]['dt_baja']>=date('Y-m-d'))||(($integrantes [$j]['dt_baja']==''))||(($integrantes [$j]['dt_baja']=='0000-00-00')))){
				$nu_total++;
				$nu_horastotal = $nu_horastotal+$integrantes [$j]['nu_horasinv'];
				$oDocente1 = new Docente ( );
				$oDocente1->setCd_docente ( $integrantes [$j]['cd_docente']);
				DocenteQuery::getDocentePorid ( $oDocente1 );
				$nivel=$oDocente1->getNu_nivelunidad();
				$oUnidad = new Unidad();
				$oUnidad->setCd_unidad($oDocente1->getCd_unidad());
				$cd_padreunlp=0;
				$insertar=0;
				while($nivel>0){
					UnidadQuery::getUnidadPorId($oUnidad);
					$oUnidad->setCd_unidad($oUnidad->getCd_padre());
					if ($nivel==1){
						$cd_facultad= $oUnidad->getCd_facultad();
					}
					if((!$insertar)&&(($oUnidad->getCd_padre()==1850)||($oUnidad->getCd_padre()==20419))){
						$cd_padreunlp=1;
						$insertar=1;
					}
					if ($oUnidad->getCd_unidad()) {
						$nivel--;
					}
					else $nivel = 0;
				}
				UnidadQuery::getUnidadPorId($oUnidad);	
				
				if ((in_array($oDocente1->getDs_categoria(),$categorias))&&($cd_padreunlp)) $nu_categorizados++;	
				if (((in_array($oDocente1->getCd_deddoc(),$mayordedicacion))||(in_array($oDocente1->getCd_carrerainv(), $carrerainvs)) ||($oDocente1->getBl_becario()))&&($oProyecto->getCd_facultad()==$oDocente1->getCd_facultad())) $nu_mayordedicacion++;	
				
			}
			
		}
		if ($nu_total<$minintegrantes){
			$err[$item]='Proyecto con menos de '.$minintegrantes.' integrantes';
			$item++;
		}
		/*if ($nu_categorizados<$mincategorizados){
			$err[$item]='Proyecto con menos de '.$mincategorizados.' integrantes categorizados con lugar de trabajo en la U.N.L.P.';
			$item++;
		}*/
		if (!( $_POST ['bl_mincategoriados'] )){
			$err[$item]='Proyecto con menos de '.$mincategorizados.' integrantes categorizados con lugar de trabajo en la U.N.L.P.';
			$item++;
		}
		/*if ($nu_mayordedicacion<$minmayordedicacion){
			$err[$item]='Proyecto con menos de '.$minmayordedicacion.' integrantes con mayor dedicaci&oacute;n en la Unidad Acad&eacute;mica que se presenta el proyecto';
			$item++;
		}*/
		/*if (!( $_POST ['bl_minhoras'] )){
			$err[$item]='La suma de dedicaciones horarias de los miembros es menor a '.$minhstotales.' hs. semanales';
			$item++;
		}*/
		if ($nu_horastotal<$minhstotales){
			$err[$item]='La suma de dedicaciones horarias de los miembros es menor a '.$minhstotales.' hs. semanales';
			$item++;
		}
	}
		
	if(!$item){		
			//ProyectoQuery::getProyectoPorId($oProyecto);
				
				if (isset ( $_POST ['ds_consecuencias'] ))
					$oIntegrante->setDs_consecuencias($_POST ['ds_consecuencias']);
				if (isset ( $_POST ['ds_motivos'] ))
					$oIntegrante->setDs_motivos($_POST ['ds_motivos']);
				$oIntegrante->setCd_estado(4);
				$exito = IntegranteQuery::modificarIntegrante ( $oIntegrante );	
		
			
			if ($exito){
				$oFuncion = new Funcion();
				$oFuncion -> setDs_funcion("Baja integrante");
				FuncionQuery::getFuncionPorDs($oFuncion);
				$oMovimiento = new Movimiento();
				$oMovimiento->setCd_funcion($oFuncion->getCd_funcion());
				$oMovimiento->setCd_usuario($cd_usuario);
				$oMovimiento->setDs_movimiento('Docente: '.$oDocente->getNu_precuil().'-'.$oDocente->getNu_documento().'-'.$oDocente->getNu_postcuil().' - Proyecto: '.$oProyecto->getDs_codigo().' - F. Baja: '.$_POST ['dt_baja']);
				$oMovimiento->setDs_consecuencia($_POST ['ds_consecuencia']);
				MovimientoQuery::insertarMovimiento($oMovimiento);
				
				header ( 'Location: ../proyectos/verproyecto.php?id=' . $oProyecto->getCd_proyecto());
				
			}else{
				$err[$item]='Error: No se han modificado los datos del docente';
				
				header ( 'Location: bajaintegrante.php?err='.FuncionesComunes::array_envia($err).'&cd_proyecto=' . $oProyecto->getCd_proyecto().'&cd_docente='.$oDocente->getCd_docente() );
			}
		
	}
	else
			header ( 'Location: bajaintegrante.php?err='.FuncionesComunes::array_envia($err).'&cd_proyecto=' . $oProyecto->getCd_proyecto() .'&cd_docente='.$oDocente->getCd_docente() );
} else
	header ( 'Location:../includes/finsolicitud.php' );
	