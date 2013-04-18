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

$cla_idcliente = $_POST["cla_idcliente"];

$sSQL="select * from clientes WHERE idcliente = ".$cla_idcliente;
$result=mysql_query($sSQL);
$row=mysql_fetch_array($result);

$cla_nrocontrato = $_POST["cla_nrocontrato"];
$cla_nroafiliado = $row["nroafiliado"];
$cla_idplan      = $_POST["cla_idplan"];
$cla_frecuencia  = $_POST["cla_frecuencia"];
$cla_nrotarjeta  = $_POST["cla_nrotarjeta"];
$cla_fecalta     = $_POST["cla_fecha"];
$cla_fecvto      = $_POST["cla_fecha1"];


if (substr($cla_fecalta,2,1) == "/")
    $cla_fecalta = cambiarFormatoFecha2($cla_fecalta);

if (substr($cla_fecvto,2,1) == "/")
    $cla_fecvto = cambiarFormatoFecha2($cla_fecvto);

$cla_importe     = $_POST["cla_importe"];
$cla_ordenmax    = $_POST["cla_ordenmax"];
$cla_tipocomprob = $_POST["cla_tipocomprob"];

$cla_nroafiliado     = $row["nroafiliado"];
$cla_nombre          = $row["nombre"];
$cla_documento       = $row["documento"];
$cla_fnacimiento     = $row["fnacimiento"];
$cla_sexo            = $row["sexo"];
$cla_identificacion  = $row["documento"];


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
$cla_idtipoplan      = $_POST["cla_idtipoplan"];


$cla_ordenmax = '0';
$cla_estado = 'A';

$sSQL= "insert into contratos (idcontrato, idcliente, nroafiliado, idplan, frecuencia, fecalta, fecvto, importe, ordenmax,
        tipocomprob,estado, codcobrador, callecob,nrocallecob,entre1cob,entre2cob,pisocob,deptocob,barriocob,
        idzonacob,localidadcob,cpostalcob, provinciacob,telefonocob,observaciones,tipocontrato,nrotarjeta)
    VALUES ('".$cla_nrocontrato."' ,'".$cla_idcliente."' , '".$cla_nroafiliado."', '".$cla_idplan."' , '".$cla_frecuencia."' , '".$cla_fecalta."' , '".$cla_fecvto."' , '".$cla_importe."' ,
             '".$cla_ordenmax."' , '".$cla_tipocomprob."', '".$cla_estado."' , '".$cla_cobrador."'   , '".$cla_calle."'   ,
             '".$cla_numero."'   , '".$cla_entre1."'     , '".$cla_entre2."' , '".$cla_piso."'       , '".$cla_depto."'   , '".$cla_barrio."',
             '".$cla_zona."'     , '".$cla_localidad."'  , '".$cla_cpostal."'  , '".$cla_provincia."'  , '".$cla_telefono."', '".$cla_observaciones."', '".$cla_idtipoplan."', '".$cla_nrotarjeta."')";
//echo $sSQL;
mysql_query($sSQL);

insertolog($legajo, "A_Contratos2", "contratos", "insert", "1999-12-01", $jSQL);

echo mensaje_ok('ABM_Contratos0.php','OK');

//$res=mysql_query("SELECT MAX(idcontrato) as maximo FROM contratos");
//$rowr=mysql_fetch_array($res);
//$idcontrato = $rowr["maximo"];
//$sSQL= "insert into padron (idcontrato, idpadron, nombre, socio, plan, integrante, fnacimiento, sexo, identificacion, documento,calle, numero,
//                            piso, depto, barrio, localidad, provincia)
//    VALUES ('".$idcontrato."' ,'".$cla_documento."' ,'".$cla_nombre."', '".$cla_nroafiliado."' , '".$cla_idplan."' , '".$cla_ordenmax."' , '".$cla_fnacimiento."' ,
//            '".$cla_sexo."' , '".$cla_nroafiliado."' , '".$cla_documento."','".$cla_calle."',
//            '".$cla_numero."' ,'".$cla_piso."' ,'".$cla_depto."' ,'".$cla_barrio."' ,'".$cla_localidad."' ,'".$cla_provincia."')";
//mysql_query($sSQL);


?>
