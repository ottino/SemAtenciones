<?
session_start();
######################INCLUDES################################
//archivo de configuracion
include_once ('config.php');

//funciones propias
include ('funciones.php');

//incluímos la clase ajax
require ('xajax/xajax.inc.php');
require_once("cookie.php");
require_once("config.php");
$cookie = new cookieClass;
$G_usuario = $cookie->get("usuario");
$G_legajo  = $cookie->get("legajo");
$G_perfil  = $cookie->get("perfil");
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@

################### Conexion a la base de datos##########################

$bd= mysql_connect($bd_host, $bd_user, $bd_pass);
mysql_select_db($bd_database, $bd);

//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
?>


<HTML>
<HEAD>
<TITLE>C1_Atenciones.php</TITLE>
</HEAD>

<body style="background-color:<?echo $body_color?>" style="font-size:<?echo $fontef?>">
<BODY>

<?
echo titulo_encabezado ('Consulta de Atención' , $path_imagen_logo);
//$segmenu = valida_menu();
//if ($segmenu <> "OK")
//  { mensaje_error ('Principal.php', 'Usuario no autorizado');
//   exit;
//  }

$pasaid = $_POST["pasaid"];

if ($pasaid < 1)
  {
    $pasaid = $_GET["pasaid"];
    $vengo  = $_GET["vengo"];
  }

if ($vengo == 'M')
    $pasaid = $_GET["pasaid"];
 else
   if ($pasaid < 1)
   {
     $resultmax=mysql_query("select max(id) as id from atenciones");
     $rowmax=mysql_fetch_array($resultmax);
     $pasaid = $rowmax["id"] +0;
     mysql_free_result($resultmax);
   };

//Ejecutamos la sentencia SQL


$result=mysql_query("select * from atenciones a, planes b WHERE id = ".$pasaid." and a.plan = b.idplan order by id ");
$row=mysql_fetch_array($result);


$resultant=mysql_query("select * from atenciones WHERE id in (select max(id) from atenciones where
                        id < ".$pasaid.") order by id");
$rowant=mysql_fetch_array($resultant);
$pasaidant = $rowant["id"] +0;
mysql_free_result($resultant);

$resultpro=mysql_query("select * from atenciones WHERE id in (select min(id) from atenciones where
                        id > ".$pasaid.") order by id");
$rowpro=mysql_fetch_array($resultpro);
$pasaidpro = $rowpro["id"] +0;
mysql_free_result($resultpro);

$resultmax=mysql_query("select max(id) as id from atenciones");
$rowmax=mysql_fetch_array($resultmax);
$pasaidmax = $rowmax["id"] +0;
mysql_free_result($resultmax);

$resultmin=mysql_query("select min(id) as id from atenciones");
$rowmin=mysql_fetch_array($resultmin);
$pasaidmin = $rowmin["id"] +0;
mysql_free_result($resultmin);

echo '
   <table width="100%" style="background-color:<?echo $th_color?>;border-left-width: 0; border-top-width: 0; border-bottom-width: 0">
   <tr><td>
    <table width="100%" border="1" align="left" >
    <tr>
    <td style="width:2000px"><INPUT TYPE="BUTTON" value="Imprimir" ALIGN ="left" onclick ="window.print()"></td>';

