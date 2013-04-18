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

$ch_iddestino = 0;
$ch_tipo = 0;

$v_idmovil = is_numeric($_POST['cla_idmovil']);
if ($v_idmovil <> true)
   $ch_idmovil = 1;


if ($ch_idmovil == 1)
  mensaje_error('A_Moviles.php','El Id Movil no es numérico');
 else
 {
   $sSQL="insert into moviles (idmovil, descmovil, dominio, marca, modelo, nromotor, nrochasis, fectransf, observaciones, codperfil,estado)
      values ('".$_POST['cla_idmovil']."','".strtoupper ($_POST['cla_descmovil'])."',
              '".strtoupper ($_POST['cla_dominio'])."','".strtoupper ($_POST['cla_marca'])."',
              '".$_POST['cla_modelo']."','".strtoupper ($_POST['cla_nromotor'])."',
              '".strtoupper ($_POST['cla_nrochasis'])."', '".$_POST['cla_fecnac']."','".strtoupper ($_POST['cla_observaciones'])."',
              '".$_POST['cla_codperfil']."',0)";
   mysql_query($sSQL);

   insertolog($legajo, "A_Moviles2", "moviles", "insert", "1999-12-01", $sSQL);

   echo mensaje_ok('ABM_Moviles.php','OK');
  }

?>
