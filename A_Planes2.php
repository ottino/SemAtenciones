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

$cla_idplan        = $_POST["idplan"];
$cla_descplan      = $_POST["descplan"];
$cla_codigoplan    = $_POST["codigoplan"];
$cla_datos         = $_POST["datos"];
$cla_contacto      = $_POST["contacto"];
$cla_contacto1     = $_POST["contacto1"];
$cla_imp1          = $_POST["imp1"];
$cla_imp2          = $_POST["imp2"];
$cla_imp3          = $_POST["imp3"];
$cla_imp4          = $_POST["imp4"];
$cla_imp5          = $_POST["imp5"];
$cla_imp6          = $_POST["imp6"];
$cla_imp7          = $_POST["imp7"];
$cla_imp8          = $_POST["imp8"];
$cla_imp9          = $_POST["imp9"];
$cla_imp10         = $_POST["imp10"];
$cla_imp11         = $_POST["imp11"];
$cla_imp12         = $_POST["imp12"];
$cla_imp13         = $_POST["imp13"];
$cla_imp14         = $_POST["imp14"];
$cla_imp15         = $_POST["imp15"];
$cla_imp16         = $_POST["imp16"];
$cla_imp17         = $_POST["imp17"];
$cla_imp18         = $_POST["imp18"];
$cla_imp19         = $_POST["imp19"];
$cla_imp20         = $_POST["imp20"];
$cla_impcoseguro   = $_POST["impcoseguro"];
$cla_fecalta       = $_POST["cla_fecha"];
$cla_fecbaja       = $_POST["cla_fecha1"];
$cla_descabrev     = $_POST["descabrev"];
$cla_frecuencia    = $_POST["frecuencia"];
$cla_cnexcede      = $_POST["cla_cnexcede"];
$cla_impexcede     = $_POST["cla_impexcede"];


$sSQL= "insert into planes (idplan, descplan, codigoplan, datos, contacto, contacto1, imp1, imp2, imp3, imp4, imp5, imp6, imp7,
        imp8, imp9, imp10, imp11, imp12, imp13, imp14, imp15, imp16, imp17, imp18, imp19, imp20, prestauto,
        faccapitado, facprestacion, factraslado, faccontaus, impcoseguro, empresa, estado, fecalta, fecbaja,
        descabrev, upg, frecuencia,cnexcedentes, impexcedentes)
    VALUES ('".$cla_idplan."' , '".$cla_descplan."' , '".$cla_codigoplan."' , '".$cla_datos."' , '".$cla_contacto."' ,
            '".$cla_contacto1."' , '".$cla_imp1."' , '".$cla_imp2."' , '".$cla_imp3."' , '".$cla_imp4."' , '".$cla_imp5."' ,
            '".$cla_imp6."' , '".$cla_imp7."' , '".$cla_imp8."' , '".$cla_imp9."' , '".$cla_imp10."' , '".$cla_imp11."' ,
            '".$cla_imp12."' , '".$cla_imp13."' , '".$cla_imp14."' , '".$cla_imp15."' , '".$cla_imp16."' , '".$cla_imp17."' ,
            '".$cla_imp18."' , '".$cla_imp19."' , '".$cla_imp20."' , '".$cla_prestauto."' , '".$cla_faccapitado."' , '".$cla_facprestacion."' ,
            '".$cla_factraslado."' , '".$cla_faccontaus."' , '".$cla_impcoseguro."' , '".$cla_empresa."' , '".$cla_estado."' ,
            '".$cla_fecalta."' , '".$cla_fecbaja."' , '".$cla_descabrev."' , '".$cla_upg."' , '".$cla_frecuencia."', '".$cla_cnexcede."', '".$cla_impexcede."')";

//echo $sSQL;
mysql_query($sSQL);

insertolog($legajo, "A_Planes2.php", "planes", "insert", "1999-12-01", $sSQL);

echo mensaje_ok('ABM_Planes0.php','OK');

?>
