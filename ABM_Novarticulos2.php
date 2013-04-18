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
<TITLE>ABM_Novarticulos2.php</TITLE>
</HEAD>

<body style="background-color:<?echo $body_color?>">
<BODY>


<?
echo titulo_encabezado ('Consulta de altas de stock' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }

$articulos = $_POST["artic"];
//echo $_POST["artic"];
$articu = explode("-",$articulos);

$articulos = $articu[0];
$rubro    =  $articu[1];

if ($_POST['cla_fecha'] == '')
    $cla_fecha = '2000-01-01';
if ($_POST['cla_fecha1'] == '')
    $cla_fecha1 = '2999-12-31';



if (($_POST['provee'] == '0') and ($_POST['artic'] == '0'))
  if (($cla_fecha == null) or ($cla_fecha1 == null))
   {
    mensaje_error('ABM_Novarticulos.php','Faltan Fechas para Consulta');
    exit;
   }
  else
   $result= mysql_query("select * from abmarticulos a, articulos b, rubros c, proveedores d where
         a.idarticulo = b.idarticulo and b.rubro = c.idrubro and a.rubro = b.rubro and a.idproveedor = d.idproveedores and
         fecha >= '".$cla_fecha."' and fecha <= '".$cla_fecha1."' order by a.fecha ");

if (($_POST['provee'] <> '0') and ($_POST['artic'] == '0'))
  if (($cla_fecha == null) or ($cla_fecha1 == null))
   {
    mensaje_error('ABM_Novarticulos.php','Faltan Fechas para Consulta');
    exit;
   }
  else
   $result= mysql_query("select * from abmarticulos a, articulos b, rubros c, proveedores d where
         a.idarticulo = b.idarticulo and b.rubro = c.idrubro and a.rubro = b.rubro and a.idproveedor = d.idproveedores and
         fecha >= '".$cla_fecha."' and fecha <= '".$cla_fecha1."' and idproveedor =
          ".$_POST['provee']." order by a.fecha");

if (($_POST['provee'] == '0') and ($_POST['artic'] <> '0'))
  if (($cla_fecha == null) or ($cla_fecha1 == null))
   {
    mensaje_error('ABM_Novarticulos.php','Faltan Fechas para Consulta');
    exit;
   }
  else
   $result= mysql_query("select * from abmarticulos a, articulos b, rubros c, proveedores d where
         a.idarticulo = b.idarticulo and b.rubro = c.idrubro and a.rubro = b.rubro and a.idproveedor = d.idproveedores and
         fecha >= '".$cla_fecha."' and fecha <= '".$cla_fecha1."' and a.idarticulo =
          ".$articulos." and a.rubro = ".$rubro." order by a.fecha");



echo '</p><table ><tr><td>';
echo '<FORM METHOD="POST" NAME="formulario3" ACTION="A_Novarticulos.php">';
echo '<input type="hidden" name= "pasacont" value="'.$idcon.'" >';
echo '<table width="100%" border = 1 align="left" cellpadding="5" cellspacing="5" style="background-color:'.$body_color.';border-left-width: 0; border-top-width: 0; border-bottom-width: 0"><tr>';
echo ' <td><td align="center" style="background-color:'.$td_color.'">
                    <label onclick="this.form.submit();" style="CURSOR: pointer" >
                     <img align="middle" alt=\'Nuevo Artículo\' src="imagenes/BOTIQUIN.ICO" width="50" height="40"/>
                    </label>
                  </td></td>';
echo '</FORM>';
echo'</table></table>';


echo '
<table width="100%" border="1" align="left">
  <tr style="background-color:'.$td_color.'">
    <td width="100%" rowspan="3" valign="top"><div align="center">
      <table style="font-size:'.$fontreg.'" border = 1 cellspacing="5" width="100%" cellpadding="5" align="left" style="background-color:'.$th_color.';border-left-width: 0; border-top-width: 0; border-bottom-width: 0">
          <tr style="font-size:'.$fontt.'">
            <th>COD</th>
            <th>ARTICULO</th>
            <th>RUBRO</th>
            <th>FECHA</th>
            <th>PROVEEDOR</th>
            <th>CANTIDAD</th>
            <th>IMPORTE</th>
            <th>BOR</th>
            <th>MOD</th>
        </td>';


//Mostramos los registros
while ($row=mysql_fetch_array($result))
{

$fecha = cambiarFormatoFecha($row['fecha']);

echo '<tr><td align="center">'.$row["rubro"].'-'.$row["idarticulo"].'</td>';
echo '<td align="center">'.$row["articulo"].'</td>';
echo '<td align="center">'.$row["descrubro"].'</td>';
echo '<td align="center">'.$fecha.'</td>';
echo '<td align="center">'.$row["proveedores"].'</td>';
echo '<td align="center">'.$row["cantidad"].'</td>';
echo '<td align="center">'.$row["importe"].'</td>';

$idnovedad = $row["idabmarticulo"];

echo '<FORM METHOD="POST" NAME="formulario2" ACTION="B_Novarticulos.php">';
echo '<input type="hidden" name= "pasabmarti" value="'.$idnovedad.'" >';
echo ' <td width="17" align="center" style="background-color:'.$td_color.'">
                    <label onclick="this.form.submit();" style="CURSOR: pointer" >
                     <img align="middle" alt=\'Borrar\' src="imagenes/102.ICO" width="30" height="30"/>
                    </label>
                  </td>';
echo '</FORM>';

echo '<FORM METHOD="POST" NAME="formulario2" ACTION="M_Novarticulos.php">';
echo '<input type="hidden" name= "pasabmarti" value="'.$idnovedad.'" >';
echo ' <td width="17" align="center" style="background-color:'.$td_color.'">
                    <label onclick="this.form.submit();" style="CURSOR: pointer" >
                     <img align="middle" alt=\'Modificar\' src="imagenes/editar.png" width="30" height="30"/>
                    </label>
                  </td>';
echo '</FORM>';

}

mysql_free_result($result)


?>

</table>


</BODY>
</HTML>