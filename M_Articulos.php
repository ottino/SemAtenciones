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

<TITLE>M_Articulos.php</TITLE>
</HEAD>

<body style="background-color:<?echo $body_color?>">
<BODY>
<?
echo titulo_encabezado ('Modificación de Articulos' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }

$articulos = $_POST["pasarticulo"];

$articu = explode("-",$articulos);

$articulos = $articu[0];
$rubro    =  $articu[1];

//Ejecutamos la sentencia SQL TABLA RUBROS
$result=mysql_query("select * from rubros order by 1");

$rubros= '<select name="rubros" style="background-color:'.$se_color.'"><option value="0">Rubro</option>';

while ($row=mysql_fetch_array($result))
{
if ($row['idrubro']== $rubro)
$rubros.='<option selected = "selected" value="'.$row['idrubro'].'">'.$row['descrubro'].'</option>';
 else
$rubros.='<option value="'.$row['idrubro'].'">'.$row['descrubro'].'</option>';
}
mysql_free_result($result);
$rubros.= '</select>';


//echo $moviles;
echo '<FORM METHOD="POST"
ACTION="M_Articulos2.php">';

//Creamos la sentencia SQL y la ejecutamos
$sSQL="select * from articulos a, rubros b where a.rubro = b.idrubro and a.idarticulo = ".$articulos." and a.rubro = ".$rubro;

$result=mysql_query($sSQL);


//Mostramos los registros en forma de menú desplegable
while ($row=mysql_fetch_array($result))
{
 echo'<Table>';
 echo '<TR><TD>ID Artículo</TD><TD><input disabled = "disabled" size= 10 type = "text" name = "cla_idarticulo" value = "'.$row[idarticulo].'" /></TD></TR>';
 echo '<TR><TD>Articulo</TD><TD><input size= 50 type = "text" name = "cla_desarticulo" value = "'.$row[articulo].'" /></TD></TR>';
 echo '<TR><TD>Rubro</TD><TD>'.$rubros.'</TD></TR>';
 echo '<TR><TD>Existencia</TD><TD><input size= 10 type = "text" name = "cla_existencia" value = "'.$row[existencia].'" /></TD></TR>';
 echo '<TR><TD>Cn Crítica</TD><TD><input size= 10 type = "text" name = "cla_cncritica" value = "'.$row[cncritica].'" /></TD></TR>';
 echo '<input type="hidden" name= "art" value="'.$row["idarticulo"].'" >';
 echo '<input type="hidden" name= "rub" value="'.$row["rubro"].'" >';
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
<FORM METHOD="POST" ACTION="ABM_Articulos.php">
<INPUT name="SUBMIT" TYPE="submit" value="Volver"></FORM>
</BODY>
</HTML>