if ($G_perfil == '1' || $G_perfil == '3' || $G_perfil == '4' || $G_perfil == '8')
  {
     echo '<td><FORM METHOD="POST" NAME="formulario2" ACTION="M_Atenciones.php">';
     echo '<input type="hidden" name= "pasaid" value  ="'.$pasaid.'" >';
     echo ' <td  style="width:200px" align="center" style="background-color:'.$td_color.'">
                     <label onclick="this.form.submit();" style="CURSOR: pointer" >
                      <img align="middle" alt=\'Modificar\' src="imagenes/editar.png" width="30" height="30"/>
                     </label>
                   </td>';
     echo '</FORM></TD>';
  }

     echo '<td><FORM METHOD="POST" NAME="formulario2" ACTION="C1_Atenciones.php">';
     echo '<input type="hidden" name= "pasaid" value  ="'.$pasaidmin.'" >';
     echo ' <td width="17" align="center" style="background-color:'.$td_color.'">
                     <label onclick="this.form.submit();" style="CURSOR: pointer" >
                      <img align="middle" alt=\'Volver\' src="imagenes/117.ico" width="30" height="30"/>
                     </label></td>';
     echo '</FORM></TD>';

     echo '<td><FORM METHOD="POST" NAME="formulario2" ACTION="C1_Atenciones.php">';
     echo '<input type="hidden" name= "pasaid" value  ="'.$pasaidant.'" >';
     echo ' <td width="17" align="center" style="background-color:'.$td_color.'">
                     <label onclick="this.form.submit();" style="CURSOR: pointer" >
                      <img align="middle" alt=\'Volver\' src="imagenes/118.ico" width="30" height="30"/>
                     </label>
                   </td>';
     echo '</FORM></TD>';

     echo '<td><FORM METHOD="POST" NAME="formulario2" ACTION="C1_Atenciones.php">';
     echo '<input type="hidden" name= "pasaid" value  ="'.$pasaidpro.'" >';
     echo ' <td width="17" align="center" style="background-color:'.$td_color.'">
                     <label onclick="this.form.submit();" style="CURSOR: pointer" >
                      <img align="middle" alt=\'Volver\' src="imagenes/119.ico" width="30" height="30"/>
                     </label>
                   </td>';
     echo '</FORM></TD>';

     echo '<td><FORM METHOD="POST" NAME="formulario2" ACTION="C1_Atenciones.php">';
     echo '<input type="hidden" name= "pasaid" value  ="'.$pasaidmax.'" >';
     echo ' <td width="17" align="center" style="background-color:'.$td_color.'">
                     <label onclick="this.form.submit();" style="CURSOR: pointer" >
                      <img align="middle" alt=\'Volver\' src="imagenes/120.ico" width="30" height="30"/>
                     </label>
                   </td>';
     echo '</FORM></TD>';

     echo '<td><FORM METHOD="POST" NAME="formulario2" ACTION="C1_Atenciones.php">';
     echo '<input type="text" name= "pasaid" >';
     echo ' <td width="17" align="center" style="background-color:'.$td_color.'">
                     <label onclick="this.form.submit();" style="CURSOR: pointer" >
                      <img align="middle" alt=\'Volver\' src="imagenes/120.ico" width="30" height="30"/>
                     </label>
                   </td>';
     echo '</FORM>';
     echo '</tr></table><TR><TD>';
     echo '<table border="1" align="left" cellspacing="5" cellpadding="5"> ';

$id = $row["id"] + 0;

$horallam = cambiarFormatoHora($row["horallam"]);
$horallegdom = cambiarFormatoHora($row["horallegdom"]);
$fecha  =  cambiarFormatoFecha($row["fecha"]);
$fechallam  =  cambiarFormatoFecha($row["fechallam"]);
$color   =  buscocolor($row["color"]);
$colorm  =  buscocolor($row["colormedico"]);
$motivo  =  buscomotivo($row["motivo1"],$row["motivo2"]);
$descplan  =  buscoplan($row["plan"]);
echo '<TD >ID</TD><td align="left">'.$id.'</td><td style="width:20px"></td>';
echo '<TD >Ingreso:</TD><td align="left">'.$fechallam.'-'.$horallam.'</td><TD >Atención:</TD><td align="left">'.$fecha.'-'.$horallegdom.'</td><td style="width:20px"></td><TD>COLOR: '.$color.' - '.$motivo.'</TD>';
echo '</tr></table><TR><TD><table border="1" align="left" cellspacing="5" cellpadding="5"><tr style="font-size:<?echo $fontt?>">';



$operador  =  buscopersonal($row["operec"]);
$despachador  =  buscopersonal($row["opedesp"]);
$medico  =  buscopersonal($row["medico"]);
$chofer  =  buscopersonal($row["chofer"]);
$diagnostico  =  buscodiagnostico($row["diagnostico"]);
$destino  =  buscodestino($row["destino"]);

if ($row["motanulacion"] > '0')
{   $medico = 'ANULADO';
   $diagnostico = buscoanulacion($row["motanulacion"]);
}

echo '<td align="left" style="width:400px" >'.$id.' - NOMBRE:  '.$row["nombre"].'</td><td style="width:20px"></td>';
echo '<TD >EDAD: '.$row["edad"].'</TD><td align="left">SEXO: '.$row["sexo"].'</td><td style="width:20px"></td><TD>PLAN: '.$row["plan"].'-'.$descplan.'</TD><TD></TD><TD>IDENTIF: '.$row["identificacion"].'</TD>';

echo '</tr></table><TR><TD><table border="1" align="left" cellspacing="5" cellpadding="5"><tr style="font-size:<?echo $fontt?>">';

echo '<TD>Dirección</TD><td align="left">CALLE: '.$row["calle"].' /*/ NRO: '.$row["numero"].' /*/ PISO: '.$row["piso"].' /*/ DPTO: '.$row["depto"].' /*/ CASA:'.$row["casa"].' /*/ MNB: '.$row["monoblok"].' /*/ ENTRE: '.$row["entre1"].' y '.$row["entre2"].' /*/ BARRIO: '.$row["barrio"].' /*/ LOCALIDAD: '.$row["localidad"].' /*/ REF: '.$row["referencia"].' /*/ TEL: '.$row["telefono"].'</td>';

