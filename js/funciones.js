/*Las funciones dentro del script est?n ordenadas alfab?ticamente*/
/********************  A  **************************/

Array.prototype.in_array=function(){
    for(var j in this){
        if(this[j]==arguments[0]){
            return true;
        }
    }
    return false;    
} 

function activar(elem, elemOp)
	{
		// Obtengo la opcion que el usuario selecciono
		var oChk = document.getElementById(elem);
		var activar = (oChk.checked)?1:0;
		var ajax=nuevoAjax();
		t = new Date();
		
		ajax.open("GET", "../includes/select_dependientes_proceso.php?random="+t.getTime()+"&select=activarUsuario&activar="+activar+"&elem="+oChk.value+"&elemOp="+elemOp, true);
		ajax.onreadystatechange=function() 
		{ 
			
			if (ajax.readyState==4)
			{
				//alert(ajax.responseText);
				if(ajax.responseText!=''){
					oChk.checked=true;
					window.parent.mensajeError(ajax.responseText);
				}
			} 
		}
		ajax.send(null);
		
	}

/********************  B  **************************/

/********************  C  **************************/

function cargarUnidad(formname, nivel, proyecto){
	var i=parseInt(nivel)+1;
	var ok=1;
	while (ok==1)
	{
		var unidad = document.getElementById('unidad'+i);
		
		if (unidad != null)
		{
			unidad.innerHTML = '';
		}
		else ok=0;
		i++;
	}
	var miAjax = new Ajax('Ajax_cargarUnidades.php?nivel='+nivel+'&formname='+formname+'&proyecto='+proyecto,
	{
		method: 'get',
		data:$(formname),
		update:'unidad'+nivel,
		onComplete: function()
		{
			if (nivel == 0)
			{
				$('cd_unidad0').className="fValidate['required']";
				exValidatorA.initialize(formname, exValidatorA.options);
			}
			
		}
	});
	miAjax.request();
	if(proyecto){
		var miAjax1 = new Ajax('Ajax_cargarDirecciones.php?nivel='+nivel+'&formname='+formname,
		{
			method: 'get',
			data:$(formname),
			update:'direccion',
			onComplete: function()
			{
				if($('ds_mail')!=null){
					$('ds_mail').className="fValidate['email']";
					exValidatorA.initialize(formname, exValidatorA.options);
				}
				
			}
		});
		miAjax1.request();
	}

}

function confirmaElim(nom,a, href){
	var preg=confirm("¿Confirma que desea eliminar "+nom+"?");
	if (preg==true)
		a.href=href;
	else
		return false;
	return true;
}

function confirmaAnular(nom,a, href){
	var preg=confirm("¿Confirma que desea anular la baja de "+nom+"?");
	if (preg==true)
		a.href=href;
	else
		return false;
	return true;
}

function confirmaCambioHS(nom,a, href){
	var preg=confirm("¿Confirma que desea anular el cambio de horas de "+nom+"?");
	if (preg==true)
		a.href=href;
	else
		return false;
	return true;
}

function confirmaCambio(nom,a, href){
	var preg=confirm("¿Confirma que desea anular el cambio de colaborador de "+nom+"?");
	if (preg==true)
		a.href=href;
	else
		return false;
	return true;
}

function confirmaConfir(a, href){
	var preg=confirm("¿Está seguro de aceptar?");
	if (preg==true)
		a.href=href;
	else
		return false;
	return true;
}

function confirmaEnviar(a, href){
	var preg=confirm("Luego de enviar la solicitud no podrá realizar modificaciones ¿Confirma?");
	if (preg==true)
		a.href=href;
	else
		return false;
	return true;
}

function copiarRadio(radio){
	var radioTXT = document.getElementById(radio);
	radioTXT.value = 1;
	
}	

function consultarSalida(){
	/*var preg=confirm("Perder? los cambios de esta pantalla ?Continuar?");
	if (preg==true)
		location.href='altaproyecto5-action.php';
	else
		return false;
	return true;*/
	location.href='index.php';
}
/********************  D  **************************/

