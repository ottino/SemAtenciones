<?
session_start();
######################INCLUDES################################
//archivo de configuracion
include_once ('config.php');

//funciones propias
include ('funciones.php');

//inclu�mos la clase ajax
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

  <!-- librer�a principal del calendario -->
 <script type="text/javascript" src="calendario/calendar.js"></script>

 <!-- librer�a para cargar el lenguaje deseado -->
  <script type="text/javascript" src="calendario/lang/calendar-es.js"></script>

  <!-- librer�a que declara la funci�n Calendar.setup, que ayuda a generar un calendario en unas pocas l�neas de c�digo -->
  <script type="text/javascript" src="calendario/calendar-setup.js"></script>

  <!-- librer�a que declara la funci�n Calendar.setup, que ayuda a generar un calendario en unas pocas l�neas de c�digo -->
  <script type="text/javascript" src="jsfunciones.js"></script>
  <!------------------------------------------------------------------------------------------------------->


<TITLE>ABM_CAtenciones.php</TITLE>
</HEAD>
<BODY>

<?
echo titulo_encabezado ('Consulta de Atenciones Realizadas' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }

//Ejecutamos la sentencia SQL
$result=mysql_query("SELECT * FROM planes order by 2");
$planes= '<select name="cla_plan" style="background-color:'.$se_color.'"><option value="0">Planes</option>';

while ($row=mysql_fetch_array($result))
{
$planes.='<option value="'.$row['idplan'].'">'.$row['descplan'].' - '.$row['idplan'].'</option>';
}
mysql_free_result($result);
$planes.= '</select>';

$resultd=mysql_query("SELECT * FROM diagnosticos order by 2");
$diag= '<select name="cla_diag" style="background-color:'.$se_color.'"><option value="0">Diagnosticos</option>';

while ($row=mysql_fetch_array($resultd))
{
$diag.='<option value="'.$row['iddiagnostico'].'">'.$row['descdiagnostico'].'</option>';
}
mysql_free_result($resultd);
$diag.= '</select>';

?>

<body style="background-color:<?echo $body_color?>">
<FORM METHOD="POST" NAME="formulario3"
ACTION="ABM_CAtenciones1.php">

<table width = "10%" align="left">
<TR><TD><? echo $planes ?></td></tr>
 <TR><TD><? echo '<input type="text" name="cla_fecha" id="cla_fecha" size="10" />
       <input type="button" id="lanzador" value="Fecha Desde" onclick="calendario();"/>';?></td></tr>
 <TR><TD><? echo '<input type="text" name="cla_fecha1" id="cla_fecha1" size="10" />
       <input type="button" id="lanzador1" value="Fecha Hasta" onclick="calendario1();"/>';?></td></tr>

 <TR><TD><? echo '<input type="text" size = 50 name="cla_nombre"/>
         <input type="button" value="Nombre"/>'; ?></td></tr>

 <TR><TD><? echo '<input type="text" size = 10 name="cla_idatencion"/>
         <input type="button" value="ID Atenci�n"/>'; ?></td></tr>

<TR><TD><? echo $diag ?></td></tr>
<TR></TR><TR></TR><TR></TR>

<TR><TD>Estados: </TD></TR>
<TD><label>
        <input type="radio" name="cla_estado" value="D">
        DESPACHADOS</label><label>
        <input type="radio" name="cla_estado" value="A">
        ANULADOS</label><label>
        <input type="radio" name="cla_estado" value="T">
        TODOS</label>

<TR></TR><TR></TR><TR></TR><TR></TR><TR></TR><TR></TR>
<TR><TD>Ordenado por: </TD></TR>
<TD><label>
        <input type="radio" name="cla_ord" value="I">
        ID</label><label>
        <input type="radio" name="cla_ord" value="F">
        FECHA</label><label>
        <input type="radio" name="cla_ord" value="P">
        PLAN</label><label>
        <input type="radio" name="cla_ord" value="N">
        NOMBRE</label></td>


<TD><INPUT TYPE="SUBMIT" value="Buscar"></TD>

</table>

</span></th>
  </tr>

</table>
<br>

</select>


</FORM>
</div>
</BODY>
</HTML>
