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

$ch_legajos = 0;
$ch_dni = 0;
$ch_matricula = 0;



$v_dni = is_numeric($_POST['cla_dni']);
if ($v_dni <> true)
   $ch_dni = 1;
if ($_POST['cla_dni'] > 59999999 or $_POST['cla_dni'] < 2999999)
   $ch_dni = 1;

$v_matricula = is_numeric($_POST['cla_matricula']);
if ($v_matricula <> true)
   $ch_matricula = 1;


if ($ch_dni == 1)
  mensaje_error('ABM_Legajos.php','El DNI no es numérico');
 else
   if ($ch_matricula == 1)
  mensaje_error('ABM_Legajos.php','La matrícula no es numérico');
 else
 {
   $sSQL= "update legajos set apeynomb = '".strtoupper($_POST['cla_apeynomb'])."',
                              sexo     = '".strtoupper($_POST['cla_sexo'])."',
                              dni      = '".$_POST['cla_dni']."',
                              cuit     = '".$_POST['cla_cuit']."',
                              fecnac   = '".$_POST['cla_fecnac']."',
                              funcion  = '".$_POST['cla_funcion']."',
                              filiacion= '".$_POST['cla_filiacion']."',
                              matricula= '".$_POST['cla_matricula']."',
                              perfil   = '".$_POST['cla_perfil']."'
              where legajo = '$legajo'";
mysql_query($sSQL);

insertolog($legajo, "M_Legajos2", "legajos", "update", "1999-12-01", $sSQL);

echo mensaje_ok('ABM_Legajos.php','OK');
  }

?>


