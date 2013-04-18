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
<TITLE>M_Guardiacerr.php</TITLE>

</HEAD>

<body style="background-color:<?echo $body_color?>" style="font-size:<?echo $font?>">
<BODY>

<?

echo titulo_encabezado ('Arreglo de Guardias' , $path_imagen_logo);

$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }

$movdisp = $_POST["pasmovildisp"];
$pasaid  = $_POST["pasaid"];

if ($movdisp < '1')
  {   $movdisp = $_GET["pasmovildisp"];
      $pasaid  = $_GET["pasaid"];
  }

$font = '12px';

//Creamos la sentencia SQL y la ejecutamos


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
$coseguros = $row['coseguros'];
$kmbaja = $row['kmbaja'];
$tipomovil = $row['codperfil'];

$medico = buscopersonal($row["legmedico"]);
$enfermero = buscopersonal($row['legenfermero']);

?>
<table width="100%">
<tr><td><table width="100%" border="1" align="left" style="font-size:<?echo $font?>">
  <tr>
    <td width="100%" rowspan="3" valign="top">
      <table style="font-size:<?echo $font?>" border = 1 cellspacing="5" width="100%" cellpadding="5" align="left" style="background-color:<?echo $th_color?>;border-left-width: 0; border-top-width: 0; border-bottom-width: 0" style="font-size:<?echo $font?>">
          <tr style="font-size:<?echo $font?>">
            <th>GUARDIA</th>
            <th>MEDICO</th>
            <th>CHOFER</th>
            <th>ENFERMERO</th>
            <th>BASE</th>
            <th>MOVIL</th>
            <th>INGRESO</th>
            <th>EGRESO</th>
        </td>

<?

echo '<tr><td align="left" style="font-size:15px">'.$idguardia.'</td>';
echo '<td align="left" style="font-size:15px">'.$medico.'&nbsp;</td>';
echo '<td align="left">'.$chofer.'&nbsp;</td>';
echo '<td align="left">'.$enfermero.'&nbsp;</td>';
echo '<td align="left">'.$base.'&nbsp;</td>';
echo '<td align="left">'.$movil.'&nbsp;</td>';
echo '<td align="left">'.$fecalta.' - '.$horaalta.'&nbsp;</td>';
echo '<td align="left">'.$fecbaja.' - '.$horabaja.'&nbsp;</td>';


     echo '<td><FORM METHOD="POST" NAME="formulario2" ACTION="C_Movdisp.php">';
     echo '<input type="hidden" name= "pasaid" value  ="'.$movdisp.'" >';
     echo '<input type="hidden" name= "marca" value  ="1" >';
     echo ' <td width="17" align="center" style="background-color:'.$td_color.'" style="CURSOR: hand" >
                     <label onclick="this.form.submit();">
                      <img align="middle" alt=\'Volver\' src="imagenes/Volver.ico" width="30" height="30"/>
                     </label></td>';
     echo '</FORM></TD>';

echo '</tr></table></table></td></tr>' ;

$sSQL="select * from atenciones where movil_2 = ".$movdisp." order by id";

$result=mysql_query($sSQL);

$c = 0;


?>
<tr><td><table width="100%" border="1" style="font-size:<?echo $font?>">
  <tr>
    <td><INPUT TYPE="BUTTON" value="Imprimir" ALIGN ="left" onclick ="window.print()"></td></tr><tr>
    <td width="100%" rowspan="3" valign="top">
      <table style="font-size:<?echo $font?>" border = 1 cellspacing="5" width="100%" cellpadding="5" align="left" style="background-color:<?echo $th_color?>;border-left-width: 0; border-top-width: 0; border-bottom-width: 0" style="font-size:<?echo $font?>">
          <tr style="font-size:<?echo $font?>">
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
            <th>COS</th>
            <th>$COS</th>
            <th>RECIBO</th>
            <th>MOD</th>
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
$zona = buscozona($row["zona"]);

echo '<FORM METHOD="POST" NAME="formulario3" ACTION="M_Gauardiacerr2.php">';

