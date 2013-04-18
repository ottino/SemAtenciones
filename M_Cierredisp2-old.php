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
?>


<HTML>
<HEAD>
<TITLE>M_Cierredisp2.php</TITLE>

</HEAD>

<body style="background-color:<?echo $body_color?>" style="font-size:<?echo $font?>">
<BODY>

<FORM METHOD="POST" NAME="formulario3"
ACTION="M_Cierredisp2.php">

<?

$vengo = $_POST["vengo"];
$fechad = $_POST["cla_fecha"];
$fechah = $_POST["cla_fecha1"];
$nombre = $_POST["cla_nombre"];
$idguardia1 = $_POST["cla_idguardia"];

if ($_POST["update"] == 1)
{
echo titulo_encabezado ('Cierre de Guardia' , $path_imagen_logo);
}
else
{
  echo titulo_encabezado ('Guardias Cerradas' , $path_imagen_logo);
}
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }
$font = '12px';

list($pagina, $pasdatos) = explode("?", $_SERVER['HTTP_REFERER']);

if ($_POST["update"] == 1)
{
  $movdisp = $_POST["movdisp"];
}
else
{
  $movdisp = $_POST["pasmovildisp"];
}

////////////////////////////////

//Creamos la sentencia SQL y la ejecutamos

if ($_POST["update"] == 1)
{
   $retiene = $_POST["cla_retiene"];
   $coseguros = $_POST["cla_coseguros"];

   if ($coseguros < $retiene)
      { mensaje_error('ABM_Movdisp.php','No puede retener más de lo cobrado');
        return;
        }
   $kmbaja = $_POST["cla_kmbaja"];
   $hoy = date("Y-m-d");
   $hora = date("H:i:s");
   $sSQL="update movildisponible set
       horabaja = '".$hora."',
       fecbaja  = '".$hoy."',
       kmbaja = '".$kmbaja."',
       vigente = '1',
       retiene = '".$retiene."',
       coseguros = '".$coseguros."'
     where idmovildisp = ".$movdisp;
   $result=mysql_query($sSQL);
   insertolog($legajo, "M_Cierredisp2", "movildisponible", "update", "1999-12-01", $sSQL);

}


$sSQL="select * from movildisponible a, legajos b, bases c, moviles d where
       a.legchofer = b.legajo and a.idbase = c.idbases and a.idmovil = d.idmovil and idmovildisp = ".$movdisp;
$result=mysql_query($sSQL);
$row=mysql_fetch_array($result);

$hoy = date("Y-m-d");
$hora = date("H:i:s");
$idguardia = $row['idmovildisp'];
$tipoguardia = $row['tipoguardia'];
$chofer = $row['apeynomb'];
$legmedico = $row['legmedico'];
$base = $row['descbases'];
$movil = $row['idmovil'].' - '.$row['descmovil'];
$fecalta = cambiarFormatoFecha($row['fecalta']);
$fecalta1 = $row['fecalta'];
$horaalta = cambiarFormatoHora($row['horaalta']);
$horaalta1 = $row['horaalta'];
$fecbaja = cambiarFormatoFecha($row['fecbaja']);
$horabaja = cambiarFormatoHora($row['horabaja']);
$fecbaja1 = $row['fecbaja'];
$horabaja1 = $row['horabaja'];
$retiene = $row['retiene'];
$kmbaja = $row['kmbaja'];
$tipomovil = $row['codperfil'];


$difhorag = calcular_horas($fecbaja1,$horabaja1,$fecalta1,$horaalta1);

$difhorag = $difhorag / 60;

list($dia,$mes,$ano)=explode("/",$fecalta);

$numerodiasemana = date('w', mktime(0,0,0,$mes,$dia,$ano));

$finde = '0';

if ($numerodiasemana == '0')
  { $finde = '1';}

list($hor,$min,$seg)=explode(":",$horaalta1);

if ($numerodiasemana == '6')
  if ($hor > '17')
     { $finde = '1';}

$sSQL="select * from movildisponible a, legajos b where
       a.legmedico = b.legajo and idmovildisp = ".$movdisp;
$result=mysql_query($sSQL);
$row=mysql_fetch_array($result);
$medico = $row['apeynomb'];
$tipomedico = $row['funcion'];


$enfermero = buscopersonal($row['legenfermero']);

//$sSQL="select * from movildisponible a, legajos b where
//       a.legenfermero = b.legajo and idmovildisp = ".$movdisp;
//$result=mysql_query($sSQL);
//$row=mysql_fetch_array($result);
//$enfermero = $row['apeynomb'];

