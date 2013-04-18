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


<HTML>
<HEAD>
<TITLE>principal.php</TITLE>
</HEAD>

<body style="background-color:<?echo $body_color?>">
<BODY>

<?php

$dir = (isset($_GET['dir']))?$_GET['dir']:"/";
$dir = " http://localhost:8888";
$directorio=opendir($dir);
echo "<b>Directorio actual: </b>$dir";
echo "<b>Archivos:</b><br>";
while ($archivo = readdir($directorio)) {
  if($archivo == '.')
    echo "";
//    echo "<a href=\"?dir=.\">$archivo</a><br>";
  elseif($archivo == '..'){
    if($dir != '.'){
      $carpetas = split("/",$dir);
      array_pop($carpetas);
      $dir2 = join("/",$carpetas);
      echo "<a href=\"?dir=$dir2\">$archivo</a><br>";
    }
  }
  elseif(is_dir("$dir/$archivo"))
      echo "<a href=\"?dir=$dir/$archivo\">$archivo</a><br>";
  else
   {
   echo "<a href=\"$archivo\" >$archivo</a><br>";
   }
}
closedir($directorio);
?>


</BODY>
</HTML>