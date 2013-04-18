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
<TITLE>A_Agenda.php</TITLE>
</HEAD>

<body style="background-color:<?echo $body_color?>">
<BODY>


<?
echo titulo_encabezado ('Alta de Contactos en Agenda' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }
?>


<br>
<FORM METHOD="POST"
ACTION="A_Agenda2.php">

<?
 echo'<Table>';
 echo '<TR><TD>Nombre</TD><TD><input size= 50 type = "text" name = "cla_nombre" /></TD></TR>';
 echo '<TR><TD>Dirección</TD><TD><input size= 50 type = "text" name = "cla_direccion" /></TD></TR>';
 echo '<TR><TD>Tel. Fijo</TD><TD><input size= 10 type = "text" name = "cla_telfijo" /></TD></TR>';
 echo '<TR><TD>Tel. Fijo 1</TD><TD><input size= 10 type = "text" name = "cla_telfijo1" /></TD></TR>';
 echo '<TR><TD>Fax</TD><TD><input size= 10 type = "text" name = "cla_fax" /></TD></TR>';
 echo '<TR><TD>Celular</TD><TD><input size= 10 type = "text" name = "cla_celular" /></TD></TR>';
 echo '<TR><TD>E-Mail</TD><TD><input size= 50 type = "text" name = "cla_email" /></TD></TR>';
 echo '<TR><TD>Empresa</TD><TD><input size= 50 type = "text" name = "cla_empresa" /></TD></TR>';
 echo '<TR><TD>Tel.Empresa</TD><TD><input size= 10 type = "text" name = "cla_etelfijo" /></TD></TR>';
 echo '<TR><TD>Tel.1.Empresa</TD><TD><input size= 10 type = "text" name = "cla_etelfijo1" /></TD></TR>';
 echo '<TR><TD>Fax Empresa</TD><TD><input size= 10 type = "text" name = "cla_efax" /></TD></TR>';
 echo '<TR><TD>E-Mail Empresa</TD><TD><input size= 50 type = "text" name = "cla_eemail" /></TD></TR>';
 echo '<TR><TD>Cargo</TD><TD><input size= 50 type = "text" name = "cla_cargo" /></TD></TR>';
 echo '<TR><TD>Acceso</TD><TD>
      <label>
        <input type="radio" name="cla_acceso" value="PUBL">
        PUBLICO</label><label>
        <input type="radio" name="cla_acceso" value="PRIV">
        PRIVADO</label></td></tr>';
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


