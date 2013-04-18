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


$articulos = $_POST["artic"];
echo $_POST["artic"];
$articu = explode("-",$articulos);

$articulos = $articu[0];
$rubro    =  $articu[1];


//Ejecucion de la sentencia SQL

 $sSQL="insert into abmarticulos (idarticulo, rubro, fecha, idproveedor, cantidad, importe, idlegajo)
      values ('".$articulos."','".$rubro."','".$_POST['cla_fecha']."','".$_POST['provee']."',
              '".$_POST['cla_cantidad']."','".$_POST['cla_importe']."','".$G_usuario."')";
 //echo $sSQL;
 mysql_query($sSQL);

 insertolog($legajo, "A_Novarticulos2", "abmarticulos", "insert", "1999-12-01", $sSQL);

 $sSQL="update articulos set existencia = existencia + '".$_POST['cla_cantidad']."'
        where idarticulo = '".$articulos."' and rubro = '".$rubro."'";
 //echo $sSQL;
 mysql_query($sSQL);

 insertolog($legajo, "A_Novarticulos2", "articulos", "update", "1999-12-01", $sSQL);

 echo mensaje_ok('A_Novarticulos.php','OK');


?>
