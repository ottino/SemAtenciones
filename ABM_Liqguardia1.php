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
<TITLE>ABM_Liqguardia1.php</TITLE>
</HEAD>

<body style="background-color:<?echo $body_color?>" style="font-size:<?echo $fontef?>">
<BODY>


<?
echo titulo_encabezado ('Liquidación de Honorarios' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }
//Ejecutamos la sentencia SQL

$fechad = $_POST["cla_fecha"];
$fechah = $_POST["cla_fecha1"];
$nombre = $_POST["cla_nombre"];
$vengo = $_POST["vengo"];
$idguardia1 = $_POST["cla_idguardia"];

$idatencion = $_POST["pasdatos"];

if ($idatencion < '1')
   {
    $idatencion = $_GET["pasdatos"];
    $vengo      = $_GET["vengo"];
    $fechad     = $_GET["cla_fecha"];
    $fechah     = $_GET["cla_fecha1"];
    $nombre     = $_GET["cla_nombre"];
    $idguardia1 = $_GET["cla_idguardia"];
   }

$sSQL="select * from movildisponible a, legajos b, bases c, moviles d where
       a.legmedico = b.legajo and a.idbase = c.idbases and a.idmovil = d.idmovil and idmovildisp = ".$idatencion;

$result=mysql_query($sSQL);
$row=mysql_fetch_array($result);

$hoy = date("Y-m-d");
$hora = date("H:i:s");
$idguardia = $row['idmovildisp'];
$medico = $row['apeynomb'];
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
$tipomedico = $row['funcion'];
$revisado   = $row['revisado'];

$difhorag = calcular_horas($fecbaja1,$horabaja1,$fecalta1,$horaalta1);

$difhorag = round(($difhorag / 60),2);

list($dia,$mes,$ano)=explode("/",$fecalta);

$numerodiasemana = date('w', mktime(0,0,0,$mes,$dia,$ano));

$finde = '0';

if ($numerodiasemana == '0')
  { $finde = '1';}

list($hor,$min,$seg)=explode(":",$horaalta1);

if ($numerodiasemana == '6')
  if ($hor > '17')
     { $finde = '1';}

$chofer = buscopersonal($row['legchofer']);
$enfermero = buscopersonal($row['legenfermero']);

$pagina = $_SERVER['HTTP_REFERER'];

echo'
<table width="100%" >
<tr style="background-color:'.$td_color.'">
  <td>
    <table font-size:".$fontreg."  width="100%"  border="1"  align="left" >
     <tr>
        <td valign="top">
            <tr style="font-size:'.$fontt.'">
             <th>ID</th>
             <th>MEDICO</th>
             <th>CHOFER</th>
             <th>ENFERMERO</th>
             <th>BASE</th>
             <th>MOVIL</th>
             <th>ALTA</th>
             <th>BAJA</th>
             <th>HS</th>
             <th>COBR</th>
             <th>RET</th>
             <th>CONS</th>
             <th>OK</th>
             <th></th>
            </tr>
         </td>
      </tr>';


$fecalta = cambiarFormatoFecha($row['fecalta']);
$fecbaja = cambiarFormatoFecha($row['fecbaja']);

echo '<tr style="font-size:'.$fontdef.'"><td align="left">'.$idguardia.'</td>';
echo '<td align="left">'.$medico.'&nbsp;</td>';
echo '<td align="left">'.substr($chofer,0,15).'&nbsp;</td>';
echo '<td align="left">'.substr($enfermero,0,15).'&nbsp;</td>';
echo '<td align="left">'.$base.'&nbsp;</td>';
echo '<td align="left">'.substr($movil,0,15).'&nbsp;</td>';
echo '<td align="left">'.$fecalta.' - '.$horaalta.'</td>';
echo '<td align="left">'.$fecbaja.' - '.$horabaja.'</td>';
echo '<td align="right">'.$difhorag.'&nbsp;</td>';
echo '<td align="right">'.$row["coseguros"].'&nbsp;</td>';
echo '<td align="right">'.$row["retiene"].'&nbsp;</td>';

$retiene = $row["retiene"];

$idmovildisp = $row["idmovildisp"];

echo '<FORM METHOD="POST" NAME="formulario3" ACTION="M_Cierredisp2.php">';

