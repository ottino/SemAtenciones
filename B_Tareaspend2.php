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
$tareaspen = $_POST['tarpen'];


//Creamos la sentencia SQL y la ejecutamos
$sSQL="delete from tareaspend where id = ".$tareaspen;
mysql_query($sSQL);

insertolog($legajo, "B_Tareaspend2", "tareaspend", "delete", "1999-12-01", $sSQL);

echo mensaje_ok('ABM_Tareaspend.php','OK');

?>
