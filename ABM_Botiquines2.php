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
<TITLE>ABM_Botiquines2.php</TITLE>
</HEAD>

<body style="background-color:<?echo $body_color?>">
<BODY>


<?
echo titulo_encabezado ('Modulo de Botiquines' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }

$movil = $_POST["movil"];

 $result= mysql_query("select * from botiquines a, moviles b, articulos c, rubros d where
         a.idmovil = b.idmovil and a.idarticulo = c.idarticulo and a.rubro = c.rubro and
         c.rubro = d.idrubro and a.idmovil = '".$movil."' order by 2 ");

echo '</p><table width="100%"><tr style="background-color:'.$body_color.'"><td>';
echo '<FORM METHOD="POST" NAME="formulario3" ACTION="A_Botiquines.php">';
echo '<input type="hidden" name= "pasabotiquin" value="'.$movil.'" >';
echo '<table width="6%" border = 1 align="left" cellpadding="5" cellspacing="5" style="background-color:<?echo $th_color?>;border-left-width: 0; border-top-width: 0; border-bottom-width: 0"><tr>';
echo '<td align="left" style="background-color:'.$td_color.'">
                    <label onclick="this.form.submit();"  style="CURSOR: pointer" >
                     <img align="middle" alt="Nuevo Artículo al Botiquí" src="imagenes/BOTIQUIN.ICO" width="50" height="40"/>
                    </label>
                  </td></table>';
echo '</FORM>';
echo'</td></tr></table>';

echo '
<table width="100%">
 <tr style="background-color:'.$td_color.'">
    <td width="100%" rowspan="3" valign="top">
      <table style="font-size:'.$fontreg.'" border = 1 cellspacing="5" width="100%" cellpadding="5" align="left" style="background-color:'.$th_color.';border-left-width: 0; border-top-width: 0; border-bottom-width: 0">
          <tr style="font-size:'.$fontt.'">
            <th>ID BOTIQUIN</th>
            <th>ARTICULO</th>
            <th>EXISTENCIA</th>
            <th>CN CRITICA</th>
            <th>BOR</th>
            <th>MOD</th>
        </td>';


//Mostramos los registros
while ($row=mysql_fetch_array($result))
{

$fecha = cambiarFormatoFecha($row['fecha']);

echo '<tr><td align="center">'.$row["idmovil"].' - '.$row["descmovil"].'</td>';
echo '<td align="left">'.$row["idarticulo"].' - '.$row["idrubro"].' - '.$row["articulo"].'</td>';
echo '<td align="center">'.$row["cantidad"].'</td>';
echo '<td align="center">'.$row["cnminima"].'</td>';


echo '<FORM METHOD="POST" NAME="formulario3" ACTION="B_Botiquines.php">';

$idnovedad = $row["idbotiquines"];
echo '<input type="hidden" name= "pasabotiquin" value="'.$idnovedad.'" >';

echo ' <td width="17" align="center" >
                    <label onclick="this.form.submit();" style="CURSOR: pointer" >
                     <img align="middle" alt=\'Borrar\' src="imagenes/102.ICO" width="20" height="20"/>
                    </label>
                  </td>';

echo '</FORM>';

echo '<FORM METHOD="POST" NAME="formulario3" ACTION="M_Botiquines.php">';
$idnovedad = $row["idbotiquines"];
echo '<input type="hidden" name= "pasabotiquin" value="'.$idnovedad.'" >';

echo ' <td width="17" align="center"  >
                    <label onclick="this.form.submit();" style="CURSOR: pointer" >
                     <img align="middle" alt=\'Modificar\' src="imagenes/editar.png" width="20" height="20"/>
                    </label>
                  </td>';

echo '</FORM>';

//echo '<td><a href="B_Botiquines.php?pasabotiquin='.$idnovedad.'" /a>Borrar</td>';
//echo '<td><a href="M_Botiquines.php?pasabotiquin='.$idnovedad.'" /a>Modificar</td></tr>';

}

mysql_free_result($result)


?>

</table>


</BODY>
</HTML>