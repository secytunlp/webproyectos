<?
include '../includes/include.php';
require '../includes/chequeo.php';
include '../includes/datosSession.php';

if (PermisoQuery::permisosDeUsuario( $cd_usuario, "Cambiar Horas" )) {
	
		
	$cd_docente = $_POST ['cd_docente'];
	$cd_proyecto = $_POST ['cd_proyecto'];
	
	$oDocente = new Docente ( );
	$oDocente->setCd_docente ( $cd_docente );
	DocenteQuery::getDocentePorId($oDocente);
	$oIntegrante = new Integrante();
	$oIntegrante->setCd_docente($oDocente->getCd_docente());
	$oIntegrante->setCd_proyecto($cd_proyecto);
	IntegranteQuery::getIntegrantePorId($oIntegrante);	
	
			
	$oCategoria = new Categoria();
	$oCategoria->setCd_categoria($oDocente->getCd_categoria());
	CategoriaQuery::getCategoriaPorId($oCategoria);
	$cd_proyecto = $_POST ['cd_proyecto'];
	$oProyecto = new Proyecto ( );
	$oProyecto->setCd_proyecto ( $cd_proyecto );
	
	if (isset ( $_POST ['cd_carrerainv'] )){
		$ds_tipomodificacion .= ($_POST ['cd_carrerainv'] != $oDocente->getCd_carrerainv())?'Carrera-':'';
		$oDocente->setCd_carrerainv ( $_POST ['cd_carrerainv'] );
	}
	if (isset ( $_POST ['cd_organismo'] )){
		$ds_tipomodificacion .= ($_POST ['cd_organismo'] != $oDocente->getCd_organismo())?'Organismo-':'';
		$oDocente->setCd_organismo ( $_POST ['cd_organismo'] );
	}
		
		ProyectoQuery::getProyectoPorId($oProyecto);
		
		if (isset ( $_POST ['cd_facultad'] )){
			$ds_tipomodificacion .= ($_POST ['cd_facultad'] != $oDocente->getCd_facultad())?'Facultad-':'';
			$oDocente->setCd_facultad ( $_POST ['cd_facultad'] );
		}
		if (isset ( $_POST ['ds_apellido'] )){
			$ds_tipomodificacion .= ($_POST ['ds_apellido'] != $oDocente->getDs_apellido())?'Apellido-':'';
			$oDocente->setDs_apellido ( $_POST ['ds_apellido'] );
		}
		if (isset ( $_POST ['ds_nombre'] )){
			$ds_tipomodificacion .= ($_POST ['ds_nombre'] != $oDocente->getDs_nombre())?'Nombre-':'';
			$oDocente->setDs_nombre ( $_POST ['ds_nombre'] );
		}
		if (isset ( $_POST ['nu_precuil'] )){
			$ds_tipomodificacion .= ($_POST ['nu_precuil'] != $oDocente->getNu_precuil())?'Precuil-':'';
			$oDocente->setNu_precuil ( $_POST ['nu_precuil'] );
		}
		if (isset ( $_POST ['nu_documento'] )){
			$ds_tipomodificacion .= ($_POST ['nu_documento'] != $oDocente->getNu_documento())?'Documento-':'';
			$oDocente->setNu_documento ( $_POST ['nu_documento'] );
		}
		if (isset ( $_POST ['nu_postcuil'] )){
			$ds_tipomodificacion .= ($_POST ['nu_postcuil'] != $oDocente->getNu_postcuil())?'Postcuil-':'';
			$oDocente->setNu_postcuil ( $_POST ['nu_postcuil'] );
		}
		
		if (isset ( $_POST ['cd_cargo'] )){
			$ds_tipomodificacion .= ($_POST ['cd_cargo'] != $oDocente->getCd_cargo())?'Cargo-':'';
			$oDocente->setCd_cargo ( $_POST ['cd_cargo'] );
		}
		if ( $_POST ['dt_cargo'] ){
			$ds_tipomodificacion .= (FuncionesComunes::fechaPHPaMysql($_POST ['dt_cargo']) != $oDocente->getDt_cargo())?'Fecha cargo-':'';
			$oDocente->setDt_cargo ( FuncionesComunes::fechaPHPaMysql($_POST ['dt_cargo']) );
			$dt_alta=(date("Y").'-'.'01-01'<=FuncionesComunes::fechaPHPaMysql($_POST ['dt_cargo']))?FuncionesComunes::fechaPHPaMysql($_POST ['dt_cargo']):date("Y").'-'.'01-01';
		}
		if (isset ( $_POST ['cd_deddoc'] )){
			$ds_tipomodificacion .= ($_POST ['cd_deddoc'] != $oDocente->getCd_deddoc())?'Dedicaci?n-':'';
			$oDocente->setCd_deddoc ( $_POST ['cd_deddoc'] );
		}
		if (isset ( $_POST ['cd_universidad'] )){
			$ds_tipomodificacion .= ($_POST ['cd_universidad'] != $oDocente->getCd_universidad())?'Universidad-':'';
			$oDocente->setCd_universidad ( $_POST ['cd_universidad'] );
		}
		if (isset ( $_POST ['bl_becario'] )){
			$ds_tipomodificacion .= ($_POST ['bl_becario'] != $oDocente->getBl_becario())?'Becario-':'';
			$oDocente->setBl_becario ( $_POST ['bl_becario'] );
		}
		if (( $_POST ['dt_beca'] )){
			$ds_tipomodificacion .= (FuncionesComunes::fechaPHPaMysql($_POST ['dt_beca']) != $oDocente->getDt_beca())?'Fecha beca-':'';
			$oDocente->setDt_beca ( FuncionesComunes::fechaPHPaMysql($_POST ['dt_beca'] ));
			if (!$dt_alta) 
				$dt_alta=(date("Y").'-'.'01-01'<=FuncionesComunes::fechaPHPaMysql($_POST ['dt_beca']))?FuncionesComunes::fechaPHPaMysql($_POST ['dt_beca']):date("Y").'-'.'01-01';
			elseif ($dt_alta>$oDocente->getDt_beca()) {
				$dt_alta=(date("Y").'-'.'01-01'<=FuncionesComunes::fechaPHPaMysql($_POST ['dt_beca']))?FuncionesComunes::fechaPHPaMysql($_POST ['dt_beca']):date("Y").'-'.'01-01';
			}
		}
		if (isset ( $_POST ['ds_tipobeca'] )){
			$ds_tipomodificacion .= ($_POST ['ds_tipobeca'] != $oDocente->getDs_tipobeca())?'Tipo Beca-':'';
			$oDocente->setDs_tipobeca ( $_POST ['ds_tipobeca'] );
		}
		if (isset ( $_POST ['ds_orgbeca'] )){
			$ds_tipomodificacion .= ($_POST ['ds_orgbeca'] != $oDocente->getDs_orgbeca())?'Org. Beca-':'';
			$oDocente->setDs_orgbeca ( $_POST ['ds_orgbeca'] );
		}
		
		
			
		
			
			$ds_tipomodificacion = ($ds_tipomodificacion)?substr($ds_tipomodificacion,0,strlen($ds_tipomodificacion)-1):$ds_tipomodificacion;	
			$ds_tipomodificacion = ($insertar)?'Nuevo':$ds_tipomodificacion;
			if ($ds_tipomodificacion){
				$oTipomodificacion = new Tipomodificacion();
				$oTipomodificacion->setDs_tipomodificacion($ds_tipomodificacion);
				TipomodificacionQuery::getTipomodificacionPorDs($oTipomodificacion);
				if (!$oTipomodificacion->getCd_tipomodificacion()){
					TipomodificacionQuery::insertarTipomodificacion($oTipomodificacion);
				}
				$oDocente->setCd_tipomodificacion($oTipomodificacion->getCd_tipomodificacion());
			}
			$exito = DocenteQuery::modificarDocente ( $oDocente );	
			
			if ($exito){
				
				if (isset ( $_POST ['nu_horasinvAnt'.$oProyecto->getCd_proyecto()] ))
						$oIntegrante->setNu_horasinvAnt ( $_POST ['nu_horasinvAnt'.$oProyecto->getCd_proyecto()] );		
				
				if (isset ( $_POST ['nu_horasinv'.$oProyecto->getCd_proyecto()] ))
						$oIntegrante->setNu_horasinv ( $_POST ['nu_horasinv'.$oProyecto->getCd_proyecto()] );
				if (isset ( $_POST ['dt_cambioHS'] ))
						$oIntegrante->setDt_cambioHS ( FuncionesComunes::fechaPHPaMysql($_POST ['dt_cambioHS'] ));
				if (isset ( $_POST ['ds_reduccionHS'] ))
						$oIntegrante->setDs_reduccionHS ( ($_POST ['ds_reduccionHS'] ));
				
				
				$oIntegrante->setCd_estado(8);
				$exito = IntegranteQuery::cambioHS ( $oIntegrante );	
			}
			if ($exito){
				$i=0;
				$ok=1;
				while ($ok){
					if (isset ( $_POST ['p'.$i] )){
						$cd_otro = $_POST ['p'.$i];
						if ($cd_otro != $oProyecto->getCd_proyecto()){
							if (isset ( $_POST ['nu_horasinv'.$cd_otro] )){
								$oIntegrante->setCd_docente($oDocente->getCd_docente());
								$oIntegrante->setCd_proyecto($cd_otro);
								IntegranteQuery::getIntegrantePorId($oIntegrante);	
								$oIntegrante->setNu_horasinv ( $_POST ['nu_horasinv'.$cd_otro] );
								IntegranteQuery::modificarIntegrante($oIntegrante);
							}
						}
					}
					else $ok=0;
					$i++;
				}		
				$oFuncion = new Funcion();
				$oFuncion -> setDs_funcion("Cambiar Horas");
				FuncionQuery::getFuncionPorDs($oFuncion);
				$oMovimiento = new Movimiento();
				$oMovimiento->setCd_funcion($oFuncion->getCd_funcion());
				$oMovimiento->setCd_usuario($cd_usuario);
				$oMovimiento->setDs_movimiento('Docente: '.$oDocente->getNu_precuil().'-'.$oDocente->getNu_documento().'-'.$oDocente->getNu_postcuil().' - Proyecto: '.$oProyecto->getCd_proyecto());
				
				MovimientoQuery::insertarMovimiento($oMovimiento);
				
				
				header ( 'Location: ../proyectos/verproyecto.php?id='.$oProyecto->getCd_proyecto() ); 
			}else
				header ( 'Location: cambiarhoras.php?er=1&cd_proyecto=' . $oProyecto->getCd_proyecto().'&cd_docente='.$oDocente->getCd_docente() );
		
	
	
} else
	header ( 'Location:../includes/finsolicitud.php' );
	