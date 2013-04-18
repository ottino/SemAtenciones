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
  window.location.href("ABM_Motctrlcaja.php");
 }
    </script>

 </head>
   <body onload="load()">

</BODY>
</HTML>

<?
//echo $_POST['desc'];
$motivos = $_POST['desc'];

//Creamos la sentencia SQL y la ejecutamos
//$sSQL="Delete From motivos Where nombre='$nombre'";
$sSQL="Delete From cjmotivos where cjmotid = ".$motivos;
//echo $sSQL;
mysql_query($sSQL);

insertolog($legajo, "B_Motctrlcaja2.php", "cjmotivos", "delete", "1999-12-01", $sSQL);

?>

