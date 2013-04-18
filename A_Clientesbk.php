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
<TITLE>A_Clientes.php</TITLE>
</HEAD>
<script>
</script>
<body style="background-color:<?echo $body_color?>">
<BODY>


<?
echo titulo_encabezado ('Alta de Clientes' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }
?>


<br>
<FORM METHOD="POST" name="formulario"
ACTION="A_Clientes2.php">

<?

//Ejecutamos la sentencia SQL  BgColor="#d0d0d0"
$result=mysql_query("SELECT * FROM provincias order by 2");
while ($row=mysql_fetch_array($result))
{
$provincias.='<option value="'.$row['idprovincia'].'">'.$row['provincia'].'</option>';
}
mysql_free_result($result);

$result=mysql_query("SELECT * FROM localidad order by 3");
while ($row=mysql_fetch_array($result))
{
$localidad.='<option value="'.$row['idlocalidad'].'">'.$row['localidad'].'</option>';
}
mysql_free_result($result);

$result=mysql_query("SELECT * FROM estadocivil order by 2");
while ($row=mysql_fetch_array($result))
{
$estadocivil.='<option value="'.$row['idestado'].'">'.$row['estado'].'</option>';
}
mysql_free_result($result);


 echo'<Table>';
 echo '<TR><TD>Nombre   </TD><TD><input size= 50 type = "text" name = "cla_nombre" /></TD>';
 echo '<TD>Tipo Pers</TD><TD>
     <label>
       <input type="radio" name="cla_tipoper" value="F" />
       P.Fisica</label>
     <label>
       <input type="radio" name="cla_tipoper" value="J" />
       P.Juridica</label></TD></TR>';

 echo '<TR><TD>Cuit     </TD><TD><input size= 15 type = "text" name = "cla_cuit" /></TD>';
 echo '<TD>Sexo</TD><TD>
     <label>
       <input type="radio" name="cla_sexo" value="M" />
       Masculino</label>
     <label>
       <input type="radio" name="cla_sexo" value="F" />
       Femenino</label></TD></TR>';

 echo '<TR><TD>Tipo Doc</TD><TD>
      <label>
        <input type="radio" name="cla_tipodoc" value="DNI">
        DNI</label><label>
        <input type="radio" name="cla_tipodoc" value="LE">
        LE</label><label>
        <input type="radio" name="cla_tipodoc" value="LC">
        LC</label><label>
        <input type="radio" name="cla_tipodoc" value="DNE">
        DNE</label></td></tr>';


echo '<TR><TD>Nro Docum</TD><TD><input size= 10 type = "text" name = "cla_documento" /></TD></TR>';
echo '<TR><TD>Nro Afil.</TD><TD><input size= 10 type = "text" name = "cla_nroafiliado" /></TD></TR>';
echo '<TR><TD>Est.Civil</TD><TD><select name="cla_estadocivil">'.$estadocivil.'</select></TD></TR>';
echo '<TR><TD>Fec.Nac. </TD><TD><input size= 2 type = "text" name = "cla_fdnac" /><input size= 2 type = "text" name = "cla_fmnac" />
      <input size= 4 type = "text" name = "cla_fanac" /></TD></TR>';
echo '<TR><TD>Calle    </TD><TD><input size= 50 type = "text" name = "cla_calle" /></TD>';
echo '<TD>Nro      </TD><TD><input size= 4 type = "text" name = "cla_nrocalle" /></TD></TR>';
echo '<TR><TD>Piso     </TD><TD><input size= 4 type = "text" name = "cla_piso" /></TD>';
echo '<TD>Depto    </TD><TD><input size= 6 type = "text" name = "cla_depto" /></TD></TR>';
echo '<TR><TD>Barrio   </TD><TD><input size= 30 type = "text" name = "cla_barrio" /></TD>';
echo '<TD>Cod.Post.</TD><TD><input size= 4 type = "text" name = "cla_cpostal" /></TD></TR>';
echo '<TR><TD>Localidad</TD><TD><select name="cla_localidad">'.$localidad.'</select></TD>';
echo '<TD>Provincia</TD><TD><select name="cla_provincia">'.$provincias.'</select></TD></TR>';
echo '<TR><TD>Telefono </TD><TD><input size= 20 type = "text" name = "cla_telefono" /></TD>';
echo '<TD>Celular  </TD><TD><input size= 20 type = "text" name = "cla_celular" /></TD></TR>';
echo '<TR><TD>E-mail   </TD><TD><input size= 40 type = "text" name = "cla_email" /></TD></TR>';
echo '<TR><TD>Contacto </TD><TD><input size= 50 type = "text" name = "cla_contacto" /></TD></TR>';
echo '</table>' ;
?>
<td><INPUT TYPE="SUBMIT" value="Insertar"></td>


    </span></th>
  </tr>
</table>
<br>
</select>


</FORM>
</div>
   </BODY>
</HTML>


