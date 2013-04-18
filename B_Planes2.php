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

$cla_idplan  = $_POST["idplan"];

$cla_estado = 'B';
$cla_fecbaja = date("Y-m-d");


  $sSQL= "update planes set estado  = '".$cla_estado."',
                            fecbaja = '".$cla_fecbaja."'
               where idplan = '$cla_idplan'";
//echo $sSQL;
mysql_query($sSQL);

insertolog($legajo, "B_Planes2.php", "planes", "update", "1999-12-01", $sSQL);

echo mensaje_ok('ABM_Planes0.php','OK');

?>
