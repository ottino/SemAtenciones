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

$datos = $_POST['datos'];

 $hoy = date("Y-m-d");

$sSQL="update datosliq set tipmovil      = '".$_POST['cla_tipmovil']."',
                          tipmed         = '".$_POST['cla_tipmedico']."',
                          descripcion    = '".strtoupper ($_POST['cla_descripcion'])."',
                          fijo           = '".$_POST['cla_fijo']."',
                          anfijo         = '".$_POST['cla_anfijo']."',
                          cnbase         = '".$_POST['cla_cnbase']."',
                          impbase        = '".$_POST['cla_impbase']."',
                          animpbase      = '".$_POST['cla_animpbase']."',
                          impexcedentes  = '".$_POST['cla_impexcedentes']."',
                          impanulados    = '".$_POST['cla_impanulados']."',
                          cnsimultaneos  = '".$_POST['cla_cnsimultaneos']."',
                          impsimultaneos = '".$_POST['cla_impsimultaneos']."',
                          animpexcede    = '".$_POST['cla_animpexcede']."',
                          azimpexcede    = '".$_POST['cla_azimpexcede']."',
                          afdimpexcede   = '".$_POST['cla_afdimpexcede']."',
                          fecultact      = '".$hoy."'
              where id = $datos";

mysql_query($sSQL);

insertolog($legajo, "M_Datosliq2", "datosliq", "update", "1999-12-01", $sSQL);

echo mensaje_ok('ABM_Datosliq.php','OK');


?>


