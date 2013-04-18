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

$idcontrato = $_POST["pasacont"];
$cla_idcliente  = $_POST["cla_idcliente"];
$cla_idcliente1 = $_POST["cla_idcliente1"];
$cla_idcliente2 = $_POST["cla_idcliente2"];
$cla_idcliente3 = $_POST["cla_idcliente3"];
$cla_idcliente4 = $_POST["cla_idcliente4"];
$cla_idcliente5 = $_POST["cla_idcliente5"];
$cla_idcliente6 = $_POST["cla_idcliente6"];
$cla_idcliente7 = $_POST["cla_idcliente7"];
$cla_idcliente8 = $_POST["cla_idcliente8"];
$cla_idcliente9 = $_POST["cla_idcliente9"];
$cla_idcliente10= $_POST["cla_idcliente10"];
$cla_idcliente11= $_POST["cla_idcliente11"];
$cla_idcliente12= $_POST["cla_idcliente12"];

$cla_idplan      = $_POST["cla_idplan"];
$cla_frecuencia  = $_POST["cla_frecuencia"];
$cla_fecalta     = $_POST["cla_fecha"];
$cla_fecvto      = $_POST["cla_fecha1"];
$cla_importe     = $_POST["cla_importe"];
$cla_ordenmax    = $_POST["cla_ordenmax"];
$cla_tipocomprob = $_POST["cla_tipocomprob"];



   $sSQL= "update contratos set estado = 'B'
              where idcontrato = '$idcontrato'";

mysql_query($sSQL);

insertolog($legajo, "B_Contratos2.php", "contratos", "update", "1999-12-01", $sSQL);

echo mensaje_ok('ABM_Contratos0.php','OK');

?>
