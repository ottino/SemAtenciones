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
  window.location.href("ABM_Destinos.php");
 }
    </script>

 </head>
   <body onload="load()">

</BODY>
</HTML>

<?
//echo $_POST['dest'];
$destino = $_POST['dest'];


//Creamos la sentencia SQL y la ejecutamos
$sSQL="Delete From destino where iddestino = ".$destino;
//echo $sSQL;

insertolog($legajo, "B_Destinos2", "destino", "delete", "1999-12-01", $sSQL);

mysql_query($sSQL);
?>

