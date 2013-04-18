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
<TITLE>ABM_Artículos.php</TITLE>
</HEAD>

<body style="background-color:<?echo $body_color?>">
<BODY>


<?
echo titulo_encabezado ('ABM de Artículos' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }

//Ejecutamos la sentencia SQL
$result=mysql_query("select * from articulos a, rubros b where
                     a.rubro = b.idrubro order by 3,1,2");

echo '<table><tr style="background-color:'.$td_color.'"><td>';
echo '<FORM METHOD="POST" NAME="formulario3" ACTION="A_Articulos.php">';
echo '<input type="hidden" name= "pasacont" value="'.$idcon.'" >';
echo '<table width="100%" border = 1 align="left" cellpadding="5" cellspacing="5" ><tr style="background-color:'.$td_color.'">';
echo ' <td><td align="center">
                    <label onclick="this.form.submit();" style="CURSOR: pointer" >
                     <img align="middle" alt=\'Nuevo Artículo\' src="imagenes/BOTIQUIN.ICO" width="50" height="40"/>
                    </label>
                  </td></td>';
echo '</FORM>';
echo'</table></td></tr></table>';

echo '
<table width="80%" border="1" align="left">
  <tr style="background-color:'.$td_color.'">
    <td width="100%" rowspan="3" valign="top"><div align="center">
      <table style="font-size:'.$fontreg.'" border = 1 cellspacing="5" width="100%" cellpadding="5" align="left" style="background-color:'.$th_color.';border-left-width: 0; border-top-width: 0; border-bottom-width: 0">
          <tr style="font-size:'.$fontt.'">
            <th>Codigo</th>
            <th>Descripción</th>
            <th>Rubro</th>
            <th>Existencia</th>
            <th>Cn Crítica</th>
            <th>Bor</th>
            <th>Mod</th>
        </td>';


//Mostramos los registros
while ($row=mysql_fetch_array($result))
{

echo '<tr><td>'.$row["rubro"].'-'.$row["idarticulo"].'</td>';
echo '<td>'.$row["articulo"].'</td>';
echo '<td>'.$row["descrubro"].'</td>';
echo '<td>'.$row["existencia"].'</td>';
echo '<td>'.$row["cncritica"].'</td>';

$idart = $row["idarticulo"].'-'.$row["rubro"];

//echo '<td>'.$row["desc"].'&nbsp;</td>';

echo '<FORM METHOD="POST" NAME="formulario2" ACTION="B_Articulos.php">';
echo '<input type="hidden" name= "pasarticulo" value="'.$idart.'" >';
echo ' <td width="17" align="center" style="background-color:'.$td_color.'">
                    <label onclick="this.form.submit();" style="CURSOR: pointer" >
                     <img align="middle" alt=\'Borrar\' src="imagenes/102.ICO" width="30" height="30"/>
                    </label>
                  </td>';
echo '</FORM>';

echo '<FORM METHOD="POST" NAME="formulario2" ACTION="M_Articulos.php">';
echo '<input type="hidden" name= "pasarticulo" value="'.$idart.'" >';
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