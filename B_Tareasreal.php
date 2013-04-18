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

<TITLE>B_Tareasreal.php</TITLE>
</HEAD>

<body style="background-color:<?echo $body_color?>">
<BODY>
<?
echo titulo_encabezado ('Baja de Tareas Realizadas' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }

$idtareareal = $_POST["pasatareareal"];

echo '<FORM METHOD="POST"
ACTION="B_Tareasreal2.php">';
//Creamos la sentencia SQL y la ejecutamos
$sSQL="select * from tareareal a, moviles b, tareas c, proveedores d where
         a.idmovil = b.idmovil and a.idtarea = c.idtarea and a.idproveedor = d.idproveedores and
         a.id = ".$idtareareal;

$result=mysql_query($sSQL);

//Mostramos los registros en forma de menú desplegable
while ($row=mysql_fetch_array($result))
{

 $fecha = cambiarFormatoFecha($row['fecha']);
 echo'<Table>';
 echo '<TR><TD>Movil</TD><TD><input disabled="disabled" size= 50 type = "text" name = "cla_movil" value = "'.$row[idmovil].' - '.$row[descmovil].'" /></TD></TR>';
 echo '<TR><TD>Tarea</TD><TD><input disabled="disabled" size= 50 type = "text" name = "cla_tarea" value = "'.$row[desctarea].'" /></TD></TR>';
 echo '<TR><TD>Proveedor</TD><TD><input disabled="disabled" size= 50 type = "text" name = "cla_proveedor" value = "'.$row[proveedores].'" /></TD></TR>';
 echo '<TR><TD>Fecha</TD><TD><input disabled="disabled" size= 50 type = "text" name = "cla_fecha" value = "'.$fecha.'" /></TD></TR>';
 echo '<TR><TD>KM</TD><TD><input disabled="disabled" size= 50 type = "text" name = "cla_km" value = "'.$row[km].'" /></TD></TR>';
 echo '<TR><TD>Importe</TD><TD><input disabled="disabled" size= 50 type = "text" name = "cla_km" value = "'.$row[importe].'" /></TD></TR>';
 echo '<input type="hidden" name= "tareal" value="'.$row["id"].'" >';
 echo '</table>' ;
 $moviles = $row[idmovil];
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

<FORM METHOD="POST" ACTION="ABM_Tareasreal2.php">
<? echo '<input type="hidden" name= "movil" value="'.$moviles.'" >'; ?>
<INPUT name="SUBMIT" TYPE="submit" value="Volver"></FORM>

   </BODY>
</HTML>