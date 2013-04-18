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
require_once("cookie.php");
require_once("config.php");
$cookie = new cookieClass;
$G_usuario = $cookie->get("usuario");
$G_legajo  = $cookie->get("legajo");
$G_perfil  = $cookie->get("perfil");
################### Conexion a la base de datos##########################

$bd= mysql_connect($bd_host, $bd_user, $bd_pass);
mysql_select_db($bd_database, $bd);

//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@

//Ejecucion de la sentencia SQL

$ch_iddestino = 0;
$ch_tipo = 0;

$v_iddestino = is_numeric($_POST['cla_iddestino']);
if ($v_iddestino <> true)
   $ch_iddestino = 1;

//echo $ch_iddestino;

$v_tipo = is_numeric($_POST['cla_tipo']);
if ($v_tipo <> true)
   $ch_tipo = 1;

//echo $ch_iddestino;

if ($ch_iddestino == 1)
  mensaje_error('A_Destinos.php','El iddestino no es numérico');
else
   if ($ch_tipo == 1)
  mensaje_error('A_Destinos.php','El tipo no es numérico');
 else
 {
   $sSQL="insert into destino (iddestino, destino, domicilio, localidad, telefono, tipo)
      values ('".$_POST['cla_iddestino']."','".strtoupper ($_POST['cla_destino'])."',
              '".strtoupper ($_POST['cla_domicilio'])."','".strtoupper ($_POST['cla_localidad'])."',
              '".strtoupper ($_POST['cla_telefono'])."','".$_POST['cla_tipo']."')";
    mysql_query($sSQL);

   insertolog($legajo, "A_Destinos2", "destino", "insert", "1999-12-01", $sSQL);

   echo mensaje_ok('ABM_Destinos.php','OK');
  }

?>
