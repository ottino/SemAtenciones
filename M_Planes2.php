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

$cla_idplan        = $_POST["idplan"];
$cla_descplan      = $_POST["descplan"];
$cla_codigoplan    = $_POST["codigoplan"];
$cla_datos         = $_POST["datos"];
$cla_contacto      = $_POST["contacto"];
$cla_contacto1     = $_POST["contacto1"];
$cla_imp1          = $_POST["imp1"];
$cla_imp2          = $_POST["imp2"];
$cla_imp3          = $_POST["imp3"];
$cla_imp4          = $_POST["imp4"];
$cla_imp5          = $_POST["imp5"];
$cla_imp6          = $_POST["imp6"];
$cla_imp7          = $_POST["imp7"];
$cla_imp8          = $_POST["imp8"];
$cla_imp9          = $_POST["imp9"];
$cla_imp10         = $_POST["imp10"];
$cla_imp11         = $_POST["imp11"];
$cla_imp12         = $_POST["imp12"];
$cla_imp13         = $_POST["imp13"];
$cla_imp14         = $_POST["imp14"];
$cla_imp15         = $_POST["imp15"];
$cla_imp16         = $_POST["imp16"];
$cla_imp17         = $_POST["imp17"];
$cla_imp18         = $_POST["imp18"];
$cla_imp19         = $_POST["imp19"];
$cla_imp20         = $_POST["imp20"];
$cla_impcoseguro   = $_POST["impcoseguro"];
$cla_fecalta       = $_POST["cla_fecha"];
$cla_fecbaja       = $_POST["cla_fecha1"];
$cla_descabrev     = $_POST["descabrev"];
$cla_frecuencia    = $_POST["frecuencia"];
$cla_estado        = $_POST["estado"];
$cla_cnexcede      = $_POST["cla_cnexcede"];
$cla_impexcede     = $_POST["cla_impexcede"];


$sSQL= "update planes set descplan = '".$cla_descplan."', codigoplan = '".$cla_codigoplan."', datos = '".$cla_datos."' ,
       contacto = '".$cla_contacto."', contacto1 = '".$cla_contacto1."', imp1 = '".$cla_imp1."', imp2 = '".$cla_imp2."',
       imp3 = '".$cla_imp3."', imp4 = '".$cla_imp4."', imp5 = '".$cla_imp5."', imp6 = '".$cla_imp6."', imp7 = '".$cla_imp7."',
       imp8 = '".$cla_imp8."', imp9 = '".$cla_imp9."', imp10 = '".$cla_imp10."', imp11 = '".$cla_imp11."', imp12 = '".$cla_imp12."',
       imp13 = '".$cla_imp13."', imp14 = '".$cla_imp14."', imp15 = '".$cla_imp15."', imp16 = '".$cla_imp16."', imp17 = '".$cla_imp17."',
       imp18 = '".$cla_imp18."', imp19 = '".$cla_imp19."', imp20 = '".$cla_imp20."',
       impcoseguro = '".$cla_impcoseguro."', estado = '".$cla_estado."', fecalta = '".$cla_fecalta."', fecbaja = '".$cla_fecbaja."',
       descabrev = '".$cla_descabrev."', upg = '".$cla_upg."', frecuencia = '".$cla_frecuencia."',
       cnexcedentes =  '".$cla_cnexcede."', impexcedentes = '".$cla_impexcede."'  where idplan = '$cla_idplan'";

//echo $sSQL;
mysql_query($sSQL);

insertolog($legajo, "M_Planes2", "planes", "update", "1999-12-01", $sSQL);

echo mensaje_ok('ABM_Planes0.php','OK');

?>
