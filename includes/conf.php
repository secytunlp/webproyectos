<?php
// SQL codes
define('BEGIN_TRANSACTION', 1);
define('END_TRANSACTION', 2);

$dbType   ="mysql";
$dbhost   ="163.10.35.34";
$dbuser   ="root";
$dbpasswd ="secyt";
$dbname   ="viajes";
$row_per_page = 25;
$categoriasPermitidas = array('I','II','III');
$categorias = array('I','II','III','IV','V');
$categoriasPermitidasEx = array('I','II');
$carrerainvs = array(1,2,3,4,5,6,9,12);
$mayordedicacion = array(1,2,5,6);
$imgvalidas = array('.jpg','.jpeg','.gif','.png');
$mailReceptor = "marcosp@presi.unlp.edu.ar";
$mailFrom = "proyectos.secyt@presi.unlp.edu.ar";
$nameFrom = "Secretaría de Ciencia y Ténica de la U.N.L.P.";
$year = 2013;
$mes = 07;
$minintegrantes=3;
$mincategorizados=2;
$minmayordedicacion=2;
$minhsdircodir=10;
$minhstotales=30;
$iniciosistema='20120628000000';
$test=1;
?>
