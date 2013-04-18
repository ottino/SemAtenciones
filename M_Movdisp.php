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
<TITLE>M_Movdisp.php</TITLE>
</HEAD>

<body style="background-color:<?echo $body_color?>">
<BODY>
<?
echo titulo_encabezado ('Modificación Moviles de Guardia' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }

$movdisp = $_POST["pasmovildisp"];

////////////////////////////////

//Creamos la sentencia SQL y la ejecutamos
$sSQL="select * from movildisponible where idmovildisp = ".$movdisp;
$result=mysql_query($sSQL);
$row=mysql_fetch_array($result);
$legmedico = $row['legmedico'];
$legchofer = $row['legchofer'];
$legenfermero = $row['legenfermero'];
$base = $row['idbase'];
$moviles = $row['idmovil'];



//Ejecutamos la sentencia SQL

$vector_tipo= '<select name ="tipo" style="background-color:'.$se_color.'"><option value="0">Tipo Guardia</option>';

if ($row["tipoguardia"]== '1')
    {      $vector_tipo.= '<option selected="selected" value="1">UTI</option>';
           $vector_tipo.= '<option value="2">PARTICULAR</option>';
           $vector_tipo.= '<option value="3">TRASLADO</option>';
           $vector_tipo.= '<option value="4">EVENTO</option>';
    }
if ($row["tipoguardia"]== '2')
    {      $vector_tipo.= '<option value="1">UTI</option>';
           $vector_tipo.= '<option selected="selected" value="2">PARTICULAR</option>';
           $vector_tipo.= '<option value="3">TRASLADO</option>';
           $vector_tipo.= '<option value="4">EVENTO</option>';
    }
if ($row["tipoguardia"]== '3')
    {      $vector_tipo.= '<option value="1">UTI</option>';
           $vector_tipo.= '<option value="2">PARTICULAR</option>';
           $vector_tipo.= '<option selected="selected" value="3">TRASLADO</option>';
           $vector_tipo.= '<option value="4">EVENTO</option>';
    }
if ($row["tipoguardia"]== '4')
    {      $vector_tipo.= '<option value="1">UTI</option>';
           $vector_tipo.= '<option value="2">PARTICULAR</option>';
           $vector_tipo.= '<option value="3">TRASLADO</option>';
           $vector_tipo.= '<option selected="selected" value="4">EVENTO</option>';
    }

$vector_tipo.= '</select>';


//$result=mysql_query("select * from legajos where legajo = ".$legchofer." order by 1");

$legajosc= '<select name="legajoc" style="background-color:'.$se_color.'"><option value="0">Chofer</option>';
$result=mysql_query("select * from legajos where (funcion in (1,2,3,4,5) and legajo not in
(select legchofer from movildisponible where vigente <> '1')) or
 legajo = ".$legchofer." order by 2");

while ($row=mysql_fetch_array($result))
{
if ($row['legajo']== $legchofer)
 $legajosc.='<option selected = "selected" value="'.$row['legajo'].'">'.$row['apeynomb'].'</option>';
else
 $legajosc.='<option value="'.$row['legajo'].'">'.$row['apeynomb'].'</option>';
}
$legajosc.= '</select>';


$result=mysql_query("select * from legajos where (funcion in (1,2) and legajo not in
(select legmedico from movildisponible where vigente <> '1')) or
 legajo = ".$legmedico." order by 2");

$legajos= '<select name="legajo" style="background-color:'.$se_color.'"><option value="0">Medico</option>';
while ($row=mysql_fetch_array($result))
{
if ($row['legajo']== $legmedico)
 $legajos.='<option selected = "selected" value="'.$row['legajo'].'">'.$row['apeynomb'].'</option>';
else
 $legajos.='<option value="'.$row['legajo'].'">'.$row['apeynomb'].'</option>';
}
$legajos.= '</select>';


