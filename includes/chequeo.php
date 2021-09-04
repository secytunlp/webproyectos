<?php
session_start ();
$path = WEB_PATH . "index.php?er=2";
if (! isset ( $_SESSION ["cd_usuarioSessionP"] ) || ($_SESSION ['cd_usuarioSessionP'] == "")) {
	header ( 'Location: ' . $path );
	die();
}
?>