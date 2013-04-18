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

<body bgcolor="#FFFF99">

<?
echo titulo_encabezado ('' , $path_imagen_logo);

//echo $_POST['bot'];
$botiquin = $_POST['bot'];


//Creamos la sentencia SQL y la ejecutamos
$sSQL="Delete From botiquines where idbotiquines = ".$botiquin;
mysql_query($sSQL);

insertolog($legajo, "B_Botiquines2", "botiquines", "delete", "1999-12-01", $sSQL);

echo mensaje_ok('ABM_Botiquines.php','OK');

?>