$idmovildisp = $row["idmovildisp"];
echo '<input type="hidden" name= "pasmovildisp" value="'.$idmovildisp.'" >';
echo '<input type="hidden" name= "vengo" value="'.$vengo.'" >';
echo '<input type="hidden" name= "cla_fecha" value="'.$fechad.'" >';
echo '<input type="hidden" name= "cla_fecha1" value="'.$fechah.'" >';
echo '<input type="hidden" name= "cla_nombre" value="'.$nombre.'" >';
echo '<input type="hidden" name= "cla_idguardia" value="'.$idguardia1.'" >';
echo ' <td width="17" align="center" style="background-color:'.$td_color.'">
                    <label onclick="this.form.submit();" style="CURSOR: pointer" >
                     <img align="middle" alt=\'Consultar\' src="imagenes/INSERTAR.ICO" width="30" height="30"/>
                    </label>
                  </td>';
echo '</FORM>';

if ($revisado == 'S')
  {
   echo ' <td width="17" align="center" style="background-color:'.$td_color.'">
                    <label onclick="this.form.submit();" style="CURSOR: pointer" >
                     <img align="middle" alt=\'Cerrado\' src="imagenes/Egreso.ico" width="30" height="30"/>
                    </label></td>';
  }
 else
  {
   echo '<FORM METHOD="POST" NAME="formulario3" ACTION="M_Liqguardia3.php">';
   $idmovildisp = $row["idmovildisp"];
   echo '<input type="hidden" name= "pasmovildisp" value="'.$idmovildisp.'" >';
   echo '<input type="hidden" name= "vengo" value="'.$vengo.'" >';
   echo '<input type="hidden" name= "cla_fecha" value="'.$fechad.'" >';
   echo '<input type="hidden" name= "cla_fecha1" value="'.$fechah.'" >';
   echo '<input type="hidden" name= "cla_nombre" value="'.$nombre.'" >';
   echo '<input type="hidden" name= "cla_idguardia" value="'.$idguardia1.'" >';
   echo ' <td width="17" align="center" style="background-color:'.$td_color.'">
                    <label onclick="this.form.submit();" style="CURSOR: pointer" >
                     <img align="middle" alt=\'Confirmar\' src="imagenes/58.ICO" width="30" height="30"/>
                    </label> </td>';
   echo '</FORM>';
  }

echo '<FORM METHOD="POST" NAME="formulario3" ACTION="ABM_Liqguardia.php">';

echo '<input type="hidden" name= "cla_fecha" value="'.$fechad.'" >';
echo '<input type="hidden" name= "cla_fecha1" value="'.$fechah.'" >';
echo '<input type="hidden" name= "cla_nombre" value="'.$nombre.'" >';
echo '<input type="hidden" name= "vengo" value="'.$vengo.'" >';
echo '<input type="hidden" name= "cla_idguardia" value="'.$idguardia1.'" >';

echo ' <td width="17" align="center" style="background-color:'.$td_color.'">
                    <label onclick="this.form.submit();" style="CURSOR: pointer" >
                     <img align="middle" alt=\'Volver\' src="imagenes/Volver.ico" width="30" height="30"/>
                    </label>
                  </td>';
echo '</FORM>';

echo '</table></td></tr></table>' ;

