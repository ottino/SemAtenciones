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
$vengo1 = $_GET["vengo"];

//echo $vengo1;
$fechad = $_POST["cla_fecha"];
$fechah = $_POST["cla_fecha1"];
$nombre = $_POST["cla_nombre"];
$chofer1 = $_POST["cla_chofer"];
$idguardia1 = $_POST["cla_idguardia"];
$update = $_POST["update"];
$idmovil = $_POST["cla_movil"];


if ($update == 1)
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

//echo substr($pagina,-14,14);

if (substr($pagina,-14,14) == "Cierredisp.php")
    $pagina = "ABM_Movdisp.php";

if ($_POST["cla_vengo"] == "MOVIL")
   {
    $vengo = $_POST["cla_vengo"];
    $pagina = "http://localhost/at/C_Movdisp2.php";
   }

if ($_POST["cla_vengo"] == "ESTACHOFER")
   {
    $vengo = $_POST["cla_vengo"];
    $pagina = "L_Estachofer1.php";
   }

if ($update == 1)
{
  $movdisp = $_POST["movdisp"];
}
else
{
  $movdisp = $_POST["pasmovildisp"];
  if ($_GET["vengo"] == 'MISMO')
   {
     $update = '0';
     $movdisp = $_GET["pasmovildisp"];
   $pagina = "ABM_Movdisp.php";
   //  echo "--";
   //  echo $movdisp;
   }
}

////////////////////////////////

//Creamos la sentencia SQL y la ejecutamos

if ($update == 1)
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
//echo $sSQL;
$result=mysql_query($sSQL);
$row=mysql_fetch_array($result);

$hoy = date("Y-m-d");
$hora = date("H:i:s");
$idguardia = $row['idmovildisp'];
$tipoguardia = $row['tipoguardia'];
$chofer = $row['apeynomb'];
$legmedico = $row['legmedico'];
$base = $row['descbases'];
$movil = $idguardia.' - ('.$row['idmovil'].')'.$row['descmovil'];
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

echo '<table width="100%">
       <tr style="background-color:'.$td_color.'"><td><table width="100%" border="1" align="left" style="font-size:'.$font.'">
         <tr>
               <td width="100%" rowspan="3" valign="top">
            <table style="font-size:'.$font.'" border = 1 cellspacing="5" width="100%" cellpadding="5" align="left" style="background-color:'.$td_color.';border-left-width: 0; border-top-width: 0; border-bottom-width: 0" style="font-size:'.$font.'">
               <tr style="font-size:'.$font.'">
            <th>GUARDIA</th>
            <th>CHOFER</th>
            <th>MEDICO</th>
            <th>ENFERMERO</th>
            <th>BASE</th>
            <th>MOVIL</th>
            <th>INGRESO</th>
            <th>EGRESO</th>
             </td>';

echo '<tr><td align="left" style="font-size:15px">'.$idguardia.'</td>';
echo '<td align="left" style="font-size:15px">'.$chofer.'&nbsp;</td>';
echo '<td align="left">'.$medico.'&nbsp;</td>';
echo '<td align="left">'.$enfermero.'&nbsp;</td>';
echo '<td align="left">'.$base.'&nbsp;</td>';
echo '<td align="left">'.$movil.'&nbsp;</td>';
echo '<td align="left">'.$fecalta.' - '.$horaalta.'&nbsp;</td>';
echo '<td align="left">'.$fecbaja.' - '.$horabaja.'&nbsp;</td>';


echo '<td><a href="'.$pagina.'?pasdatos='.$movdisp.'&vengo='.$vengo.'&cla_fecha='.$fechad.'&cla_fecha1='.$fechah.'&cla_nombre='.$nombre.'&cla_idguardia='.$idguardia1.'&cla_movil='.$idmovil.'&cla_chofer='.$chofer1.'"/a> <img border="0" src="imagenes/Volver.ico" width="30" height="30"  align="top" /></td></tr>';
echo '</table></table></td></tr>' ;

$sSQL="select * from atenciones a left join destino c on a.destino = c.iddestino
                                  left join zonas d   on a.zona = d.idzonas
                where movil_2 = ".$movdisp." order by fecha, horallegdom";

$result=mysql_query($sSQL);