?>
<table width="100%">
<tr><td><table width="100%" border="1" align="left" style="font-size:<?echo $fontdef?>">
  <tr>
    <td width="100%" rowspan="3" valign="top">
      <table style="font-size:<?echo $fontreg?>" border = 1 cellspacing="5" width="100%" cellpadding="5" align="left" style="background-color:<?echo $th_color?>;border-left-width: 0; border-top-width: 0; border-bottom-width: 0" style="font-size:<?echo $font?>">
          <tr style="font-size:<?echo $fontt?>">
            <th>GUARDIA</th>
            <th>CHOFER</th>
            <th>MEDICO</th>
            <th>ENFERMERO</th>
            <th>BASE</th>
            <th>MOVIL</th>
            <th>INGRESO</th>
            <th>EGRESO</th>
        </td>

<?

echo '<tr><td align="left" style="font-size:18px">'.$idguardia.'</td>';
echo '<td align="left" style="font-size:18px">'.$chofer.'&nbsp;</td>';
echo '<td align="left">'.$medico.'&nbsp;</td>';
echo '<td align="left">'.$enfermero.'&nbsp;</td>';
echo '<td align="left">'.$base.'&nbsp;</td>';
echo '<td align="left">'.$movil.'&nbsp;</td>';
echo '<td align="left">'.$fecalta.' - '.$horaalta.'&nbsp;</td>';
echo '<td align="left">'.$fecbaja.' - '.$horabaja.'&nbsp;</td>';


echo '<td><a href="'.$pagina.'?pasdatos='.$movdisp.'&vengo='.$vengo.'&cla_fecha='.$fechad.'&cla_fecha1='.$fechah.'&cla_nombre='.$nombre.'&cla_idguardia='.$idguardia1.'"</a> <img border="0" src="imagenes/Volver.ico" width="30" height="30"  align="top" /></td></tr>';
echo '</table></table></td></tr>' ;

$sSQL="select * from atenciones a left join destino c on a.destino = c.iddestino
                                  left join zonas d   on a.zona = d.idzonas
                where movil_2 = ".$movdisp." order by id";

$result=mysql_query($sSQL);

$c = 0;
$coseguros = 0;

?>
<tr><td><table width="100%" border="1" style="font-size:<?echo $fontreg?>">
  <tr>
    <td><INPUT TYPE="BUTTON" value="Imprimir" ALIGN ="left" onclick ="window.print()"></td></tr><tr>
    <td width="100%" rowspan="3" valign="top">
      <table style="font-size:<?echo $fontreg?>" border = 1 cellspacing="5" width="100%" cellpadding="5" align="left" style="background-color:<?echo $th_color?>;border-left-width: 0; border-top-width: 0; border-bottom-width: 0" style="font-size:<?echo $font?>">
          <tr style="font-size:<?echo $fontt?>">
            <th>ID</th>
            <th>F / H</th>
            <th>NOMBRE</th>
            <th>E</th>
            <th>S</th>
            <th>LOC.</th>
            <th>COL</th>
            <th>AN</th>
            <th>DIAGNOSTICO</th>
            <th>PLAN</th>
            <th>COS.</th>
            <th>RECIBO</th>
        </td>

<?
//Mostramos los registros
$c = 0;
$secuencia = 0;
$anulados = 0;

