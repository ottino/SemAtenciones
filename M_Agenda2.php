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

$datos = $_POST['datos'];

$acceso = '0';

if ($_POST['cla_acceso'] == 'PRIV')
  { $acceso = $G_legajo; }


$sSQL="update agenda set nombre         = '".strtoupper ($_POST['cla_nombre'])."',
                           direccion      = '".strtoupper ($_POST['cla_direccion'])."',
                           telfijo        = '".$_POST['cla_telfijo']."',
                           telfijo1       = '".$_POST['cla_telfijo1']."',
                           fax            = '".$_POST['cla_fax']."',
                           celular        = '".$_POST['cla_celular']."',
                           email          = '".$_POST['cla_email']."',
                           empresa        = '".strtoupper ($_POST['cla_empresa'])."',
                           etelfijo       = '".$_POST['cla_etelfijo']."',
                           etelfijo1      = '".$_POST['cla_etelfijo1']."',
                           efax           = '".$_POST['cla_efax']."',
                           eemail         = '".$_POST['cla_eemail']."',
                           cargo          = '".$_POST['cla_cargo']."',
                           acceso         = '".$acceso."'
              where id = $datos";

echo $sSQL;
mysql_query($sSQL);

insertolog($legajo, "M_Agenda2", "agenda", "update", "1999-12-01", $sSQL);

echo mensaje_ok('ABM_Agenda.php','OK');


?>


