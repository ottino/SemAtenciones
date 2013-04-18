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

$cla_codbarra = $_POST["cla_codbarra"];

$hoy   = date("Y-m-d");
$legajo = $G_legajo;


$comprobante = substr($cla_codbarra, 0, 10);


$sSQL="select * from comprobantes where idcomprob = ".$comprobante;
$result=mysql_query($sSQL);
$row=mysql_fetch_array($result);
//echo $row[nroafiliado];

if ($row[usuario] < 1)
 {
  $idcontrato = $row[idcontrato];
  $importe = $row[monto];
  $upp     = $row[periodo];
  $ySQL="update comprobantes set
         fecpago   = '".$hoy."',
         usuario   = '".$legajo."'
       where idcomprob = ".$comprobante;
   mysql_query($ySQL);

   insertolog($legajo, "A_Pagocuotas2.php", "comprobantes", "update", "1999-12-01", $ySQL);

  $jSQL="update contratos set
         deuda  = deuda - '".$importe."',
         upp    = '".$upp."'
       where idcontrato = ".$idcontrato;
  mysql_query($jSQL);

  insertolog($legajo, "A_Pagocuotas2.php", "comprobantes", "update", "1999-12-01", $jSQL);

  echo mensaje_ok('A_Pagocuotas.php','OK');
 }
 else
  mensaje_error ('A_Pagocuotas.php', 'Cuota ya pagada - Verifique!!!');

?>
