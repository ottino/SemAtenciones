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
?>


<HTML>
<HEAD>
<TITLE>C_Atenciones.php</TITLE>
</HEAD>

<body style="background-color:<?echo $body_color?>" style="font-size:<?echo $fontef?>">
<BODY>

<?
echo titulo_encabezado ('Consulta de Atención' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }

$lestad1      = $_POST["lestad1"];
$lestad2      = $_POST["lestad2"];
$lestad3      = $_POST["lestad3"];
$lestad4      = $_POST["lestad4"];
$lestad5      = $_POST["lestad5"];
$lestadf      = $_POST["lestadf"];
$lestadf1     = $_POST["lestadf1"];
$lestadcol    = $_POST["lestadcol"];
$lestadh1     = $_POST["lestadh1"];
$lestadh2     = $_POST["lestadh2"];
$lestadmin    = $_POST["lestadmin"];

$fechad = $_POST["cla_fecha"];
$fechah = $_POST["cla_fecha1"];
$nombre = $_POST["cla_nombre"];
$diag = $_POST["cla_diag"];
$vengo = $_POST["vengo"];
$idguardia1 = $_POST["cla_idguardia"];
$idatencion = $_POST["cla_idatencion"];
$idord = $_POST["cla_ord"];
$idestado = $_POST["cla_estado"];
$plan1 = $_POST["cla_plan"];

$movdisp = $_POST["pasguardia"];

list($pagina, $pasdatos) = explode("?", $_SERVER['HTTP_REFERER']);

if ($movdisp > '0')
   { $pagina1 = '?cla_ord='.$idord.'&cla_estado='.$idestado.'&pasdatos='.$movdisp.'&vengo='.$vengo.'&cla_fecha='.$fechad.'&cla_fecha1='.$fechah.'&cla_nombre='.$nombre.'&cla_idguardia='.$idguardia1.'&cla_plan='.$plan1.'&cla_diag='.$diag; }
 else
   { $pagina1 = '?cla_ord='.$idord.'&cla_estado='.$idestado.'&pasdatos='.$movdisp.'&vengo='.$vengo.'&cla_fecha='.$fechad.'&cla_fecha1='.$fechah.'&cla_nombre='.$nombre.'&cla_idatencion='.$idatencion.'&cla_plan='.$plan1.'&cla_diag='.$diag; }


$pagina = $pagina.$pagina1;

$pasaid = $_POST["pasaid"];

$fechad1=  cambiarFormatoFecha1($fechad);
$fechah1=  cambiarFormatoFecha1($fechah);



//Ejecutamos la sentencia SQL

$result=mysql_query("select * from atenciones a, planes b WHERE id = ".$pasaid." order by id ");
$row=mysql_fetch_array($result);