echo '<tr><td align="center"  style="width:40px">'.$id.'</td>';
echo '<td align="center" style="width:70px">'.substr($fecha,0,5).'-'.$horaver.'</td>';
echo '<td align="left" style="width:200px">'.substr($row["nombre"],0,18).'</td>';
echo '<td align="center" style="width:30px">'.$row["edad"].'</td>';
echo '<td align="center" style="width:30px">'.$row["sexo"].'</td>';
echo '<td align="center"  style="width:100px">'.$zona.'</td>';
echo '<td align="center" style="width:40px">'.$color.'</td>';
echo '<td align="center" style="width:30px">'.$row["motanulacion"].'</td>';
echo '<td align="left" style="width:200px">'.substr($diagnostico,0,20).'</td>';
echo '<td align="left" style="width:100px">'.$plan.'&nbsp;</td>';
echo '<td align="left" style="width:30px">'.$row["coseguro"].'&nbsp;</td>';
echo '<td align="right"><input size= 6 type = "text" name = "cla_importe" value = "'.number_format($row["impcoseguro"],2).'" /></td>';
echo '<td align="right">'.$row["nrecibo"].'&nbsp;</td>';

$idatencion = $row["id"];
echo '<input type="hidden" name= "pasmovildisp" value="'.$movdisp.'" >';
echo '<input type="hidden" name= "idatencion" value="'.$idatencion.'" >';
echo '<input type="hidden" name= "pasaid" value  = "'.$pasaid.'" >';
echo ' <td width="17" align="center" style="background-color:'.$td_color.'" style="CURSOR: hand" >
                    <label onclick="this.form.submit();">
                     <img align="middle" alt=\'Modificar\' src="imagenes/editar.png" width="20" height="20"/>
                    </label>
                  </td>';
echo '</FORM>';

$total = $total + $row["impcoseguro"];

}

echo '</TR></table></table></td></tr></table>' ;
mysql_free_result($result);

?>
<tr><td><table width="100%" border="1" align="left" style="font-size:<?echo $font?>">
  <tr>
    <td width="100%" rowspan="3" valign="top">
      <table style="font-size:<?echo $font?>" border = 1 cellspacing="5" width="100%" cellpadding="5" align="left" style="background-color:<?echo $th_color?>;border-left-width: 0; border-top-width: 0; border-bottom-width: 0" style="font-size:<?echo $font?>">
          <tr style="font-size:<?echo $font?>">
            <th>ATENCIONES</th>
            <th>ANULADOS</th>
            <th>COSEGUROS</th>
            <th>RETIRA</th>
            <th>RINDE</th>
            <th>MOD</th>
        </td>

<?

echo '<FORM METHOD="POST" NAME="formulario3" ACTION="M_Gauardiacerr3.php">';

$diferencia = $coseguros - $retiene;
echo '<tr><td align="center">'.$c.'</td>';
echo '<td align="center">'.$anulados.'</td>';
echo '<td align="center">'.number_format($coseguros,2).'  - Calculado('.number_format($total,2).')</td>';

echo '<td align="center"><input size= 6 type = "text" name = "cla_retiene" value = "'.number_format($retiene,2).'" /></td>';
echo '<td align="center">'.number_format($diferencia,2).'</td>';

echo '<input type="hidden" name= "cla_importe" value="'.number_format($total,2).'" >';
echo '<input type="hidden" name= "pasmovildisp" value="'.$movdisp.'" >';
echo '<input type="hidden" name= "idatencion" value="'.$idatencion.'" >';
echo '<input type="hidden" name= "pasaid" value  = "'.$pasaid.'" >';
echo ' <td width="17" align="center" style="background-color:'.$td_color.'" style="CURSOR: hand" >
                    <label onclick="this.form.submit();">
                     <img align="middle" alt=\'Consultar\' src="imagenes/editar.png" width="20" height="20"/>
                    </label>
                  </td></tr>';
echo '</FORM>';

echo '</table></table></td></tr>' ;


?>

</FORM>
</BODY>
</HTML>