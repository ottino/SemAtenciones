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
  window.location.href("ABM_Motivos.php");
 }
    </script>

 </head>
   <body onload="load()">

</BODY>
</HTML>

<?
//echo $_POST['desc'];
$vector_motivo = explode("-",$_POST['desc']);
$motivo1 = $vector_motivo[0];
$motivo2 = $vector_motivo[1];


//Creamos la sentencia SQL y la ejecutamos
//$sSQL="Delete From motivos Where nombre='$nombre'";
$sSQL="Delete From motivos where idmotivo = ".$motivo1." and idmotivo2 = ".$motivo2;
//echo $sSQL;
mysql_query($sSQL);

insertolog($legajo, "B_Motivos2.php", "motivos", "delete", "1999-12-01", $sSQL);

?>