if ($lestad1 < '1' && $_POST["demora"] != 'DEMORA')
 { echo '
   <table width="100%" style="background-color:<?echo $th_color?>;border-left-width: 0; border-top-width: 0; border-bottom-width: 0">
   <tr><td>
    <table width="100%" border="1" align="left" >
    <tr>
    <td style="width:6000px"><INPUT TYPE="BUTTON" value="Imprimir" ALIGN ="left" onclick ="window.print()"></td>
      <td><a href="'.$pagina.'"/a> <img border="0" src="imagenes/Volver.ico" width="30" height="30"  align="top" /></td>
  </tr></table>
  <TR><TD>

  <table border="1" align="left" cellspacing="5" cellpadding="5">
    <tr style="font-size:<?echo $fontt?>"> ';
  }
 else
 { echo '
     <table width="100%" style="background-color:<?echo $th_color?>;border-left-width: 0; border-top-width: 0; border-bottom-width: 0">
      <tr><td>
       <table width="100%" border="1" align="left" >
       <tr>
         <td style="width:6000px"><INPUT TYPE="BUTTON" value="Imprimir" ALIGN ="left" onclick ="window.print()"></td>
         <td>';
   if ($_POST["demora"] == 'DEMORA')
    {
     echo '<FORM METHOD="POST" NAME="formulario2" ACTION="L_Estadisticas2.php">';
     echo '<input type="hidden" name= "cla_fecha" value  ="'.$_POST["lestadf"].'" >';
     echo '<input type="hidden" name= "cla_fecha1" value ="'.$_POST["lestadf1"].'" >';
     echo '<input type="hidden" name= "cla_color" value="'.$_POST["lestadcol"].'" >';
     echo '<input type="hidden" name= "hora1" value ="'.$_POST["lestadh1"].'" >';
     echo '<input type="hidden" name= "hora2" value ="'.$_POST["lestadh2"].'" >';
     echo '<input type="hidden" name= "cla_minuto" value="'.$_POST["lestadmin"].'" >';
     echo '<input type="hidden" name= "demora" value="'.$_POST["demora"].'" >';
    }
   else
    {
     echo '<FORM METHOD="POST" NAME="formulario2" ACTION="L_Estadisticas1.php">';
     echo '<input type="hidden" name= "pasaid" value="VUELVOCATENCIONES" >';
     echo '<input type="hidden" name= "cla_estad1" value  ="'.$_POST["lestad1"].'" >';
     echo '<input type="hidden" name= "cla_estad2" value  ="'.$_POST["lestad2"].'" >';
     echo '<input type="hidden" name= "cla_estad3" value  ="'.$_POST["lestad3"].'" >';
     echo '<input type="hidden" name= "cla_estad4" value  ="'.$_POST["lestad4"].'" >';
     echo '<input type="hidden" name= "cla_estad5" value  ="'.$_POST["lestad5"].'" >';
     echo '<input type="hidden" name= "cla_fecha" value  ="'.$_POST["lestadf"].'" >';
     echo '<input type="hidden" name= "cla_fecha1" value ="'.$_POST["lestadf1"].'" >';
     echo '<input type="hidden" name= "cla_color" value="'.$_POST["lestadcol"].'" >';
     echo '<input type="hidden" name= "hora1" value ="'.$_POST["lestadh1"].'" >';
     echo '<input type="hidden" name= "hora2" value ="'.$_POST["lestadh2"].'" >';
     echo '<input type="hidden" name= "cla_minuto" value="'.$_POST["lestadmin"].'" >';
    }

   echo ' <td width="17" align="center" style="background-color:'.$td_color.'">
                     <label onclick="this.form.submit();" style="CURSOR: pointer" >
                      <img align="middle" alt=\'Volver\' src="imagenes/Volver.ico" width="30" height="30"/>
                     </label>
                   </td>';
   echo '</FORM></FORM></tr></table><TR><TD>
         <table border="1" align="left" cellspacing="5" cellpadding="5">
         <tr style="font-size:<?echo $fontt?>"> ';
  };





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

echo '<td align="left">NOMBRE:  '.$row["nombre"].'</td><td style="width:20px"></td>';
echo '<TD >EDAD: '.$row["edad"].'</TD><td align="left">SEXO: '.$row["sexo"].'</td><td style="width:20px"></td><TD>PLAN: '.$row["plan"].'-'.$descplan.'</TD><TD></TD><TD>IDENTIF: '.$row["identificacion"].'</TD>';

echo '</tr></table><TR><TD><table border="1" align="left" cellspacing="5" cellpadding="5"><tr style="font-size:<?echo $fontt?>">';

echo '<TD>Dirección</TD><td align="left">CALLE: '.$row["calle"].' /*/ NRO: '.$row["numero"].' /*/ PISO: '.$row["piso"].' /*/ DPTO: '.$row["depto"].' /*/ CASA:'.$row["casa"].' /*/ MNB: '.$row["monoblok"].' /*/ ENTRE: '.$row["entre1"].' y '.$row["entre2"].' /*/ BARRIO: '.$row["barrio"].' /*/ LOCALIDAD: '.$row["localidad"].' /*/ REF: '.$row["referencia"].' /*/ TEL: '.$row["telefono"].'</td>';

echo '</tr></table><TR><TD><table border="1" align="left" cellspacing="5" cellpadding="5"><tr style="font-size:<?echo $fontt?>">';
echo '<TD>Atención</TD><td align="left">OPER.: '.substr($operador,0,15).'</td><td align="left">DESP.: '.substr($despachador,0,15).'</td><td> MEDICO: '.substr($medico,0,15).'</td><td> CHOFER: '.substr($chofer,0,15).'</td><td> MOVIL: '.$row["movil"].'</td><td> GUARDIA: '.$row["movil_2"].'</td>';
echo '</tr></table><TR><TD><table border="1" align="left" cellspacing="5" cellpadding="5"><tr style="font-size:<?echo $fontt?>">';

$horallam = cambiarFormatoHora($row["horallam"]);
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