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

$movdisp = $_POST["pasmovildisp"];
$vengo = $_POST["vengo"];
$fechad = $_POST["cla_fecha"];
$fechah = $_POST["cla_fecha1"];
$nombre = $_POST["cla_nombre"];
$idguardia = $_POST["cla_idguardia"];
$update = $_POST["update"];
$revisado = "S";


   $sSQL= "update movildisponible set revisado = '".$revisado."'
              where idmovildisp = '".$movdisp."'";
//echo $sSQL;
mysql_query($sSQL);

insertolog($legajo, "M_Liqguardias3", "movildisponible", "update", "1999-12-01", $sSQL);


//$cookie->parametros("datoliq",$idguardia);

$mensaje = "ABM_Liqguardia1.php?pasdatos=$movdisp&vengo=$vengo&cla_fecha=$fechad&cla_fecha1=$fechah&cla_nombre=$nombre&cla_idguardia=$idguardia1";
//echo $mensaje;
echo mensaje_ok($mensaje,'OK');


?>


