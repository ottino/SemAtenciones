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
<TITLE>A_Motctrlcaja.php</TITLE>
</HEAD>

<body style="background-color:<?echo $body_color?>">
<BODY>


<?
echo titulo_encabezado ('Alta de Motivos de Mov. Caja' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }
?>


<br>
<FORM METHOD="POST"
ACTION="A_Motctrlcaja2.php">

<?

 echo'<Table>';
 echo '<TR><TD>CODIGO</TD><TD><input size= 5 type = "text" name = "idmotivo" /></TD></TR>';
 echo '<TR><TD>Descripcion</TD><TD><input size= 50 type = "text" name = "descripcion" /></TD></TR>';
 echo '</table>' ;
?>
<INPUT TYPE="SUBMIT" value="Insertar"></FORM>

<FORM METHOD="POST" ACTION="ABM_Motctrlcaja.php">

<INPUT name="SUBMIT" TYPE="submit" value="Volver"></FORM>

    </span></th>
  </tr>
</table>
<br>
</select>


</FORM>
</div>
   </BODY>
</HTML>


