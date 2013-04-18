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
<TITLE>C_Agenda.php</TITLE>
</HEAD>

<body style="background-color:<?echo $body_color?>">
<BODY>
<?
echo titulo_encabezado ('Consulta Agenda Personal' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }

$datos = $_POST["pasdatos"];
$nombre = $_POST["cla_nombre"];

echo '<FORM METHOD="POST"
ACTION="ABM_Agenda0.php">';
//Creamos la sentencia SQL y la ejecutamos
$sSQL="Select * From agenda where id = ".$datos;
$result=mysql_query($sSQL);


//Mostramos los registros en forma de menú desplegable
while ($row=mysql_fetch_array($result))
{echo'<Table>';
 echo '<TR><TD>ID</TD><TD><input disabled="disabled" size= 50 type = "text" name = "cla_id" value = "'.$row[id].'"/></TD></TR>';
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

$acceso=$row['acceso'];
 if ($acceso > '0')
    $checkacc = '    <label>
        <input disabled="disabled" type="radio" name="cla_acceso" value="PUBL">
        PUBLICO</label><label>
        <input disabled="disabled" type="radio" name="cla_acceso" value="PRIV" checked="checked">
        PRIVADO</label></td></tr>';
   else
    $checkacc = '    <label>
        <input disabled="disabled" type="radio" name="cla_acceso" value="PUBL" checked="checked">
        PUBLICO</label><label>
        <input disabled="disabled" type="radio" name="cla_acceso" value="PRIV">
        PRIVADO</label></td></tr>';


 echo '<TR><TD>Acceso</TD><TD>'.$checkacc.'</TD></TR>';

 echo '<input type="hidden" name= "datos" value="'.$row["id"].'" >';
 echo '</table></FORM>' ;
}

?>
    </span></th>
  </tr>
</table>
</select>

<?
     echo '<FORM METHOD="POST" NAME="formulario2" ACTION="ABM_Agenda.php">';
     echo '<input type="hidden" name= "cla_nombre" value  ="'.$nombre.'" >';
     echo ' <td width="17" align="center" style="background-color:'.$td_color.'">
                     <label onclick="this.form.submit();" style="CURSOR: pointer" >
                      <img align="middle" alt=\'Volver\' src="imagenes/Volver.ico" width="30" height="30"/>
                     </label>
                   </td>';
     echo '</FORM></FORM></tr></table><TR><TD>
         <table border="1" align="left" cellspacing="5" cellpadding="5">
         <tr style="font-size:<?echo $fontt?>"> ';

?>



</FORM>
</div>
   </BODY>
</HTML>