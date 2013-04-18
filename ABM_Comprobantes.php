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
<TITLE>ABM_Comprobantes.php</TITLE>
</HEAD>

<body style="background-color:<?echo $body_color?>">
<BODY>


<?
//echo titulo_encabezado ('Comprobantes' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }

//Ejecutamos la sentencia SQL
$result=mysql_query("select * from comprobantes a, contratos b, clientes c, planes d, cobrador g where
                     a.idcontrato = b.idcontrato and b.idcliente = c.idcliente  and
                     b.idplan = d.idplan and b.codcobrador = g.idcob and a.tipocomprob = 'C' order by 1");
?>

</p>

<table width="100%" border="1" align="left">
  <tr>
    <td width="100%" rowspan="3" valign="top"><div align="center">
      <table border = 1 cellspacing="5" width="100%" cellpadding="5" align="left" style="background-color:<?echo $th_color?>;border-left-width: 0; border-top-width: 0; border-bottom-width: 0">
          <tr >

<?
//Mostramos los registros
while ($row=mysql_fetch_array($result))
{
$calle     =  $row["callecob"];
$nrocalle  =  $row["nrocallecob"];
$entre1    =  $row["entre1"];
$entre2    =  $row["entre2"];
$piso      =  $row["pisocob"];
$depto     =  $row["deptocob"];
$barrio    =  $row["barriocob"];
$localidad =  $row["localidadcob"];
$provincia =  $row["provinciacob"];
$cpostal   =  $row["cpostalcob"];
$cobrador  =  $row["desccob"];
$telefono  =  $row["telefonocob"];
$observaciones = $row["observaciones"];
$plan      =  $row["descabrev"];
$idplan    =  $row["idplan"];
$ordenmax  =  $row[ordenmax];
$fechavto  =  cambiarFormatoFecha($row["fechavto"]);

$sep       = ' - ';

$direccion = $calle.$sep.$nrocalle.$sep.$entre1.$sep.$entre2.$sep.$piso.$sep.$depto.$sep.$barrio.$sep.$localidad.$sep.$provincia.$sep.$cpostal.$sep.$telefono;
echo '<tr><td><font size="4">'."(".$row["nroafiliado"].")- ".$row["nombre"].'</font><font size="2">'.'<br>
     '."DIRECCION".'<br>'."CALLE: ".$calle."    NRO.: ".$nrocalle.'<br>'."PISO: ".$piso." DEPTO: ".$depto." BARRIO: ".$barrio.'<br>
     '."ENTRE: ".$entre1." - ".$entre2.'<br>'." LOCALIDAD: ".$localidad.'<br>'." PROVINCIA: ".$provincia.".           COBRADOR: ".$cobrador.'<br>'."PERIODO: ".$row["periodo"]." - IMPORTE: $".$row["monto"]." - VENCIMIENTO: ".$fechavto.'<br>
     '."PLAN: (".$idplan.")-".$plan.'<br>'."CANT. AFILIADOS: ".$ordenmax.'<br></font><font size="7" face="I2OF5NT">'.$row["codbarras"].'</font><br><font size="4">'.$row["codbarras"].'</font><br>';
echo '<td style="border:none"><font size="4">'."(".$row["nroafiliado"].")- ".$row["nombre"].'</font><font size="2">'.'<br>
     '."DIRECCION".'<br>'."CALLE: ".$calle."    NRO.: ".$nrocalle.'<br>'."PISO: ".$piso." DEPTO: ".$depto." BARRIO: ".$barrio.'<br>
     '."ENTRE: ".$entre1." - ".$entre2.'<br>'." LOCALIDAD: ".$localidad.'<br>'." PROVINCIA: ".$provincia.".           COBRADOR: ".$cobrador.'<br><br>'."OBSERVACIONES: ".$observaciones.'<br><br></font>
     <font size="7" face="I2OF5NT">'.$row["codbarras"].'</font><br><font size="4">'.$row["codbarras"].'</font><br>';

echo '<td style="border:none" style="vertical-align:text-top"><img align="middle" src="imagenes/Logo_a_tiempo.jpg" width="120" height="80"/>
      <br><font size="2">'."PLAN: (".$idplan.")-".$plan.'<br>
     '."PERIODO: ".$row["periodo"].'<br><br>'."VENCIMIENTO: ".$fechavto.'<br><br>'."CANT. AFILIADOS: ".$ordenmax.'<br><br>'."IMPORTE CUOTA: $".$row["monto"].'</td></font>';
}

mysql_free_result($result)


?>

</table>


</BODY>
</HTML>