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
require_once("cookie.php");
require_once("config.php");
$cookie = new cookieClass;
$G_usuario = $cookie->get("usuario");
$G_legajo  = $cookie->get("legajo");
$G_perfil  = $cookie->get("perfil");

################### Conexion a la base de datos##########################

$bd= mysql_connect($bd_host, $bd_user, $bd_pass);
mysql_select_db($bd_database, $bd);

//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@


$fechad = $_POST["cla_fecha"];
$fechah = $_POST["cla_fecha1"];
$nombre = $_POST["legajo"];
$idmarcaje = $_POST["idmarcaje"];

$fechamod = $_POST["fecha1"];
$horah = $_POST["cla_hora1"];

$hoy = date("Y/m/d");
$hora = date("H:i:s");
$actualiza = "MARCA";

//Ejecucion de la sentencia SQL

  $sSQL="update marcaje set fechas='".$fechamod."', horas='".$horah."', tipomarcaje='E'
         where idmarcaje = '".$idmarcaje."'";
   mysql_query($sSQL);

   insertolog($legajo, "M_Marcaje2", "marcaje", "update", "1999-12-01", $sSQL);

$pagina = 'ABM_Marcaje.php?vengo='.$actualiza.'&cla_fecha='.$fechad.'&cla_fecha1='.$fechah.'&cla_nombre='.$nombre.'&cla_idmarcaje='.$idmarcaje;

?>
<html>
<head>
<script language="JavaScript">
function funcion_href()
{
 window.location.href("<?php print $pagina ?>");
}
</script>
</head>
<body onload="funcion_href()">
</body>
</html>

