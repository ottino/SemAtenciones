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


<?

$dire = '';
$dire = $_GET["directorio"];
$pagina = '';
if ($dire == '')
   listar_directorios_ruta("./");
  else
   listar_directorios_ruta($dire);



function listar_directorios_ruta($ruta){
   // abrir un directorio y listarlo recursivo
   if (is_dir($ruta)) {
      if ($dh = opendir($ruta)) {
         while (($file = readdir($dh)) !== false) {
            //esta línea la utilizaríamos si queremos listar todo lo que hay en el directorio
            //mostraría tanto archivos como directorios
            echo "<a href=$file target='_blank'>$file</a><br>";
            if ($file == '..')
             {
               $pagina = 'principal2.php?directorio='.$ruta.$file;
               echo "<br><a href='$pagina'>Directorio: $ruta</a><br>";
               $pagina = '';
            }

            //echo "<br>Nombre de archivo: $file : Es un: " . filetype($ruta . $file);
            if (is_dir($ruta . $file)&& $file!="." && $file!=".."){
               //solo si el archivo es un directorio, distinto que "." y ".."
               $pagina = 'principal2.php?directorio='.$ruta.$file;
               if ($file == '..')
                   $file = '';
               echo "<br><a href='$pagina'>Directorio: $ruta$file</a><br>";
               $pagina = '';
            }
         }
      closedir($dh);
      }
   }else
      echo "<br>No es ruta valida";
}



?>


</BODY>
</HTML>