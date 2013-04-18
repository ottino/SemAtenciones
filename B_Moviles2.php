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

$moviles = $_POST['mov'];

$sSQL= "update moviles set estado = '1'
              where idmovil = ".$moviles;
//echo $sSQL;
mysql_query($sSQL);

insertolog($legajo, "B_Moviles2", "moviles", "update", "1999-12-01", $sSQL);

echo mensaje_ok('ABM_Moviles.php','OK');
?>


