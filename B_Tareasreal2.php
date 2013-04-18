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
?>

<?
echo titulo_encabezado ('' , $path_imagen_logo);


$tareareal = $_POST['tareal'];


//Creamos la sentencia SQL y la ejecutamos
$sSQL="delete from tareareal where id = ".$tareareal;
mysql_query($sSQL);

insertolog($legajo, "B_Tareasreal2", "tareasreal", "delete", "1999-12-01", $sSQL);

echo mensaje_ok('ABM_Tareasreal.php','OK');

?>