function formatDec(valor, decimales) {
	var parts = String(valor).split(".");
	parts[1] = String(parts[1]).substring(0, decimales);
	// parts[1] = Number(parts[1]) * Math.pow(10, -(decimales - 1)); //POTENCIA
	// parts[1] = String(Math.floor(parts[1])); //REDODEA HACIA ABAJO
	return parseFloat(parts.join("."));
}
/*function deshabilitarInput(id){
	inp = document.getElementById('nu_matricula');
	check = document.getElementById('todos').checked;
	if(check == true)
	{
		inp.disabled = false;
		inp.className = "fValidate['required']";
		inp.value = "";
	}
	else
	{
		inp.disabled = true;
		inp.className = "";
		inp.style['border-color'] = "FFFFFF";
		inp.style['background-color'] = "FFFFFF";
		inp.value = "";
		//borro el p que contiene el nro de matricula
		$('ds_apynom').innerHTML = "";
	
		//Borro el div con el msj del validador
		if($('nu_matricularequired_msg')!= null)
		{
			div = $('nu_matricularequired_msg');
			div.innerHTML = "";
		}
	}
	
}*/


/********************  G  **************************/
function getHTTPObject() {
    var xmlhttp;
    /*@cc_on
    @if (@_jscript_version >= 5)
       try {
          xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
       } catch (e) {
          try {
             xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
          } catch (E) { xmlhttp = false; }
       }
    @else
    xmlhttp = false;
    @end @*/
    if (!xmlhttp && typeof XMLHttpRequest != 'undefined') {
       try {
          xmlhttp = new XMLHttpRequest();
       } catch (e) { xmlhttp = false; }
    }
    return xmlhttp;
}

var enProceso = false; // lo usamos para ver si hay un proceso activo
var http = getHTTPObject(); // Creamos el objeto XMLHttpRequest

function abrirVentanita(pagina){
	derecha=(screen.width-500)/2;
	arriba=(screen.height-500)/2;
	stringComun="toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=0,width=500,height=350, left="+derecha+", top="+arriba+"";
	mw = window.open(pagina, '', stringComun);
	
}



/********************  H  **************************/
function handleHttpResponse() {
	
	if (http.readyState == 4) {
       if (http.status == 200) {
          if (http.responseText.indexOf('invalid') == -1) {
             // Armamos un array, usando la coma para separar elementos
             results = http.responseText.split(";");
			//alert(results[0]);	
			 
			 switch(results[0])
				{
				case "1": 
					 if (results[1]!='')
					 {
						 
						 document.getElementById('contenido').innerHTML =results[1];
					 }
			 
				break;
				case "2": 
					 if (results[7]!='')
					 {	
						
						document.getElementById('navi').innerHTML='';
						document.getElementById('navi').className='capa_fotocentro'+results[7];
						div='';
						for (i = 0; i < results[7]; i++)
						{
							div =div+'<div class="capa_fotito"><div id=DivFoto'+i+'></div></div>';
							
						}
							
						document.getElementById('navi').innerHTML=div;
						
						
						autom="'"+results[5]+"'";
						document.getElementById('img1').innerHTML='';
						if (results[7]!='')
						{
							document.getElementById('img1').innerHTML='<a href="#" onClick="abrirVentanita(\'admin/imagenespublicaciones/imagenes/'+results[8]+'\')"><IMG SRC="admin/imagenespublicaciones/imagenes/'+results[8]+'" WIDTH=200 HEIGHT=200 ALT="" ></a>'
						}
						
						for (i = 0; i < results[7]; i++)
						{
							foto="'"+results[i+8]+"'";
							
							
							
							
							img='<img class="center" src="admin/imagenespublicaciones/thumbnail/'+results[i+8]+'" width="40" height="30" alt="" >';
							document.getElementById('DivFoto'+i).innerHTML ='<a href="cambiar" onClick="cambiarImg('+foto+');return false;">'+img+'</a>';
						}
						id="'"+results[1]+"'";
						ant="'"+results[2]+"'";
						sig="'"+results[3]+"'";
						
						pag = parseInt(results[4]) ;
						var ultimo=0;
						 ultimo=(pag-1)*5;
						ultimo="'"+ultimo+"'";
						document.getElementById('siguiente').innerHTML='<a href="cambiar" onClick="paginar('+id+', '+sig+', '+autom+');return false;"><img class="sinBorde" src="imagenes/irsiguiente.jpg" width="18" height="18" alt="Siguiente"></a>';
						document.getElementById('anterior').innerHTML='<a href="cambiar" onClick="paginar('+id+', '+ant+', '+autom+');return false;"><img class="sinBorde" src="imagenes/iranterior.jpg" width="18" height="18" alt="Anterior"></a>';
						document.getElementById('ultimo').innerHTML='<a href="cambiar" onClick="paginar('+id+', '+ultimo+', '+autom+');return false;"><img class="sinBorde" src="imagenes/irultimo.jpg" width="18" height="18" alt="Ultimo"></a>';
						
					 }
					automatic = parseInt(results[5]) ;
					
					if (automatic)
					 {
						for (i = 0; i < results[7]; i++)
							{
							
							setTimeout("cambiarImg('"+results[i+8]+"')",i*5000);
							}
						
						if (results[6]!=1){
							setTimeout("paginar("+id+", "+sig+", '1')",results[7]*5000);
						}
						

					 }
				break;
				
			}
			 
			 
             enProceso = false;
			 
          }
       }
	   
    }
	
}

