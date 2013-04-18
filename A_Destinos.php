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
<TITLE>A_Destinos.php</TITLE>
</HEAD>

<body style="background-color:<?echo $body_color?>">
<BODY>


<?
echo titulo_encabezado ('Alta de Destinos' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }
?>


<br>
<FORM METHOD="POST"
ACTION="A_Destinos2.php">

<?
 echo'<Table>';
 echo '<TR><TD>ID Destino</TD><TD><input size= 50 type = "text" name = "cla_iddestino" /></TD></TR>';
 echo '<TR><TD>Destino</TD><TD><input size= 50 type = "text" name = "cla_destino" /></TD></TR>';
 echo '<TR><TD>Domicilio</TD><TD><input size= 50 type = "text" name = "cla_domicilio" /></TD></TR>';
 echo '<TR><TD>Localidad</TD><TD><input size= 50 type = "text" name = "cla_localidad" /></TD></TR>';
 echo '<TR><TD>Telefono</TD><TD><input size= 50 type = "text" name = "cla_telefono" /></TD></TR>';
 echo '<TR><TD>Tipo</TD><TD><input size= 50 type = "text" name = "cla_tipo" /></TD></TR>';
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


