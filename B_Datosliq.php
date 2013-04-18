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
<TITLE>B_Datosliq.php</TITLE>
</HEAD>

<body style="background-color:<?echo $body_color?>">
<BODY>


<?
echo titulo_encabezado ('Baja de Parámetros Liquidación' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }

$iddatos = $_POST["pasdatos"];


echo '<FORM METHOD="POST"
ACTION="B_Datosliq2.php">';
//Creamos la sentencia SQL y la ejecutamos
$sSQL="Select * From datosliq where id = ".$iddatos;

$result=mysql_query($sSQL);

while ($row=mysql_fetch_array($result))
{echo'<Table>';
 echo '<TR><TD>ID</TD><TD><input disabled="disabled" size= 50 type = "text" name = "cla_id" value = "'.$row[id].'"/></TD></TR>';
 echo '<TR><TD>Tipo Movil</TD><TD><input disabled="disabled" size= 6 type = "text" name = "cla_tipmovil" value = "'.$row[tipmovil].'" /></TD></TR>';
 echo '<TR><TD>Tipo Medico</TD><TD><input disabled="disabled" size= 6 type = "text" name = "cla_tipmedico" value = "'.$row[tipmed].'"/></TD></TR>';
 echo '<TR><TD>Descripción</TD><TD><input disabled="disabled" size= 50 type = "text" name = "cla_descripcion" value = "'.$row[descripcion].'"/></TD></TR>';
 echo '<TR><TD>Importe Fijo</TD><TD><input disabled="disabled" size= 10 type = "text" name = "cla_fijo" value = "'.$row[fijo].'"/></TD></TR>';
 echo '<TR><TD>Ad.Noct Fijo</TD><TD><input disabled="disabled" size= 10 type = "text" name = "cla_anfijo" value = "'.$row[anfijo].'"/></TD></TR>';
 echo '<TR><TD>Cn.Base Incl.</TD><TD><input disabled="disabled" size= 10 type = "text" name = "cla_cnbase" value = "'.$row[cnbase].'"/></TD></TR>';
 echo '<TR><TD>Importe Base</TD><TD><input disabled="disabled" size= 10 type = "text" name = "cla_impbase" value = "'.$row[impbase].'"/></TD></TR>';
 echo '<TR><TD>Ad.Noct I.Base</TD><TD><input disabled="disabled" size= 10 type = "text" name = "cla_animpbase" value = "'.$row[animpbase].'"/></TD></TR>';
 echo '<TR><TD>Importe Excedentes</TD><TD><input disabled="disabled" size= 10 type = "text" name = "cla_impexcedentes" value = "'.$row[impexcedentes].'"/></TD></TR>';
 echo '<TR><TD>Importe Anulados</TD><TD><input disabled="disabled" size= 10 type = "text" name = "cla_impanulados" value = "'.$row[impanulados].'"/></TD></TR>';
 echo '<TR><TD>Cn Simultáneos</TD><TD><input disabled="disabled" size= 10 type = "text" name = "cla_cnsimultaneos" value = "'.$row[cnsimultaneos].'"/></TD></TR>';
 echo '<TR><TD>Importe Simultáneos</TD><TD><input disabled="disabled" size= 10 type = "text" name = "cla_impsimultaneos" value = "'.$row[impsimultaneos].'"/></TD></TR>';
 echo '<TR><TD>Ad.Noct I.Excedentes</TD><TD><input disabled="disabled" size= 10 type = "text" name = "cla_animpexcede" value = "'.$row[animpexcede].'"/></TD></TR>';
 echo '<TR><TD>Ad.Zona I.Excedentes</TD><TD><input disabled="disabled" size= 10 type = "text" name = "cla_azimpexcede" value = "'.$row[azimpexcede].'"/></TD></TR>';
 echo '<TR><TD>Ad.Finde I.Excedentes</TD><TD><input disabled="disabled" size= 10 type = "text" name = "cla_afdimpexcede" value = "'.$row[afdimpexcede].'"/></TD></TR>';
 echo '<TR><TD>Ultima Actualización</TD><TD><input disabled="disabled" size= 10 type = "text" name = "cla_fultact" value = "'.$row[fecultact].'"/></TD></TR>';
 echo '<input type="hidden" name= "datos" value="'.$row["id"].'" >';
 echo '</table>' ;
}

mysql_free_result($result)


?>
    </span></th>
  </tr>
</table>
<br>
</select>
<INPUT TYPE="SUBMIT" value="Borrar">
</FORM>
</div>
<FORM METHOD="POST" ACTION="ABM_Datosliq.php">
<INPUT name="SUBMIT" TYPE="submit" value="Volver"></FORM>
</BODY>
</HTML>