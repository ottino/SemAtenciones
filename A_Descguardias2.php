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

$vengo = "";
$fechad = $_POST["cla_fecha2"];
$fechah = $_POST["cla_fecha1"];
$nombre = $_POST["cla_nombre"];
$idguardia1 = $_POST["cla_idguardia"];


$motivo = $_POST["motivo"];
$importe = $_POST["importe"];
$fecha = $_POST["cla_fecha"];
$legajomed = $_POST["cla_legajo"];

$hoy = date("Y/m/d");
$hora = date("H:i:s");
$actualiza = "DESCUENTO";


//Ejecucion de la sentencia SQL

 $sSQL="insert into descuentosliq (legajo,fecha,fechadesc,hora, motivo, autoriza, importe) values
         ('".$legajomed."','".$hoy."','".$fecha."','".$hora."','".strtoupper ($_POST['motivo'])."','".$G_legajo."','".$importe."')";
   mysql_query($sSQL);

 //echo $sSQL;

   insertolog($legajo, "A_Descguardia2", "descuentosliq", "insert", "1999-12-01", $sSQL);


   $pagina = 'ABM_Liqguardia.php?vengo='.$actualiza.'&vengo1='.$vengo.'&cla_fecha='.$fechad.'&cla_fecha1='.$fechah.'&cla_nombre='.$nombre.'&cla_idguardia='.$idguardia1;

   echo mensaje_ok($pagina,'OK');




?>