function habilitar(f){
	for (var iterador = 0; iterador < f.elements.length; iterador++) {
		elem = f.elements[iterador];
		elem.removeAttribute('disabled');
	}
}

function habilitarInput(id){
	document.getElementById(id).readonly = false;
	todos = document.getElementsByTagName('input');
	i=0;
	while(i<todos.length){
		if ((todos[i].type != 'submit')||(todos[i].type != 'button')){
			if(todos[i].id != id){
				todos[i].readonly = true;
			}
		}
				i++;
	}
}

/********************  L  **************************/

function listartodos(){
 	formu = document.getElementById('validar').value="false";
 	document.getElementById('filtro').selectedIndex = 0;
 	document.getElementById('filtro').value="";
}



/********************  M  **************************/
function mayusculas(input){
 	
	input.value = input.value.toUpperCase(); 
}

function mensajeError(error) {
	var lightbox = document.getElementById('lightbox');
	var overlay = document.getElementById('overlay');
	var mensajeErrorText = document.getElementById('mensajeErrorText');
	if(error != null) {
		mensajeErrorText.innerHTML = error;
		lightbox.style.visibility = 'visible';
		overlay.style.visibility = 'visible';
	} else {
		lightbox.style.visibility = 'hidden';
		overlay.style.visibility = 'hidden';	
	}
}

