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
<TITLE>A_Articulos.php</TITLE>
</HEAD>
<body style="background-color:<?echo $body_color?>">

<BODY>


<?
echo titulo_encabezado ('Alta de Artículos' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }

//Ejecutamos la sentencia SQL
$result=mysql_query("select * from rubros order by 1");
$rubros= '<select name="rubros" style="background-color:'.$se_color.'"><option value="0">Rubro</option>';
while ($row=mysql_fetch_array($result))
{
$rubros.='<option value="'.$row['idrubro'].'">'.$row['descrubro'].'</option>';
}
mysql_free_result($result);
$rubros.= '</select>';


?>

<br>
<FORM METHOD="POST"
ACTION="A_Articulos2.php">

<?
 echo'<Table>';
 echo '<TR><TD>ID Articulo</TD><TD><input size= 50 type = "text" name = "cla_idarticulo" /></TD></TR>';
 echo '<TR><TD>Descripcion</TD><TD><input size= 50 type = "text" name = "cla_desarticulo" /></TD></TR>';
 echo '<TR><TD>Rubro</TD><TD>'.$rubros.'</TD></TR>';
 echo '<TR><TD>Cn Crítica</TD><TD><input size= 50 type = "text" name = "cla_cncritica" /></TD></TR>';

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


