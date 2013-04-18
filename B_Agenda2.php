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
?>

<body style="background-color:<?echo $body_color?>">

<?
echo titulo_encabezado ('' , $path_imagen_logo);
?>


<html>
<head>
    <script type="text/javascript">
function load()
 {
//  alert("alerta");
  window.location.href("ABM_Agenda.php");
 }
    </script>

 </head>
   <body onload="load()">

</BODY>
</HTML>

<?
$datos = $_POST['datos'];

//Creamos la sentencia SQL y la ejecutamos
$sSQL="Delete From agenda where id = ".$datos;

insertolog($legajo, "B_Agenda2", "agenda", "delete", "1999-12-01", $sSQL);

mysql_query($sSQL);
?>

