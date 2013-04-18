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

 $sSQL="insert into tareaspend (idtarea, idmovil, fecha, km, idproveedor)
      values ('".$_POST['tarea']."','".$_POST['moviles']."','".$_POST['cla_fecha']."','".$_POST['cla_km']."','".$_POST['provee']."')";
//echo $sSQL;
 mysql_query($sSQL);

 insertolog($legajo, "A_Tareaspend2.php", "tareaspend", "insert", "1999-12-01", $sSQL);

 echo mensaje_ok('ABM_Tareaspend.php','OK');


?>
