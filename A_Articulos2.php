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

 $sSQL="insert into articulos (idarticulo, articulo, rubro, cncritica)
      values ('".$_POST['cla_idarticulo']."','".strtoupper ($_POST['cla_desarticulo'])."',
              '".$_POST['rubros']."','".$_POST['cla_cncritica']."')";
// echo $sSQL;
   mysql_query($sSQL);

   insertolog($legajo, "A_Articulos2", "articulos", "insert", "1999-12-01", $sSQL);

   echo mensaje_ok('ABM_Articulos.php','OK');


?>
