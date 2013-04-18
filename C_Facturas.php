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


<TITLE>C_Facturas.php</TITLE>
</HEAD>

<body style="background-color:<?echo $body_color?>">
<BODY>
<?
echo titulo_encabezado ('Consulta de Facturas' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }

$cupon = $_POST["pasafact"];

$cliente = $_POST["cla_cliente"];
$periodo = $_POST["cla_periodo"];
$fechad  = $_POST["cla_fecha"];
$fechah  = $_POST["cla_fecha1"];
$comprob = $_POST["cla_tipocomprob"];
$vengo   = $_POST["cla_vengo"];
$nrolote = $_POST["cla_nrolote"];



//echo $cupon;

//Creamos la sentencia SQL y la ejecutamos
$sSQL="select * from comprobantes a, contratos b, clientes c, planes d, localidad e, provincias f, cobrador g where
                     a.idcontrato = b.idcontrato and b.idcliente = c.idcliente  and
                     b.idplan = d.idplan and  b.codcobrador = g.idcob and a.idcomprob = ".$cupon;
$result=mysql_query($sSQL);
$row=mysql_fetch_array($result);

$fechavto  =  cambiarFormatoFecha($row["fechavto"]);
$fecpago  =  cambiarFormatoFecha($row["fecpago"]);
if ($row["tipocomprob"] == 'C')
    $tipocomprob = 'CUPON';
   else
    $tipocomprob = 'FACTURA';

$usuario = buscopersonal($row["usuario"]);


 echo' <table width="100%" border="1" align="left" style="font-size:<?echo $fontreg?>"><tr><td>';
 echo' <table width="100%" border="1" align="left" style="font-size:<?echo $fontreg?>">';
 echo '<tr><td width="40"><INPUT TYPE="BUTTON" value="Imprimir" ALIGN ="left" onclick ="window.print()"></td>';

if ($vengo == 'FACT')
   echo '<td><FORM METHOD="POST" NAME="formulario2" ACTION="ABM_Facturas2.php">';
  else
   echo '<td><FORM METHOD="POST" NAME="formulario2" ACTION="A_Cobranzas1.php">';

 echo '<input type="hidden" name= "cla_cliente" value="'.$cliente.'" >';
 echo '<input type="hidden" name= "cla_periodo" value="'.$periodo.'" >';
 echo '<input type="hidden" name= "cla_fecha" value="'.$fechad.'" >';
 echo '<input type="hidden" name= "cla_fecha1" value="'.$fechah.'" >';
 echo '<input type="hidden" name= "cla_tipocomprob" value="'.$comprob.'" >';
 echo '<input type="hidden" name= "cla_nrolote" value="'.$nrolote.'" >';
  echo ' <td width="40" align="center" style="background-color:'.$body_color.'" style="CURSOR: hand" >
        <label onclick="this.form.submit();">
        <img align="middle" alt=\'Volver\' src="imagenes/Volver.ico" width="30" height="30"/>
        </label></td>';
 echo '</FORM></TR></Table></TD></TR>';

 echo' <TR><TD><table width="100%" border="1" align="left" style="font-size:<?echo $fontreg?>">';
 echo '<TR><TD>Nro.Comprob</TD><TD><input size= 10 disabled = "disabled" type = "text" name = "cla_idcomprob" value = "'.$row[idcomprob].'" /></TD></TR>';
 echo '<TR><TD>Nro.Contrato</TD><TD><input size= 10 disabled = "disabled"type = "text" name = "cla_idcontrato" value = "'.$row[idcontrato].'" /></TD></TR>';
 echo '<TR><TD>Nro.Afiliado</TD><TD><input size= 10 disabled = "disabled"type = "text" name = "cla_nroafiliado" value = "'.$row[nroafiliado].'" /></TD></TR>';
 echo '<TR><TD>Nombre</TD><TD><input size= 50 disabled = "disabled"type = "text" name = "cla_nombre" value = "'.$row[nombre].'" /></TD></TR>';
 echo '<TR><TD>Período</TD><TD><input size= 6 disabled = "disabled"type = "text" name = "cla_periodo" value = "'.$row[periodo].'" /></TD></TR>';
 echo '<TR><TD>Monto</TD><TD><input size= 8 disabled = "disabled"type = "text" name = "cla_monto" value = "'.$row[monto].'" /></TD></TR>';
 echo '<TR><TD>Cn Afiliados</TD><TD><input size= 8 disabled = "disabled"type = "text" name = "cla_ordenmax" value = "'.$row[ordenmax].'" /></TD></TR>';
 echo '<TR><TD>Comprobante</TD><TD><input size= 10 disabled = "disabled"type = "text" name = "cla_tipocomprob" value = "'.$tipocomprob.'" /></TD></TR>';
 echo '<TR><TD>Cobrador</TD><TD><input size= 30 disabled = "disabled"type = "text" name = "cla_cobrador" value = "'.$row[desccob].'" /></TD></TR>';
 echo '<TR><TD>F.Vencim.</TD><TD><input size= 10 disabled = "disabled"type = "text" name = "cla_fechavto" value = "'.$fechavto.'" /></TD></TR>';
 echo '<TR><TD>F. Pago</TD><TD><input size= 10 disabled = "disabled"type = "text" name = "cla_fecpago" value = "'.$fecpago.'" /></TD></TR>';
 echo '<TR><TD>Usuario</TD><TD><input size= 30 disabled = "disabled"type = "text" name = "cla_cobrador" value = "'.$usuario.'" /></TD></TR>';
// echo '<input type="hidden" name= "leg" value="'.$row["legajo"].'" >';
 echo '</table>' ;

?>

    </span></th>
  </tr>
</table>
<br>
</select>
</FORM>
</div>
   </BODY>
</HTML>