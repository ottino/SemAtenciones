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


$idsegmenu = $_POST["pasmenu"];

//Creamos la sentencia SQL y la ejecutamos
$sSQL="Delete From segmenu where idsegmenu = ".$idsegmenu;
//echo $sSQL;

mysql_query($sSQL);

insertolog($legajo, "B_Menusegu2.php", "segmenu", "delete", "1999-12-01", $sSQL);

echo mensaje_ok('ABM_Menusegu.php','OK');

?>

