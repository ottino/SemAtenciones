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

$guardia = $_POST['guar'];

$ch_legajos = 0;
$ch_dni = 0;
$ch_matricula = 0;

$fecingreso = $_POST['cla_fecingreso'];
$fecsalida = $_POST['cla_fecsalida'];
$horaingreso = $_POST['cla_horaingreso'];
$horasalida = $_POST['cla_horasalida'];

if ($fecingreso > $fecsalida)
{
  mensaje_error('ABM_Guardias.php','Fecha de ingreso mayor a salida');
  exit;
}

if ($fecingreso == $fecsalida)
  if ($horaingreso >= $horasalida)
{
  mensaje_error('ABM_Guardias.php','Error en fechas y horas');
  exit;
}

   $sSQL= "update guardias set fecingreso = '".$fecingreso."',
                               horaingreso= '".$horaingreso."',
                               fecsalida  = '".$fecsalida."',
                               horasalida = '".$horasalida."',
                               base       = '".$_POST['cla_bases']."'
              where idguardia = $guardia";
//echo $sSQL;
mysql_query($sSQL);

insertolog($legajo, "M_Guardias2", "guardias", "update", "1999-12-01", $sSQL);

echo mensaje_ok('ABM_Guardias.php','OK');


?>


