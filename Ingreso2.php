<?
session_start();
######################INCLUDES################################
//archivo de configuracion
include_once ('config.php');

//funciones propias
include ('funciones.php');

//inclu�mos la clase ajax
require ('xajax/xajax.inc.php');
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@

require_once("cookie.php");

################### Conexion a la base de datos##########################

$bd= mysql_connect($bd_host, $bd_user, $bd_pass);
mysql_select_db($bd_database, $bd);

//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@



//Ejecucion de la sentencia SQL

$legajo = $_POST['leg'];
$contrasena = $_POST['cla'];

$sSQL= "select * from legajos where legajo = ".$legajo;
$result=mysql_query($sSQL);


//$contrasena=crypt($_POST['cla'], $semilla);

//echo $contrasena;


if ($result)
{
  $resultado = mysql_fetch_array($result);
  
  if ($resultado['clave'] <> $contrasena)
    echo mensaje_error('index.php','Usuario y clave incorrectos');
   else
   {
    $cookie = new cookieClass;
    $cookie->parametros("usuario",$resultado['apeynomb']);
    $cookie->parametros("legajo",$resultado['legajo']);
    $cookie->parametros("perfil",$resultado['perfil']);
    $cookie->parametros("funcion",$resultado['funcion']);
    $cookie->parametros("nick",$resultado['nick']);
    echo mensaje_ok('Principal.php',"OK");
   }
   
   mysql_free_result($result);
}
else
    echo mensaje_error('index.php','Usuario y clave incorrectos');

?>


