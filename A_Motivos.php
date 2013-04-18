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
<TITLE>A_Motivos.php</TITLE>
</HEAD>

<body style="background-color:<?echo $body_color?>">
<BODY>


<?
echo titulo_encabezado ('Alta de Motivos' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }
?>


<br>
<FORM METHOD="POST"
ACTION="A_Motivos2.php">

<INPUT TYPE="SUBMIT" value="Insertar">

<?
$result=mysql_query("SELECT * FROM colores order by 1");
$colores= '<select name="idmotivo" style="width:150px" style="background-color:'.$se_color.'"><option value="0">Color</option>';
while ($row=mysql_fetch_array($result))
{
$colores.='<option value="'.$row['idcolor'].'">'.$row['desc'].'</option>';
}
mysql_free_result($result);
$colores.= '</select>';


 echo'<Table>';
 echo '<TR><TD>ID Color</TD><TD>'.$colores.'</TD>';
 echo '<TR><TD>ID Motivo</TD><TD><input size= 50 type = "text" name = "idmotivo2" /></TD></TR>';
 echo '<TR><TD>Descripcion</TD><TD><input size= 50 type = "text" name = "descripcion" /></TD></TR>';
 echo '<TR><TD>Instrucciones Pre-arribo</TD><TD><textarea name="cla_instrucciones" rows="25" cols="60"></textarea></TD></TR>';
 echo '</table>' ;
?>


    </span></th>
  </tr>
</table>
<br>
</select>


</FORM>
</div>
   </BODY>
</HTML>


