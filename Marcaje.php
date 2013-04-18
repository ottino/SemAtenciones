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

<TITLE>Marcaje.php</TITLE>
</head>

<body style="background-color:<?echo $body_color?>">


<FORM METHOD="POST"
ACTION="Marcaje2.php">


<table  align="center"  width="38%" height="437" border="0">
  <tr>
    <td height="107"  >&nbsp;</td>
  </tr>
  <tr>
    <td height="322"  background="imagenes/Logo_a_tiempo.jpg">
    <table width="100%" height="201" border="0">
        <tr>
          <th width="75%" scope="col">&nbsp;</th>
          <th width="25%" scope="col">&nbsp;</th>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>Usuario</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td><input size= 10 type = "text" name = "leg" value = "" /></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>Clave</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td><input  size= 10 type = "password" name = "cla" value = "" /></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td><INPUT name="SUBMIT" TYPE="submit" value="Marcar"></td>
        </tr>
        <tr>
          <td height="21">&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td height="21">&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td height="21">&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td height="21">&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td height="21">&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td height="21">&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</FORM>

</body>
</html>
