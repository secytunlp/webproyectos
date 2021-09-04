<?php
include 'clases/Usuario.Class.php';
$oUsuario = new Usuario ( );
if (unserialize ( $_SESSION ['usuarioP'] )) {
	$oUsuario = unserialize ( $_SESSION ['usuarioP'] );
}

$oUsuario->cerrarSesion ();


header ( 'location:index.php' );

?>