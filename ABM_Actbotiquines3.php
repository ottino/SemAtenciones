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


echo 'Filas: '.$_POST['filas'].'<BR>';

for ($c =1; $c <= $_POST['filas']; $c++)
{
$carga = $_POST['cla_recarga'.-$c];
if ($carga == null)
   $carga = 0;

$vector_articulos = explode("-",$_POST['cla_articulo'.-$c]);
$articulo = $vector_articulos[0];
$rubro = $vector_articulos[1];

$botiq = $_POST['cla_botiquin'.-$c];

//echo 'Canti: '.$_POST['cla_recarga'.-$c].'&nbsp;';
//echo 'Botiq: '.$_POST['cla_botiquin'.-$c].'<BR>';

 $sSQL="update botiquines set
               cantidad = cantidad + ".$carga."
               where idbotiquines = ".$botiq;

 mysql_query($sSQL);

 $sSQL2="update articulos set
               existencia = existencia - ".$carga."
               where idarticulo = ".$articulo." and rubro = ".$rubro;
 mysql_query($sSQL2);
 insertolog($legajo, "ABM_Actbotiquines3.php", "articulos", "update", "1999-12-01", $sSQL);

echo mensaje_ok('ABM_Actbotiquines.php','OK');
//echo $sSQL.'<br>'.$sSQL2;

}

//print_r($_POST);
?>
