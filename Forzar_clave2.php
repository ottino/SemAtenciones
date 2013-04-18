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

require_once("cookie.php");

################### Conexion a la base de datos##########################

$bd= mysql_connect($bd_host, $bd_user, $bd_pass);
mysql_select_db($bd_database, $bd);

//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@



//Ejecucion de la sentencia SQL

$legajo = $_POST['legajo'];

$sSQL= "select * from legajos where legajo = ".$legajo;
$result=mysql_query($sSQL);

$resultado = mysql_fetch_array($result);

$contrasena = md5($legajo);

//echo $contrasena;

//$contrasena=crypt($legajo, $semilla);


$sSQL="update legajos set clave = '".$contrasena."'
              where legajo = '$legajo'";

//   echo $sSQL;
   mysql_query($sSQL);

   insertolog($legajo, "forzar_clave2.php", "legajos", "update", "1999-12-01", $sSQL);

   echo mensaje_ok('Forzar_clave.php','OK');

mysql_free_result($result);


//echo $sSQL;
//mysql_query($sSQL);
?>


