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

$ch_idmotivo = 0;
$ch_idmotivo2 = 0;

$v_idmotivo = is_numeric($_POST['idmotivo']);
if ($v_idmotivo <> true)
   $ch_idmotivo = 1;

$v_idmotivo2 = is_numeric($_POST['idmotivo2']);
if ($v_idmotivo2 <> true)
   $ch_idmotivo2 = 1;

if ($ch_idmotivo == 1)
  mensaje_error('A_Motivos.php','El ID Color no es numérico');
else
   if ($ch_idmotivo2 == 1)
  mensaje_error('A_Motivos.php','El ID Motivo no es numérico');
 else
 {
  $sSQL="insert into motivos (idmotivo,idmotivo2,`desc`,instrucciones) values
         ('".$_POST['idmotivo']."','".$_POST['idmotivo2']."','".strtoupper ($_POST['descripcion'])."','".strtoupper ($_POST['cla_instrucciones'])."')";
   mysql_query($sSQL);

   insertolog($legajo, "A_Motivos2", "motivos", "insert", "1999-12-01", $sSQL);

   echo mensaje_ok('ABM_Motivos.php','OK');
  }

?>


