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

require_once("cookie.php");
require_once("config.php");
$cookie = new cookieClass;
$G_usuario = $cookie->get("usuario");
$G_legajo  = $cookie->get("legajo");
$G_perfil  = $cookie->get("perfil");

################### Conexion a la base de datos##########################

$bd= mysql_connect($bd_host, $bd_user, $bd_pass);
mysql_select_db($bd_database, $bd);

//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
?>

<HTML>
<HEAD>
<TITLE>A_Cajas.php</TITLE>
</HEAD>
<body style="background-color:<?echo $body_color?>">

<BODY>
<FORM METHOD="POST"
ACTION="A_Cajas2.php">

<?
echo titulo_encabezado ('Alta de Cajas' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }
$perfil = $G_perfil;
$legajo = $G_legajo;
$usuario = $G_usuario;

//Ejecutamos la sentencia SQL

if ($perfil == '3')
   $result=mysql_query("select * from cajas where estado < 1 order by 2,3");
  else
   $result=mysql_query("select * from cajas where tipo = '1' and estado < 1 order by 2,3");

$cajas= '<select name="cajas" style="background-color:'.$se_color.'"><option value="0">Cajas abiertas</option>';
while ($row=mysql_fetch_array($result))
{
$usuario = buscopersonal($row['legajo']);
$cajas.='<option value="'.$row['idcaja'].'">'.$usuario.'</option>';

}

$cajas.= '</select>';



echo '
  <table width="50%" border="1" align="left">
  <tr>
    <td width="100%" rowspan="3" valign="top"><div align="center">
      <table style="font-size:'.$fontreg.'" border = 1 cellspacing="5" width="100%" cellpadding="5" align="left" style="background-color:'.$th_color.';border-left-width: 0; border-top-width: 0; border-bottom-width: 0">
         <tr style="font-size:'.$fontt.'; background-color:'.$td_color.'">
            <th>CAJA ANTERIOR</th>
            <th>CONTINUAR</th>
        </td>';


echo '<tr style="background-color:'.$td_color.'"><td align="left">'.$cajas.'</td>';

echo ' <td width="17" align="center" style="background-color:'.$td_color.'" >
                    <label onclick="this.form.submit();" style="CURSOR: pointer" >
                     <img align="middle" alt=\'Continuar\' src="imagenes/INSERTAR.ICO" width="30" height="30"/>
                    </label>
                  </td>';

echo '</table>' ;

mysql_free_result($result);

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


