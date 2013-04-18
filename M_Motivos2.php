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

//echo $_POST['desc'];
$vector_motivo = explode("-",$_POST['desc']);
$motivo1 = $vector_motivo[0];
$motivo2 = $vector_motivo[1];

$ch_idmotivo = 0;
$ch_idmotivo2 = 0;

$v_idmotivo = is_numeric($motivo1);
if ($v_idmotivo <> true)
   $ch_idmotivo = 1;

$v_idmotivo2 = is_numeric($motivo2);
if ($v_idmotivo2 <> true)
   $ch_idmotivo2 = 1;

if ($ch_idmotivo == 1)
  mensaje_error('A_Motivos.php','El ID Color no es numérico');
else
   if ($ch_idmotivo2 == 1)
  mensaje_error('A_Motivos.php','El ID Motivo no es numérico');
 else
 {
    $vector_motivo = explode("-",$_POST['desc']);
    $motivo1 = $vector_motivo[0];
    $motivo2 = $vector_motivo[1];
    $desc = $_POST['desc'];
    $sSQL="Update motivos set `desc` ='".strtoupper ($_POST['clave'])."', instrucciones ='".strtoupper ($_POST['cla_instrucciones'])."' where idmotivo = ".$motivo1." and idmotivo2 = ".$motivo2;
    mysql_query($sSQL);

    insertolog($legajo, "M_Motivos2", "motivos", "update", "1999-12-01", $sSQL);

   echo mensaje_ok('ABM_Motivos.php','OK');
  }

?>


