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

$idsegmenu = $_POST["pasmenu"];

 $sSQL= "update segmenu set   pagina   = '".$_POST['cla_pagina']."',
                              p1       = '".$_POST['cla_p1']."',
                              p2       = '".$_POST['cla_p2']."',
                              p3       = '".$_POST['cla_p3']."',
                              p4       = '".$_POST['cla_p4']."',
                              p5       = '".$_POST['cla_p5']."',
                              p6       = '".$_POST['cla_p6']."',
                              p7       = '".$_POST['cla_p7']."',
                              p8       = '".$_POST['cla_p8']."',
                              p9       = '".$_POST['cla_p9']."',
                              p10      = '".$_POST['cla_p10']."',
                              p11      = '".$_POST['cla_p11']."',
                              p12      = '".$_POST['cla_p12']."',
                              p13      = '".$_POST['cla_p13']."',
                              p14      = '".$_POST['cla_p14']."',
                              p15      = '".$_POST['cla_p15']."'
              where idsegmenu = '$idsegmenu'";
//echo $sSQL;
mysql_query($sSQL);

insertolog($legajo, "M_Menusegu2", "segmenu", "update", "1999-12-01", $sSQL);

echo mensaje_ok('ABM_Menusegu.php','OK');


?>


