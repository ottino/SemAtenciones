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

$clave_a = md5($_POST['cla_clave']);
$clave_1 = md5($_POST['cla_clave1']);
$clave_2 = md5($_POST['cla_clave2']);

//$clave_a=crypt($_POST['cla_clave'], $semilla);
//$clave_1=crypt($_POST['cla_clave1'], $semilla);
//$clave_2=crypt($_POST['cla_clave2'], $semilla);

$ch_clave = 0;

$sSQL="SELECT * FROM legajos WHERE legajo = ".$legajo;
//echo $sSQL;
$result=mysql_query($sSQL);
while ($row=mysql_fetch_array($result))
{
$clave_control.= $row['clave'];
}

if ($clave_control <> $clave_a)
   $ch_clave = 1;

if ($clave_1 <> $clave_2)
   $ch_clave = 2;

if ($ch_clave == 1)
{  mensaje_error('Cambio_clave.php','Clave Anterior incorrecta');
  exit; }
  else
   if ($ch_clave == 2)
{  mensaje_error('Cambio_clave.php','Difieren las claves nuevas');
   exit; }
 else
   $sSQL= "update legajos set clave = '".$clave_1."' where legajo = ".$legajo;


mysql_query($sSQL);

insertolog($legajo, "Cambio_clave2", "legajos", "update", "1999-12-01", $sSQL);

echo mensaje_ok('Cambio_clave.php','OK');
?>
