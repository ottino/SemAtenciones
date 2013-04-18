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
                                    <!--       CALENDARIO    -->
 <!--Hoja de estilos del calendario -->
  <link rel="stylesheet" type="text/css" media="all" href="calendario/calendar-green.css" title="win2k-cold-1" />

  <!-- librería principal del calendario -->
 <script type="text/javascript" src="calendario/calendar.js"></script>

 <!-- librería para cargar el lenguaje deseado -->
  <script type="text/javascript" src="calendario/lang/calendar-es.js"></script>

  <!-- librería que declara la función Calendar.setup, que ayuda a generar un calendario en unas pocas líneas de código -->
  <script type="text/javascript" src="calendario/calendar-setup.js"></script>

  <!-- librería que declara la función Calendar.setup, que ayuda a generar un calendario en unas pocas líneas de código -->
  <script type="text/javascript" src="jsfunciones.js"></script>
  <!------------------------------------------------------------------------------------------------------->


<TITLE>A_Botiquines.php</TITLE>
</HEAD>
<BODY>

<?
echo titulo_encabezado ('Alta de Elemento del Botiquin' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }

$moviles = $_POST["pasabotiquin"];
//echo $movil;

//Ejecutamos la sentencia SQL
$result=mysql_query("select * from moviles where idmovil = ".$moviles);
$movil= '<select style="width:300px" name="movil" style="background-color:'.$se_color.'"><option value="0">Moviles</option>';
while ($row=mysql_fetch_array($result))
{ if ($row['idmovil'] == $moviles)
 $movil.='<option selected="selected" value="'.$row['idmovil'].'">'.$row['idmovil'].'-'.$row['descmovil'].'</option>';
else
 $movil.='<option value="'.$row['idmovil'].'">'.$row['idmovil'].'-'.$row['descmovil'].'</option>';
}
mysql_free_result($result);
$movil.= '</select>';


//Ejecutamos la sentencia SQL para los articulos
$result=mysql_query("select * from articulos a, rubros b where a.rubro = b.idrubro order by 2");
$arti= '<select name="artic" style="background-color:'.$se_color.'"><option value="0">Artículo</option>';
while ($row=mysql_fetch_array($result))
{
 $arti.='<option value="'.$row['idarticulo'].'-'.$row['rubro'].'">'.$row['articulo'].'-'.$row['descrubro'].'</option>';
}
mysql_free_result($result);
$arti.= '</select>';

?>


<body style="background-color:<?echo $body_color?>">
<FORM METHOD="POST" NAME="formulario3"
ACTION="A_Botiquines2.php">


<table width = "50%" align="left">
 <tr>
            <th>MOVILES</th>
            <th>ARTICULOS</th>
            <th>CN CRITICA</th>
 </tr>
<TR>
<TD><? echo $movil?></TD>
<TD><? echo $arti ?></TD>
<TD><input size= 12 type = "text" name = "cla_cnminima" /></TD>
<td><INPUT TYPE="SUBMIT" value="Insertar"></td>

<TD>&nbsp;
</TD>
</TR></table>
</select>


</FORM>
</div>
</BODY>
</HTML>


