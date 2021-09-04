<?php
//include '../fpdf/fpdf.php';
include '../fpdf/fpdfhtml.php';
include '../includes/include.php';
include '../includes/datosSession.php';
$enviar = (isset($_GET['enviar']))?1:0;
$tipo = $_GET['tipo'];
$funcion = ($enviar)?(($tipo==1)?"Enviar alta":(($tipo==3)?"Enviar cambio":(($tipo==4)?"Enviar cambio Horas":"Enviar baja"))):"Ver proyecto";
if (PermisoQuery::permisosDeUsuario( $cd_usuario, $funcion )) {
	$oPDF_Solicitud = new PDF_Solicitud ( );
	$err=array();
	$item=0;
	//Header Fijo para todos los estados de cuenta
	$year = $_SESSION ["nu_yearSessionP"];
	$mes = $_SESSION ["nu_mesSessionP"];
	$oIntegrante = new Integrante ( );
	$oIntegrante->setCd_docente ( $_GET['cd_docente'] );
	$oIntegrante->setCd_proyecto ( $_GET['cd_proyecto'] );
	IntegranteQuery::getIntegrantePorId($oIntegrante);
	
	$cd_estado = $oIntegrante->getCd_estado();
	$ds_tipoinvestigador = ($oIntegrante->getCd_tipoinvestigador()==6)?'COLABORADOR':'INTEGRANTE';
	/*$oSolicitud = new Solicitud();
	$cd_solicitud = $_GET ['cd_solicitud'];
	$oSolicitud->setCd_solicitud($cd_solicitud);
	SolicitudQuery::getSolicitudPorId ($oSolicitud);*/
	//$dt_alta = ($cd_estado==7)?$oIntegrante->getDt_alta():$oIntegrante->getDt_altapendiente();
	
	if ($enviar){
		switch ($tipo) {
			case 1:
				$cd_estado=2;
			break;
			case 2:
				$cd_estado=5;
			break;
			case 3:
				$cd_estado=7;
			break;
			case 4:
				$cd_estado=9;
			break;
		}
		
	}
	$dt_alta = (($tipo!=3)&&($tipo!=4))?$oIntegrante->getDt_alta():(($tipo==4)?$oIntegrante->getDt_cambioHS():$oIntegrante->getDt_altapendiente());
	
	$oPDF_Solicitud->AddPage();
	$oDocente = new Docente();
	$oDocente->setCd_docente($oIntegrante->getCd_docente());
	DocenteQuery::getDocentePorId($oDocente);
	$oProyecto = new Proyecto();
	$oProyecto->setCd_proyecto($oIntegrante->getCd_proyecto());
	ProyectoQuery::getProyectoPorId($oProyecto);
	$oPDF_Solicitud->facultad($oProyecto->getDs_facultad());
	if ($oProyecto->getNu_duracion()==2){
		$ds_duracion = 'BIENAL';

	}
	if ($oProyecto->getNu_duracion()==4){
		$ds_duracion =  "TETRA ANUAL";

	}
	if (($oProyecto->getNu_duracion()!=2)&&($oProyecto->getNu_duracion()!=4)){
		$nuevaFecha = explode ( "-", $oProyecto->getDt_ini () );
		$yini = $nuevaFecha [0];
		$nuevaFecha = explode ( "-", $oProyecto->getDt_fin () );
		$yfin = $nuevaFecha [0];
		if (($yfin-$yini)==1){
			$ds_duracion = 'BIENAL';
		}
		if (($yfin-$yini)==3){	
			$ds_duracion =  "TETRA ANUAL";
		}
	}
	$oPDF_Solicitud->identificacion($oProyecto->getDs_titulo(),$ds_duracion,$oProyecto->getDs_codigo(),$oProyecto->getDt_ini(),$oProyecto->getDt_fin());
	$oPDF_Solicitud->director($oProyecto->getDs_director());

	switch ($tipo) {
		case 1:
			$ds_tipo = 'ALTA';
		break;
		case 2:
			$ds_tipo = 'BAJA';
		break;
		case 3:
			$ds_tipo = 'CAMBIO';
		break;
		case 4:
			$ds_tipo = 'CAMBIODEDHS';
		break;
		
	}
	$oTitulo = new Titulo();
	$oTitulo->setCd_titulo($oDocente->getCd_titulopost());
	TituloQuery::getTituloPorId($oTitulo);
	$oTipoInvestigador = new Tipoinvestigador();
	$oTipoInvestigador->setCd_tipoinvestigador($oIntegrante->getCd_tipoinvestigador());
	TipoinvestigadorQuery::getTipoinvestigadorPorId($oTipoInvestigador);
	$proyectos = ProyectoQuery::getProyectosDocentes($oDocente->getCd_docente() );
	
	$oPDF_Solicitud->integrante($ds_tipo,$oDocente->getDs_apellido().', '.$oDocente->getDs_nombre(),$oDocente->getNu_precuil().'-'.$oDocente->getNu_documento().'-'.$oDocente->getNu_postcuil(),$oDocente->getDs_categoria(),$oDocente->getDs_titulo(),$oTitulo->getDs_titulo(),$oDocente->getDs_cargo(),$oDocente->getDs_deddoc(),$oDocente->getDs_facultad(),$oDocente->getDs_universidad(),$oDocente->getDs_carrerainv(),$oDocente->getDs_organismo(),$oDocente->getBl_becario(),$oDocente->getDs_tipobeca(),$oDocente->getDs_orgbeca(),$oDocente->getDs_unidad(),$oIntegrante->getNu_horasinv(),$oTipoInvestigador->getDs_tipoinvestigador(),$proyectos,$oProyecto->getDs_codigo(),$oIntegrante->getDt_baja(),$oIntegrante->getDs_consecuencias(),$oIntegrante->getDs_motivos(),$dt_alta,$oDocente->getDt_cargo(),$oDocente->getDt_beca(),$oDocente->getBl_estudiante(),$oDocente->getNu_materias(),$oIntegrante->getNu_horasinvAnt(),$oIntegrante->getDs_reduccionHS(), $minhstotales);
	$oPDF_Solicitud->firma($tipo);
	if ($enviar){
		if (($tipo==2)||($tipo==4)){
			if ($oIntegrante->getCd_tipoinvestigador()!=6){
				$integrantes = IntegranteQuery::getIntegrantes( 'ds_investigador', 'ASC', '', 1, 50, $oProyecto->getCd_proyecto() );
				$countp = count ( $integrantes );
				$nu_horastotal=0;
				$nu_total=0;
				$nu_categorizados=0;
				$nu_mayordedicacion=0;
				for($j = 0; $j < $countp; $j ++) {
					if (($integrantes [$j]['cd_tipoinvestigador']!=6)&&(($integrantes [$j]['dt_baja']>=date('Y-m-d'))||(($integrantes [$j]['dt_baja']==''))||(($integrantes [$j]['dt_baja']=='0000-00-00')))){
						if (($tipo==2)&&($integrantes [$j]['cd_docente']==$oDocente->getCd_docente())) {
							continue;
						}
						$nu_total++;
						$nu_horastotal = $nu_horastotal+$integrantes [$j]['nu_horasinv'];
						if ($tipo==2){
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
							//if ((in_array($oDocente1->getCd_deddoc(),$mayordedicacion))&&($oProyecto->getCd_facultad()==$oDocente1->getCd_facultad())) $nu_mayordedicacion++;	
							if (((in_array($oDocente1->getCd_deddoc(),$mayordedicacion))||(in_array($oDocente1->getCd_carrerainv(), $carrerainvs)) ||($oDocente1->getBl_becario()))&&($oProyecto->getCd_facultad()==$oDocente1->getCd_facultad())) $nu_mayordedicacion++;
						}
					}
					
				}
				if ($tipo==2){
					if ($nu_total<$minintegrantes){
						$err[$item]='Proyecto con menos de '.$minintegrantes.' integrantes';
						$item++;
					}
					/*if ($nu_categorizados<$mincategorizados){
						$err[$item]='Proyecto con menos de '.$mincategorizados.' integrantes categorizados con lugar de trabajo en la U.N.L.P.';
						$item++;
					}*/	
					if ($nu_mayordedicacion<$minmayordedicacion){
						$err[$item]='Proyecto con menos de '.$minmayordedicacion.' integrantes con mayor dedicaci&oacute;n en la Unidad Acad&eacute;mica que se presenta el proyecto';
						$item++;
					}
				}
				
				if ($nu_horastotal<$minhstotales){
					$err[$item]='La suma de dedicaciones horarias de los miembros es menor a '.$minhstotales.' hs. semanales';
					$item++;
				}
				if(($tipo==4)&&($oIntegrante->getNu_horasinv()<$oIntegrante->getNu_horasinvAnt())&&(!$oIntegrante->getDs_reduccionHS())){
					$err[$item]='En el caso de ser una reducción horaria, especificar las consecuencias que la misma tendrá en el desarrollo del proyecto';
					$item++;
				}
			}
		}
	if (($tipo==1)||($tipo==3)){
		if (!$oIntegrante->getDs_curriculum()){
				$err[$item]='Falta el CV del docente';
				$item++;
			}
		if (!$oIntegrante->getDs_actividades()){
				$err[$item]='Falta el Plan de Trabajo del docente';
				$item++;
			}
		if ((!$oIntegrante->getNu_horasinv())&&($oIntegrante->getCd_tipoinvestigador()!=6)){
				$err[$item]='Debe especificar las horas dedicadas al proyecto';
				$item++;
			}
	}
	if(!$item){		
		
		$dir = APP_PATH.'pdfs/'.$_SESSION ["nu_yearSessionP"].'/';
		if (!file_exists($dir)) mkdir($dir, 0777); 
		$dir .= $_SESSION ["nu_mesSessionP"].'/';
		if (!file_exists($dir)) mkdir($dir, 0777); 
		$dir .= $oProyecto->getCd_proyecto().'/';
		if (!file_exists($dir)) mkdir($dir, 0777); 
		$dir .= $oDocente->getNu_documento().'/';
		if (!file_exists($dir)) mkdir($dir, 0777);
		$ds_apellido = stripslashes(str_replace("'","_",$oDocente->getDs_apellido()));
		
		$fileName=$ds_tipo."_".FuncionesComunes::stripAccents($ds_apellido).'_'.$oDocente->getNu_documento().".pdf";
		//$fileName = "SOLICITUD_".$ds_apellido.".pdf";
		$nombreArchivo = $dir . $fileName;
		//el output se hace en el llamador porque depende de quien lo llame
		
		$oPDF_Solicitud->Output ( $nombreArchivo, 'F');
		
		$file = fopen($nombreArchivo, "r");
		$contenidoA = fread($file, filesize($nombreArchivo));
		$encoded_attach = chunk_split(base64_encode($contenidoA));
		fclose($file);
		
		$oIntegrante->setCd_estado($cd_estado);
		/*$oIntegrante->setDt_alta($oIntegrante->getDt_altapendiente());
		$oIntegrante->setDt_altapendiente('');*/
		$exito = IntegranteQuery::modificarIntegrante($oIntegrante);
		if ($exito){
			if (($tipo==1)||($tipo==3))
				$oProyecto->setBl_altapendiente(1);
			elseif ($tipo==2) 
				$oProyecto->setBl_bajapendiente(1);
			$exito = ProyectoQuery::modificarproyecto($oProyecto);
			if ($exito){
				$oFuncion = new Funcion();
				$oFuncion -> setDs_funcion($funcion);
				FuncionQuery::getFuncionPorDs($oFuncion);
				$oMovimiento = new Movimiento();
				$oMovimiento->setCd_funcion($oFuncion->getCd_funcion());
				$oMovimiento->setCd_usuario($cd_usuario);
				$oMovimiento->setDs_movimiento('Proyecto: '.$oProyecto->getDs_codigo().' Docente: '.$oDocente->getNu_precuil().'-'.$oDocente->getNu_documento().'-'.$oDocente->getNu_postcuil());
				MovimientoQuery::insertarMovimiento($oMovimiento);
				$oUsuario = new Usuario();
				$oUsuario->setCd_usuario($cd_usuario);
				UsuarioQuery::getUsuarioPorId($oUsuario);
				$ds_investigador = str_replace(',','',$oProyecto->getDs_director());
				$cabeceras="From: ".$ds_investigador."<".$oUsuario->getDs_mail().">\nReply-To: ".$oUsuario->getDs_mail()."\nReturn-path: ".$oUsuario->getDs_mail()."\n";
	                     
				$cabeceras .="X-Mailer:PHP/".phpversion()."\n";
				$cabeceras .="Mime-Version: 1.0\n";
				$cabeceras .= "Content-type: multipart/mixed; ";
				$cabeceras .= "boundary=\"Message-Boundary\"\n";
				$cabeceras .= "Content-transfer-encoding: 7BIT\n";
				//$cabeceras .= "X-attachments: ".$nombre_archivo;
				
				$body_top = "--Message-Boundary\n";
				$body_top .= "Content-type: text/html; charset=iso-8859-1\n";
				$body_top .= "Content-transfer-encoding: 7BIT\n";
				$body_top .= "Content-description: Mail message body\n\n";
				
				if (file_exists($dir)){
					
			      $adjuntos = '';
			     $handle=opendir($dir);
					while ($archivo = readdir($handle))
					{
				        if ((is_file($dir.$archivo))&&(($tipo==1)&&(!strchr($archivo,'BAJA_'))&&(!strchr($archivo,'CAMBIO_'))&&(!strchr($archivo,'CAMBIODEDHS_'))||($tipo==2)&&(strchr($archivo,'BAJA_'))&&(!strchr($archivo,'CAMBIODEDHS_'))||($tipo==3)&&(!strchr($archivo,'ALTA_'))&&(!strchr($archivo,'BAJA_'))&&(!strchr($archivo,'CAMBIODEDHS_'))||($tipo==4)&&(!strchr($archivo,'ALTA_'))&&(!strchr($archivo,'BAJA_'))&&(!strchr($archivo,'CAMBIO_'))))
				         {
				         	//if (!in_array($archivo,$archivosNoEnv)){
					         	$file = fopen($dir.$archivo, "r");
					         	$contenido = fread($file, filesize($dir.$archivo));
								$encoded_attach = chunk_split(base64_encode($contenido));
								fclose($file);
					         	
								//$cabeceras .= "X-attachments: ".$archivo;
					         	$adjuntos .= "\n\n--Message-Boundary\n";
								$adjuntos .= "Content-type: Binary; name=\"$archivo\"\n";
								$adjuntos .= "Content-Transfer-Encoding: BASE64\n";
								$adjuntos .= "Content-disposition: attachment; filename=\"$archivo\"\n\n";
								$adjuntos .= "$encoded_attach\n";
				         	}
							//$adjuntos .= "--Message-Boundary--\n"; 
				        // }
					}
				}
				
				closedir($handle);
				$integranteMail = ($oIntegrante->getCd_tipoinvestigador()==6)?'Colaborador':'Integrante';
				if ($tipo == 3) {
					$integranteMail = 'Colaborador';
				}
				
				switch ($tipo) {
					case 1:
						$fecha = $oIntegrante->getDt_alta();
					break;
					case 2:
						$fecha = $oIntegrante->getDt_baja();
					break;
					case 3:
						$fecha = $oIntegrante->getDt_altapendiente();
					break;
					case 4:
						$fecha = $oIntegrante->getDt_cambioHS();
					break;
					
				}
				$asunto = ($tipo==4)?'Cambio de dedicación horaria':$ds_tipo." de ".$integranteMail;
				$tipo = ($tipo==4)?'Cambio de dedicación horaria':$ds_tipo;
				$shtml = $body_top."<html><body><div style='padding-left: 30px; padding-right: 30px; padding-top: 30px ; padding-bottom: 30px; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; color: #666666; background-color:#FFFFFF'><img src=\"".WEB_PATH."img/image002.gif\" alt=\"Logo\" longdesc=\"Logo\"><br>PROYECTOS DE INVESTIGACION<hr style= 'color: #999999; text-decoration: none;'><p><strong>".$asunto."<br>Proyecto</strong>: ".$oProyecto->getDs_codigo()."<br><strong>".$integranteMail."</strong>: ".$oDocente->getDs_apellido().", ".$oDocente->getDs_nombre()." (".$oDocente->getNu_precuil().'-'.$oDocente->getNu_documento().'-'.$oDocente->getNu_postcuil().")<br><strong>F. de ".$tipo."</strong>: ".FuncionesComunes::fechaMysqlaPHP($fecha)."</p><hr style= 'color: #999999; text-decoration: none;'></body></html>";
				$shtml .= $adjuntos;
				
				mail($mailReceptor,"Solicitud de ".$asunto,$shtml,$cabeceras);
								
			
				$cabeceras="From: ".$nameFrom."<".$mailFrom.">\nReply-To: ".$mailFrom."\n";
	                        
				$cabeceras .="X-Mailer:PHP/".phpversion()."\n";
				$cabeceras .="Mime-Version: 1.0\n";
				$cabeceras .= "Content-type: multipart/mixed; ";
				$cabeceras .= "boundary=\"Message-Boundary\"\n";
				$cabeceras .= "Content-transfer-encoding: 7BIT\n";
				//if ($oSolicitud->getDs_mail()!=$oUsuario->getDs_mail())	$cabeceras .="BCC: ".$oUsuario->getDs_mail()."\n";
				$shtml = $body_top."<html><body><div style='padding-left: 30px; padding-right: 30px; padding-top: 30px ; padding-bottom: 30px; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; color: #666666; background-color:#FFFFFF'><img src=\"".WEB_PATH."img/image002.gif\" alt=\"Logo\" longdesc=\"Logo\"><br>PROYECTOS DE INVESTIGACION<hr style= 'color: #999999; text-decoration: none;'><p><strong>Alta de integrante<br>Proyecto</strong>: ".$oProyecto->getDs_codigo()."<br><strong>".$integranteMail."</strong>: ".$oDocente->getDs_apellido().", ".$oDocente->getDs_nombre()." (".$oDocente->getNu_precuil().'-'.$oDocente->getNu_documento().'-'.$oDocente->getNu_postcuil().")<br><strong>F. de ".$ds_tipo."</strong>: ".FuncionesComunes::fechaMysqlaPHP($fecha)."<br>Recibirá la confirmación o el rechazo en esta dirección de correo electrónico con previa presentación de la Planilla de Solicitud debidamente firmada en la Secretaría de Ciencia y Técnica de su Unidad Académica</p><hr style= 'color: #999999; text-decoration: none;'></body></html>";
				$shtml .= $adjuntos;
				if (!$test) {
					mail($oUsuario->getDs_mail(),"Solicitud de ".$asunto,$shtml,$cabeceras);
				}
				
				$err[$item]='Se envió la solicitud, imprímala desde el ícono PDF y preséntala en su U. Académica';
				header ( 'Location:index.php?err='.FuncionesComunes::array_envia($err) );
				header ( 'Location:verproyecto.php?err='.FuncionesComunes::array_envia($err).'&id='.$oIntegrante->getCd_proyecto() );
			}
			else header ( 'Location:verproyecto.php?err='.FuncionesComunes::array_envia($err).'&id='.$oIntegrante->getCd_proyecto() );
		}
		else 
			header ( 'Location:verproyecto.php?er=2&id='.$oIntegrante->getCd_proyecto() );
		}
		else 
			header ( 'Location:verproyecto.php?err='.FuncionesComunes::array_envia($err).'&id='.$oIntegrante->getCd_proyecto() );
	}
	
	else
		$oPDF_Solicitud->Output();
} else
	header ( 'Location:../includes/finsolicitud.php' );

?>