while ($row=mysql_fetch_array($result))
{

$secuencia++;
$motanulacion = $row["motanulacion"];
if ($motanulacion < 1)
{
   $coseguros = $coseguros + $row['impcoseguro'];
   $c++;
} else
{
   $anulados++;
}

$fecha = cambiarFormatoFecha($row['fecha']);

$id = $row["id"] + 0;

$fechallam = $row["fecha"];
$horallegdom = $row["horallegdom"];
$horasaldom = $row["horasaldom"];
$motivo1 = $row["motivo1"];
$motivo2 = $row["motivo2"];
$color1 = $row["color"];

$dif = calcular_tiempo($horasaldom,$horallegdom);

$difhora = round($dif / 60);

$sigo = 'S';

$horaver = cambiarFormatoHora($row['horallegdom']);
$motivo = buscomotivo($motivo1,$motivo2);
$color = substr(buscocolor($color1),0,1);
$diagnostico = substr(buscodiagnostico($row["diagnostico"]),0,22);
$plan = substr(buscoplan($row["plan"]),0,10);

echo '<tr><td align="center"  style="width:40px">'.$id.'</td>';
echo '<td align="center" style="width:70px">'.substr($fecha,0,5).'-'.$horaver.'</td>';
echo '<td align="left" style="width:200px">'.substr($row["nombre"],0,18).'</td>';
echo '<td align="center" style="width:30px">'.$row["edad"].'</td>';
echo '<td align="center" style="width:30px">'.$row["sexo"].'</td>';
echo '<td align="center"  style="width:100px">'.$row["desczonas"].'</td>';
echo '<td align="center" style="width:40px">'.$color.'</td>';
echo '<td align="center" style="width:30px">'.$row["motanulacion"].'</td>';
echo '<td align="left" style="width:200px">'.substr($diagnostico,0,20).'</td>';
echo '<td align="left" style="width:100px">'.$plan.'&nbsp;</td>';
echo '<td align="right">'.number_format($row["impcoseguro"],2).'&nbsp;</td>';
echo '<td align="right">'.$row["nrecibo"].'&nbsp;</td>';
echo '<input size= 12 type = "hidden" name = "cla_botiquin'.-$c.'" value="'.$row["idbotiquines"].'"/>';
echo '<input size= 12 type = "hidden" name = "cla_articulo'.-$c.'" value="'.$row["idarticulo"].' - '.$row["idrubro"].'"/>';


if ($_POST["update"] == 1)
{

  $normal = '';
  $excendente = '';
  $simultaneo = '';
  $anulado = '';
  $adnoct = '';
  $adzona = '';
  $adfinde = '';
  $impbase = '';
  $total = '';

  if ($tipoguardia == '4')
    {  $normal = $difhorag;
       $sigo = 'N';
       $tipoguardia = 'EVENTO';
       $uSQL="select * from  datosliq where tipmovil = '4'";
       $uresult=mysql_query($uSQL);
       $rowu=mysql_fetch_array($uresult);
       $total = $normal * $rowu["impbase"];
       $impbase = $rowu["impbase"];

    }

  if ($sigo == 'S')
   if ($tipoguardia == '3')
    {  $normal = '1';
       $sigo = 'N';
       $tipoguardia = 'TRASLADO';
       $uSQL="select * from  datosliq where tipmovil = '3'";
       $uresult=mysql_query($uSQL);
       $rowu=mysql_fetch_array($uresult);
       $total = $difhorag * $rowu["impbase"];
       $impbase = $rowu["impbase"];

    }

  if ($sigo == 'S')
    if ($tipomovil == '1')
     if ($tipomedico == '1')
     {
       $tipoguardia = 'FIJO-AMBULANCIA';
       $uSQL="select * from  datosliq where tipmovil = '".$tipomovil."' and tipmed = ".$tipomedico;
       $uresult=mysql_query($uSQL);
       $rowu=mysql_fetch_array($uresult);
       $cnbase = $rowu["cnbase"];

       $normal = '1';
       $ctrlhora = $difhorag * 60;
       if ($ctrlhora < '700')
          { $normal = $ctrlhora / 720;}
       if ($secuencia == '1')
          {$impbase = $rowu["fijo"] * $normal;
           $total = $total + $impbase; }
       $normal = '1';
       $sigo = 'N';
     }

  if ($sigo == 'S')
   if ($tipomovil == '1')
    if ($tipomedico == '2')
     {
       $sigo = 'N';
       $tipoguardia = 'PROD-AMBULANCIA';
       $uSQL="select * from  datosliq where tipmovil = '".$tipomovil."' and tipmed = ".$tipomedico;
       $uresult=mysql_query($uSQL);
       $rowu=mysql_fetch_array($uresult);
       $cnbase = $rowu["cnbase"];

       $normal1 = 1;
       $ctrlhora = $difhorag * 60;
       if ($ctrlhora < '700')
          { $normal1 = $ctrlhora / 720;}

       if ($secuencia == '1')
          { $impbase = $rowu["fijo"];
              if ($finde == '1')
                { $impbase = $impbase + $rowu["anfijo"]; }
          $impbase = $impbase * $normal1;
          $total = $total + $impbase;
          }


       if ($row["motanulacion"] > '0')
          { $anulado = '1';
            $total = $total + $rowu["impanulados"]; }
         else
          if ($secuencia > $cnbase)
            { $excedente = '1';
            $total = $total + $rowu["impexcedentes"]; }
            else
            { $normal = '1';
            $total = $total + $rowu["impbase"]; }

       if ($simultaneos > '0')
          { $simultaneos = $row["cnadicionales"];
            $total = $total + ($rowu["impsimultaneos"] * $simultaneos); }

     }

  if ($sigo == 'S')
    if ($tipomovil == '2')
     {
       $sigo = 'N';
       $tipoguardia = 'DOM-PARTICULAR';
       $uSQL="select * from  datosliq where tipmovil = ".$tipomovil;
       $uresult=mysql_query($uSQL);
       $rowu=mysql_fetch_array($uresult);
       $cnbase = $rowu["cnbase"];

       if ($secuencia == '1')
          { $impbase = $rowu["fijo"]; }

       if ($row["motanulacion"] > '0')
          { $anulado = '1';
            $total = $total + $rowu["impanulados"]; }
         else
          if ($secuencia > $cnbase)
            { $excedente = '1';
              $total = $total + $rowu["impexcedentes"]; }
            else
            { $normal = '1';
              $total = $total + $rowu["impbase"]; }

       if ($simultaneos > '0')
          { $simultaneos = $row["cnadicionales"];
            $total = $total + ($rowu["impsimultaneos"] * $simultaneos); }

       list($hor,$min,$seg)=explode(":",$horallegdom);

       if ($hor > '7')
          { $adnoct = ''; }

       if ($hor == '7')
         if ($min > '30')
          { $adnoct = ''; }
          else
          { $adnoct = '1';
            $total = $total + $rowu["animpexcede"]; }

       if ($hor < '7')
          { $adnoct = '1';
            $total = $total + $rowu["animpexcede"]; }

       if ($row["zona"] == '5')
          { $adzona = '1';
            $total = $total + $rowu["azimpexcede"]; }

       if ($row["zona"] == '6')
          { $adzona = '1';
            $total = $total + $rowu["azimpexcede"]; }

       if ($finde == '1')
          { $adfinde = '1';
            $total = $total + $rowu["afdimpexcede"]; }

     }


  ///////////////////////////////////////


// if ($secuencia == '1')
//     { $difhorag = $difg / 60; }


  $uSQL="insert into guardiasliq (cnhoras, idguardia, idmovildisp, retiene, legmed, tipoguardia, secuencia, idatencion, fecha, hora,
       normal, excedente, simultaneo, anulado, adnoct, adzona, adfinde,impbase,importe)
     values
       ('".$difhorag."','".$idguardia."','".$idguardia."','".$retiene."','".$legmedico."','".$tipoguardia."','".$secuencia."','".$id."','".$fechallam."','".$horallegdom."',
        '".$normal."','".$excedente."','".$simultaneo."','".$anulado."','".$adnoct."','".$adzona."','".$adfinde."','".$impbase."','".$total."')";

  //echo $uSQL;

  $uresult=mysql_query($uSQL);
 // mysql_free_result($uresult);

 }   //CIERRE DEL IF

}   //CIERRE DEL WHILE


