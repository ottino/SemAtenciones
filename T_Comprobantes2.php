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
require_once("cookie.php");
require_once("config.php");
$cookie = new cookieClass;
$G_usuario = $cookie->get("usuario");
$G_legajo  = $cookie->get("legajo");
$G_perfil  = $cookie->get("perfil");

################### Conexion a la base de datos##########################

$bd= mysql_connect($bd_host, $bd_user, $bd_pass);
mysql_select_db($bd_database, $bd);

//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@

//Ejecucion de la sentencia SQL

$cla_periodo = $_POST["cla_periodo"];
$fechavto    = $_POST["cla_fechavto"];
$leyenda     = $_POST["cla_leyenda"];
$leyenda1    = $_POST["cla_leyenda1"];
$legajo      = $G_legajo;


$sSQL="select * from ctrlcupones where ultid in (select max(ultid) from ctrlcupones)";
$result=mysql_query($sSQL);
$row=mysql_fetch_array($result);

$comprobante = $row[ultid];

$sSQL="select * from contratos where estado = 'A' order by 1";
$result=mysql_query($sSQL);
while ($row=mysql_fetch_array($result))
{
  $det = determinocuota($cla_periodo, $row[upg], $row[frecuencia]);

  if ($det == '0')
  {}
  else
  {
   $plan = $row[idplan];
   $idcontrato = $row[idcontrato];
   $nroafiliado = $row[nroafiliado];
   $ordenmax = $row[ordenmax];
   $tipocomprob = $row[tipocomprob];
   $cobrador = $row[codcobrador];
   $importe  = $row[importe];

   $ySQL = "select * from planes where idplan = ".$plan;
   $yresult = mysql_query($ySQL);
   $yrow=mysql_fetch_array($yresult);
   $comprobante = $comprobante + 1;
   $comprobante = str_pad($comprobante, 10, "0", STR_PAD_LEFT);
 if ($importe < '1')
    if ($ordenmax < 1)
       $importe = $yrow[imp1];
      else
    if ($ordenmax == 1)
       $importe = $yrow[imp2];
      else
     if ($ordenmax == 2)
       $importe = $yrow[imp3];
        else
     if ($ordenmax == 3)
       $importe = $yrow[imp4];
        else
     if ($ordenmax == 4)
       $importe = $yrow[imp5];
        else
     if ($ordenmax == 5)
       $importe = $yrow[imp6];
        else
     if ($ordenmax == 6)
       $importe = $yrow[imp7];
        else
     if ($ordenmax == 7)
       $importe = $yrow[imp8];
        else
     if ($ordenmax == 8)
       $importe = $yrow[imp9];
        else
     if ($ordenmax == 9)
       $importe = $yrow[imp10];
        else
     if ($ordenmax == 10)
       $importe = $yrow[imp11];
        else
     if ($ordenmax == 11)
       $importe = $yrow[imp12];
        else
     if ($ordenmax == 12)
       $importe = $yrow[imp13];
        else
     if ($ordenmax == 13)
       $importe = $yrow[imp14];
        else
     if ($ordenmax == 14)
       $importe = $yrow[imp15];
        else
     if ($ordenmax == 15)
       $importe = $yrow[imp16];
        else
     if ($ordenmax == 16)
       $importe = $yrow[imp17];
        else
     if ($ordenmax == 17)
       $importe = $yrow[imp18];
        else
     if ($ordenmax == 18)
       $importe = $yrow[imp19];
        else
     if ($ordenmax == 19)
       $importe = $yrow[imp20];
        else
     if ($ordenmax > 19)
       $importe = $yrow[imp20];


   $importe2 = $importe * 100;
   $importe1 = $importe;
   $importe2 = str_pad($importe2, 10, "0", STR_PAD_LEFT);
   $codbarra = $comprobante;

   $uSQL= "insert into comprobantes (idcomprob, idcontrato, nroafiliado, periodo, monto, codbarras, fechavto, ordenmax,
        tipocomprob,cobrador,idplan,leyenda,leyenda1)
    VALUES ('".$comprobante."' , '".$idcontrato."', '".$nroafiliado."' , '".$cla_periodo."' , '".$importe1."' ,
             '".$codbarra."' , '".$fechavto."', '".$ordenmax."' , '".$tipocomprob."', '".$cobrador."', '".$plan."', '".$leyenda."', '".$leyenda1."')";
   mysql_query($uSQL);

  insertolog($legajo, "A_Comprobantes2", "comprobantes", "insert", "1999-12-01", $uSQL);

   $jSQL="update contratos set
       upg    = '".$cla_periodo."',
       deuda  = deuda + '".$importe1."'
     where idcontrato = ".$idcontrato;
   mysql_query($jSQL);

  insertolog($legajo, "A_Comprobantes2", "contratos", "update", "1999-12-01", $jSQL);

  }
}

   $hoy   = date("Y-m-d");
   $legajo = $G_legajo;

   $pSQL="update ctrlcupones set
       ultid    = '".$comprobante."',
       fecha    = '".$hoy."',
       estado   = 'OK',
       usuario  = '".$legajo."'
     where periodo = ".$cla_periodo;
 //  echo $pSQL;
     mysql_query($pSQL);

    insertolog($legajo, "A_Comprobantes2", "ctrlcupones", "update", "1999-12-01", $jSQL);

    echo mensaje_ok('A_Comprobantes.php','OK');


?>
