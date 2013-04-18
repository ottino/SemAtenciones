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

$pasmovildisp      = $_POST["pasmovildisp"];
$idatencion        = $_POST["idatencion"];
$cla_importe       = $_POST["cla_importe"];
$pasaid  = $_POST["pasaid"];


if ($cla_importe < '1')
 $coseguro = 'no';
else
 $coseguro = 'si';

$sSQL= "update atenciones set coseguro = '".$coseguro."', impcoseguro = '".$cla_importe."' where id = ".$idatencion;

mysql_query($sSQL);

insertolog($legajo, "M_Guardiacerr2.php", "atenciones", "update", "1999-12-01", $sSQL);

$pagina = "M_Guardiacerr.php?pasmovildisp=".$pasmovildisp."&pasaid=".$pasmovildisp;

echo mensaje_ok($pagina,"OK");

?>
