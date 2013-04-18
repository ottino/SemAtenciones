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

$movil = $_POST['mov'];

$sSQL= "update moviles set descmovil = '".strtoupper($_POST['cla_descmovil'])."',
                              dominio  = '".strtoupper($_POST['cla_dominio'])."',
                              marca    = '".$_POST['cla_marca']."',
                              modelo   = '".$_POST['cla_modelo']."',
                              nromotor = '".$_POST['cla_nromotor']."',
                              nrochasis= '".$_POST['cla_nrochasis']."',
                              fectransf= '".$_POST['cla_fecnac']."',
                         observaciones = '".$_POST['cla_observaciones']."',
                         codperfil    = '".$_POST['cla_codperfil']."'
              where idmovil = '$movil'";
mysql_query($sSQL);

insertolog($legajo, "M_Moviles2", "moviles", "update", "1999-12-01", $sSQL);

echo mensaje_ok('ABM_Moviles.php','OK');


?>


