<?
include '../includes/include.php';
require '../includes/chequeo.php';
include '../includes/datosSession.php';

if (PermisoQuery::permisosDeUsuario( $cd_usuario, "Exportar datos" )) {
	
	$fdocente = fopen("../datos/docentes.csv", "w+") or die("Operation Failed!");
	$modificados = DocenteQuery::getModificados(1);
	$count = count ( $modificados );
	for($i = 0; $i < $count; $i ++) {	
		$nu_documento=($modificados [$i]['nu_documento'])?$modificados [$i]['nu_documento']:'0';
		if (MovimientoQuery::tieneMovimientos($iniciosistema, $nu_documento)) {
		
			
			
			$nu_nro=($modificados [$i]['nu_nro'])?$modificados [$i]['nu_nro']:'0';
			$nu_piso=($modificados [$i]['nu_piso'])?$modificados [$i]['nu_piso']:'0';
			$nu_dedinv=($modificados [$i]['nu_dedinv'])?$modificados [$i]['nu_dedinv']:'0';
			
			$linea = trim($modificados [$i]['ds_nombre']).'¬'.trim($modificados [$i]['ds_apellido']).'¬'.trim($modificados [$i]['nu_precuil']).'¬'.trim($nu_documento).'¬'.trim($modificados [$i]['nu_postcuil']).'¬'.FuncionesComunes::fechaMysqlaPHP(trim($modificados [$i]['dt_nacimiento'])).'¬'.trim($modificados [$i]['ds_sexo']).'¬'.trim($modificados [$i]['ds_calle']).'¬'.trim($nu_nro).'¬'.trim($nu_piso).'¬'.trim($modificados [$i]['ds_depto']).'¬'.trim($modificados [$i]['ds_localidad']).'¬'.trim($modificados [$i]['cd_provincia']).'¬'.trim($modificados [$i]['nu_cp']).'¬'.trim($modificados [$i]['nu_telefono']).'¬'.trim($modificados [$i]['ds_mail']).'¬'.trim($modificados [$i]['cd_categoria']).'¬'.trim($nu_dedinv).'¬'.trim($modificados [$i]['cd_carrerainv']).'¬'.trim($modificados [$i]['cd_organismo']).'¬'.trim($modificados [$i]['cd_facultad']).'¬'.trim($modificados [$i]['cd_cargo']).'¬'.trim($modificados [$i]['cd_deddoc']).'¬'.trim($modificados [$i]['cd_titulo']).'¬'.trim($modificados [$i][' ds_codigo']).'¬'.trim($modificados [$i]['ds_tipomodificacion']).'¬'.trim($modificados [$i]['cd_tipoinvestigador']).'¬'.trim($modificados [$i]['cd_universidad']).'¬'.trim($modificados [$i]['nu_ident']).'¬'.trim($modificados [$i]['ds_proyecto']);
			fputs($fdocente, $linea."\n");
		}
		
	}
	fclose($fdocente);
	$fintegrantes = fopen("../datos/integrantes.csv", "w+") or die("Operation Failed!");
	$insertados = IntegranteQuery::getInsertados(1);
	$count = count ( $insertados );
	for($i = 0; $i < $count; $i ++) {	
		
		if (MovimientoQuery::tieneMovimientos($iniciosistema, $insertados [$i]['nu_documento'])) {	
			$linea = trim($insertados [$i]['cd_proyecto']).'¬'.trim($insertados [$i]['cd_docente']).'¬'.trim($insertados [$i]['nu_documento']).'¬'.trim($insertados [$i]['ds_codigo']).'¬'.trim(FuncionesComunes::fechaMysqlaPHP($insertados [$i]['dt_alta'])).'¬'.trim(FuncionesComunes::fechaMysqlaPHP($insertados [$i]['dt_baja'])).'¬'.trim($insertados [$i]['nu_horasinv']).'¬'.trim($insertados [$i]['cd_tipoinvestigador']);
			/*$oIntegrante = new Integrante();
			$oIntegrante->setCd_docente($insertados [$i]['cd_docente']);
			$oIntegrante->setCd_proyecto($insertados [$i]['cd_proyecto']);
			IntegranteQuery::getIntegrantePorId($oIntegrante);
			$oIntegrante->setBl_insertado(0);
			IntegranteQuery::modificarIntegrante($oIntegrante);*/
			fputs($fintegrantes, $linea."\n");
		}
		
	}
	fclose($fintegrantes);
	$fdocente = fopen("../datos/docentes_ppid.csv", "w+") or die("Operation Failed!");
	$modificados = DocenteQuery::getModificados(2);
	$count = count ( $modificados );
	for($i = 0; $i < $count; $i ++) {	
		$nu_documento=($modificados [$i]['nu_documento'])?$modificados [$i]['nu_documento']:'0';
		if (MovimientoQuery::tieneMovimientos($iniciosistema, $nu_documento)) {
		
			
			
			$nu_nro=($modificados [$i]['nu_nro'])?$modificados [$i]['nu_nro']:'0';
			$nu_piso=($modificados [$i]['nu_piso'])?$modificados [$i]['nu_piso']:'0';
			$nu_dedinv=($modificados [$i]['nu_dedinv'])?$modificados [$i]['nu_dedinv']:'0';
			
			$linea = trim($modificados [$i]['ds_nombre']).'¬'.trim($modificados [$i]['ds_apellido']).'¬'.trim($modificados [$i]['nu_precuil']).'¬'.trim($nu_documento).'¬'.trim($modificados [$i]['nu_postcuil']).'¬'.FuncionesComunes::fechaMysqlaPHP(trim($modificados [$i]['dt_nacimiento'])).'¬'.trim($modificados [$i]['ds_sexo']).'¬'.trim($modificados [$i]['ds_calle']).'¬'.trim($nu_nro).'¬'.trim($nu_piso).'¬'.trim($modificados [$i]['ds_depto']).'¬'.trim($modificados [$i]['ds_localidad']).'¬'.trim($modificados [$i]['cd_provincia']).'¬'.trim($modificados [$i]['nu_cp']).'¬'.trim($modificados [$i]['nu_telefono']).'¬'.trim($modificados [$i]['ds_mail']).'¬'.trim($modificados [$i]['cd_categoria']).'¬'.trim($nu_dedinv).'¬'.trim($modificados [$i]['cd_carrerainv']).'¬'.trim($modificados [$i]['cd_organismo']).'¬'.trim($modificados [$i]['cd_facultad']).'¬'.trim($modificados [$i]['cd_cargo']).'¬'.trim($modificados [$i]['cd_deddoc']).'¬'.trim($modificados [$i]['cd_titulo']).'¬'.trim($modificados [$i][' ds_codigo']).'¬'.trim($modificados [$i]['ds_tipomodificacion']).'¬'.trim($modificados [$i]['cd_tipoinvestigador']).'¬'.trim($modificados [$i]['cd_universidad']).'¬'.trim($modificados [$i]['nu_ident']).'¬'.trim($modificados [$i]['ds_proyecto']);
			fputs($fdocente, $linea."\n");
		}
		
	}
	fclose($fdocente);
	$fintegrantes = fopen("../datos/integrantes_ppid.csv", "w+") or die("Operation Failed!");
	$insertados = IntegranteQuery::getInsertados(2);
	$count = count ( $insertados );
	for($i = 0; $i < $count; $i ++) {		
		
		if (MovimientoQuery::tieneMovimientos($iniciosistema, $insertados [$i]['nu_documento'])) {	
			$linea = trim($insertados [$i]['cd_proyecto']).'¬'.trim($insertados [$i]['cd_docente']).'¬'.trim($insertados [$i]['nu_documento']).'¬'.trim($insertados [$i]['ds_codigo']).'¬'.trim(FuncionesComunes::fechaMysqlaPHP($insertados [$i]['dt_alta'])).'¬'.trim(FuncionesComunes::fechaMysqlaPHP($insertados [$i]['dt_baja'])).'¬'.trim($insertados [$i]['nu_horasinv']).'¬'.trim($insertados [$i]['cd_tipoinvestigador']);
			/*$oIntegrante = new Integrante();
			$oIntegrante->setCd_docente($insertados [$i]['cd_docente']);
			$oIntegrante->setCd_proyecto($insertados [$i]['cd_proyecto']);
			IntegranteQuery::getIntegrantePorId($oIntegrante);
			$oIntegrante->setBl_insertado(0);
			IntegranteQuery::modificarIntegrante($oIntegrante);*/
			fputs($fintegrantes, $linea."\n");
		}
		
	}
	fclose($fintegrantes);
	header ( 'Location: index.php?er=1' );
} else
	header ( 'Location:../includes/accesodenegado.php' );
	