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

$articulos = $_POST['art'];
$rubros    = $_POST['rub'];

$sSQL= "delete from abmarticulos where idabmarticulo = '$articulos'";
//echo $sSQL;
mysql_query($sSQL);

insertolog($legajo, "B_Novarticulos2", "abmarticulos", "delete", "1999-12-01", $sSQL);

echo mensaje_ok('ABM_Novaticulos.php','OK');


?>


