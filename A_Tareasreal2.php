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

 $sSQL="insert into tareareal (idtarea, idmovil, fecha, km, idproveedor, importe)
      values ('".$_POST['tarea']."','".$_POST['movil']."','".$_POST['cla_fecha']."','".$_POST['cla_km']."','".$_POST['provee']."','".$_POST['cla_importe']."')";
//echo $sSQL;
 mysql_query($sSQL);

 insertolog($legajo, "B_Tareasreal2", "tareasreal", "insert", "1999-12-01", $sSQL);

 echo mensaje_ok('ABM_Tareasreal.php','OK');


?>
