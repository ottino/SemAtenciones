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

 $hoy = date("Y-m-d");

$acceso = '0';

if ($_POST['cla_acceso'] == 'PRIV')
  { $acceso = $G_legajo; }


 $sSQL="insert into agenda (nombre, direccion, telfijo, telfijo1, fax, celular, email, empresa, etelfijo, etelfijo1,
        efax, eemail, cargo, acceso)
      values ('".strtoupper ($_POST['cla_nombre'])."','".strtoupper ($_POST['cla_direccion'])."','".$_POST['cla_telfijo']."',
              '".$_POST['cla_telfijo1']."','".$_POST['cla_fax']."','".$_POST['cla_celular']."','".$_POST['cla_email']."',
              '".$_POST['cla_empresa']."','".$_POST['cla_etelfijo']."','".$_POST['cla_etelfijo1']."','".$_POST['cla_efax']."',
              '".$_POST['cla_eemail']."','".$_POST['cla_cargo']."','".$acceso."')";

 //  echo $sSQL;
  mysql_query($sSQL);

  insertolog($legajo, "A_Agenda", "agenda", "insert", "1999-12-01", $sSQL);

  echo mensaje_ok('ABM_Agenda.php','OK');

?>
