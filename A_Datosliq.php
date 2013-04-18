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
<TITLE>A_Datosliq.php</TITLE>
</HEAD>

<body style="background-color:<?echo $body_color?>">
<BODY>


<?
echo titulo_encabezado ('Alta de Parámetros Liquidación' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }
?>


<br>
<FORM METHOD="POST"
ACTION="A_Datosliq2.php">

<?
 echo'<Table>';
 echo '<TR><TD>ID</TD><TD><input disabled="disabled" size= 50 type = "text" name = "cla_id" /></TD></TR>';
 echo '<TR><TD>Tipo Movil</TD><TD><input size= 6 type = "text" name = "cla_tipmovil" /></TD></TR>';
 echo '<TR><TD>Tipo Medico</TD><TD><input size= 6 type = "text" name = "cla_tipmedico" /></TD></TR>';
 echo '<TR><TD>Descripción</TD><TD><input size= 50 type = "text" name = "cla_descripcion" /></TD></TR>';
 echo '<TR><TD>Importe Fijo</TD><TD><input size= 10 type = "text" name = "cla_fijo" /></TD></TR>';
 echo '<TR><TD>Ad.Noct Fijo</TD><TD><input size= 10 type = "text" name = "cla_anfijo" /></TD></TR>';
 echo '<TR><TD>Cn.Base Incl.</TD><TD><input size= 10 type = "text" name = "cla_cnbase" /></TD></TR>';
 echo '<TR><TD>Importe Base</TD><TD><input size= 10 type = "text" name = "cla_impbase" /></TD></TR>';
 echo '<TR><TD>Ad.Noct I.Base</TD><TD><input size= 10 type = "text" name = "cla_animpbase" /></TD></TR>';
 echo '<TR><TD>Importe Excedentes</TD><TD><input size= 10 type = "text" name = "cla_impexcedentes" /></TD></TR>';
 echo '<TR><TD>Importe Anulados</TD><TD><input size= 10 type = "text" name = "cla_impanulados" /></TD></TR>';
 echo '<TR><TD>Cn Simultáneos</TD><TD><input size= 10 type = "text" name = "cla_cnsimultaneos" /></TD></TR>';
 echo '<TR><TD>Importe Simultáneos</TD><TD><input size= 10 type = "text" name = "cla_impsimultaneos" /></TD></TR>';
 echo '<TR><TD>Ad.Noct I.Excedentes</TD><TD><input size= 10 type = "text" name = "cla_animpexcede" /></TD></TR>';
 echo '<TR><TD>Ad.Zona I.Excedentes</TD><TD><input size= 10 type = "text" name = "cla_azimpexcede" /></TD></TR>';
 echo '<TR><TD>Ad.Finde I.Excedentes</TD><TD><input size= 10 type = "text" name = "cla_afdimpexcede" /></TD></TR>';
 echo '</table>' ;
?>


<INPUT TYPE="SUBMIT" value="Insertar">

    </span></th>
  </tr>
</table>
<br>
</select>


</FORM>
</div>
   </BODY>
</HTML>