/********************  N  **************************/
function nuevoAjax()
{ 
	/* Crea el objeto AJAX. Esta funcion es generica para cualquier utilidad de este tipo, por
	lo que se puede copiar tal como esta aqui */
	var xmlhttp=false;
	try
	{
		// Creacion del objeto AJAX para navegadores no IE
		xmlhttp=new ActiveXObject("Msxml2.XMLHTTP");
	}
	catch(e)
	{
		try
		{
			// Creacion del objet AJAX para IE
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		catch(E)
		{
			if (!xmlhttp && typeof XMLHttpRequest!='undefined') xmlhttp=new XMLHttpRequest();
		}
	}
	return xmlhttp; 
}

/********************  P  **************************/
function popUp(a){
	window.open(a.href, a.target, 'width=900,height=450, ,location=center, scrollbars=YES'); 
	return false;

}

function paginar(id, start, autom) {  
	
	if (!enProceso && http) {
        
	   var url = "admin/imagenespublicaciones/Ajax_imagenes.php?id="+id+"&start="+start+"&auto="+autom;
      	
	   http.open("GET", url, true);
       http.onreadystatechange = handleHttpResponse;
       enProceso = true;
       http.send(null);
    }
}

/********************  T  **************************/


/********************  V  **************************/

function validarHoras(form){
	var cd_proyecto = document.getElementById('cd_proyecto');
	var cd_proyecto = document.getElementById('cd_proyecto');
	var tipoInv = document.getElementById('cd_tipoinvestigador');
	var ded = document.getElementById('cd_deddoc');
	var divDed = document.getElementById('divDed');
	var cargo = document.getElementById('cd_cargo');
	var divCargo = document.getElementById('divCargo');
	var divDtcargo = document.getElementById('divDtcargo');
	var dt_cargo = document.getElementById('dt_cargo');
	if((cargo.value==6)&&(ded.value!=4)){
		divCargo.innerHTML = 'Debe especificar un cargo';
		cargo.style.background = '#FFF4F4';
		cargo.style.borderColor =  "#8E3B1B";
		return false
	}
	else{
		divCargo.innerHTML = '';
		cargo.style.background = '#FFFFFF';
		cargo.style.borderColor = '#FFFFFF';
	}
	if(dt_cargo != null){
		if((cargo.value!=6)&&(dt_cargo.value == '')){
			divDtcargo.innerHTML = 'Debe especificar la fecha del cargo';
			dt_cargo.style.background = '#FFF4F4';
			dt_cargo.style.borderColor =  "#8E3B1B";
			return false
		}
		else{
			divDtcargo.innerHTML = '';
			dt_cargo.style.background = '#FFFFFF';
			dt_cargo.style.borderColor = '#FFFFFF';
		}
	}
	if((cargo.value!=6)&&(ded.value==4)){
		divDed.innerHTML = 'Debe especificar una dedicación';
		ded.style.background = '#FFF4F4';
		ded.style.borderColor =  "#8E3B1B";
		return false
	}
	else{
		divDed.innerHTML = '';
		ded.style.background = '#FFFFFF';
		ded.style.borderColor = '#FFFFFF';
	}
	var carr = document.getElementById('cd_carrerainv');
	var divCarrera = document.getElementById('divCarrera');
	var univ = document.getElementById('cd_universidad');
	var becario = document.getElementById('bl_becario');
	var divDtbeca = document.getElementById('divDtbeca');
	var dt_beca = document.getElementById('dt_beca');
	var tipo = document.getElementById('ds_tipobeca');
	var divTipo = document.getElementById('divTipobeca');
	var inst = document.getElementById('ds_orgbeca');
	var divOrg = document.getElementById('divOrgbeca');
	var divTituloGrado = document.getElementById('divTituloGrado');
	var ds_titulogrado = document.getElementById('ds_titulogrado');
	var bl_estudiante = document.getElementById('bl_estudiante');
	var nu_materias = document.getElementById('nu_materias');
	var divmatadeudadas = document.getElementById('divmatadeudadas');
	var cd_organismo = document.getElementById('cd_organismo');
	var carreras = [1,2,3,4,5,6,9,12]; 
	if((cargo.value==6)&&(ded.value==4)){
		if((!carreras.in_array(carr.value))&&(!becario.checked)&&(tipoInv.value!=6)){
			divCarrera.innerHTML = 'Si no posee cargo, debe ser becario o tener un cargo en la carrera de investigación.';
			
			return false
			}
		else{
			divCarrera.innerHTML = '';
			
		}
	}
	else{
			divCarrera.innerHTML = '';
			
	}
	if((ded.value==5)||(ded.value==6)){
		if((cd_organismo.value==7)||!carreras.in_array(carr.value)){
			divCarrera.innerHTML = 'Si está adherido al art. 25, debe completar los datos en la carrera de investigación.';
			
			return false
			}
		else{
			divCarrera.innerHTML = '';
			
		}
	}
	else{
			divCarrera.innerHTML = '';
			
	}
	if(ds_titulogrado!=null){
		if((ds_titulogrado.value=='')&&(tipoInv.value!=6)){
			divTituloGrado.innerHTML = 'Este Campo es requerido.';
			ds_titulogrado.style.background = '#FFF4F4';
			ds_titulogrado.style.borderColor =  "#8E3B1B";
			return false
			}
		else{
			if((ds_titulogrado.value=='')&&(tipoInv.value==6)){
				
					bl_estudiante.checked = true;
				}
				else{
					bl_estudiante.checked = false;
					nu_materias.value='';
				}
			
			if((bl_estudiante.checked)&&((nu_materias.value=='')||(nu_materias.value==0))&&(tipoInv.value==6)){
				divmatadeudadas.innerHTML = 'Este Campo es requerido. (si no es estudiante complete el título de grado)';
				nu_materias.style.background = '#FFF4F4';
				nu_materias.style.borderColor =  "#8E3B1B";
				return false
				}
			else{
				divmatadeudadas.innerHTML = '';
				nu_materias.style.background = '#FFFFFF';
				nu_materias.style.borderColor = '#FFFFFF';
			}
			divTituloGrado.innerHTML = '';
			ds_titulogrado.style.background = '#FFFFFF';
			ds_titulogrado.style.borderColor = '#FFFFFF';
		}
	}
	if(becario.checked){
		if(dt_beca != null){
			if(dt_beca.value==''){
				divDtbeca.innerHTML = 'Debe especificar la fecha de la beca.';
				dt_beca.style.background = '#FFF4F4';
				dt_beca.style.borderColor =  "#8E3B1B";
				return false
				}
			else{
				divDtbeca.innerHTML = '';
				dt_beca.style.background = '#FFFFFF';
				dt_beca.style.borderColor = '#FFFFFF';
			}
		}
		if(tipo.value==''){
			divTipo.innerHTML = 'Este Campo es requerido.';
			tipo.style.background = '#FFF4F4';
			tipo.style.borderColor =  "#8E3B1B";
			return false
			}
		else{
			divTipo.innerHTML = '';
			tipo.style.background = '#FFFFFF';
			tipo.style.borderColor = '#FFFFFF';
		}
		if(inst.value==''){
			divOrg.innerHTML = 'Este Campo es requerido.';
			inst.style.background = '#FFF4F4';
			inst.style.borderColor =  "#8E3B1B";
			return false
			}
		else{
			divOrg.innerHTML = '';
			inst.style.background = '#FFFFFF';
			inst.style.borderColor = '#FFFFFF';
		}

	

	}
	else{
		divTipo.innerHTML = '';
		tipo.style.background = '#FFFFFF';
		tipo.style.borderColor = '#FFFFFF';
		divOrg.innerHTML = '';
		inst.style.background = '#FFFFFF';
		inst.style.borderColor = '#FFFFFF';
	}
	
	var i=0;
	var ok=1;
	var hs=0;
	while (ok==1){
		var p = document.getElementById('p'+i);
		var cd_tipoinvestigador = document.getElementById('pTI'+i);
		if (p==null) ok=0;
			else{
				var div = document.getElementById('div'+i);
				var hsP = document.getElementById('nu_horasinv'+p.value);
				var hsPAnt = document.getElementById('nu_horasinvAnt'+p.value);
				var vp = hsP.value;
				if(hsPAnt!=null){
					if((p.value == cd_proyecto.value)&&(hsP.value==hsPAnt.value)){
						div.innerHTML = 'No modificó las horas';  hsP.style.background = '#FFF4F4'; hsP.style.borderColor =  "#8E3B1B";   return false;}
					  else {div.innerHTML = '';		
							hsP.style.background = '#FFFFFF';
							hsP.style.borderColor =  "#FFFFFF";
						}
				}
				vp = ((vp=='')||(tipoInv.value==6))?0:vp;
				var hs = parseInt(vp) + parseInt(hs);
				if((tipoInv.value==6)||(cd_tipoinvestigador.value==6)){
					var hsAnt= hs;
					hs = 0;
					if ((p.value == cd_proyecto.value)||(cd_tipoinvestigador.value==6))
					{
						hs = parseInt(vp);
					}
					/*if(hs > 0){ div.innerHTML = 'No puede aportar horas'; hsP.style.background = '#FFF4F4'; hsP.style.borderColor =  "#8E3B1B";   return false;}
					  else {div.innerHTML = ''; 	
							hsP.style.background = '#FFFFFF';
							hsP.style.borderColor =  "#FFFFFF";
							
							}*/
					var hs= hsAnt;
					}
					else{
					if(univ.value!=11){
						if(ded.value==3){
							if(hs !=4){ div.innerHTML = 'Las hs. en el proyecto deben ser 4'; hsP.style.background = '#FFF4F4'; hsP.style.borderColor =  "#8E3B1B";  return false;}
							  else {div.innerHTML = '';	
									hsP.style.background = '#FFFFFF';
									hsP.style.borderColor =  "#FFFFFF";
							  }
						}
						else{	
							if((hs > 6)||(hs < 4)){ div.innerHTML = 'Las hs. en el/los proyecto/s deben ser mayor que 3 y no superar 6';  hsP.style.background = '#FFF4F4'; hsP.style.borderColor =  "#8E3B1B";   return false;}
								  else {div.innerHTML = '';		
										hsP.style.background = '#FFFFFF';
										hsP.style.borderColor =  "#FFFFFF";
										}
						}
					}
					else{
						if((carreras.in_array(carr.value))||(becario.checked)){
							if((hs > 35)){ div.innerHTML = 'Las hs. en el/los proyecto/s no deben superar 35';  hsP.style.background = '#FFF4F4'; hsP.style.borderColor =  "#8E3B1B";  return false;}
							  else {div.innerHTML = '';	
									hsP.style.background = '#FFFFFF';
									hsP.style.borderColor =  "#FFFFFF";
									
									}
							if((hsP.value < 10)&&(p.value == cd_proyecto.value)){ div.innerHTML = 'Las hs. en el proyecto deben ser mayor a 9';  hsP.style.background = '#FFF4F4'; hsP.style.borderColor =  "#8E3B1B";  return false;}
							  else {div.innerHTML = '';	
									hsP.style.background = '#FFFFFF';
									hsP.style.borderColor =  "#FFFFFF";
									
									}
						}
						else{
							switch (ded.value) {
								case '1': if((hs > 35)){ div.innerHTML = 'Las hs. en el/los proyecto/s no deben superar 35';  hsP.style.background = '#FFF4F4'; hsP.style.borderColor =  "#8E3B1B";  return false;}
										  else {div.innerHTML = '';	
												hsP.style.background = '#FFFFFF';
												hsP.style.borderColor =  "#FFFFFF";
												
												}
											if((hsP.value < 10)&&(p.value == cd_proyecto.value)){ div.innerHTML = 'Las hs. en el proyecto deben ser mayor a 9';  hsP.style.background = '#FFF4F4'; hsP.style.borderColor =  "#8E3B1B";  return false;}
											  else {div.innerHTML = '';	
													hsP.style.background = '#FFFFFF';
													hsP.style.borderColor =  "#FFFFFF";
													
													}
											break;
								case '2': if((hs > 15)){ div.innerHTML = 'Las hs. en el/los proyecto/s no deben superar 15';  hsP.style.background = '#FFF4F4'; hsP.style.borderColor =  "#8E3B1B";   return false;}
										  else {div.innerHTML = '';	
												hsP.style.background = '#FFFFFF';
												hsP.style.borderColor =  "#FFFFFF";
												
												}
										if((hsP.value < 6)&&(p.value == cd_proyecto.value)){ div.innerHTML = 'Las hs. en el proyecto deben ser mayor a 5';  hsP.style.background = '#FFF4F4'; hsP.style.borderColor =  "#8E3B1B";  return false;}
										  else {div.innerHTML = '';	
												hsP.style.background = '#FFFFFF';
												hsP.style.borderColor =  "#FFFFFF";
												
												}
										break;
								case '3': if(hs !=4){ div.innerHTML = 'Las hs. en el proyecto deben ser 4'; hsP.style.background = '#FFF4F4'; hsP.style.borderColor =  "#8E3B1B";  return false;}
										  else {div.innerHTML = '';	
												hsP.style.background = '#FFFFFF';
												hsP.style.borderColor =  "#FFFFFF";
												
												}
										break;
								case '5': if((hs > 35)) {div.innerHTML = 'Las hs. en el/los proyecto/s no deben superar 35'; hsP.style.background = '#FFF4F4'; hsP.style.borderColor =  "#8E3B1B"; return false;}
										  else {div.innerHTML = '';	
												hsP.style.background = '#FFFFFF';
												hsP.style.borderColor =  "#FFFFFF";
												
												}
											if((hsP.value < 10)&&(p.value == cd_proyecto.value)){ div.innerHTML = 'Las hs. en el proyecto deben ser mayor a 9';  hsP.style.background = '#FFF4F4'; hsP.style.borderColor =  "#8E3B1B";  return false;}
											  else {div.innerHTML = '';	
													hsP.style.background = '#FFFFFF';
													hsP.style.borderColor =  "#FFFFFF";
													
													}
											break;
								case '6': if((hs > 35)){ div.innerHTML = 'Las hs. en el/los proyecto/s no deben superar 35';  hsP.style.background = '#FFF4F4'; hsP.style.borderColor =  "#8E3B1B"; return false;}
										  else {div.innerHTML = '';	
												hsP.style.background = '#FFFFFF';
												hsP.style.borderColor =  "#FFFFFF";
												
												}
											if((hsP.value < 10)&&(p.value == cd_proyecto.value)){ div.innerHTML = 'Las hs. en el proyecto deben ser mayor a 9';  hsP.style.background = '#FFF4F4'; hsP.style.borderColor =  "#8E3B1B";  return false;}
											  else {div.innerHTML = '';	
													hsP.style.background = '#FFFFFF';
													hsP.style.borderColor =  "#FFFFFF";
													
													}
											break;
								/*default: if(hs > 0){ div.innerHTML = 'No puede aportar horas';  hsP.style.background = '#FFF4F4'; hsP.style.borderColor =  "#8E3B1B";  return false;}
										  else {div.innerHTML = ''; 
												hsP.style.background = '#FFFFFF';
												hsP.style.borderColor =  "#FFFFFF";
												
												}
											break;*/
							}
						}
					}	
					}
			}
		i++;	
		}
		
	
	
	var div = document.getElementById('cv');
	var ds_curriculum = document.getElementById('ds_curriculum');
	var ds_curriculumH = document.getElementById('ds_curriculumH');
	if((ds_curriculum.value=='')&&(ds_curriculumH.value=='')){
		div.innerHTML = 'Este Campo es requerido.';
		ds_curriculum.style.background = '#FFF4F4';
		ds_curriculum.style.borderColor =  "#8E3B1B";
		return false
		}
	else{
		if(ds_curriculum.value!=''){
			var cv = ds_curriculum.value.toUpperCase();
			if (cv.indexOf('PDF', 0) == -1 && cv.indexOf('DOC', 0) == -1 && cv.indexOf('DOCX', 0) == -1 && cv.indexOf('RTF', 0) == -1){
				div.innerHTML = 'Formato de archivo no v&aacute;lido.';
				ds_curriculum.style.background = '#FFF4F4';
				ds_curriculum.style.borderColor =  "#8E3B1B";
				return false
			}
			else{
				div.innerHTML = '';
				ds_curriculum.style.background = '#FFFFFF';
				ds_curriculum.style.borderColor = '#FFFFFF';
				}
		}
		else{
			div.innerHTML = '';
			ds_curriculum.style.background = '#FFFFFF';
			ds_curriculum.style.borderColor = '#FFFFFF';
			}
	}

	var divia = document.getElementById('ia');
	var ds_actividades = document.getElementById('ds_actividades');
	var ds_actividadesH = document.getElementById('ds_actividadesH');
	if((ds_actividades.value=='')&&(ds_actividadesH.value=='')){
		divia.innerHTML = 'Este Campo es requerido.';
		ds_actividades.style.background = '#FFF4F4';
		ds_actividades.style.borderColor =  "#8E3B1B";
		return false
		}
	else{
		if(ds_actividades.value!=''){
			var ia = ds_actividades.value.toUpperCase();
			if (ia.indexOf('PDF', 0) == -1 && ia.indexOf('DOC', 0) == -1 && ia.indexOf('DOCX', 0) == -1 && ia.indexOf('RTF', 0) == -1){
				divia.innerHTML = 'Formato de archivo no válido.';
				ds_actividades.style.background = '#FFF4F4';
				ds_actividades.style.borderColor =  "#8E3B1B";
				return false
			}
			else{
				divia.innerHTML = '';
				ds_actividades.style.background = '#FFFFFF';
				ds_actividades.style.borderColor = '#FFFFFF';
				}
		}
		else{
			divia.innerHTML = '';
			ds_actividades.style.background = '#FFFFFF';
			ds_actividades.style.borderColor = '#FFFFFF';
			}
	}	
	//form.submit();
	
	
	
}

function verificarFiltro(){
	if (document.getElementById('filtro').value==""){
		if(document.getElementById('validar').value=="true"){
			alert("Se debe ingresar un criterio de búsqueda");
			return false;
			
		}
	}
	return true;
}

function verificarCampos(){
	if($('nu_porcentaje').value ==""){
		$('nu_porcentaje').value =="";
	}
}

function volver(form, action){
	form.action = action;
	validarArea();
	//form.submit();
}

function seleccionarOrganismo(){
	var ds_orgbeca = document.getElementById('ds_orgbeca');
    var divSelectBeca = document.getElementById('divSelectBeca');
    var cd_unidad = document.getElementById('cd_universidad');	
    var ds_universidad = document.getElementById('ds_universidad');	
    cd_universidad.value='';
	ds_universidad.value='';
    var html ="<select name='ds_tipobeca' id='ds_tipobeca'><option value=''> -- Seleccione uno -- </option>";
	switch(ds_orgbeca.value)
	{
		case "ANPCyT": 
			html = html +"<option value='Agencia 1'>Agencia 1</option><option value='Agencia 2'>Agencia 2</option>";
 
		break;
		case "CIC": 
			html = html +"<option value='CIC 1'>CIC 1</option><option value='CIC 2'>CIC 2</option>";
 
		break;
		case "CONICET": 
			html = html +"<option value='CONICET 1'>CONICET 1</option><option value='CONICET 2'>CONICET 2</option>";
 
		break;
		case "UNLP": 
			html = html +"<option value='UNLP 1'>UNLP 1</option><option value='UNLP 2'>UNLP 2</option>";
			cd_universidad.value=11;
			ds_universidad.value='UNIVERSIDAD NACIONAL DE LA PLATA (UNLP)';
			
		break;
	}
	
	html = html +"</select>";
	divSelectBeca.innerHTML=html;
   
}

function mostraBeca(){
	var bl_becario = document.getElementById('bl_becario');
	var divBeca = document.getElementById('datosBeca');
	
	if(bl_becario.checked){
		divBeca.style.display = "block";
		
	}
	else{
		
		divBeca.style.display = "none";
		
		}
}

