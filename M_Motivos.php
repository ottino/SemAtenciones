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
<TITLE>ABM_Motivos.php</TITLE>
</HEAD>

<body style="background-color:<?echo $body_color?>">
<BODY>
<?
echo titulo_encabezado ('Modificación de Motivos' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }


$motivos = $_POST["pasmotivo"];
//echo $motivos;

$vector_motivo = explode("-",$motivos);
$motivo1 = $vector_motivo[0];
$motivo2 = $vector_motivo[1];
//echo $motivo1;
//echo $motivo2;


$sSQL="Select * From motivos where idmotivo = ".$motivo1." and idmotivo2 = ".$motivo2;
$result=mysql_query($sSQL);
$row=mysql_fetch_array($result);
$id=$row['idmotivo'];
$id1=$row['idmotivo2'];
$descripcion=$row['desc'];

echo '<FORM METHOD="POST"
ACTION="M_motivos2.php">';
//Creamos la sentencia SQL y la ejecutamos
$sSQL="Select * From motivos where idmotivo = ".$motivo1." and idmotivo2 = ".$motivo2;
$result=mysql_query($sSQL);


while ($row=mysql_fetch_array($result))
{echo'<Table>';

$instrucciones = $row[instrucciones];

 echo '<input type="hidden" name= "desc" value="'.$row["idmotivo"].'-'.$row["idmotivo2"].'" >';
 echo '<TR><TD>Motivo de llamado</TD><TD><input size= 50 type = "text" name = "clave" value = "'.$row[desc].'"/></TD></TR>';
 echo '<TR><TD>Instrucciones Pre-arribo</TD><TD><textarea name="cla_instrucciones" rows="25" cols="60">'.$instrucciones.'</textarea></TD></TR>';
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