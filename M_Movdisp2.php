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

$moviles = $_POST['movdisp'];

if ($_POST['tipo'] < '1')
   {
      $errores = '1';
      $mensaje = "No ingresó tipo de guardia - ";
    }

if ($_POST['base'] == '0')
   {
      $errores = '1';
      $mensaje = $mensaje."No ingresó la base - ";
    }

if ($_POST['tipo'] == '2' && $_POST['movil'] > '12')
   {
      $errores = '2';
      $mensaje = $mensaje."No concuerda movil con tipo de guardia - ";
    }

if ($_POST['tipo'] != '2' && $_POST['movil'] < '13')
   {
      $errores = '3';
      $mensaje = $mensaje."No concuerda movil con tipo de guardia - ";
    }

if ($errores > '0')
  mensaje_error('ABM_Movdisp.php', $mensaje);
 else
 {

   $sSQL="update movildisponible set idmovil ='".$_POST['movil']."',
                                  idbase  ='".$_POST['base']."',
                                  tipoguardia = '".$_POST['tipo']."',
                                  legchofer ='".$_POST['legajoc']."',
                                  legmedico ='".$_POST['legajo']."',
                                  legenfermero ='".$_POST['legajoe']."',
                                  kmalta       ='".$_POST['cla_kmalta']."'
              where idmovildisp = $moviles";
 //echo $sSQL;
 mysql_query($sSQL);
 insertolog($legajo, "M_Movdisp2", "movildisponible", "update", "1999-12-01", $sSQL);
 echo mensaje_ok('ABM_Movdisp.php','OK');
 }

?>