$result=mysql_query("select * from legajos where (funcion in (3,4,5) and legajo not in
(select legenfermero from movildisponible where vigente <> '1')) or
 legajo = ".$legenfermero." order by 2");

$legajose= '<select name="legajoe" style="background-color:'.$se_color.'"><option value="0">Enfermero</option>';
while ($row=mysql_fetch_array($result))
{
if ($row['legajo']== $legenfermero)
 $legajose.='<option selected = "selected" value="'.$row['legajo'].'">'.$row['apeynomb'].'</option>';
else
 $legajose.='<option value="'.$row['legajo'].'">'.$row['apeynomb'].'</option>';
}
$legajose.= '</select>';

mysql_free_result($result);




//Ejecutamos la sentencia SQL  SELECCIONAR BASE
$result=mysql_query("select * from bases order by 1");

$bases= '<select name="base" style="background-color:'.$se_color.'"><option value="0">Base</option>';

while ($row=mysql_fetch_array($result))
{
if ($row['idbases']== $base)
  $bases.='<option selected = "selected" value="'.$row['idbases'].'">'.$row['descbases'].'</option>';
else
  $bases.='<option value="'.$row['idbases'].'">'.$row['descbases'].'</option>';
}
mysql_free_result($result);
$bases.= '</select>';



//Ejecutamos la sentencia SQL SELECCIONA MOVILES
$result=mysql_query("select * from moviles where (idmovil not in
                     (select idmovil from movildisponible where vigente <> '1')) or
                     idmovil = ".$moviles." order by 1");

$movil= '<select name="movil" style="background-color:'.$se_color.'"><option value="0">Movil</option>';

while ($row=mysql_fetch_array($result))
{
if ($row['idmovil']== $moviles)
   $movil.='<option selected = "selected" value="'.$row['idmovil'].'">'.$row['idmovil'].'-'.$row['descmovil'].'</option>';
else
   $movil.='<option value="'.$row['idmovil'].'">'.$row['idmovil'].'-'.$row['descmovil'].'</option>';
}
mysql_free_result($result);
$movil.= '</select>';






//////////////////////////////


//echo $destino;


echo '<FORM METHOD="POST"
ACTION="M_Movdisp2.php">';
//Creamos la sentencia SQL y la ejecutamos
$sSQL="select * from movildisponible where idmovildisp = ".$movdisp;
$result=mysql_query($sSQL);


//Mostramos los registros en forma de menú desplegable
while ($row=mysql_fetch_array($result))
{echo'<Table>';
 echo '<input type="hidden" name= "movdisp" value="'.$row["idmovildisp"].'" >';
 echo '<TR><TD>Movil</TD><TD>'.$movil.'</TD></TR>';
 echo '<TR><TD>Tipo Guardia</TD><TD>'.$vector_tipo.'</TD></TR>';
 echo '<TR><TD>Base</TD><TD>'.$bases.'</TD></TR>';
 echo '<TR><TD>Chofer</TD><TD>'.$legajosc.'</TD></TR>';
 echo '<TR><TD>Medico</TD><TD>'.$legajos.'</TD></TR>';
 echo '<TR><TD>Enfermero</TD><TD>'.$legajose.'</TD></TR>';
 echo '<TR><TD>KM Salida</TD><TD><input size= 12 type = "text" name = "cla_kmalta" value = "'.$row[kmalta].'" /></TD></TR>';
 echo '<input type="hidden" name= "fecalta" value="'.$row["fecalta"].'" >';
 echo '<input type="hidden" name= "horaalta" value="'.$row["horaalta"].'" >';
 echo '</table>' ;
}

?>
    </span></th>
  </tr>
</table>
<br>
</select>

<INPUT name="SUBMIT" TYPE="submit" value="Actualizar"></FORM>
    <th width="769" scope="col">

</FORM>
</div>
<FORM METHOD="POST" ACTION="ABM_Movdisp.php">
<INPUT name="SUBMIT" TYPE="submit" value="Volver"></FORM>

   </BODY>
</HTML>