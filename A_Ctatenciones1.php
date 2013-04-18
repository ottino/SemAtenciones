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

$idatenciones = $_POST["pasaid"];
$cta = $_POST["cla_cta"];
$observaciones = $_POST["cla_observaciones"];

$sSQL= "update atenciones set cta = '".$cta."',
                              obscta = '".$observaciones."'
              where id = '$idatenciones'";
//echo $sSQL;
mysql_query($sSQL);

insertolog($legajo, "A_Ctatenciones1.php", "atenciones", "update", "1999-12-01", $sSQL);

echo mensaje_ok('ABM_CAtenciones.php','OK');


?>


