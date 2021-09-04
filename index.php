<?php
include_once 'includes/include.php';



/*******************************************************
 * La variable er por GET indica el tipo de error por el
 * que se redireccion� al login
 *******************************************************/
if (isset ( $_GET ['er'] )) {
	$error = $_GET ['er'];
	switch ( $error) {
		case '1' :
			$msj = "C.U.I.L. y/o contrase�a incorrecta";
		break;
		case '2' :
			$msj = "No existe una sesi�n iniciada";
		break;
		case '3' :
			//$msj = $_GET ['clave'];
			$msj = "Se ha enviado una nueva password por E-mail";
		break;
	}
}


$xtpl = new XTemplate ( 'index1.html' );

$xtpl->assign ( 'titulo', 'SeCyT' );
$xtpl->assign ( 'MSJ', $msj );
$xtpl->parse ( 'main.block1' );
$xtpl->parse ( 'main' );
$xtpl->out ( 'main' );

?>