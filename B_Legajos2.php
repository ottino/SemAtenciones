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

$legajo = $_POST['leg'];

$fechad = $_POST['cla_fecbaja'];


if (substr($fechad,2,1) == "/")
    $fechad = cambiarFormatoFecha2($fechad);

$sSQL= "update legajos set estado = '1', fecbaja1 = '".$fechad."',
        observac = '".$_POST['cla_observaciones']."' where legajo = ".$legajo;
//echo $sSQL;
mysql_query($sSQL);

insertolog($legajo, "B_Legajos2.php", "legajos", "update", "1999-12-01", $sSQL);

echo mensaje_ok('ABM_Legajos.php','OK');
?>


