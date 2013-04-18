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

<TITLE>B_Moviles.php</TITLE>
</HEAD>

<body style="background-color:<?echo $body_color?>">
<BODY>
<?
echo titulo_encabezado ('Baja de Moviles' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }

$moviles = $_POST["pasmoviles"];

echo '<FORM METHOD="POST"
ACTION="B_Moviles2.php">';
//Creamos la sentencia SQL y la ejecutamos
$sSQL="SELECT * FROM moviles WHERE idmovil = ".$moviles;
//echo $sSQL;
$result=mysql_query($sSQL);

//Mostramos los registros en forma de menú desplegable
while ($row=mysql_fetch_array($result))
{
 echo'<Table>';
 echo '<TR><TD>IDMovil</TD><TD><input disabled="disabled" size= 50 type = "text" name = "cla_idmovil" value = "'.$row[idmovil].'" /></TD></TR>';
 echo '<TR><TD>Movil</TD><TD><input disabled="disabled" size= 50 type = "text" name = "cla_descmovil" value = "'.$row[descmovil].'" /></TD></TR>';
 echo '<TR><TD>Dominio</TD><TD><input disabled="disabled" size= 50 type = "text" name = "cla_dominio" value = "'.$row[dominio].'" /></TD></TR>';
 echo '<TR><TD>Marca</TD><TD><input disabled="disabled" size= 50 type = "text" name = "cla_marca" value = "'.$row[marca].'" /></TD></TR>';
 echo '<TR><TD>Modelo</TD><TD><input disabled="disabled" size= 50 type = "text" name = "cla_modelo" value = "'.$row[modelo].'" /></TD></TR>';
 echo '<TR><TD>Nro Motor</TD><TD><input disabled="disabled" size= 50 type = "text" name = "cla_nromotor" value = "'.$row[nromotor].'" /></TD></TR>';
 echo '<TR><TD>Nro Chasis</TD><TD><input disabled="disabled" size= 50 type = "text" name = "cla_nrochasis" value = "'.$row[nrochasis].'" /></TD></TR>';
 echo '<TR><TD>Fecha Transf.</TD><TD><input disabled="disabled" size= 50 type = "text" name = "cla_fectransf" value = "'.$row[fectransf].'" /></TD></TR>';
 echo '<TR><TD>Observaciones</TD><TD><input disabled="disabled" size= 50 type = "text" name = "cla_observaciones" value = "'.$row[observaciones].'" /></TD></TR>';
 echo '<TR><TD>Perfil Movil</TD><TD><input disabled="disabled" size= 50 type = "text" name = "cla_codperfil" value = "'.$row[codperfil].'" /></TD></TR>';
 echo '<input type="hidden" name= "mov" value="'.$row["idmovil"].'" >';
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
<FORM METHOD="POST" ACTION="ABM_Moviles.php">

<INPUT name="SUBMIT" TYPE="submit" value="Volver"></FORM>


</div>

   </BODY>
</HTML>