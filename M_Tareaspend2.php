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


$tareapen = $_POST["tarpen"];

//Ejecucion de la sentencia SQL

 $sSQL="update tareaspend set
                               idmovil = '".$_POST['movil']."',
                               idtarea  = '".$_POST['tarea']."',
                               idproveedor= '".$_POST['provee']."',
                               fecha    = '".$_POST['cla_fecha']."',
                               km       = '".$_POST['cla_km']."'
               where id = '$tareapen'";

//echo $sSQL;
 mysql_query($sSQL);

 insertolog($legajo, "M_Tareaspend2", "tareaspend", "update", "1999-12-01", $sSQL);

 echo mensaje_ok('ABM_Tareaspend.php','OK');

?>
