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
<TITLE>ABM_Facturas2.php</TITLE>
</HEAD>

<body style="background-color:<?echo $body_color?>">
<BODY>


<?
echo titulo_encabezado ('Detalle de Facturas' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }

$cliente = $_POST["cla_cliente"];
$periodo = $_POST["cla_periodo"];
$fechad  = $_POST["cla_fecha"];
$fechah  = $_POST["cla_fecha1"];

if ($fechah == '')
    $fechah = '2999-12-31';
if ($fechad == '')
    $fechad = '2000-01-01';

//Ejecutamos la sentencia SQL

if ($cliente == '0' and $periodo == '0')
     $result=mysql_query("select * from comprobantes a, contratos b, clientes c, planes d, localidad e, provincias f, cobrador g where
                     a.idcontrato = b.idcontrato and b.idcliente = c.idcliente  and
                     b.idplan = d.idplan and b.localidadcob = e.idlocalidad and b.provinciacob = f.idprovincia and
                     b.codcobrador = g.idcob and a.tipocomprob = 'C'
                     and fechavto >= '".$fechad."' and fechavto <= '".$fechah."' order by 1");

else
 if ($cliente != '0' and $periodo == '0')
       $result=mysql_query("select * from comprobantes a, contratos b, clientes c, planes d, localidad e, provincias f, cobrador g where
                     a.idcontrato = b.idcontrato and b.idcliente = c.idcliente  and
                     b.idplan = d.idplan and b.localidadcob = e.idlocalidad and b.provinciacob = f.idprovincia and
                     b.codcobrador = g.idcob and a.tipocomprob = 'C'
                     and fechavto >= '".$fechad."' and fechavto <= '".$fechah."' and c.idcliente = '".$cliente."' order by 1");
 else
  if ($cliente == '0' and $periodo > 0)
       $result=mysql_query("select * from comprobantes a, contratos b, clientes c, planes d, localidad e, provincias f, cobrador g where
                     a.idcontrato = b.idcontrato and b.idcliente = c.idcliente  and
                     b.idplan = d.idplan and b.localidadcob = e.idlocalidad and b.provinciacob = f.idprovincia and
                     b.codcobrador = g.idcob and a.tipocomprob = 'C'
                     and fechavto >= '".$fechad."' and fechavto <= '".$fechah."' and a.periodo = '".$periodo."' order by 1");


?>

</p>

<table width="100%" border="1" align="left">
  <tr>
    <td width="100%" rowspan="3" valign="top"><div align="center">
      <table style="font-size:<?echo $fontreg?>" border = 1 cellspacing="5" width="100%" cellpadding="5" align="left" style="background-color:<?echo $th_color?>;border-left-width: 0; border-top-width: 0; border-bottom-width: 0">
          <tr style="font-size:<?echo $fontt?>">
            <th>NRO</th>
            <th>AFILIADO</th>
            <th>PLAN</th>
            <th>PERIODO</th>
            <th>MONTO</th>
            <th>COBRADOR</th>
            <th>VENCIMIENTO</th>
            <th>CONS</th>
        </td>

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
$localidad =  $row["localidad"];
$provincia =  $row["provincia"];
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

echo '<tr><td>'.$row["nroafiliado"].'</td>';
echo '<td>'.$row["nombre"].'</td>';
echo '<td>'.$row["descabrev"].'</td>';
echo '<td>'.$row["periodo"].'</td>';
echo '<td>'.$row["monto"].'</td>';
echo '<td>'.$cobrador.'</td>';
echo '<td>'.$fechavto.'</td>';
echo '<FORM METHOD="POST" NAME="formulario2" ACTION="C_Facturas.php">';
echo '<input type="hidden" name= "pasafact" value="'.$idfact.'" >';
echo ' <td width="17" align="center" style="background-color:'.$td_color.'" style="CURSOR: hand" >
                    <label onclick="this.form.submit();">
                     <img align="middle" alt=\'Consultar\' src="imagenes/INSERTAR.ICO" width="30" height="30"/>
                    </label>
                  </td></tr>';
echo '</FORM>';

}

mysql_free_result($result)


?>

</table>


</BODY>
</HTML>