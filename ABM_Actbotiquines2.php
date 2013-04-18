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
<TITLE>ABM_Actbotiquines2.php</TITLE>
</HEAD>

<body style="background-color:<?echo $body_color?>">
<BODY>

<?
echo titulo_encabezado ('Recarga de Botiquines' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }

$articulos = $_POST["movil"];

 $result= mysql_query("select * from botiquines a, moviles b, articulos c, rubros d where
         a.idmovil = b.idmovil and a.idarticulo = c.idarticulo and a.rubro = c.rubro and
         c.rubro = d.idrubro and a.idmovil = '".$articulos."' order by 2 ");

?>
<TABLE><TR style="background-color:'.$td_color.'"><TD>
<FORM METHOD="POST" NAME="formulario1"
      ACTION="ABM_Actbotiquines.php">
<INPUT TYPE="SUBMIT" value="Volver">
</FORM></TD>
<TD>
<FORM METHOD="POST" NAME="formulario3"
ACTION="ABM_Actbotiquines3.php">
<INPUT TYPE="SUBMIT" value="Actualizar">
</TD></TR></TABLE>
<table width="100%" border="1" align="left">
  <tr>
    <td width="100%" rowspan="3" valign="top"><div align="center">
      <table border = 1 cellspacing="5" width="100%" cellpadding="5" align="left" style="background-color:<?echo $th_color?>;border-left-width: 0; border-top-width: 0; border-bottom-width: 0">
          <tr>
            <th>ID BOTIQUIN</th>
            <th>ARTICULO</th>
            <th>EXISTENCIA</th>
            <th>CN CRITICA</th>
            <th>RECARGA</th>
        </td>

<?
//Mostramos los registros
$c = 0;
while ($row=mysql_fetch_array($result))
{
$c++;

$fecha = cambiarFormatoFecha($row['fecha']);

echo '<tr><td align="center">'.$row["idmovil"].' - '.$row["descmovil"].'</td>';
echo '<td align="left">'.$row["idarticulo"].' - '.$row["idrubro"].' - '.$row["articulo"].'</td>';
echo '<td align="center">'.$row["cantidad"].'</td>';
echo '<td align="center">'.$row["cnminima"].'</td>';
echo '<TD align="center"><input size= 12 type = "text" name = "cla_recarga'.-$c.'"/></TD>';

echo '<input size= 12 type = "hidden" name = "cla_botiquin'.-$c.'" value="'.$row["idbotiquines"].'"/>';
echo '<input size= 12 type = "hidden" name = "cla_articulo'.-$c.'" value="'.$row["idarticulo"].' - '.$row["idrubro"].'"/>';

$idnovedad = $row["idbotiquines"];

}
echo'<input type="hidden" name= "filas" value="'.$c.'" />';

mysql_free_result($result);

?>

</table>

</FORM>
</BODY>
</HTML>