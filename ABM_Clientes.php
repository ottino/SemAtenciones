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
<TITLE>ABM_Clientes.php</TITLE>
</HEAD>

<body style="background-color:<?echo $body_color?>" style="font-size:<?echo $fontef?>">

<?
echo titulo_encabezado ('ABM de Clientes' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }

$idbus  = $_POST["cla_bus"];
$idord  = $_POST["cla_ord"];
$nombre  = $_POST["cla_nombre"];
$fecha  = $_POST["cla_fecha"];


if ($idbus == '' && $idord == '' && $nombre == '' && $fecha == '')
  {
  $idbus  = $_GET["cla_bus"];
  $idord  = $_GET["cla_ord"];
  $nombre  = $_GET["cla_nombre"];
  $fecha  = $_GET["cla_fecha"];
  };


 if ($idbus == 'C')
     $sqlnombre = " where cuit = '".$nombre."' ";

 if ($idbus == 'D')
     $sqlnombre = " where documento = '".$nombre."' ";

 if ($idbus == 'S')
     $sqlnombre = " where nroafiliado = '".$nombre."' ";

 if ($idbus == 'N')
     $sqlnombre = " where nombre like '%".$nombre."%' ";

if ($nombre == '')
     $sqlnombre = '';

$sqlnombre1 = " order by nombre";


 if ($idord == 'C')
     $sqlnombre1 = " order by cuit";

 if ($idord == 'D')
     $sqlnombre1 = " order by documento";

 if ($idord == 'S')
     $sqlnombre1 = " order by nroafiliado";

 if ($idord == 'N')
     $sqlnombre1 = " order by nombre";



//Ejecutamos la sentencia SQL
$result=mysql_query("select * from clientes ".$sqlnombre." ".$sqlnombre1."");

echo '</p><table ><tr><td>';
echo '<FORM METHOD="POST" NAME="formulario3" ACTION="A_Clientes.php">';
echo '<table width="20%" border = 1 align="left" cellpadding="5" cellspacing="5" style="background-color:'.$body_color.';border-left-width: 0; border-top-width: 0; border-bottom-width: 0"><tr>';
echo ' <td><td width="25" align="center" style="background-color:'.$td_color.'">
                    <label onclick="this.form.submit();" style="CURSOR: pointer" >
                     <img align="middle" alt=\'Nuevo Cliente\' src="imagenes/clientes.ico" width="50" height="40"/>
                    </label>
                  </td></td>';
echo '</FORM>';
echo'</table></table>';

echo'
<table width="80%" border="1" align="left">
 <tr style="background-color:'.$td_color.'">
    <td width="100%" rowspan="3" valign="top"><div align="center">
      <table style="font-size:'.$fontreg.'" border = 1 cellspacing="5" width="100%" cellpadding="5" align="left" style="background-color:'.$th_color.';border-left-width: 0; border-top-width: 0; border-bottom-width: 0">
          <tr style="font-size:'.$fontt.'; background-color:'.$td_color.'">
            <th>CUIT</th>
            <th>DOCUMENTO</th>
            <th>AFILIADO</th>
            <th>NOMBRE</th>
            <th>EDAD</th>
            <th>Borrar</th>
            <th>Editar</th>
        </td>';


//Mostramos los registros
while ($row=mysql_fetch_array($result))
{

echo '<tr><td>'.$row["cuit"].'</td>';
echo '<td>'.$row["documento"].'</td>';
echo '<td>'.$row["nroafiliado"].'</td>';
echo '<td>'.$row["nombre"].'</td>';

$edadcli = edad($row["fnacimiento"]);
echo '<td>'.$edadcli.'</td>';

$idcli = $row["idcliente"];

echo '<FORM METHOD="POST" NAME="formulario2" ACTION="B_Clientes.php">';
echo '<input type="hidden" name= "pasacli" value="'.$idcli.'" >';
echo ' <td width="17" align="center" style="background-color:'.$td_color.'">
                    <label onclick="this.form.submit();" style="CURSOR: pointer" >
                     <img align="middle" alt=\'Borrar\' src="imagenes/102.ICO" width="30" height="30"/>
                    </label>
                  </td>';
echo '</FORM>';

echo '<FORM METHOD="POST" NAME="formulario2" ACTION="M_Clientes.php">';
echo '<input type="hidden" name= "pasacli" value="'.$idcli.'" >';
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