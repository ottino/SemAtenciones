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

<TITLE>B_Botiquines.php</TITLE>
</HEAD>

<body style="background-color:<?echo $body_color?>">
<BODY>
<?
echo titulo_encabezado ('Baja de Novedades de stock' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }

$idbotiquin = $_POST["pasabotiquin"];

echo '<FORM METHOD="POST"
ACTION="B_Botiquines2.php">';
//Creamos la sentencia SQL y la ejecutamos
$sSQL="select * from botiquines a, articulos b, rubros c, moviles d where
       a.idarticulo = b.idarticulo and a.rubro = b.rubro and b.rubro = c.idrubro and a.rubro = c.idrubro
       and a.idmovil = d.idmovil and a.idbotiquines = ".$idbotiquin;
$result=mysql_query($sSQL);

//Mostramos los registros en forma de menú desplegable
while ($row=mysql_fetch_array($result))
{
 echo'<Table>';
 echo '<TR><TD>Botiquin</TD><TD><input disabled="disabled" size= 50 type = "text" name = "cla_botiquin" value = "'.$row[idmovil].' - '.$row[descmovil].'" /></TD></TR>';
 echo '<TR><TD>Articulo</TD><TD><input disabled="disabled" size= 50 type = "text" name = "cla_botiquin" value = "'.$row[idarticulo].' - '.$row[idrubro].' - '.$row[articulo].'" /></TD></TR>';
 echo '<TR><TD>Existencia</TD><TD><input disabled="disabled" size= 50 type = "text" name = "cla_fecha" value = "'.$row[cantidad].'" /></TD></TR>';
 echo '<TR><TD>Cn Minima</TD><TD><input disabled="disabled" size= 50 type = "text" name = "cla_fecha1" value = "'.$row[cnminima].'" /></TD></TR>';
 echo '<input type="hidden" name= "bot" value="'.$row["idbotiquines"].'" >';
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
<FORM METHOD="POST" ACTION="ABM_Botiquines2.php">
<?
echo '<input type="hidden" name= "movil" value="'.$idbotiquin.'" >';
?>
<INPUT name="SUBMIT" TYPE="submit" value="Volver"></FORM>

   </BODY>
</HTML>