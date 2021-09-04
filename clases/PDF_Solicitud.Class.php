<?php

class PDF_Solicitud extends fpdfhtmlHelper {
	
	function Header() {
		global $year;
		global $mes;
		global $cd_estado;
		global $tipo;
		global $ds_tipoinvestigador;
		
		$this->SetTextColor(100, 100, 100);
		/*$this->SetDrawColor(1,1,1);
		$this->SetLineWidth(.1);*/
		$this->SetFont('Arial','B',36);
		if (($cd_estado==1)||($cd_estado==4) ||($cd_estado==6)||($cd_estado==8)){
			$this->RotatedText(10, $this->h - 10, 'Vista preliminar    Vista preliminar    Vista preliminar', 60);
		}
			
		
		$this->SetY(13);
		
		$this->SetTextColor(0, 0, 0);
		$this->ln(15);
			$this->Image('../img/image002.gif',10,5,185,15);
		
		//$this->SetY(2);
		/*if (($cd_estado==1)||($cd_estado==4) ||($cd_estado==6)){
			$this->SetFont ( 'Arial', '', 10 );
			
		
		$this->SetY(0);
			$this->Cell ( 185, 10, "Vista preliminar - Vista preliminar - Vista preliminar - Vista preliminar - Vista preliminar - Vista preliminar - Vista preliminar", '',0,'L');
			
	
			$this->ln(25);
			$this->Image('../img/image002.gif',10,7,185,15);
			
		}
		else{
			$this->ln(15);
			$this->Image('../img/image002.gif',10,5,185,15);
		}*/
		
		$this->SetFont ( 'Arial', 'B', 13 );
		
		
		$webtitulo='WEB GESTION DE PROYECTOS ';
		switch ($tipo) {
			case 1:
				$ds_titulo='ALTA DE '.$ds_tipoinvestigador.' - A';
			break;
			case 2:
				$ds_titulo='BAJA DE '.$ds_tipoinvestigador.' - B';
			break;
			case 3:
				$ds_titulo='CAMBIO COLABORADOR - C';
			break;
			case 4:
				$ds_titulo='CAMBIO EN LA DED. HORARIA - D';
			break;
			
		}
		$this->SetFillColor(0,0,0);
		$this->SetTextColor(255,255,255);
		$this->Cell ( 100, 6, $ds_titulo, '',0,'L',1);
		$this->Cell ( 85, 6, '0'.$mes.'/'.$year.' '.$webtitulo, '',0,'R',1);
		
		$this->SetTextColor(0,0,0);
		$this->SetFillColor(255,255,255);
		$this->ln(8);
	}
	
	function Footer() {
		global $cd_estado;
		if (($cd_estado==1)||($cd_estado==4) ||($cd_estado==6)){
			$this->SetFont ( 'Arial', '', 10 );
			$this->SetY(-15);
		//	$this->Cell ( 15, 10, "", '',0,'L');
			//$this->Cell ( 185, 10, "Vista preliminar - Vista preliminar - Vista preliminar - Vista preliminar - Vista preliminar - Vista preliminar - Vista preliminar", '',0,'L');
		}
	}
	

	
	function facultad($ds_facultad) {
		$this->SetFillColor(255,255,255);
		$this->SetFont ( 'Arial', 'B', 10 );
		$this->Cell ( 40, 6, "UNIDAD ACADEMICA");
		$this->SetFont ( 'Arial', '', 10 );
		$this->Cell ( 145, 6, stripslashes($ds_facultad), 'LTBR',0,'L',1);
		
		$this->ln(8);
		
	}
	
