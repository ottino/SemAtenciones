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
?>

<HTML>
<HEAD>
                                    <!--       CALENDARIO    -->
 <!--Hoja de estilos del calendario -->
  <link rel="stylesheet" type="text/css" media="all" href="calendario/calendar-green.css" title="win2k-cold-1" />

  <!-- librería principal del calendario -->
 <script type="text/javascript" src="calendario/calendar.js"></script>

 <!-- librería para cargar el lenguaje deseado -->
  <script type="text/javascript" src="calendario/lang/calendar-es.js"></script>

  <!-- librería que declara la función Calendar.setup, que ayuda a generar un calendario en unas pocas líneas de código -->
  <script type="text/javascript" src="calendario/calendar-setup.js"></script>

  <!-- librería que declara la función Calendar.setup, que ayuda a generar un calendario en unas pocas líneas de código -->
  <script type="text/javascript" src="jsfunciones.js"></script>
  <!------------------------------------------------------------------------------------------------------->


<TITLE>UP_Mensajes.php</TITLE>
</HEAD>
<script>
</script>
<body style="background-color:<?echo $body_color?>">
<BODY>


<?

$idmensaje = $_POST["pasmensaje"];
$vengo     = $_POST["vengo"];

$vengo1 = substr($vengo,0,1);
$vengo2 = substr($vengo,1,1);

$marcamensaje = $_POST["marcamensaje"];

if ($vengo == '1B')
   $sSQL= "update mensajes set borrar = '1' where idmensaje = ".$idmensaje;
if ($vengo == '1A')
   $sSQL= "update mensajes set archivar = '1' where idmensaje = ".$idmensaje;

if ($vengo == '2R')
   $sSQL= "update mensajes set archivar = '', borrar = '' where idmensaje = ".$idmensaje;
if ($vengo == '2B')
   $sSQL= "update mensajes set archivar = '', borrar = '1' where idmensaje = ".$idmensaje;

if ($vengo == '3R')
   $sSQL= "update mensajes set archivar = '', borrar = '' where idmensaje = ".$idmensaje;
if ($vengo == '3B')
   $sSQL= "delete mensajes where idmensaje = ".$idmensaje;

echo $sSQL;

 mysql_query($sSQL);
 insertolog($legajo, "C_Mensajes.php", "mensajes", "update", "1999-12-01", $sSQL);

if ($vengo1 == '1')
    echo mensaje_ok('ABM_Mensajes.php','OK');
if ($vengo1 == '2')
    echo mensaje_ok('ABM_Mensajesarch.php','OK');
if ($vengo1 == '3')
    echo mensaje_ok('ABM_Mensajesbor.php','OK');



 ?>

