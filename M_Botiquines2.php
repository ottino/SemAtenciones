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


$botiquin = $_POST["botiquin"];

//Ejecucion de la sentencia SQL

 $sSQL="update botiquines set
                               cantidad = '".$_POST['cla_cantidad']."',
                               cnminima = '".$_POST['cla_cnminima']."'
               where idbotiquines = '$botiquin'";

//echo $sSQL;
 mysql_query($sSQL);

 insertolog($legajo, "M_Botiquines2", "botiquines", "update", "1999-12-01", $sSQL);

 echo mensaje_ok('ABM_Botiquines.php','OK');

?>