$c = 0;
$coseguros = 0;

echo '<tr><td><table width="100%" border="1" style="font-size:'.$font.';background-color:'.$td_color.'">
      <tr>
    <td><INPUT TYPE="BUTTON" value="Imprimir" ALIGN ="left" onclick ="window.print()"></td></tr><tr>
    <td width="100%" rowspan="3" valign="top">
      <table style="font-size:'.$font.'" border = 1 cellspacing="5" width="100%" cellpadding="5" align="left" style="background-color:'.$th_color.';border-left-width: 0; border-top-width: 0; border-bottom-width: 0" style="font-size:'.$font.'">
         <tr style="font-size:'.$font.'">
            <th>ID</th>
            <th>F / H</th>
            <th>ATEN</th>
            <th>NOMBRE</th>
            <th>E</th>
            <th>S</th>
            <th>LOC.</th>
            <th>COL</th>
            <th>ANU</th>
            <th>DIAGNOSTICO</th>
            <th>PLAN</th>
            <th>COS.</th>
            <th>RECIBO</th>
        </td>';


//Mostramos los registros
$c = 0;
$secuencia = 0;
$anulados = 0;
$cuenta = 0;

while ($row=mysql_fetch_array($result))
{

$secuencia++;
$motanulacion = $row["motanulacion"];
$diagnostico = substr(buscodiagnostico($row["diagnostico"]),0,22);


if ($motanulacion < 1)
{
   $coseguros = $coseguros + $row['impcoseguro'];
   $c++;
   $simult = $simult + $row['cnadicionales'];
   $atenciones = $row["cnadicionales"] + 1;
} else
{
   $anulados++;
   $diagnostico = $diagnostico.' (ANUL)';
   $atenciones = '0';
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
$plan = substr(buscoplan($row["plan"]),0,10);

echo '<tr><td align="center"  style="width:40px">'.$id.'</td>';
echo '<td align="center" style="width:70px">'.substr($fecha,0,5).'-'.$horaver.'</td>';
echo '<td align="center"  style="width:40px">'.$atenciones.'</td>';
echo '<td align="left" style="width:200px">'.substr($row["nombre"],0,18).'</td>';
echo '<td align="center" style="width:30px">'.$row["edad"].'</td>';
echo '<td align="center" style="width:30px">'.$row["sexo"].'</td>';
echo '<td align="center"  style="width:100px">'.$row["desczonas"].'</td>';
echo '<td align="center" style="width:40px">'.$color.'</td>';
echo '<td align="center" style="width:30px">'.$row["motanulacion"].'</td>';
echo '<td align="left" style="width:200px">'.substr($diagnostico,0,24).'</td>';
echo '<td align="left" style="width:100px">'.$plan.'&nbsp;</td>';
echo '<td align="right">'.number_format($row["impcoseguro"],2).'&nbsp;</td>';
echo '<td align="right">'.$row["nrecibo"].'&nbsp;</td>';
echo '<input size= 12 type = "hidden" name = "cla_botiquin'.-$c.'" value="'.$row["idbotiquines"].'"/>';
echo '<input size= 12 type = "hidden" name = "cla_articulo'.-$c.'" value="'.$row["idarticulo"].' - '.$row["idrubro"].'"/>';


if ($update == 1)
{
  $normal = '';
  $excedente = '';
  $simultaneo = '';
  $anulado = '';
  $adnoct = '';
  $adzona = '';
  $adfinde = '';
  $impbase = '';
  $total = '';
  $simultaneos = $row["cnadicionales"];

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

       if ($row["diagnostico"] == 0 || $row["diagnostico"] == 1 ||$row["diagnostico"] == 2 || $row["diagnostico"] == 3 ||
           $row["diagnostico"] == 15 || $row["diagnostico"] == 16 || $row["diagnostico"] == 75)
          $anulado = '1';
         else
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
       $cnsimult = $rowu["cnsimultaneos"];

       $normal1 = 1;
       $ctrlhora = $difhorag * 60;
       if ($ctrlhora < '700')
          { $normal1 = $ctrlhora / 720;}

       if ($ctrlhora < '450')
          { $cnbase = $cnbase/2;}

       if ($row["diagnostico"] == 0 || $row["diagnostico"] == 1 ||$row["diagnostico"] == 2 || $row["diagnostico"] == 3 ||
           $row["diagnostico"] == 15 || $row["diagnostico"] == 16 || $row["diagnostico"] == 75)
         $rechaza = '1';
        else
         $rechaza = '0';

       if ($secuencia == '1')
          { $impbase = $rowu["fijo"];
              if ($finde == '1' && $rechaza < '1')
                { $impbase = $impbase + $rowu["anfijo"];
                }
          $impbase = $impbase * $normal1;
          $total = $total + $impbase;
          }

       if ($rechaza > '0')
          { $anulado = '1';
            $total = $total + $rowu["impanulados"]; }
         else
          if ($cuenta >= $cnbase)
            { $excedente = '1';
              $cuenta = $cuenta +1;
              $total = $total + $rowu["impexcedentes"];
            }
            else
            { $normal = '1';
              $cuenta = $cuenta +1;
              $total = $total + $rowu["impbase"];
            }

       if ($cuenta >= $cnsimult && $simultaneos > '0')
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

       if ($row["diagnostico"] == 0 || $row["diagnostico"] == 1 ||$row["diagnostico"] == 2 || $row["diagnostico"] == 3 ||
           $row["diagnostico"] == 15 || $row["diagnostico"] == 16 || $row["diagnostico"] == 75)
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

if ($simultaneos < '1')
  $simultaneos = '';


  $uSQL="insert into guardiasliq (cnhoras, idguardia, idmovildisp, retiene, legmed, tipoguardia, secuencia, idatencion, fecha, hora,
       normal, excedente, simultaneo, anulado, adnoct, adzona, adfinde,impbase,importe)
     values
       ('".$difhorag."','".$idguardia."','".$idguardia."','".$retiene."','".$legmedico."','".$tipoguardia."','".$secuencia."','".$id."','".$fechallam."','".$horallegdom."',
        '".$normal."','".$excedente."','".$simultaneos."','".$anulado."','".$adnoct."','".$adzona."','".$adfinde."','".$impbase."','".$total."')";

  //echo $uSQL;

  $uresult=mysql_query($uSQL);
 // mysql_free_result($uresult);

 }   //CIERRE DEL IF

}   //CIERRE DEL WHILE


