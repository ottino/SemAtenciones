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
<TITLE>M_Atenciones.php</TITLE>
</HEAD>

<body style="background-color:<?echo $body_color?>" style="font-size:<?echo $fontef?>">
<BODY>

<?
echo titulo_encabezado ('Modificación de Atención' , $path_imagen_logo);
//$segmenu = valida_menu();
//if ($segmenu <> "OK")
//  { mensaje_error ('Principal.php', 'Usuario no autorizado');
//   exit;
//  }

$pasaid = $_POST["pasaid"];

if ($pasaid < 1)
  {
    $pasaid = $_GET["pasaid"];
  }

echo '<FORM METHOD="POST"
ACTION="M_Atenciones2.php">';

//Ejecutamos la sentencia SQL
$result=mysql_query("select * from atenciones a, planes b WHERE id = ".$pasaid." order by id ");
$row=mysql_fetch_array($result);


$id = $row["id"] + 0;

$horallam = cambiarFormatoHora($row["horallam"]);
$horallegdom = cambiarFormatoHora($row["horallegdom"]);
$fecha  =  cambiarFormatoFecha($row["fecha"]);
$fechallam  =  cambiarFormatoFecha($row["fechallam"]);
$color   =  buscocolor($row["color"]);
$colorm  =  buscocolor($row["colormedico"]);
$motivo  =  buscomotivo($row["motivo1"],$row["motivo2"]);
$descplan  =  buscoplan($row["plan"]);

$resultcol=mysql_query("SELECT * FROM colores order by orden");
while ($rowcol=mysql_fetch_array($resultcol))
{ if ($rowcol['idcolor'] == $row["color"])
     $color.='<option selected="selected" value="'.$rowcol['idcolor'].'">'.$rowcol['desc'].'</option>';
  else
     $color.='<option value="'.$rowcol['idcolor'].'">'.$rowcol['desc'].'</option>';
}
mysql_free_result($resultcol);

$resultcolm=mysql_query("SELECT * FROM colores order by orden");
while ($rowcolm=mysql_fetch_array($resultcolm))
{ if ($rowcolm['idcolor'] == $row["colormedico"])
     $colorm.='<option selected="selected" value="'.$rowcolm['idcolor'].'">'.$rowcolm['desc'].'</option>';
  else
     $colorm.='<option value="'.$rowcolm['idcolor'].'">'.$rowcolm['desc'].'</option>';
}
mysql_free_result($resultcolm);

$resultdiag=mysql_query("SELECT * FROM diagnosticos order by descdiagnostico");
while ($rowdiag=mysql_fetch_array($resultdiag))
{ if ($rowdiag['iddiagnostico'] == $row["diagnostico"])
     $diagnostico.='<option selected="selected" value="'.$rowdiag['iddiagnostico'].'">'.$rowdiag['descdiagnostico'].'</option>';
  else
     $diagnostico.='<option value="'.$rowdiag['iddiagnostico'].'">'.$rowdiag['descdiagnostico'].'</option>';
}
mysql_free_result($resultdiag);

$resultmov=mysql_query("SELECT * FROM movildisponible a, moviles b where a.idmovil = b.idmovil and a.vigente <> '1' order by b.idmovil");
while ($rowmov=mysql_fetch_array($resultmov))
{ if ($rowmov['idmovildisp'] == $row["movil_2"])
     $movil.='<option selected="selected" value="'.$rowmov['idmovildisp'].'">'.$rowmov[9].'-'.$rowmov['descmovil'].'</option>';
  else
     $movil.='<option value="'.$rowmov['idmovildisp'].'">'.$rowmov[9].'-'.$rowmov['descmovil'].'</option>';
}
mysql_free_result($resultmov);


echo '
   <table width="100%" style="background-color:<?echo $th_color?>;border-left-width: 0; border-top-width: 0; border-bottom-width: 0">
   <tr><td>
    <table width="80%" border="1" align="left" >
    <tr>';

echo '<TD >ID</TD><td align="left">'.$id.'</td><td style="width:20px"></td>';
echo '<TD >Ingreso:</TD><td align="left">'.$fechallam.'-'.$horallam.'</td><TD >Atención:</TD><td align="left">'.$fecha.'-'.$horallegdom.'</td><td style="width:20px"></td><TD><select name="cla_color">'.$color.'</select></TD><TD> - '.$motivo.'</TD>';
echo '</tr></table><TR><TD><table border="1" align="left" cellspacing="5" cellpadding="5"><tr style="font-size:<?echo $fontt?>">';



$operador  =  buscopersonal($row["operec"]);
$despachador  =  buscopersonal($row["opedesp"]);
$medico  =  buscopersonal($row["medico"]);
$chofer  =  buscopersonal($row["chofer"]);
//$diagnostico  =  buscodiagnostico($row["diagnostico"]);
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
echo '<TD>Atención</TD><td align="left">OPER.: '.substr($operador,0,15).'</td><td align="left">DESP.: '.substr($despachador,0,15).'</td><td> MEDICO: '.substr($medico,0,15).'</td><td> CHOFER: '.substr($chofer,0,15).'</td><TD><select name="cla_movil">'.$movil.'</select></TD>';
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
echo '<TR><TD>Diagnóstico</TD><td style="width:400px" align="left"><select name="cla_diagnostico">'.$diagnostico.'</select></td><TD>Destino</TD><td style="width:300px" align="left"> '.substr($destino,0,20).'</td><td> Color médico:</td><TD><select name="cla_colorm">'.$colorm.'</select></TD><td>Coseg.:</TD><td><input size= 6 type = "text" name = "cla_impcoseguro" value = "'.$impocoseguro.'" /></td></tr>';

echo '</tr></table><TR><TD><table border="1" align="left" cellspacing="5" cellpadding="5"><tr style="font-size:<?echo $fontt?>">';
echo '<TR><TD>Observaciones</TD><td style="width:900px" align="left">'.$row["observa1"].' // '.$row["observa2"].' // '.$row["obs_final"].'</td>';
echo '<TR><td></td><td td style="width:900px" align="left"><input size= 150 type = "text" name = "cla_observa" /></td></tr>';


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

echo '<TR><TD>Ingrese su clave</TD><td style="width:150px" align="left"><input type="password" name= "cla_clave" ></td></tr>';

mysql_free_result($resulta);

mysql_free_result($result);


echo '<input type="hidden" name= "pasaid" value="'.$pasaid.'" >';

?>

</table>
</table>

<INPUT name="SUBMIT" TYPE="submit" value="Actualizar"></FORM>
    <th width="769" scope="col">

</FORM>

</BODY>
</HTML>