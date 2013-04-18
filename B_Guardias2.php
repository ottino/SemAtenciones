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



//Ejecucion de la sentencia SQL

$guardia = $_POST['guar'];

$sSQL= "delete from guardias where idguardia = ".$guardia;

//echo $sSQL;
mysql_query($sSQL);

insertolog($legajo, "B_Guardias2", "guardias", "delete", "1999-12-01", $sSQL);

echo mensaje_ok('ABM_Guardias.php','OK');
?>


