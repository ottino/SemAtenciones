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
<TITLE>B_Datosliq.php</TITLE>
</HEAD>

<body style="background-color:<?echo $body_color?>">
<BODY>


<?
echo titulo_encabezado ('Baja de Parámetros Liquidación' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }

$iddatos = $_POST["pasdatos"];


echo '<FORM METHOD="POST"
ACTION="B_Agenda2.php">';
//Creamos la sentencia SQL y la ejecutamos
$sSQL="Select * From agenda where id = ".$iddatos;

$result=mysql_query($sSQL);

while ($row=mysql_fetch_array($result))
{echo'<Table>';

 if ($row["acceso"] > '0')
    { $acceso = 'PRIVADO';}
    else
    { $acceso = 'PUBLICO';}

 echo '<TR><TD>Nombre</TD><TD><input disabled="disabled" size= 50 type = "text" name = "cla_nombre" value="'.$row["nombre"].'" /></TD></TR>';
 echo '<TR><TD>Dirección</TD><TD><input disabled="disabled" size= 50 type = "text" name = "cla_direccion" value="'.$row["direccion"].'" /></TD></TR>';
 echo '<TR><TD>Tel. Fijo</TD><TD><input disabled="disabled" size= 10 type = "text" name = "cla_telfijo" value="'.$row["telfijo"].'" /></TD></TR>';
 echo '<TR><TD>Tel. Fijo 1</TD><TD><input disabled="disabled" size= 10 type = "text" name = "cla_telfijo1" value="'.$row["telfijo1"].'" /></TD></TR>';
 echo '<TR><TD>Fax</TD><TD><input disabled="disabled" size= 10 type = "text" name = "cla_fax" value="'.$row["fax"].'" /></TD></TR>';
 echo '<TR><TD>Celular</TD><TD><input disabled="disabled" size= 10 type = "text" name = "cla_celular" value="'.$row["celular"].'" /></TD></TR>';
 echo '<TR><TD>E-Mail</TD><TD><input disabled="disabled" size= 50 type = "text" name = "cla_email" value="'.$row["email"].'" /></TD></TR>';
 echo '<TR><TD>Empresa</TD><TD><input disabled="disabled" size= 50 type = "text" name = "cla_empresa" value="'.$row["empresa"].'" /></TD></TR>';
 echo '<TR><TD>Tel.Empresa</TD><TD><input disabled="disabled" size= 10 type = "text" name = "cla_etelfijo" value="'.$row["etelfijo"].'" /></TD></TR>';
 echo '<TR><TD>Tel.1.Empresa</TD><TD><input disabled="disabled" size= 10 type = "text" name = "cla_etelfijo1" value="'.$row["etelfijo1"].'" /></TD></TR>';
 echo '<TR><TD>Fax Empresa</TD><TD><input disabled="disabled" size= 10 type = "text" name = "cla_efax" value="'.$row["efax"].'" /></TD></TR>';
 echo '<TR><TD>E-Mail Empresa</TD><TD><input disabled="disabled" size= 50 type = "text" name = "cla_eemail" value="'.$row["eemail"].'" /></TD></TR>';
 echo '<TR><TD>Cargo</TD><TD><input disabled="disabled" size= 50 type = "text" name = "cla_cargo" value="'.$row["cargo"].'" /></TD></TR>';
 echo '<TR><TD>Acceso</TD><TD><input disabled="disabled" size= 50 type = "text" name = "cla_acceso" value="'.$acceso.'" /></TD></TR>';
 echo '<input type="hidden" name= "datos" value="'.$row["id"].'" >';
 echo '</table>' ;
}

mysql_free_result($result)


?>
    </span></th>
  </tr>
</table>
<br>
</select>
<INPUT TYPE="SUBMIT" value="Borrar">
</FORM>
</div>
<FORM METHOD="POST" ACTION="ABM_Agenda.php">
<INPUT name="SUBMIT" TYPE="submit" value="Volver"></FORM>
</BODY>
</HTML>