	function identificacion($ds_titulo, $ds_duracion, $ds_codigo, $dt_ini, $dt_fin) {
		$this->SetFillColor(200,200,200);
		$this->SetFont ( 'Arial', 'B', 10 );
		$this->Cell ( 185, 6, "IDENTIFICACION DEL PROYECTO",0,0,'',1);
		$this->ln(8);
		$this->SetFillColor(255,255,255);
		$this->Cell ( 20, 6, "CODIGO:");
		$this->SetFont ( 'Arial', '', 10 );
		$this->Cell ( 20, 6, stripslashes($ds_codigo), 'LTBR',0,'L',1);
		$this->Cell ( 30, 6, "");
		$this->SetFont ( 'Arial', 'B', 10 );
		$this->Cell ( 25, 6, "DURACION:");
		$this->SetFont ( 'Arial', '', 10 );
		$this->Cell ( 90, 6, stripslashes($ds_duracion), 'LTBR',0,'L',1);
		$this->SetFont ( 'Arial', 'B', 10 );
		$this->ln(8);
		$this->Cell ( 60, 6, "DENOMINACION DEL PROYECTO:");
		$this->SetFont ( 'Arial', '', 10 );
		$this->MultiCell ( 125, 4, stripslashes($ds_titulo), 'LTBR','L',1);
		$this->ln(3);
		$this->SetFont ( 'Arial', 'B', 10 );
		$this->Cell ( 35, 6, "FECHA DE INICIO:");
		$this->SetFont ( 'Arial', '', 10 );
		$this->Cell ( 30, 6, FuncionesComunes::fechaMysqlaPHP($dt_ini), 'LTBR',0,'L',1);
		$this->Cell ( 30, 6, "");
		$this->SetFont ( 'Arial', 'B', 10 );
		$this->Cell ( 35, 6, "FECHA DE FIN:");
		$this->SetFont ( 'Arial', '', 10 );
		$this->Cell ( 30, 6, FuncionesComunes::fechaMysqlaPHP($dt_fin), 'LTBR',0,'L',1);
		
		$this->ln(8);
	}
	
	function director($ds_director) {
		$this->SetFillColor(200,200,200);
		$this->SetFont ( 'Arial', 'B', 10 );
		$this->Cell ( 185, 6, "DIRECTOR",0,0,'',1);
		$this->ln(8);
		$this->SetFillColor(255,255,255);
		$this->Cell ( 40, 6, "Apellido y Nombres:");
		$this->SetFont ( 'Arial', '', 10 );
		$this->Cell ( 145, 6, stripslashes($ds_director), 'LTBR',0,'L',1);	
		$this->ln(8);
	}
	
