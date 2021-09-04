<?
include '../includes/include.php';
require '../includes/chequeo.php';
include '../includes/datosSession.php';






$dir = APP_PATH.'img/firmas/';


if (isset($_FILES['imagen']['tmp_name'])) {
   $extension=strrchr($_FILES['imagen'.$pos]['name'],'.');
    if (in_array(strtolower($extension),$imgvalidas)) {
        

           
        //
		
		
		$nuevo=$_FILES['imagen']['name'];
                $nuevo=$cd_usuario.$extension;
		
        if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $dir.$nuevo))
			echo '<script> window.top.mensajeError(\'Error al Subir el Archivo '.$dir.$nuevo.'\');</script>';
		
		$datos = getimagesize($dir.$nuevo);
		if($datos[2]==1){$img = @imagecreatefromgif($dir.$nuevo);}
		if($datos[2]==2){$img = @imagecreatefromjpeg($dir.$nuevo);}
		if($datos[2]==3){$img = @imagecreatefrompng($dir.$nuevo);} 

		$width=300;
		$height=150;
		$width = ($datos[0]<$width)?$datos[0]:$width;
		$heightMax = ($datos[1]<$height)?$datos[1]:$height;
		
		//$width = $datos[0];
		//$heightMax = $datos[1];
		
		$radio = $datos[0] / $width;
		$height = $datos[1] / $radio;
		if($height>$heightMax){
			$height=$heightMax;
            $width=($height/$datos[1])*$datos[0];
			}
			
		$imgNuevo = imagecreatetruecolor($width,$height);
		imagecopyresized($imgNuevo,$img,0,0,0,0,$width,$height,$datos[0],$datos[1]);
		if($datos[2]==1){imagegif($imgNuevo, $dir.$nuevo);}
		if($datos[2]==2){imagejpeg($imgNuevo, $dir.$nuevo, 95);}
		if($datos[2]==3){imagepng($imgNuevo, $dir.$nuevo); }
		
		
		
		
		
		
		
		
		$oUsuario = new Usuario();
		$oUsuario->setCd_usuario($cd_usuario);
		UsuarioQuery::getUsuarioPorId($oUsuario);
		$oUsuario->setDs_firma($nuevo);
		$oUsuario->setDs_password('');
		UsuarioQuery::modificarUsuario($oUsuario);
		echo '<script>var imgHidden = window.top.document.getElementById(\'ds_firma\');';
		echo 'var divImg = window.top.document.getElementById(\'img\');';	
		
		echo 'imgHidden.value=\''.$nuevo.'\';';
		echo 'divImg.innerHTML=\'<img src="../img/firmas/'.$nuevo.'" alt="img" border="0"/>\'</script>;';
    }
        
     else echo '<script> window.top.mensajeError(\'Error: la imagen debe ser JPG, JPEG, GIF o PNG\');</script>';
 }
else echo '<script> window.top.mensajeError(\'Error: no se pudo subir\');</script>';
//echo '<script>parent.parent.document.getElementById(\'overlay\').style.visibility="hidden";parent.parent.document.getElementById(\'cargando\').style.visibility="hidden";</script>';
//echo "<script>parent.cerrar();</script>"
?>