<?
session_start();
######################INCLUDES################################
//archivo de configuracion
include_once ('config.php');

//funciones propias
include ('funciones.php');

//incluímos la clase ajax
require ('xajax/xajax.inc.php');
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@

################### Conexion a la base de datos##########################

$bd= mysql_connect($bd_host, $bd_user, $bd_pass);
mysql_select_db($bd_database, $bd);

//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
?>


<HTML>
<HEAD>
<TITLE>principal.php</TITLE>
</HEAD>

<body style="background-color:<?echo $body_color?>">
<BODY>

<?php
$d = dir("c:/appserv/www/gn");
echo "Gestor: " . $d->handle . "\n";
echo "Ruta: " . $d->path . "\n";
while (false !== ($entrada = $d->read())) {
   echo $entrada."\n";
}
$d->close();
?>


</BODY>
</HTML>