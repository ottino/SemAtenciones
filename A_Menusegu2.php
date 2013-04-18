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

//Ejecucion de la sentencia SQL

$cla_pagina = $_POST["pagina"];
$cla_p1     = $_POST["cla_p1"];
$cla_p2     = $_POST["cla_p2"];
$cla_p3     = $_POST["cla_p3"];
$cla_p4     = $_POST["cla_p4"];
$cla_p5     = $_POST["cla_p5"];
$cla_p6     = $_POST["cla_p6"];
$cla_p7     = $_POST["cla_p7"];
$cla_p8     = $_POST["cla_p8"];
$cla_p9     = $_POST["cla_p9"];
$cla_p10    = $_POST["cla_p10"];
$cla_p11    = $_POST["cla_p11"];
$cla_p12    = $_POST["cla_p12"];
$cla_p13    = $_POST["cla_p13"];
$cla_p14    = $_POST["cla_p14"];
$cla_p15    = $_POST["cla_p15"];


$sSQL= "insert into segmenu (pagina, p1, p2, p3, p4, p5, p6, p7, p8, p9, p10, p11, p12, p13, p14, p15)
    VALUES ('".$cla_pagina."' ,'".$cla_p1."','".$cla_p2."','".$cla_p3."','".$cla_p4."','".$cla_p5."','".$cla_p6."',
            '".$cla_p7."','".$cla_p8."','".$cla_p9."','".$cla_p10."','".$cla_p11."','".$cla_p12."','".$cla_p13."',
            '".$cla_p14."','".$cla_p15."')";

mysql_query($sSQL);

insertolog($legajo, "A_Menusegu2.php", "segmenu", "insert", "1999-12-01", $sSQL);

echo mensaje_ok('ABM_Menusegu.php','OK');
//echo $sSQL;
?>
