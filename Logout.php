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
################### Conexion a la base de datos##########################

$bd= mysql_connect($bd_host, $bd_user, $bd_pass);
mysql_select_db($bd_database, $bd);

//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@

require_once("cookie.php");

insertolog($legajo, "Logout.php", "logout", "logout", "1999-12-01", "logout");


//Ejecucion de la sentencia SQL


    $cookie = new cookieClass;
    $cookie->borrar_cookie("usuario");
    $cookie->borrar_cookie("apeynomb");
    $cookie->borrar_cookie("legajo");
    $cookie->borrar_cookie("perfil");
    $cookie->borrar_cookie("funcion");


    echo mensaje_ok('index.php','OK');


?>


