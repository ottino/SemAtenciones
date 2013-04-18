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
<TITLE>ABM_Agenda.php</TITLE>
</HEAD>

<body style="background-color:<?echo $body_color?>" style="font-size:<?echo $fontef?>">
<BODY>


<?
echo titulo_encabezado ('Agenda Personal' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }
//Ejecutamos la sentencia SQL

$nombre = $_POST["cla_nombre"];

if ($nombre == '')
      $query = '';
    else
    $query = " and nombre like '%".$nombre."%' ";

$legajo = $G_legajo;

$result=mysql_query("select * from agenda where acceso in (0,".$legajo.") ".$query." order by 2");

echo '</p><table ><tr><td>';
echo '<FORM METHOD="POST" NAME="formulario3" ACTION="A_Agenda.php">';
echo '<table width="100%" border = 1 align="left" cellpadding="5" cellspacing="5" style="background-color:'.$body_color.';border-left-width: 0; border-top-width: 0; border-bottom-width: 0"><tr>';
echo ' <td><td width="25" align="center" style="background-color:'.$td_color.'">
                    <label onclick="this.form.submit();"  style="CURSOR: pointer" >
                     <img align="middle" alt=\'Nuevo Contacto\' src="imagenes/AGENDA1.ICO" width="50" height="40"/>
                    </label>
                  </td></td><td style="width:6000px;background-color:'.$body_color.'"></td>';
echo '</FORM>';
     echo '<FORM METHOD="POST" NAME="formulario2" ACTION="ABM_Agenda0.php">';
     echo ' <td width="17" align="center" style="background-color:'.$td_color.'">
                     <label onclick="this.form.submit();" style="CURSOR: pointer" >
                      <img align="middle" alt=\'Volver\' src="imagenes/Volver.ico" width="30" height="30"/>
                     </label>
                   </td>';
     echo '</FORM></FORM></tr></table><TR><TD>
         <table border="1" align="left" cellspacing="5" cellpadding="5">
         <tr style="font-size:<?echo $fontt?>"> ';


echo'</table></table>';

echo'
<table width="100%" border="1" align="left">
  <TR style="background-color:'.$td_color.'">
    <td width="100%" rowspan="3" valign="top"><div align="center">
      <table style="font-size:'.$fontreg.'" border = 1 cellspacing="5" width="100%" cellpadding="5" align="left" style="background-color:'.$th_color.';border-left-width: 0; border-top-width: 0; border-bottom-width: 0">
          <tr style="font-size:'.$fontt.'">
            <th>ID</th>
            <th>NOMBRE</th>
            <th>DIRECCION</th>
            <th>TEL</th>
            <th>CELULAR</th>
            <th>Consultar</th>
            <th>Borrar</th>
            <th>Modif</th>
        </td>';


//Mostramos los registros
while ($row=mysql_fetch_array($result))
{

echo '<tr><td>'.$row["id"].'</td>';
echo '<td>'.$row["nombre"].'&nbsp;</td>';
echo '<td>'.$row["direccion"].'&nbsp;</td>';
echo '<td>'.$row["telfijo"].'&nbsp;</td>';
echo '<td>'.$row["celular"].'&nbsp;</td>';

$datos = $row["id"];

echo '<FORM METHOD="POST" NAME="formulario2" ACTION="C_Agenda.php">';
echo '<input type="hidden" name= "pasdatos" value="'.$datos.'" >';
echo '<input type="hidden" name= "cla_nombre" value="'.$nombre.'" >';
echo ' <td width="17" align="center" style="background-color:'.$td_color.'">
                    <label onclick="this.form.submit();" style="CURSOR: pointer" >
                     <img align="middle" alt=\'Consultar\' src="imagenes/INSERTAR.ICO" width="30" height="30"/>
                    </label>
                  </td>';
echo '</FORM>';

echo '<FORM METHOD="POST" NAME="formulario2" ACTION="B_Agenda.php">';
echo '<input type="hidden" name= "pasdatos" value="'.$datos.'" >';
echo ' <td width="17" align="center" style="background-color:'.$td_color.'">
                    <label onclick="this.form.submit();" style="CURSOR: pointer" >
                     <img align="middle" alt=\'Borrar\' src="imagenes/102.ICO" width="30" height="30"/>
                    </label>
                  </td>';
echo '</FORM>';

echo '<FORM METHOD="POST" NAME="formulario2" ACTION="M_Agenda.php">';
echo '<input type="hidden" name= "pasdatos" value="'.$datos.'" >';
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