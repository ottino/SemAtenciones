<?
session_cache_limiter('public');
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
?>


<HTML>
<HEAD>
<TITLE>A_Ctatenciones.php</TITLE>
</HEAD>

<body style="background-color:<?echo $body_color?>" style="font-size:<?echo $fontef?>">
<BODY>

<?
echo titulo_encabezado ('Cierre Telefónico de Atención' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }

$pasaid = $_POST["pasaid"];

$fechad1=  cambiarFormatoFecha1($fechad);
$fechah1=  cambiarFormatoFecha1($fechah);



//Ejecutamos la sentencia SQL

$result=mysql_query("select * from atenciones a, planes b WHERE id = ".$pasaid." order by id ");
$row=mysql_fetch_array($result);

echo '
<table width="100%" style="background-color:'.$body_color.';border-left-width: 0; border-top-width: 0; border-bottom-width: 0">
 <tr><td>
  <table width="100%" border="1" align="left">
  <tr>
    <td style="width:6000px"><INPUT TYPE="BUTTON" value="Imprimir" ALIGN ="left" onclick ="window.print()"></td>
    <td style="width:60px"><th> <a href="javascript:history.back(1)"/a> <img border="0" src="imagenes/Volver.ico" width="30" height="30"  align="top" /></th></td></td>
  </tr></table>
  <TR><TD>

  <table border="1" align="left" cellspacing="5" cellpadding="5" style="background-color:<?echo $th_color?>;border-left-width: 0; border-top-width: 0; border-bottom-width: 0">
    <tr style="font-size:'.$fontt.'">';


$id = $row["id"] + 0;
$fecha  =  cambiarFormatoFecha($row["fecha"]);
$color   =  buscocolor($row["color"]);
$colorm  =  buscocolor($row["colormedico"]);
$motivo  =  buscomotivo($row["motivo1"],$row["motivo2"]);
echo '<TD >ID</TD><td align="left">'.$id.'</td><td style="width:20px"></td>';
echo '<TD >TEL</TD><td align="left">'.$row["telefono"].'</td><td style="width:20px"></td>';

echo '<TD >Fecha</TD><td align="left">'.$fecha.'</td><td style="width:20px"></td><TD>COLOR: '.$color.' - '.$motivo.'</TD>';
echo '</tr></table><TR><TD><table border="1" align="left" cellspacing="5" cellpadding="5" style="background-color:<?echo $th_color?>;border-left-width: 0; border-top-width: 0; border-bottom-width: 0"><tr style="font-size:<?echo $fontt?>">';



$operador  =  buscopersonal($row["operec"]);
$medico  =  buscopersonal($row["medico"]);
$chofer  =  buscopersonal($row["chofer"]);
$diagnostico  =  buscodiagnostico($row["diagnostico"]);

if ($row["motanulacion"] > '0')
{   $medico = 'ANULADO';
   $diagnostico = buscoanulacion($row["motanulacion"]);
}

echo '<td align="left">NOMBRE:  '.$row["nombre"].'</td><td style="width:20px"></td>';
echo '<TD >EDAD: '.$row["edad"].'</TD><td align="left">SEXO: '.$row["sexo"].'</td><td style="width:20px"></td><TD>PLAN: '.$row["plan"].'-'.$row["descplan"].'</TD>';

echo '</tr></table><TR><TD><table border="1" align="left" cellspacing="5" cellpadding="5" style="background-color:<?echo $th_color?>;border-left-width: 0; border-top-width: 0; border-bottom-width: 0"><tr style="font-size:<?echo $fontt?>">';

echo '<TD>Dirección</TD><td align="left">CALLE: '.$row["calle"].' /*/ NRO: '.$row["numero"].' /*/ PISO: '.$row["piso"].' /*/ DPTO: '.$row["depto"].' /*/ CASA:'.$row["casa"].' /*/ MNB: '.$row["monoblok"].' /*/ ENTRE: '.$row["entre1"].' y '.$row["entre2"].' /*/ BARRIO: '.$row["barrio"].' /*/ LOCALIDAD: '.$row["localidad"].' /*/ REF: '.$row["referencia"].' /*/ TEL: '.$row["telefono"].'</td>';

echo '</tr></table><TR><TD><table border="1" align="left" cellspacing="5" cellpadding="5" style="background-color:<?echo $th_color?>;border-left-width: 0; border-top-width: 0; border-bottom-width: 0"><tr style="font-size:<?echo $fontt?>">';
echo '<TD>Atención</TD><td align="left">OPERADOR: '.$operador.'</td><td> MEDICO: '.$medico.'</td><td> CHOFER: '.$chofer.'</td><td> MOVIL: '.$row["movil"].'</td><td> GUARDIA: '.$row["movil_2"].'</td>';
echo '</tr></table><TR><TD><table border="1" align="left" cellspacing="5" cellpadding="5" style="background-color:<?echo $th_color?>;border-left-width: 0; border-top-width: 0; border-bottom-width: 0"><tr style="font-size:<?echo $fontt?>">';