	function integrante($ds_tipo, $ds_investigador, $nu_cuil, $ds_categoria, $ds_titulogrado, $ds_tituloposgrado, $ds_cargo, $ds_deddoc, $ds_facultad, $ds_universidad, $ds_carrinv, $ds_organismo, $bl_becario, $ds_tipobeca, $ds_orgbeca, $ds_unidad, $nu_horasinv, $ds_tipoinvestigador,$proyectos,$ds_codigo, $dt_baja,$ds_consecuencias,$ds_motivos, $dt_alta,$dt_cargo, $dt_beca, $bl_estudiante, $nu_materias, $nu_horasinvAnt, $ds_reduccionHS, $minhstotales) {
		$ds_tipoSTR = ($ds_tipo=='CAMBIODEDHS')?'CAMBIO EN LA DED. HORARIA':$ds_tipo;
		$this->SetFillColor(200,200,200);
		$this->SetFont ( 'Arial', 'B', 10 );
		$this->Cell ( 185, 6, $ds_tipoSTR." - IDENTIFICACION DEL INTEGRANTE",0,0,'',1);
		$this->ln(8);
		$this->SetFillColor(255,255,255);
		$this->Cell ( 40, 6, "Apellido y Nombres:");
		$this->SetFont ( 'Arial', '', 10 );
		$this->Cell ( 145, 6, stripslashes($ds_investigador), 'LTBR',0,'L',1);	
		$this->ln(8);
		$this->SetFont ( 'Arial', 'B', 10 );
		$this->Cell ( 20, 6, "C.U.I.L.:");
		$this->SetFont ( 'Arial', '', 10 );
		$this->Cell ( 30, 6, stripslashes($nu_cuil), 'LTBR',0,'L',1);	
		$this->Cell ( 30, 6, "");
		$this->SetFont ( 'Arial', 'B', 10 );
		$this->Cell ( 65, 6, "Categoría de Docente Investigador:");
		$this->SetFont ( 'Arial', '', 10 );
		$this->Cell ( 40, 6, stripslashes($ds_categoria), 'LTBR',0,'L',1);	
		if (($ds_tipo == 'ALTA')||($ds_tipo == 'CAMBIO')){
			$this->ln(8);
			$this->SetFont ( 'Arial', 'B', 10 );
			if ($ds_titulogrado=='') {
				
				$this->Cell ( 30, 6, "Estudiante:");
				$this->SetFont ( 'Arial', '', 10 );
				$ds_becario = ($bl_estudiante)?'SI':'NO';
				$this->Cell ( 10, 6, stripslashes($ds_becario), 'LTBR',0,'L',1);
				$this->Cell ( 40, 6, '', 'L',0,'L',1);
				$this->SetFont ( 'Arial', 'B', 10 );
				$this->Cell ( 40, 6, "Materias Adeudadas:");
				$this->SetFont ( 'Arial', '', 10 );
				$this->Cell ( 20, 6, stripslashes($nu_materias), 'LTBR',0,'L',1);
				$this->ln(8);
			}
			else{
				
				$this->Cell ( 40, 6, "Título de Grado:");
				$this->SetFont ( 'Arial', '', 10 );
				$this->MultiCell( 145, 4, stripslashes($ds_titulogrado), 'LTBR','L');	
				$this->ln(3);
				$this->SetFont ( 'Arial', 'B', 10 );
				$this->Cell ( 40, 6, "Título de posgrado:");
				$this->SetFont ( 'Arial', '', 10 );
				$this->MultiCell( 145, 4, stripslashes($ds_tituloposgrado), 'LTBR','L');	
				$this->ln(3);
			}
		}
		else 
			$this->ln(8);
		$this->SetFont ( 'Arial', 'B', 10 );
		$this->Cell ( 40, 6, "Cargo docente:");
		$this->SetFont ( 'Arial', '', 10 );
		$this->Cell ( 80, 6, stripslashes($ds_cargo), 'LTBR',0,'L',1);	
		$this->Cell ( 20, 6, "");
		$this->SetFont ( 'Arial', 'B', 10 );
		$this->Cell ( 25, 6, "Dedicación:");
		$this->SetFont ( 'Arial', '', 10 );
		$this->Cell ( 20, 6, stripslashes($ds_deddoc), 'LTBR',0,'L',1);	
		$this->ln(8);
		$this->SetFont ( 'Arial', 'B', 10 );
		$this->Cell ( 40, 6, "Carrera del Inv.:");
		$this->SetFont ( 'Arial', '', 10 );
		$this->Cell ( 60, 6, stripslashes($ds_carrinv), 'LTBR',0,'L',1);
		
		$this->SetFont ( 'Arial', 'B', 10 );
		$this->Cell ( 22, 6, "Organismo:");
		$this->SetFont ( 'Arial', '', 10 );
		$this->Cell ( 63, 6, stripslashes($ds_organismo), 'LTBR',0,'L',1);	
		
		$this->ln(8);
		$this->SetFont ( 'Arial', 'B', 10 );
		$this->Cell ( 20, 6, "Becario:");
		$this->SetFont ( 'Arial', '', 10 );
		$ds_becario = ($bl_becario)?'SI':'NO';
		$this->Cell ( 10, 6, stripslashes($ds_becario), 'LTBR',0,'L',1);
		$this->SetFont ( 'Arial', 'B', 10 );
		$this->Cell ( 10, 6, "Tipo:");
		$this->SetFont ( 'Arial', '', 10 );
		$this->Cell ( 60, 6, stripslashes($ds_tipobeca), 'LTBR',0,'L',1);
		
		$this->SetFont ( 'Arial', 'B', 10 );
		$this->Cell ( 22, 6, "Institución:");
		$this->SetFont ( 'Arial', '', 10 );
		$this->Cell ( 63, 6, stripslashes($ds_orgbeca), 'LTBR',0,'L',1);
		if (($ds_tipo == 'CAMBIO')||($ds_tipo == 'CAMBIODEDHS')) {
			$this->ln(8);
			$this->SetFont ( 'Arial', 'B', 10 );
			$this->Cell ( 80, 6, "Fecha Obtención Cargo:");
			$this->SetFont ( 'Arial', '', 10 );
			$dt=(FuncionesComunes::fechaMysqlaPHP($dt_cargo)!='00/00/0000')?FuncionesComunes::fechaMysqlaPHP($dt_cargo):'';
			$this->Cell ( 20, 6, $dt, 'LTBR',0,'L',1);
			//$this->Cell ( 40, 6, "");
			$this->SetFont ( 'Arial', 'B', 10 );
			$this->Cell ( 65, 6, "Fecha Obtención Beca:");
			$this->SetFont ( 'Arial', '', 10 );
			$dt=(FuncionesComunes::fechaMysqlaPHP($dt_beca)!='00/00/0000')?FuncionesComunes::fechaMysqlaPHP($dt_beca):'';
			$this->Cell ( 20, 6, $dt, 'LTBR',0,'L',1);
			
			
		}
		elseif ($ds_tipo == 'ALTA') {
			$this->ln(8);
			$this->SetFont ( 'Arial', 'B', 10 );
			$this->Cell ( 80, 6, "Fecha Obtención Beca:");
			$this->SetFont ( 'Arial', '', 10 );
			$dt=(FuncionesComunes::fechaMysqlaPHP($dt_beca)!='00/00/0000')?FuncionesComunes::fechaMysqlaPHP($dt_beca):'';
			$this->Cell ( 20, 6, $dt, 'LTBR',0,'L',1);
			
		}
		$this->ln(8);
		if (($ds_tipo == 'ALTA')||($ds_tipo == 'CAMBIO')){
			$this->SetFont ( 'Arial', 'B', 10 );
			$this->Cell ( 40, 6, "Lugar de trabajo:");
			$this->SetFont ( 'Arial', '', 10 );
			$this->MultiCell( 145, 4, stripslashes($ds_unidad), 'LTBR','L');	
		}
		
		$this->ln(3);
		if (($ds_tipo == 'ALTA')||($ds_tipo == 'CAMBIO')||($ds_tipo == 'CAMBIODEDHS')){
			
			if ($ds_tipo != 'CAMBIODEDHS') {
				$this->SetFont ( 'Arial', 'B', 12 );
				$this->Cell ( 40, 6, "FECHA DE ALTA:");
				$this->SetFont ( 'Arial', '', 12 );
				$this->Cell ( 40, 6, FuncionesComunes::fechaMysqlaPHP($dt_alta), 'LTBR',0,'L',1);	
			}
			else{
				$this->SetFont ( 'Arial', 'B', 10 );
				$this->Cell ( 40, 6, "FECHA DEL CAMBIO:");
				$this->SetFont ( 'Arial', '', 12 );
				$this->Cell ( 40, 6, FuncionesComunes::fechaMysqlaPHP($dt_alta), 'LTBR',0,'L',1);	
			} 
			
			$this->SetFont ( 'Arial', 'B', 10 );
			$this->Cell ( 24, 6, "Universidad:");
			$this->SetFont ( 'Arial', '', 10 );
			$this->Cell ( 81, 6, stripslashes($ds_universidad), 'LTBR',0,'L',1);	
			$this->ln(8);
			$this->SetFont ( 'Arial', 'B', 10 );
			if ($ds_tipo != 'CAMBIODEDHS') {
				$this->Cell ( 52, 6, "Horas dedicadas al proyecto:");
				$this->SetFont ( 'Arial', '', 10 );
				$this->Cell ( 10, 6, stripslashes($nu_horasinv), 'LTBR',0,'L',1);	
			}
			else {
				$this->Cell ( 52, 6, "Hs. dedicadas actualmente:");
				$this->SetFont ( 'Arial', '', 10 );
				$this->Cell ( 10, 6, stripslashes($nu_horasinvAnt), 'LTBR',0,'L',1);	
			}
			$this->Cell ( 20, 6, "");
			$this->SetFont ( 'Arial', 'B', 10 );
			if ($ds_tipo != 'CAMBIODEDHS') {
				$this->Cell ( 40, 6, "Tipo de Investigador:");
				$this->SetFont ( 'Arial', '', 10 );
				$this->Cell ( 63, 6, stripslashes($ds_tipoinvestigador), 'LTBR',0,'L',1);	
			}
			else {
				$this->Cell ( 40, 6, "Hs. solicitadas:");
				$this->SetFont ( 'Arial', '', 10 );
				$this->Cell ( 10, 6, stripslashes($nu_horasinv), 'LTBR',0,'L',1);	
			}
			$this->ln(8);
			$this->SetFillColor(200,200,200);
			$this->SetFont ( 'Arial', 'B', 10 );
			$this->Cell ( 185, 6, "OTRO PROYECTO EN EL QUE PARTICIPA",0,0,'',1);
			$this->SetFillColor(255,255,255);
			$this->ln(8);
			$this->SetFont ( 'Arial', 'B', 8 );
			$this->SetWidths(array(15, 75, 40, 20, 25, 10));
			$this->SetAligns(array('C', 'C','C','C','C','C'));
			$this->row(array('Código','Título','Director','Tipo','Período','Hs. x Sem.'));
			$this->SetFont ( 'Arial', '', 8 );
			$this->SetAligns(array('L', 'L','L','L','L','C'));
			$count = count ( $proyectos );
			for($i = 0; $i < $count; $i ++) {
				if ($proyectos[$i]['ds_codigo']!=$ds_codigo){
					$this->row(array($proyectos[$i]['ds_codigo'],$proyectos[$i]['ds_titulo'],$proyectos[$i]['ds_director'],$proyectos[$i]['ds_tipoinvestigador'],FuncionesComunes::fechaMysqlaPHP($proyectos [$i]['dt_ini']).' - '.FuncionesComunes::fechaMysqlaPHP($proyectos [$i]['dt_fin']),$proyectos[$i]['nu_horasinv']));
				}
			}
			if ($ds_tipo == 'CAMBIODEDHS') {
				if ($ds_reduccionHS) {
					$this->SetFillColor(255,255,255);
					$this->ln(8);
					$this->SetFont ( 'Arial', 'B', 10 );
					$this->MultiCell( 185, 4, 'En el caso de ser una reducción horaria, especificar las consecuencias que la misma tendrá en el desarrollo del proyecto', '','L');
					$this->ln(3);
					$this->SetFont ( 'Arial', '', 8 );
					$this->MultiCell( 185, 4, stripslashes($ds_reduccionHS), 'LTBR','L');	
					$this->ln(3);
					$this->SetFont ( 'Arial', 'B', 10 );
					$this->MultiCell( 185, 4, 'Considerando la reducción, el proyecto cumple con las pautas fijadas en la Acreditación: La suma de dedicaciones horarias de los miembros del proyecto es igual o mayor a '.$minhstotales.' hs. semanales', 'LTBR','L');	
					
				}
				
				
			}
		}
		else{
			//$this->ln(8);
			$this->SetFont ( 'Arial', 'B', 12 );
			$this->Cell ( 40, 6, "FECHA DE BAJA:");
			$this->SetFont ( 'Arial', '', 12 );
			$this->Cell ( 40, 6, FuncionesComunes::fechaMysqlaPHP($dt_baja), 'LTBR',0,'L',1);	
			$this->SetFont ( 'Arial', 'B', 10 );
			/*$this->Cell ( 24, 6, "Universidad:");
			$this->SetFont ( 'Arial', '', 10 );
			$this->Cell ( 81, 6, stripslashes($ds_universidad), 'LTBR',0,'L',1);*/
			$this->ln(8);
			$this->SetFillColor(200,200,200);
			$this->SetFont ( 'Arial', 'B', 10 );
			$this->Cell ( 185, 6, "EN CASO DE OTORGARSE LA BAJA SOLICITADA",0,0,'',1);
			$this->SetFillColor(255,255,255);
			$this->ln(8);
			$this->MultiCell( 185, 4, 'IMPORTANTE: con respecto a las solicitudes de bajas se debe tener en cuenta que, a los efectos del cobro de incentivos, el Ministerio no permite que los docentes investigadores cambien de proyecto. Cada docente investigador es asociado a un proyecto hasta su finalización y no puede solicitar incentivos por otro proyecto.','','L'); 
			$this->ln(2);
			$this->Cell ( 185, 6, "Explicar las consecuencias de la baja en el desenvolvimiento del proyecto",0,0,'',1);
			$this->ln(8);
			$this->SetFont ( 'Arial', '', 8 );
			$this->MultiCell( 185, 4, stripslashes($ds_consecuencias), 'LTBR','L');	
			$this->ln(3);
			if ($ds_motivos) {
				$this->SetFont ( 'Arial', 'B', 10 );
				$this->SetFillColor(255,255,255);
				$this->Cell ( 185, 6, "Explicar los motivos de la baja",0,0,'',1);
				$this->ln(8);
				$this->SetFont ( 'Arial', '', 8 );
				$this->MultiCell( 185, 4, stripslashes($ds_motivos), 'LTBR','L');	
				$this->ln(3);
			}
			$this->SetFont ( 'Arial', 'B', 10 );
			$this->Cell ( 185, 6, "Considerando la baja, el proyecto cumple con los siguientes requisitos:",0,0,'',1);
			$this->ln(8);
			$this->SetFont ( 'Arial', '', 8 );
			$this->MultiCell( 185, 4, 'La suma de dedicaciones horarias de los miembros del proyecto es igual o mayor a 30 hs. semanales.', 'LTBR','L');	
			//$this->ln(3);
			$this->MultiCell( 185, 4, 'Se cumple con las pautas fijadas en la Acreditación', 'LTBR','L');	
			$this->ln(3);
		}	
		$this->ln(8);
		$this->SetFont ( 'Arial', 'B', 10 );
	}
	
	
	
	
	function firma($tipo) {
		$this->SetFillColor(200,200,200);
		$this->SetFont ( 'Arial', 'B', 10 );
		$this->Cell ( 185, 6, "CONSENTIMIENTO DEL INTERESADO",0,0,'',1);
		$this->SetFillColor(255,255,255);
		$this->ln(8);
		$ds_baja=($tipo)?'':'a la presente baja';
		$this->Cell ( 185, 6, "Dejo constancia que otorgo mi conformidad ".$ds_baja,0,0,'',1);
		$this->SetFont ( 'Arial', '', 10 );
		$this->ln(10);
		$this->Cell ( 10, 8);
		$this->Cell ( 60, 8, '', 'B');
		$this->Cell ( 30, 8);
		$this->Cell ( 60, 8, '', 'B');
		$this->ln(8);
		$this->Cell ( 10, 8);
		$this->Cell ( 60, 8, 'Lugar y Fecha', '', 0, 'C');
		$this->Cell ( 30, 8);
		$this->Cell ( 60, 8, 'Firma y Aclaración', '', 0, 'C');
		$this->ln(1);
		$this->Cell ( 185, 8, '', 'B');
		$this->ln(10);
		$this->Cell ( 10, 8);
		$this->Cell ( 60, 8, '', 'B');
		$this->Cell ( 30, 8);
		$this->Cell ( 60, 8, '', 'B');
		$this->ln(8);
		$this->Cell ( 10, 8);
		$this->Cell ( 60, 8, 'Lugar y Fecha', '', 0, 'C');
		$this->Cell ( 30, 8);
		$this->Cell ( 60, 8, 'Firma del Director del Proyecto', '', 0, 'C');
		$this->ln(1);
		$this->Cell ( 185, 8, '', 'B');
		$this->ln(10);
		$this->SetFont ( 'Arial', 'B', 10 );
		$this->Cell ( 185, 6, "La información detallada en esta solicitud  tiene carácter de DECLARACION JURADA.",0,0,'',1);
		
	}
	
	
	
	
	
}
?>