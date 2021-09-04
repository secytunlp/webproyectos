<?php
include '../includes/include.php';

if (isset ( $_GET ['ds_apellido'] ))
	$ds_apellido = $_GET ['ds_apellido']; else
	$ds_apellido = '';
if (isset ( $_GET ['cd_proyecto'] ))
	$cd_proyecto = $_GET ['cd_proyecto']; else
	$cd_proyecto = 0;

$oDocente = new Docente();
$oDocente->setDs_apellido($ds_apellido);
$docentes = DocenteQuery::getDocentesPorApellido($oDocente);

$html='<select name="docente" size="18" id="listado_docente">';

$count = count ( $docentes );
	for($i = 0; $i < $count; $i ++) {
                $aux=$docentes[$i]['nu_documento'];
                $html.="<option id='doc' value=".$aux.">".htmlentities($docentes [$i]['ds_apellido']).", ".htmlentities($docentes [$i]['ds_nombre'])." | ".$docentes [$i]['nu_documento']."</option>";
//		$docentes [$i]['nu_ident'];
//		echo $docentes [$i]['cd_docente'];
//		echo $docentes [$i]['ds_nombre'];
//		echo $docentes [$i]['ds_apellido'];
//		echo $docentes [$i]['nu_documento'];
//
//		$xtpl->assign ( 'DATOS', $proyectos [$i] );
//		$xtpl->parse ( 'main.row' );
	}
$html.='</select><input type="hidden" name="cd_proyecto" id="cd_proyecto" value="'.$cd_proyecto.'"/><p class="span_ajax">
        &bull;Presione la cruz negra si desea realizar una nueva busqueda.<br>
        &bull;De no existir ningun Integrante haga "click" en el centro del recuadro vacio.</p>';
