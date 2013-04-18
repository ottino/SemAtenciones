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

$v_idmotivo = is_numeric($_POST['idmotivo']);
if ($v_idmotivo <> true)
   $ch_idmotivo = 1;

if ($ch_idmotivo == 1)
  mensaje_error('A_Motivos.php','El Codigo no es numérico');
else
 {
  $sSQL="insert into cjmotivos (cjmotcodigo,cjmotdesc) values
         ('".$_POST['idmotivo']."','".strtoupper ($_POST['descripcion'])."')";
   mysql_query($sSQL);

   insertolog($legajo, "A_Motctrlcaja2", "motivos", "insert", "1999-12-01", $sSQL);

   echo mensaje_ok('ABM_Motctrlcaja.php','OK');
  }

?>


