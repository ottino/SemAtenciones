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

<TITLE>A_Botiquines.php</TITLE>
</HEAD>
<BODY>

<?
echo titulo_encabezado ('Alta de Elemento del Botiquin' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }

$idbotiquin = $_POST["pasabotiquin"];

//Creamos la sentencia SQL y la ejecutamos
$sSQL="select * from botiquines where idbotiquines = ".$idbotiquin;
//echo $sSQL;
$result=mysql_query($sSQL);
$row=mysql_fetch_array($result);

$idbotiquin = $row['idbotiquines'];
$moviles = $row['idmovil'];
$articulo = $row['idarticulo'];
$rubro = $row['rubro'];
$cantidad = $row['cantidad'];
$cnminima = $row['cnminima'];


//Ejecutamos la sentencia SQL
$result=mysql_query("select * from moviles order by 1");
$movil= '<select name="movil" style="background-color:'.$se_color.'"><option value="0">Moviles</option>';
while ($row=mysql_fetch_array($result))
{
if ($row['idmovil']== $moviles)
   $movil.='<option selected = "selected" value="'.$row['idmovil'].'">'.$row['idmovil'].'-'.$row['descmovil'].'</option>';
else
   $movil.='<option value="'.$row['idmovil'].'">'.$row['idmovil'].'-'.$row['descmovil'].'</option>';
}
mysql_free_result($result);
$movil.= '</select>';


//Ejecutamos la sentencia SQL para los articulos
$result=mysql_query("select * from articulos a, rubros b where a.rubro = b.idrubro order by 2");
$arti= '<select name="artic" style="background-color:'.$se_color.'"><option value="0">Artículo</option>';
while ($row=mysql_fetch_array($result))
{
if ($row['idarticulo']== $articulo and $row['rubro']== $rubro)
 $arti.='<option selected = "selected" value="'.$row['idarticulo'].'-'.$row['rubro'].'">'.$row['articulo'].'-'.$row['descrubro'].'</option>';
else
 $arti.='<option value="'.$row['idarticulo'].'-'.$row['rubro'].'">'.$row['articulo'].'-'.$row['descrubro'].'</option>';
}
mysql_free_result($result);
$arti.= '</select>';

?>


<body style="background-color:<?echo $body_color?>">
<FORM METHOD="POST" NAME="formulario3"
ACTION="M_Botiquines2.php">

<?
 echo'<Table>';
 echo '<TR><TD>Moviles</TD><TD>'.$movil.'</TD></TR>';
 echo '<TR><TD>Artículos</TD><TD>'.$arti.'</TD></TR>';
 echo '<TR><TD>Cantidad</TD><TD><input size= 12 type = "text" name = "cla_cantidad" value = "'.$cantidad.'" /></TD></TR>';
 echo '<TR><TD>Cn Minima</TD><TD><input size= 12 type = "text" name = "cla_cnminima" value = "'.$cnminima.'"/></TD></TR>';
 echo '<TR><TD></TD><TD><input type="hidden" name= "botiquin" value="'.$idbotiquin.'" /></TD></TR>';
 echo '</table>' ;
?>
<td><INPUT TYPE="SUBMIT" value="Actualizar"></td>

<TD>&nbsp;
</TD>
</TR></table>
</select>
</FORM>
</div>
<FORM METHOD="POST" ACTION="ABM_Botiquines2.php">
<?
echo '<input type="hidden" name= "movil" value="'.$idbotiquin.'" >';
?>
<INPUT name="SUBMIT" TYPE="submit" value="Volver"></FORM>
</BODY>
</HTML>