/*$html.='<a href="altaintegrante.php?cd_proyecto="'.$cd_proyecto.'"/>Cancelar</a>';*/
//print_r($docentes);
//
//$nu_precuil=($oDocente->getNu_precuil()==0)?'':$oDocente->getNu_precuil();
//$nu_documento=($oDocente->getNu_documento()==0)?'':$oDocente->getNu_documento();
//$nu_postcuil=($oDocente->getNu_postcuil()===0)?'':$oDocente->getNu_postcuil();
//$disabled = ($oDocente->getCd_docente())?'disabled="disabled"':'';
//$html = "<p class=MsoNormal style='text-align:justify;line-height:125%'><span lang=ES-TRAD style='font-size:11.0pt;line-height:125%;
//font-family:Arial;color:windowtext'>C.U.I.L.: <label>
//    <input type='text' name='nu_precuil' id='nu_precuil' value='".$nu_precuil."' size='2' maxlength='2' class='' /> -
//	<input type='text' name='nu_documento' id='nu_documento' value='".$nu_documento."' size='10' maxlength='9' class=''  onChange='cargarDatos();'/> - <input type='text' name='nu_postcuil' id='nu_postcuil' value='".$nu_postcuil."' size='1' maxlength='1' class='' />
//    </label></span></p>";
//
//$html .= "<p class=MsoNormal style='line-height:125%'><span lang=ES-TRAD
//style='font-size:11.0pt;line-height:125%;font-family:Arial;color:windowtext'>Apellido
//y Nombres:
//    <label>
//    <input type='text' name='ds_apellido' id='ds_apellido' value='".htmlentities($oDocente->getDs_apellido())."' class='' onchange='mayusculas(this)'/>
//    ,
//    <input type='text' name='ds_nombre' id='ds_nombre' value='".htmlentities($oDocente->getDs_nombre())."' class='' onchange='mayusculas(this)'/>
//    </label>
//</span></p>";
//$oIntegrante = new Integrante();
//$oIntegrante->setCd_docente($oDocente->getCd_docente());
//$oIntegrante->setCd_proyecto($cd_proyecto);
//IntegranteQuery::getIntegrantePorId($oIntegrante);
//$html .= "<p class=MsoNormal style='line-height:125%'><span lang=ES-TRAD style='font-size:11.0pt;line-height:125%;font-family:Arial;color:windowtext'>Tipo de Investigador:<label><select name='cd_tipoinvestigador' id='cd_tipoinvestigador' style='width: 300px'>
//										<option value=''> -- Seleccione una -- </option>";
//$tipoinvestigadores = TipoinvestigadorQuery::listar ($oIntegrante->getCd_tipoinvestigador());
//	$rowsize = count ( $tipoinvestigadores );
//
//	for($i = 0; $i < $rowsize; $i ++) {
//		$html .= "<option value=" . $tipoinvestigadores [$i] ['cd_tipoinvestigador'] . ">" . htmlentities($tipoinvestigadores [$i] ['ds_tipoinvestigador']) . "</option>";
//	}
//
//$html .= "</select></label></span></p>";
//$html .= "<p class=MsoNormal style='text-align:justify;line-height:125%'><span
//lang=ES-TRAD style='font-size:11.0pt;line-height:125%;font-family:Arial;
//color:windowtext'>Categor&iacute;a de Docente Investigador: <select name='cd_categoria' id='cd_categoria'  class='' $disabled>
//							<option value=''>- Seleccione Uno -</option>";
//
//$categorias = CategoriaQuery::listar ($oDocente->getCd_categoria());
//	$rowsize = count ( $categorias );
//
//	for($i = 0; $i < $rowsize; $i ++) {
//
//		$html .= "<option value=" . $categorias [$i] ['cd_categoria'] . ">" . htmlentities($categorias [$i] ['ds_categoria']) . "</option>";
//	}
//
//
//$html .= "</select></span></p>";
//$html .= "<p class=MsoNormal style='text-align:justify;line-height:125%'><span
//lang=ES-TRAD style='font-size:11.0pt;line-height:125%;font-family:Arial;
//color:windowtext'>T&iacute;tulo de Grado :
//    <select name='cd_titulo' id='cd_titulo' class='' style='width: 600px'>
//							<option value=''>- Seleccione Uno -</option>";
//$todos = (($oDocente->getCd_titulo())&&($oDocente->getCd_titulo()!=9999))?1:0;
//$titulos = TituloQuery::listar ($oDocente->getCd_titulo(),$todos);
//	$rowsize = count ( $titulos );
//
//	for($i = 0; $i < $rowsize; $i ++) {
//
//		$html .= "<option value=" . $titulos [$i] ['cd_titulo'] . ">" . htmlentities($titulos [$i] ['ds_titulo']) . "</option>";
//	}
//
//
//$html .= "</select></span></p>";
//
//$html .= "<p class=MsoNormal style='text-align:justify;line-height:125%'><span
//lang=ES-TRAD style='font-size:11.0pt;line-height:125%;font-family:Arial;
//color:windowtext'>Cargo docente: <select name='cd_cargo' id='cd_cargo' class='' $disabled>
//							<option value=''>- Seleccione Uno -</option>";
//$cargos = CargoQuery::listar ($oDocente->getCd_cargo());
//	$rowsize = count ( $cargos );
//
//	for($i = 0; $i < $rowsize; $i ++) {
//
//		$html .= "<option value=" . $cargos [$i] ['cd_cargo'] . ">" . htmlentities($cargos [$i] ['ds_cargo']) . "</option>";
//	}
//
//
//$html .= "</select>";
//$html .= "<span style='mso-tab-count:4'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>Dedicaci&oacute;n: <select name='cd_deddoc' id='cd_deddoc' class='' $disabled>
//							<option value=''>- Seleccione Uno -</option>";
//$deddocs = DeddocQuery::listar ($oDocente->getCd_deddoc());
//	$rowsize = count ( $deddocs );
//
//	for($i = 0; $i < $rowsize; $i ++) {
//
//		$html .= "<option value=" . $deddocs [$i] ['cd_deddoc'] . ">" . htmlentities($deddocs [$i] ['ds_deddoc']) . "</option>";
//	}
//
//$html .= "</select></span></p>";
//$html .= "<p class=MsoNormal style='line-height:125%'><span lang=ES-TRAD
//style='font-size:11.0pt;line-height:125%;font-family:Arial;color:windowtext'>Unidad
//Acad&eacute;mica: <select name='cd_facultadDoc' id='cd_facultadDoc' class='' style='width: 300px'>
//							<option value=''>- Seleccione Uno -</option>";
//$facultads = FacultadQuery::listar ($oDocente->getCd_facultad());
//$rowsize = count ( $facultads );
//
//for($i = 0; $i < $rowsize; $i ++) {
//
//	$html .= "<option value=" . $facultads [$i] ['cd_facultad'] . ">" . htmlentities($facultads [$i] ['ds_facultad']) . "</option>";
//}
//$html .= "</select>
//&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Universidad:
//<select name='cd_universidad' id='cd_universidad' class='' style='width: 300px'>
//							<option value=''>- Seleccione Uno -</option>";
//$universidads = UniversidadQuery::listar ($oDocente->getCd_universidad());
//$rowsize = count ( $universidads );
//
//for($i = 0; $i < $rowsize; $i ++) {
//
//	$html .= "<option value=" . $universidads [$i] ['cd_universidad'] . ">" . htmlentities($universidads [$i] ['ds_universidad']) . "</option>";
//}
//$html .= "</select></span></p>";
//$html .= "<p class=MsoNormal style='line-height:125%'><span lang=ES-TRAD
//style='font-size:11.0pt;line-height:125%;font-family:Arial;color:windowtext'>Cargo en la C. del  Inv.:
//  <select name='cd_carrerainv' id='cd_carrerainv' class='' style='width: 275px'>
//							<option value=''>- Seleccione Uno -</option>";
//$carrerainvs = CarrerainvQuery::listar ($oDocente->getCd_carrerainv());
//$rowsize = count ( $carrerainvs );
//
//for($i = 0; $i < $rowsize; $i ++) {
//
//	$html .= "<option value=" . $carrerainvs [$i] ['cd_carrerainv'] . ">" . htmlentities($carrerainvs [$i] ['ds_carrerainv']) . "</option>";
//}
//$html .= "</select>
//&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Organismo:
//<select name='cd_organismo' id='cd_organismo' class='' style='width: 300px'>
//							<option value=''>- Seleccione Uno -</option>";
//$organismos = OrganismoQuery::listar ($oDocente->getCd_organismo());
//$rowsize = count ( $organismos );
//
//for($i = 0; $i < $rowsize; $i ++) {
//
//	$html .= "<option value=" . $organismos [$i] ['cd_organismo'] . ">" . htmlentities($organismos [$i] ['ds_organismo']) . "</option>";
//}
//$html .= "</select></span></p>";
//
//$nivel=$oDocente->getNu_nivelunidad();
//$htmlarray = array();
//$oUnidad = new Unidad();
//$oUnidad->setCd_unidad($oDocente->getCd_unidad());
//UnidadQuery::getUnidadPorId($oUnidad);
//while($nivel>0){
//
//	$htmlarray[$nivel]="<div id='unidad".$nivel."'><p class=MsoNormal style='line-height:125%'><span lang=ES-TRAD
//style='font-size:11.0pt;line-height:125%;font-family:Arial;color:windowtext'><label>Lugar de trabajo nivel ".$nivel.":";
//	$htmlarray[$nivel] .= "<select name='cd_unidad".$nivel."' id='cd_unidad".$nivel."' onchange=\"cargarUnidad('altaproyecto1', '".($nivel+1)."');\" style='width: 300px'>";
//	$htmlarray[$nivel] .= "<option value=''> -- Seleccione una -- </option>";
//
//	$res = UnidadQuery::listar ($oUnidad);
//	foreach ( $res as $unidad ) {
//		$htmlarray[$nivel] .= "<option value=" . $unidad ['cd_unidad'] . ">" . htmlentities($unidad ['ds_unidad']) . "</option>";
//
//	}
//
//	$htmlarray[$nivel] .= "</select></label></p></div>";
//	//$htmlarray[$nivel] .= "<div id='unidad".($nivel+1)."'></div>";
//	$oUnidad->setCd_unidad($oUnidad->getCd_padre());
//	UnidadQuery::getUnidadPorId($oUnidad);
//	$nivel--;
//}
//
//
//
//
//$html .= "<p class=MsoNormal style='line-height:125%'><span lang=ES-TRAD
//style='font-size:11.0pt;line-height:125%;font-family:Arial;color:windowtext'>Tipo de Lugar de trabajo:
//    <label> <select name='cd_tipounidad' id='cd_tipounidad' class='' style='width: 300px' onchange=\"cargarUnidad('altaintegrante',0);\">
//							<option value=''>- Seleccione Uno -</option>";
//$tipounidads = TipounidadQuery::listar ($oUnidad->getCd_tipounidad());
//$rowsize = count ( $tipounidads );
//
//for($i = 0; $i < $rowsize; $i ++) {
//
//	$html .= "<option value=" . $tipounidads [$i] ['cd_tipounidad'] . ">" . htmlentities($tipounidads [$i] ['ds_tipounidad']) . "</option>";
//}
//$html .= "</select></label></p>";
//
//
//
//
//$html .= "<div id='unidad0'><p class=MsoNormal style='line-height:125%'><span lang=ES-TRAD
//style='font-size:11.0pt;line-height:125%;font-family:Arial;color:windowtext'>Lugar de trabajo nivel 0:<label><select name='cd_unidad0' id='cd_unidad0' class='' style='width: 300px' onchange=\"cargarUnidad('altaintegrante', '1');\">
//							<option value=''>- Seleccione Uno -</option>";
////if ($oUnidad->getCd_tipounidad()){
//	UnidadQuery::getUnidadPorId($oUnidad);
//	$unidads = UnidadQuery::listar ($oUnidad);
//	$rowsize = count ( $unidads );
//
//	for($i = 0; $i < $rowsize; $i ++) {
//
//		$html .= "<option value=" . $unidads [$i] ['cd_unidad'] . ">" . htmlentities($unidads [$i] ['ds_unidad']) . "</option>";
//	}
////}
//$html .= "</select></label></p></div>";
//
//$divhtml = '';
//for ($i=1; $i <= count($htmlarray); $i++){
//		$divhtml .= $htmlarray[$i];
//	}
//$html .= $divhtml;
//
//$html .= "<p class=MsoNormal style='text-align:justify;line-height:125%'><span
//lang=ES-TRAD style='font-size:11.0pt;line-height:125%;font-family:Arial;
//color:windowtext'>Horas dedicadas al proyecto: <input type='text' name='nu_horasinv' id='nu_horasinv' value='".$oIntegrante->getNu_dedinv()."' size='10' maxlength='6' class=''/><div id=\"divHoras\"></div></span></p>";
//
//$html .= "<p class=MsoNormal style='line-height:125%'><span lang=ES-TRAD
//style='font-size:11.0pt;line-height:125%;font-family:Arial;color:windowtext'>Otro Proy.:
//    <select name='ds_codigootro' id='ds_codigootro' onKeyDown='fnKeyDownHandler(this, event);' onKeyUp='fnKeyUpHandler_A(this, event); return false;' onKeyPress = 'return fnKeyPressHandler_A(this, event);'  onChange='fnChangeHandler_A(this, event);cargarTitulos();' >
//							<option value=''>- Seleccione/tipee Uno -</option>";
//$proyectos = ProyectoQuery::listarCodigo ($oDocente->getDs_codigootro());
//$rowsize = count ( $proyectos );
//
//for($i = 0; $i < $rowsize; $i ++) {
//
//	$html .= "<option value=" . htmlentities($proyectos [$i] ['cd_codigo']) . ">" . htmlentities($proyectos [$i] ['ds_codigo']) . "</option>";
//}
//
//$html .= "</select>
//    <span id='titulo'>
//&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Denominaci&oacute;n:
//
//<select name='ds_titulootro' id='ds_titulootro' onKeyDown='fnKeyDownHandler(this, event);' onKeyUp='fnKeyUpHandler_A(this, event); return false;' onKeyPress = 'return fnKeyPressHandler_A(this, event);'  onChange='fnChangeHandler_A(this, event);' style='width: 300px'>
//							<option value=''>- Seleccione/tipee Uno -</option>";
//$proyectos = ProyectoQuery::listarTituloPorCodigo ($oDocente->getDs_codigootro(), $oDocente->getDs_titulootro());
//$rowsize = count ( $proyectos );
//
//for($i = 0; $i < $rowsize; $i ++) {
//
//	$html .= "<option value=" . htmlentities($proyectos [$i] ['cd_titulo']) . ">" . htmlentities($proyectos [$i] ['ds_titulo']) . "</option>";
//}
// $html .= "   </select></span></span></p>";
//$html .= "<p class=MsoNormal style='line-height:125%'><span lang=ES-TRAD
//style='font-size:11.0pt;line-height:125%;font-family:Arial;color:windowtext'>Duraci&oacute;n (inicio-finalizaci&oacute;n) :
//    <input type='text' name='ds_duracionotro' id='ds_duracionotro' value='".htmlentities($oDocente->getDs_duracionotro())."' onchange='mayusculas(this)'/>
//&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;participaci&oacute;n Horas :
//<input type='text' name='nu_horasotro' id='nu_horasotro' value='".$oDocente->getNu_horasotro()."' size='10' maxlength='6' /></span></p>
//$html.=<input type='hidden' name='cd_docente' id='cd_docente' value='".$oDocente->getCd_docente()."' />";

echo $html;

?>