echo '</TR></table></table></td></tr></table>' ;
mysql_free_result($result);

echo '<tr><td><table width="100%" border="1" align="left" style="font-size:'.$font.'; background-color:'.$td_color.'">
  <tr>
    <td width="100%" rowspan="3" valign="top">
      <table style="font-size:'.$font.'" border = 1 cellspacing="5" width="100%" cellpadding="5" align="left" style="background-color:'.$th_color.';border-left-width: 0; border-top-width: 0; border-bottom-width: 0" style="font-size:'.$font.'">
         <tr style="font-size:'.$font.'">
            <th>ATENCIONES</th>
            <th>ADICIONALES</th>
            <th>ANULADOS</th>
            <th>COSEGUROS</th>
            <th>RETIRA</th>
            <th>RINDE</th>
        </td>';

$diferencia = $coseguros - $retiene;

echo '<tr><td align="center">'.$c.'</td>';
echo '<td align="center">'.$simult.'</td>';
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

if ($update == 1)
{
 $sSQL="insert into movcaja (idcaja, debcre, fecmov, horamov, idmotdc, observac, importe)
      values ('".$idcaja."','".$debcre."','".$hoy."','".$hora."','".$motivos."','".$movil."','".$diferencia."')";
 $result=mysql_query($sSQL);

 insertolog($legajo, "M_Cierredisp2", "movcaja", "insert", "1999-12-01", $sSQL);

 $sSQL="update cajas set saldocierre = saldocierre + '".$diferencia."' where idcaja = ".$idcaja;
 $result=mysql_query($sSQL);
 insertolog($legajo, "M_Cierredisp2", "cajas", "update", "1999-12-01", $sSQL);

 //echo mensaje_ok('M_Cierredisp2.php?pasmovildisp='.$idguardia.'&vengo=MISMO','OK');

}
else
{
  $movdisp = $_POST["pasmovildisp"];
}


?>

</FORM>
</BODY>
</HTML>