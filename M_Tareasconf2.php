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


$tareaconf = $_POST["tarconf"];

//Ejecucion de la sentencia SQL



//Creamos la sentencia SQL y la ejecutamos
$sSQL="delete from tareaspend where id = ".$tareaconf;
mysql_query($sSQL);

insertolog($legajo, "M_Tareasconf2", "tareaspend", "delete", "1999-12-01", $sSQL);

 $sSQL="insert into tareareal (idtarea, idmovil, fecha, km, idproveedor, importe)
      values ('".$_POST['tarea']."','".$_POST['movil']."','".$_POST['cla_fecha']."',
              '".$_POST['cla_km']."','".$_POST['provee']."','".$_POST['cla_importe']."')";
 mysql_query($sSQL);

insertolog($legajo, "M_Tareasconf2", "tareareal", "insert", "1999-12-01", $sSQL);

echo mensaje_ok('ABM_Tareaspend.php','OK');

?>
