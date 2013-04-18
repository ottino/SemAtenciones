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

$cla_legajo     = $_POST["legajo"];
$cla_asunto     = $_POST["cla_asunto"];
$cla_texto      = $_POST["cla_texto"];


$hoy = date("Y-m-d");
$hora = date("H:i:s");

  $sSQL="insert into mensajes (de, a, asunto, texto, envrec, fechae, horae)
      values ('".$G_legajo."','".$cla_legajo."','".$cla_asunto."','".$cla_texto."','E',
              '".$hoy."','".$hora."')";

 // echo $sSQL;
  mysql_query($sSQL);
  insertolog($legajo, "A_Enviomensaje2.php", "mensajes", "insert", "1999-12-01", $sSQL);

  echo mensaje_ok('ABM_Mensajes.php','OK');

?>