$horallam = cambiarFormatoHora($row["horallam"]);
$horadesp = cambiarFormatoHora($row["horadesp"]);
$horasalbase = cambiarFormatoHora($row["horasalbase"]);
$horallegdom = cambiarFormatoHora($row["horallegdom"]);
$horasaldom = cambiarFormatoHora($row["horasaldom"]);
$horalleghosp = cambiarFormatoHora($row["horalleghosp"]);
$horasalhosp = cambiarFormatoHora($row["horasalhosp"]);
$horadisp = cambiarFormatoHora($row["horadisp"]);

echo '<TR><TD>Horarios</TD><td align="left">LLAM: '.$horallam.'</td><td>DESP: '.$horadesp.'</td><td>SAL.BASE: '.$horasalbase.'</td><td>L.DOM: '.$horallegdom.'</td><td>S.DOM: '.$horasaldom.'</td><td>L.HOSP: '.$horalleghosp.'</td><td>S.HOSP: '.$horasalhosp.'</td><td>DISP: '.$horadisp.'</td>';

echo '</tr></table><TR><TD><table border="1" align="left" cellspacing="5" cellpadding="5" style="background-color:<?echo $th_color?>;border-left-width: 0; border-top-width: 0; border-bottom-width: 0"><tr style="font-size:<?echo $fontt?>">';
echo '<TR><TD>Diagnóstico</TD><td style="width:800px" align="left"> '.$diagnostico.'</td><td> Color médico: '.$colorm.'</td><td> Coseg: '.$row["impcoseguro"].'</td></tr>';

echo '</tr></table><TR><TD><table border="1" align="left" cellspacing="5" cellpadding="5" style="background-color:<?echo $th_color?>;border-left-width: 0; border-top-width: 0; border-bottom-width: 0"><tr style="font-size:<?echo $fontt?>">';
echo '<TR><TD>Observaciones</TD><td style="width:900px" align="left">'.$row["obs_final"].'</td>';

$resultcta=mysql_query("select * from cta WHERE id = ".$row[cta]." order by 1");
$rowcta=mysql_fetch_array($resultcta);

echo '</tr></table><TR><TD><table border="1" align="left" cellspacing="5" cellpadding="5" style="background-color:<?echo $th_color?>;border-left-width: 0; border-top-width: 0; border-bottom-width: 0"><tr style="font-size:<?echo $fontt?>">';


$resulta=mysql_query("select * from clientes_nopadron WHERE idatencion = ".$id." order by idatencion, idnopadron");
while ($rowa=mysql_fetch_array($resulta))
 {
   echo '<TR><TD style="width:60px">Adicionales</TD><td style="width:650px" align="left">'.$id.' - Nombre: '.$rowa["nombre"].' - Edad: '.$rowa["edad"].' - Sexo: '.$rowa["sexo"].'</td></tr>';
 }
mysql_free_result($resulta);

mysql_free_result($result);

$resulta=mysql_query("select * from botiquin_cierre a, articulos b WHERE id_atencion = ".$id." and a.id_rubro = b.rubro and a.id_articulo = b.idarticulo order by 2,3");
while ($rowa=mysql_fetch_array($resulta))
 {
   echo '<TR><TD style="width:60px">Gasto Botiquin</TD><td style="width:650px" align="left">'.$rowa["id_articulo"].'-'.$rowa["id_rubro"].'-'.$rowa["articulo"].'</TD><td>'.$rowa["cantidad"].'</td></tr>';
 }
mysql_free_result($resulta);


$result=mysql_query("SELECT * FROM cta order by idcta, motcta");
$cta.='<option selected="selected" value="">Seleccione Respuesta</option>';
while ($row=mysql_fetch_array($result))
{
$cta.='<option value="'.$row['id'].'">'.$row['idcta'].' - '.$row['motcta'].' - '.$row['desccta'].'</option>';
}
mysql_free_result($result);


echo '<FORM METHOD="POST" NAME="formulario2" ACTION="A_Ctatenciones1.php">';
echo '<input type="hidden" name= "pasaid" value="'.$id.'" >';
echo '<TR><TD style="width:60px">Cierre Telefónico</TD><TD width="17" align="left" style="background-color:'.$body_color.'">
      <select name="cla_cta">'.$cta.'</select><textarea name="cla_observaciones" rows="5" cols="80"></textarea><label onclick="this.form.submit();" style="CURSOR: pointer">
                     <img align="middle" alt=\'Cierre Telefónico\' src="imagenes/Phone 4.ico" width="30" height="30"/>
                    </label></TD></tr>';


echo '</FORM>';




?>

</table>
</table>


</BODY>
</HTML>