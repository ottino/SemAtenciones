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

$idcontrato = $_POST["pasacont"];
$cla_idcliente  = $_POST["cla_idcliente"];
$cla_idcliente1 = $_POST["cla_idcliente1"];
$cla_idcliente2 = $_POST["cla_idcliente2"];
$cla_idcliente3 = $_POST["cla_idcliente3"];
$cla_idcliente4 = $_POST["cla_idcliente4"];
$cla_idcliente5 = $_POST["cla_idcliente5"];
$cla_idcliente6 = $_POST["cla_idcliente6"];
$cla_idcliente7 = $_POST["cla_idcliente7"];
$cla_idcliente8 = $_POST["cla_idcliente8"];
$cla_idcliente9 = $_POST["cla_idcliente9"];
$cla_idcliente10= $_POST["cla_idcliente10"];
$cla_idcliente11= $_POST["cla_idcliente11"];
$cla_idcliente12= $_POST["cla_idcliente12"];

$cla_nrotarjeta  = $_POST["cla_nrotarjeta"];
$cla_idplan      = $_POST["cla_idplan"];
$cla_frecuencia  = $_POST["cla_frecuencia"];
$cla_fecalta     = $_POST["cla_fecha"];
$cla_fecvto      = $_POST["cla_fecha1"];
$cla_importe     = $_POST["cla_importe"];
$cla_ordenmax    = $_POST["cla_ordenmax"];
$cla_tipocomprob = $_POST["cla_tipocomprob"];
$cla_tipoplan    = $_POST["cla_idtipoplan"];
$cla_calle           = $_POST["cla_calle"];
$cla_numero          = $_POST["cla_nrocalle"];
$cla_entre1          = $_POST["cla_entre1"];
$cla_entre2          = $_POST["cla_entre2"];
$cla_piso            = $_POST["cla_piso"];
$cla_depto           = $_POST["cla_depto"];
$cla_barrio          = $_POST["cla_barrio"];
$cla_localidad       = $_POST["cla_localidad"];
$cla_cpostal         = $_POST["cla_cpostal"];
$cla_zona            = $_POST["cla_zona"];
$cla_provincia       = $_POST["cla_provincia"];
$cla_observaciones   = $_POST["cla_observaciones"];
$cla_cobrador        = $_POST["cla_cobrador"];
$cla_telefono        = $_POST["cla_telefono"];




   $sSQL= "update contratos set idplan    = '".$cla_idplan."',
                            frecuencia    = '".$cla_frecuencia."',
                            fecalta       = '".$cla_fecalta."',
                            fecvto        = '".$cla_fecvto."',
                            importe       = '".$cla_importe."',
                            tipocomprob   = '".$cla_tipocomprob."',
                            codcobrador   = '".$cla_cobrador."',
                            callecob      = '".$cla_calle."',
                            nrocallecob   = '".$cla_numero."',
                            entre1cob     = '".$cla_entre1."',
                            entre2cob     = '".$cla_entre2."',
                            pisocob       = '".$cla_piso."',
                            deptocob      = '".$cla_depto."',
                            barriocob     = '".$cla_barrio."',
                            localidadcob  = '".$cla_localidad."',
                            cpostalcob    = '".$cla_cpostal."',
                            idzonacob     = '".$cla_zona."',
                            provinciacob  = '".$cla_provincia."',
                            telefonocob   = '".$cla_telefono."',
                            tipocontrato  = '".$cla_tipoplan."',
                            nrotarjeta    = '".$cla_nrotarjeta."',
                            observaciones = '".$cla_observaciones."'
              where idcontrato = '$idcontrato'";

//echo $sSQL;
mysql_query($sSQL);

insertolog($legajo, "M_Contratos2", "contratos", "update", "1999-12-01", $sSQL);

echo mensaje_ok('ABM_Contratos0.php','OK');

?>