$result=mysql_query("select * from guardiasliq a, legajos b, movildisponible c, atenciones d where a.idguardia = c.idmovildisp and
                    a.legmed = b.legajo and a.idatencion = d.id and a.idguardia = ".$idatencion." order by a.secuencia");


$total = '0';

echo '
<table width="100%" border="1">
 <tr style="background-color:'.$td_color.'">
        <td><INPUT TYPE="BUTTON" value="Imprimir" ALIGN ="left" onclick ="window.print()"></td>
       </tr>
</table>';

echo '
<table width="100%" border="1">
 <tr style="background-color:'.$td_color.'">
    <td>
   <table width="100%" border="1">
   <tr>
    <td valign="top">
          <tr style="font-size:'.$fontt.'">
            <th>SEC</th>
            <th>ID</th>
            <th>TIPO</th>
            <th>F / H</th>
            <th>NOMBRE</th>
            <th>E</th>
            <th>S</th>
            <th>LOC.</th>
            <th>C</th>
            <th>AN</th>
            <th>DIAGNOSTICO</th>
            <th>PLAN</th>
            <th>IMP BASE</th>
            <th>N</th>
            <th>E</th>
            <th>S</th>
            <th>A</th>
            <th>N</th>
            <th>Z</th>
            <th>F</th>
            <th>TOTAL</th>
            <th>Consultar</th>
            <th>Modif</th>
        </td></tr>';


//Mostramos los registros

$snormales = 0;
$sexcedente = 0;
$ssimultaneo = 0;
$sanulado = 0;
$snocturno = 0;
$szona = 0;
$sfinde = 0;

while ($row=mysql_fetch_array($result))
{


$fecalta = cambiarFormatoFecha($row['fecha']);
$horaver = cambiarFormatoHora($row['hora']);
$fechallam = $row["fecha"];
$horallegdom = $row["horallegdom"];
$horasaldom = $row["horasaldom"];
$motivo1 = $row["motivo1"];
$motivo2 = $row["motivo2"];
$color1 = $row["color"];

$motivo = buscomotivo($motivo1,$motivo2);
$color = substr(buscocolor($color1),0,1);
$diagnostico = substr(buscodiagnostico($row["diagnostico"]),0,22);
$plan = substr(buscoplan($row["plan"]),0,10);
$zona = substr(buscozona($row["zona"]),0,8);

echo '<tr style="font-size:'.$fontdef.'"><td align="center">'.$row["secuencia"].'&nbsp;</td>';
echo '<td align="center">'.$row["idatencion"].'&nbsp;</td>';
echo '<td align="center">'.$row["tipoguardia"].'&nbsp;</td>';
echo '<td align="center" style="width:70px">'.substr($fecalta,0,5).'-'.$horaver.'</td>';
echo '<td align="left" style="width:160px">'.substr($row["nombre"],0,18).'</td>';
echo '<td align="center" style="width:20px">'.$row["edad"].'</td>';
echo '<td align="center" style="width:20px">'.$row["sexo"].'</td>';
echo '<td align="center"  style="width:50px">'.$zona.'</td>';
echo '<td align="center" style="width:20px">'.$color.'</td>';
echo '<td align="center" style="width:20px">'.$row["motanulacion"].'</td>';
echo '<td align="left" style="width:170px">'.substr($diagnostico,0,20).'</td>';
echo '<td align="left" style="width:100px">'.$plan.'&nbsp;</td>';

echo '<td align="right">'.$row["impbase"].'&nbsp;</td>';
echo '<td align="right">'.$row["normal"].'&nbsp;</td>';
echo '<td align="right" style="width:10px">'.$row["excedente"].'&nbsp;</td>';
echo '<td align="right">'.$row["simultaneo"].'&nbsp;</td>';
echo '<td align="right">'.$row["anulado"].'&nbsp;</td>';
echo '<td align="right">'.$row["adnoct"].'&nbsp;</td>';
echo '<td align="right">'.$row["adzona"].'&nbsp;</td>';
echo '<td align="right">'.$row["adfinde"].'&nbsp;</td>';
echo '<td align="right">'.$row["importe"].'&nbsp;</td>';

$snormales   = $snormales   + $row["normal"];
$sexcedente  = $sexcedente  + $row["excedente"];
$ssimultaneo = $ssimultaneo + $row["simultaneo"];
$sanulado    = $sanulado    + $row["anulado"];
$snocturno   = $snocturno   + $row["adnoct"];
$szona       = $szona       + $row["adzona"];
$sfinde      = $sfinde      + $row["adfinde"];

$datos = $row["idatencion"];
$total = $total + $row["importe"];

echo '<FORM METHOD="POST" NAME="formulario2" ACTION="C_Atenciones.php">';
echo '<input type="hidden" name= "pasaid" value="'.$datos.'" >';
echo '<input type="hidden" name= "pasguardia" value="'.$row["idguardia"].'" >';

echo '<input type="hidden" name= "pasmovildisp" value="'.$idmovildisp.'" >';
echo '<input type="hidden" name= "vengo" value="'.$vengo.'" >';
echo '<input type="hidden" name= "cla_fecha" value="'.$fechad.'" >';
echo '<input type="hidden" name= "cla_fecha1" value="'.$fechah.'" >';
echo '<input type="hidden" name= "cla_nombre" value="'.$nombre.'" >';
echo '<input type="hidden" name= "cla_idguardia" value="'.$idguardia1.'" >';

echo ' <td width="17" align="center" style="background-color:'.$td_color.'">
                    <label onclick="this.form.submit();" style="CURSOR: pointer" >
                     <img align="middle" alt=\'Consultar\' src="imagenes/INSERTAR.ICO" width="30" height="30"/>
                    </label>
                  </td>';
echo '</FORM>';


$datos1 = $row["idguardia"].'-'.$datos;


if ($revisado == 'S')
  {
   echo ' <td width="17" align="center" style="background-color:'.$td_color.'">
                    <label onclick="this.form.submit();" style="CURSOR: pointer" >
                     <img align="middle" alt=\'Cerrado\' src="imagenes/Egreso.ico" width="30" height="30"/>
                    </label></td>';
  }
 else
 {
  echo '<FORM METHOD="POST" NAME="formulario2" ACTION="ABM_Liqguardia2.php">';
  echo '<input type="hidden" name= "pasdatos" value="'.$datos1.'" >';
  echo '<input type="hidden" name= "cla_fecha" value="'.$fechad.'" >';
  echo '<input type="hidden" name= "cla_fecha1" value="'.$fechah.'" >';
  echo '<input type="hidden" name= "cla_nombre" value="'.$nombre.'" >';
  echo '<input type="hidden" name= "vengo" value="'.$vengo.'" >';
  echo '<input type="hidden" name= "cla_idguardia" value="'.$idguardia1.'" >';
  echo ' <td width="17" align="center" style="background-color:'.$td_color.'">
                    <label onclick="this.form.submit();" style="CURSOR: pointer" >
                     <img align="middle" alt=\'Modificar\' src="imagenes/editar.png" width="30" height="30"/>
                    </label></td></FORM>';
  };


}

echo '<tr><td align="center"></td>';
echo '<td align="center"></td>';
echo '<td align="center"></td>';
echo '<td align="center" style="width:70px"></td>';
echo '<td align="left" style="width:160px"></td>';
echo '<td align="center" style="width:20px"></td>';
echo '<td align="center" style="width:20px"></td>';
echo '<td align="center"  style="width:50px"></td>';
echo '<td align="center" style="width:20px"></td>';
echo '<td align="center" style="width:20px"></td>';
echo '<td align="left" style="width:170px"></td>';
echo '<td align="left" style="width:100px"></td>';

echo '<td align="right"></td>';
echo '<td align="right">'.$snormales.'&nbsp;</td>';
echo '<td align="right">'.$sexcedente.'&nbsp;</td>';
echo '<td align="right" style="width:10px">'.$ssimultaneo.'&nbsp;</td>';
echo '<td align="right">'.$sanulado.'&nbsp;</td>';
echo '<td align="right">'.$snocturno.'&nbsp;</td>';
echo '<td align="right">'.$szona.'&nbsp;</td>';
echo '<td align="right">'.$sfinde.'&nbsp;</td>';

echo '</TR></TR></TR></table></table></td></tr>' ;

echo '
<tr><td><table width="60%" border="1" align="right" style="font-size:'.$fontreg.'">
  <tr style="background-color:'.$td_color.'">
    <td width="100%" rowspan="3" valign="top">
      <table style="font-size:'.$fontreg.'" border = 1 cellspacing="5" width="100%" cellpadding="5" align="left" style="background-color:'.$th_color.';border-left-width: 0; border-top-width: 0; border-bottom-width: 0">
          <tr style="font-size:'.$fontt.'">
            <th>LIQUIDACION</th>
            <th>IMPORTE A COBRAR</th>
            <th>RETIENE</th>
            <th>NETO A COBRAR</th>
       </td>';

echo '<tr><td align="center" style="width:160px">'."TOTAL".'</td>';
echo '<td align="right">'.number_format($total,2).'&nbsp;</td>';
echo '<td align="right">'.number_format($retiene * -1,2).'&nbsp;</td>';
echo '<td align="right">'.number_format($total - $retiene,2).'&nbsp;</td>';

mysql_free_result($result);

echo '</TR></table></table>' ;
?>

</BODY>
</HTML>

