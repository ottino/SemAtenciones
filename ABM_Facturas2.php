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
$comprob = $_POST["cla_tipocomprob"];
$vengo   = "FACT";

if ($fechah == '')
    $fechah = '2999-12-31';
if ($fechad == '')
    $fechad = '2000-01-01';

//Ejecutamos la sentencia SQL

if ($cliente == '0' and $periodo == '0')
     $result=mysql_query("select * from comprobantes a, contratos b, clientes c, planes d, cobrador g where
                     a.idcontrato = b.idcontrato and b.idcliente = c.idcliente  and
                     b.idplan = d.idplan and
                     b.codcobrador = g.idcob and fechavto >= '".$fechad."' and fechavto <= '".$fechah."' and a.tipocomprob = '".$comprob."' order by cobrador, 1");

else
 if ($cliente != '0' and $periodo == '0')
       $result=mysql_query("select * from comprobantes a, contratos b, clientes c, planes d, cobrador g where
                     a.idcontrato = b.idcontrato and b.idcliente = c.idcliente  and
                     b.idplan = d.idplan and
                     b.codcobrador = g.idcob and fechavto >= '".$fechad."' and fechavto <= '".$fechah."' and c.idcliente = '".$cliente."' and a.tipocomprob = '".$comprob."' order by cobrador, 1");
 else
  if ($cliente == '0' and $periodo > 0)
       $result=mysql_query("select * from comprobantes a, contratos b, clientes c, planes d, cobrador g where
                     a.idcontrato = b.idcontrato and b.idcliente = c.idcliente  and
                     b.idplan = d.idplan and
                     b.codcobrador = g.idcob and fechavto >= '".$fechad."' and fechavto <= '".$fechah."' and a.periodo = '".$periodo."' and a.tipocomprob = '".$comprob."' order by cobrador, 1");


echo '
<table width="100%" border="1" align="left">
  <TR style="background-color:'.$td_color.'"><td>
  <table width="100%" border="1" align="left" ><TR style="background-color:'.$td_color.'">
    <td style="width:2000px"><INPUT TYPE="BUTTON" value="Imprimir" ALIGN ="left" onclick ="window.print()"></td>
    <TD valign="center"><FORM METHOD="POST" NAME="formulario1" ACTION="ABM_Facturas.php">
    <INPUT TYPE="SUBMIT" value="Volver" valign="center">
    </FORM></TD>

    </TR></table></td></TR>
    <TR style="background-color:'.$td_color.'">
    <td width="100%" rowspan="3" valign="top"><div align="center">
      <table style="font-size:'.$fontreg.'" border = 0 cellspacing="5" width="100%" cellpadding="1" align="left" style="background-color:'.$th_color.';border-left-width: 0; border-top-width: 0; border-bottom-width: 0">
          <tr style="font-size:'.$fontt.'" >
            <th>NRO</th>
            <th>CUPON</th>
            <th>AFILIADO</th>
            <th>PLAN</th>
            <th>Cn</th>
            <th>PERIODO</th>
            <th>MONTO</th>
            <th>COBRADOR</th>
            <th>VENCIMIENTO</th>
            <th>EST</th>
            <th>CONS</th>
        </td>';



$contador = 0;
$scontador = 0;
$subtotal = "SUB-TOTAL";
$ltotal = "TOTAL";
$vacio = " ";
$monto = 0;

//Mostramos los registros
while ($row=mysql_fetch_array($result))
{
$contador = $contador + 1;

if ($row["cobrador"] > $cobant)
    {
   if ($contador > 1 )
    {
     echo '<tr><td>'.$vacio.'</td>';
     echo '<td>'.$vacio.'</td>';
     echo '<td>'.$subtotal.'</td>';
     echo '<td>'.$vacio.'</td>';
     echo '<td align="right">'.$scontador.'</td>';
     echo '<td>'.$vacio.'</td>';
     echo '<td align="right">'.number_format($monto,2).'</td>';
     echo '<td>'.$vacio.'</td>';
     echo '<td>'.$vacio.'</td></tr>';
    };
     $cobant = $row["cobrador"];
     $monto = 0;
     $scontador = 0;
    };

$scontador = $scontador + 1;


$monto = $monto + $row["monto"];
$total = $total + $row["monto"];

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
$plan      =  $row["descabrev"];
$idplan    =  $row["idplan"];
$idfact    =  $row["idcomprob"];
$ordenmax  =  $row[ordenmax];
$observaciones = $row["observaciones"];
$fechavto  =  cambiarFormatoFecha($row["fechavto"]);

$sep       = ' - ';

$direccion = $calle.$sep.$nrocalle.$sep.$entre1.$sep.$entre2.$sep.$piso.$sep.$depto.$sep.$barrio.$sep.$localidad.$sep.$provincia.$sep.$cpostal.$sep.$telefono;

echo '<tr><td>'.$row["nroafiliado"].'</td>';
echo '<td>'.$row["idcomprob"].'</td>';
echo '<td>'.$row["nombre"].'</td>';
echo '<td>'.$row["descabrev"].'</td>';
echo '<td align="right">'.$row["ordenmax"].'</td>';
echo '<td align="center">'.$row["periodo"].'</td>';
echo '<td align="right">'.$row["monto"].'</td>';
echo '<td>'.$cobrador.'</td>';
echo '<td>'.$fechavto.'</td>';
echo '<td align="center">'.$row["compestado"].'</td>';
echo '<FORM METHOD="POST" NAME="formulario2" ACTION="C_Facturas.php">';
echo '<input type="hidden" name= "pasafact" value="'.$idfact.'" >';
echo '<input type="hidden" name= "cla_vengo" value="'.$vengo.'" >';
echo '<input type="hidden" name= "cla_cliente" value="'.$cliente.'" >';
echo '<input type="hidden" name= "cla_periodo" value="'.$periodo.'" >';
echo '<input type="hidden" name= "cla_fecha" value="'.$fechad.'" >';
echo '<input type="hidden" name= "cla_fecha1" value="'.$fechah.'" >';
echo '<input type="hidden" name= "cla_tipocomprob" value="'.$comprob.'" >';
echo ' <td width="17" align="center" style="background-color:'.$td_color.'">
                    <label onclick="this.form.submit();" style="CURSOR: pointer" >
                     <img align="middle" alt=\'Consultar\' src="imagenes/INSERTAR.ICO" width="30" height="15"/>
                    </label>
                  </td></tr>';
echo '</FORM>';

}

     echo '<tr><td>'.$vacio.'</td>';
     echo '<td>'.$vacio.'</td>';
     echo '<td>'.$subtotal.'</td>';
     echo '<td>'.$vacio.'</td>';
     echo '<td align="right">'.$scontador.'</td>';
     echo '<td>'.$vacio.'</td>';
     echo '<td align="right">'.number_format($monto,2).'</td>';
     echo '<td>'.$vacio.'</td>';
     echo '<td>'.$vacio.'</td></tr>';

     echo '<tr><td>'.$vacio.'</td>';
     echo '<td>'.$vacio.'</td>';
     echo '<td>'.$ltotal.'</td>';
     echo '<td>'.$vacio.'</td>';
     echo '<td align="right">'.$contador.'</td>';
     echo '<td>'.$vacio.'</td>';
     echo '<td align="right">'.number_format($total,2).'</td>';
     echo '<td>'.$vacio.'</td>';
     echo '<td>'.$vacio.'</td></tr>';

mysql_free_result($result)


?>

</table>


</BODY>
</HTML>