echo '</TR></table></table></td></tr></table>' ;
mysql_free_result($result);

?>
<tr><td><table width="100%" border="1" align="left" style="font-size:<?echo $fontreg?>">
  <tr>
    <td width="100%" rowspan="3" valign="top">
      <table style="font-size:<?echo $fontreg?>" border = 1 cellspacing="5" width="100%" cellpadding="5" align="left" style="background-color:<?echo $th_color?>;border-left-width: 0; border-top-width: 0; border-bottom-width: 0" style="font-size:<?echo $font?>">
          <tr style="font-size:<?echo $fontt?>">
            <th>ATENCIONES</th>
            <th>ANULADOS</th>
            <th>COSEGUROS</th>
            <th>RETIRA</th>
            <th>RINDE</th>
        </td>

<?

$diferencia = $coseguros - $retiene;
echo '<tr><td align="center">'.$c.'</td>';
echo '<td align="center">'.$anulados.'</td>';
echo '<td align="center">'.number_format($coseguros,2).'</td>';
echo '<td align="center">'.number_format($retiene,2).'</td>';
echo '<td align="center">'.number_format($diferencia,2).'</td></tr>';

echo '</table></table></td></tr>' ;

$sSQL="select * from  cajas where estado < '1' and legajo = ".$G_legajo;
// echo $sSQL;

$result=mysql_query($sSQL);
$row=mysql_fetch_array($result);
$idcaja =  $row['idcaja'];
$debcre =  '2';
$motivos =  '4';
$hoy = date("Y-m-d");
$hora = date("H:i:s");

if ($_POST["update"] == 1)
{
 $sSQL="insert into movcaja (idcaja, debcre, fecmov, horamov, idmotdc, observac, importe)
      values ('".$idcaja."','".$debcre."','".$hoy."','".$hora."','".$motivos."','".$movil."','".$diferencia."')";
 $result=mysql_query($sSQL);

 insertolog($legajo, "M_Cierredisp2", "movcaja", "insert", "1999-12-01", $sSQL);

 $sSQL="update cajas set saldocierre = saldocierre + '".$diferencia."' where idcaja = ".$idcaja;
 $result=mysql_query($sSQL);
 insertolog($legajo, "M_Cierredisp2", "cajas", "update", "1999-12-01", $sSQL);

 echo mensaje_ok('C_Movdisp.php','OK');

}
else
{
  $movdisp = $_POST["pasmovildisp"];
}


?>

</FORM>
</BODY>
</HTML>