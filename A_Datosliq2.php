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


 $sSQL="insert into datosliq (tipmovil, tipmed, descripcion, fijo, anfijo, cnbase, impbase, animpbase, impexcedentes, impanulados,
        cnsimultaneos, impsimultaneos, animpexcede, azimpexcede, afdimpexcede, fecultact)
      values ('".$_POST['cla_tipmovil']."','".$_POST['cla_tipmedico']."','".strtoupper ($_POST['cla_descripcion'])."','".$_POST['cla_fijo']."',
              '".$_POST['cla_anfijo']."','".$_POST['cla_cnbase']."','".$_POST['cla_impbase']."','".$_POST['cla_animpbase']."',
              '".$_POST['cla_impexcedentes']."','".$_POST['cla_impanulados']."','".$_POST['cla_cnsimultaneos']."',
              '".$_POST['cla_impsimultaneos']."','".$_POST['cla_animpexcede']."','".$_POST['cla_azimpexcede']."','".$_POST['cla_afdimpexcede']."','".$hoy."')";

   echo $sSQL;
   mysql_query($sSQL);

   insertolog($legajo, "A_Datosliq2", "datosliq", "insert", "1999-12-01", $sSQL);

   echo mensaje_ok('ABM_Datosliq.php','OK');

?>
