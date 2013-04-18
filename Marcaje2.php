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

################### Conexion a la base de datos##########################

$bd= mysql_connect($bd_host, $bd_user, $bd_pass);
mysql_select_db($bd_database, $bd);

//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@



//Ejecucion de la sentencia SQL

$legajo = $_POST['leg'];

$sSQL= "select * from legajos where legajo = ".$legajo;
$result=mysql_query($sSQL);

$resultado = mysql_fetch_array($result);

$contrasena = md5($_POST['cla']);

//echo $contrasena;


if ($resultado <> null)
{
  if ($resultado[clave] <> $contrasena)
    echo 'ERROR CLAVE';
   else
   {
    $cookie = new cookieClass;
    $cookie->parametros("usuario",$resultado['apeynomb']);
    $cookie->parametros("legajo",$resultado['legajo']);
    $cookie->parametros("perfil",$resultado['perfil']);
    $cookie->parametros("funcion",$resultado['funcion']);
    echo mensaje_ok('Marcaje3.php','OK');
   }
}
else
  echo mensaje_error('Marcaje.php','El usuario no existe');;


mysql_free_result($result);


?>


