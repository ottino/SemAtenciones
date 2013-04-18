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

<TITLE>B_Novarticulos.php</TITLE>
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

$idabmarticulos = $_POST["pasabmarti"];

echo '<FORM METHOD="POST"
ACTION="B_Novarticulos2.php">';
//Creamos la sentencia SQL y la ejecutamos
$sSQL="select * from abmarticulos a, articulos b, rubros c, proveedores d where
       a.idarticulo = b.idarticulo and a.rubro = b.rubro and b.rubro = c.idrubro and a.rubro = c.idrubro
       and a.idproveedor = d.idproveedores and a.idabmarticulo = ".$idabmarticulos;

//echo $sSQL;
$result=mysql_query($sSQL);

//Mostramos los registros en forma de menú desplegable
while ($row=mysql_fetch_array($result))
{
 echo'<Table>';
 echo '<TR><TD>ID Artículo</TD><TD><input disabled="disabled" size= 50 type = "text" name = "cla_idarticulo" value = "'.$row[idarticulo].'" /></TD></TR>';
 echo '<TR><TD>Articulo</TD><TD><input disabled="disabled" size= 50 type = "text" name = "cla_desarticulo" value = "'.$row[articulo].'" /></TD></TR>';
 echo '<TR><TD>Rubro</TD><TD><input disabled="disabled" size= 50 type = "text" name = "cla_rubro" value = "'.$row[descrubro].'" /></TD></TR>';
 echo '<TR><TD>Proveedor</TD><TD><input disabled="disabled" size= 50 type = "text" name = "cla_proveedor" value = "'.$row[proveedores].'" /></TD></TR>';
 echo '<TR><TD>Fecha</TD><TD><input disabled="disabled" size= 50 type = "text" name = "cla_fecha" value = "'.$row[fecha].'" /></TD></TR>';
 echo '<input type="hidden" name= "art" value="'.$row["idabmarticulo"].'" >';
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
   </BODY>
</HTML>