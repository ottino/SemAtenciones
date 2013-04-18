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

<TITLE>B_Guardias.php</TITLE>
</HEAD>

<body style="background-color:<?echo $body_color?>">
<BODY>
<?
echo titulo_encabezado ('Baja de Guardia' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }

$guardia = $_POST["pasguardia"];

echo '<FORM METHOD="POST"
ACTION="B_Guardias2.php">';
//Creamos la sentencia SQL y la ejecutamos
$sSQL="select * from guardias a, legajos b, bases c WHERE
a.legajo = b.legajo and a.base = c.idbases and a.idguardia = ".$guardia;

$result=mysql_query($sSQL);

//Mostramos los registros en forma de menú desplegable
while ($row=mysql_fetch_array($result))
{

 $fecingreso = cambiarFormatoFecha($row['fecingreso']);
 $fecsalida  = cambiarFormatoFecha($row['fecsalida']);

 echo'<Table>';
 echo '<TR><TD>Legajo</TD><TD><input disabled="disabled" size= 10 type = "text" value = "'.$row[legajo].'" /></TD></TR>';
 echo '<TR><TD>Apellido y Nombres</TD><TD><input disabled="disabled" size= 50 type = "text" name = "'.$row[apeynomb].'" value = "'.$row[apeynomb].'" /></TD></TR>';
 echo '<TR><TD>F.Ingreso</TD><TD><input disabled="disabled" size= 10 type = "text" name = "cla_fecingreso" value = "'.$fecingreso.'" /></TD></TR>';
 echo '<TR><TD>H.Ingreso</TD><TD><input disabled="disabled" size= 50 type = "text" name = "cla_horaingreso" value = "'.$row[dni].'" /></TD></TR>';
 echo '<TR><TD>F.Salida</TD><TD><input disabled="disabled" size= 50 type = "text" name = "cla_fecsalida" value = "'.$fecsalida.'" /></TD></TR>';
 echo '<TR><TD>H.Salida</TD><TD><input disabled="disabled" size= 10 type = "text" name = "cla_horasalida" value = "'.$row[horasalida].'" /></TD></TR>';
 echo '<TR><TD>Base</TD><TD><input disabled="disabled" size= 10 type = "text" name = "cla_bases" value = "'.$row[descbases].'" /></TD></TR>';
 echo '<input type="hidden" name= "guar" value="'.$row[idguardia].'" >';
echo '</table>' ;
}
?>

    </span></th>
  </tr>
</table>
<br>
</select>

<INPUT name="SUBMIT" TYPE="submit" value="Borrar"></FORM>
    <th width="769" scope="col">

</FORM>
</div>
   </BODY>
</HTML>