echo '</tr></table><TR><TD><table border="1" align="left" cellspacing="5" cellpadding="5"><tr style="font-size:<?echo $fontt?>">';
echo '<TD>Atención</TD><td align="left">OPER.: '.substr($operador,0,15).'</td><td align="left">DESP.: '.substr($despachador,0,15).'</td><td> MEDICO: '.substr($medico,0,15).'</td><td> CHOFER: '.substr($chofer,0,15).'</td><td> MOVIL: '.$row["movil"].'</td><td> GUARDIA: '.$row["movil_2"].'</td>';
echo '</tr></table><TR><TD><table border="1" align="left" cellspacing="5" cellpadding="5"><tr style="font-size:<?echo $fontt?>">';

$horadesp = cambiarFormatoHora($row["horadesp"]);
$horasalbase = cambiarFormatoHora($row["horasalbase"]);
$horallegdom = cambiarFormatoHora($row["horallegdom"]);
$horasaldom = cambiarFormatoHora($row["horasaldom"]);
$horalleghosp = cambiarFormatoHora($row["horalleghosp"]);
$horasalhosp = cambiarFormatoHora($row["horasalhosp"]);
$horadisp = cambiarFormatoHora($row["horalib"]);
$impocoseguro = $row[44];

$r1 = cambiarFormatoHora($row["reclamo_1"]);
$r2 = cambiarFormatoHora($row["reclamo_2"]);
$r3 = cambiarFormatoHora($row["reclamo_3"]);


echo '<TR><TD>Horarios</TD><td align="left">LLAM: '.$horallam.'</td><td>DESP: '.$horadesp.'</td>
      <td>S.BASE: '.$horasalbase.'</td><td>L.DOM: '.$horallegdom.'</td><td>S.DOM: '.$horasaldom.'</td>
      <td>L.HOSP: '.$horalleghosp.'</td><td>S.HOSP: '.$horasalhosp.'</td><td>LIB.: '.$horadisp.'</td>
      <td>RECLAMO.1: '.$r1.'</td><td>R.2: '.$r2.'</td><td>R.3: '.$r3.'</td>';

echo '</tr></table><TR><TD><table border="1" align="left" cellspacing="5" cellpadding="5"><tr style="font-size:<?echo $fontt?>">';
echo '<TR><TD>Diagnóstico</TD><td style="width:400px" align="left"> '.substr($diagnostico,0,40).'</td><TD>Destino</TD><td style="width:300px" align="left"> '.substr($destino,0,20).'</td><td> Color médico: '.$colorm.'</td><td>Coseg.: '.$impocoseguro.'</td></tr>';

echo '</tr></table><TR><TD><table border="1" align="left" cellspacing="5" cellpadding="5"><tr style="font-size:<?echo $fontt?>">';
echo '<TR><TD>Observaciones</TD><td style="width:900px" align="left">'.$row["observa1"].' // '.$row["observa2"].' // '.$row["obs_final"].'</td>';

$resultcta=mysql_query("select * from cta WHERE id = ".$row[cta]." order by 1");
$rowcta=mysql_fetch_array($resultcta);

echo '</tr></table><TR><TD><table border="1" align="left" cellspacing="5" cellpadding="5"><tr style="font-size:<?echo $fontt?>">';
echo '<TR><TD style="width:60px">Cierre Telefónico</TD><TD style="width:850px"align="left">'.$rowcta[idcta].'-'.$rowcta[motcta].'-'.$rowcta[desccta].'<textarea disabled="disabled" name="cla_observaciones" rows="5" cols="80">'.$row[obscta].'</textarea>
                     </TD></tr>';


$resulta=mysql_query("select * from clientes_nopadron WHERE idatencion = ".$id." order by idatencion, idnopadron");
while ($rowa=mysql_fetch_array($resulta))
 {
   $descdiagno = buscodiagnostico($rowa["cod_diagnostico"]);
   $descdestino = buscodestino($rowa["cod_destino"]);

   echo '<TR><TD style="width:60px">Adicionales</TD><td style="width:850px" align="left">'.$id.' - Nombre: '.$rowa["nombre"].' - Edad: '.$rowa["edad"].' - Sexo: '.$rowa["sexo"].' - Diagnostico: '.$descdiagno.' - Destino: '.$descdestino.'</td></tr>';
 }
mysql_free_result($resulta);


$resulta=mysql_query("select * from botiquin_cierre a, articulos b WHERE id_atencion = ".$id." and a.id_rubro = b.rubro and a.id_articulo = b.idarticulo order by 2,3");
while ($rowa=mysql_fetch_array($resulta))
 {
   echo '<TR><TD style="width:60px">Gasto Botiquin</TD><td style="width:650px" align="left">'.$rowa["id_articulo"].'-'.$rowa["id_rubro"].'-'.$rowa["articulo"].'</TD><td>'.$rowa["cantidad"].'</td></tr>';
 }
mysql_free_result($resulta);



mysql_free_result($result);

?>

</table>
</table>

</BODY>
</HTML>