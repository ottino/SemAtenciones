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
<TITLE>M_Destinos.php</TITLE>
</HEAD>

<body style="background-color:<?echo $body_color?>">
<BODY>
<?
echo titulo_encabezado ('Modificación de Destinos' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }

$destino = $_POST["pasdestino"];
//echo $destino;


echo '<FORM METHOD="POST"
ACTION="M_Destinos2.php">';
//Creamos la sentencia SQL y la ejecutamos
$sSQL="Select * From destino where iddestino = ".$destino;
$result=mysql_query($sSQL);


//Mostramos los registros en forma de menú desplegable
while ($row=mysql_fetch_array($result))
{echo'<Table>';
 echo '<input type="hidden" name= "dest" value="'.$row["iddestino"].'" >';
 echo '<TR><TD>Destino</TD><TD><input size= 50 type = "text" name = "cla_destino" value = "'.$row[destino].'" /></TD></TR>';
 echo '<TR><TD>Domicilio</TD><TD><input size= 50 type = "text" name = "cla_domicilio" value = "'.$row[domicilio].'" /></TD></TR>';
 echo '<TR><TD>Localidad</TD><TD><input size= 50 type = "text" name = "cla_localidad" value = "'.$row[localidad].'" /></TD></TR>';
 echo '<TR><TD>Telefono</TD><TD><input size= 50 type = "text" name = "cla_telefono" value = "'.$row[telefono].'" /></TD></TR>';
 echo '<TR><TD>Tipo</TD><TD><input size= 50 type = "text" name = "cla_tipo" value = "'.$row[tipo].'" /></TD></TR>';
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
   </BODY>
</HTML>