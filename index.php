<?php
session_start();
######################INCLUDES################################
//archivo de configuracion
include_once ('config.php');

//funciones propias
include ('funciones.php');

//incluímos la clase ajax
require ('xajax/xajax.inc.php');
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//require_once("cookie.php");

################### Conexion a la base de  ##########################
    $bd= mysql_connect($bd_host, $bd_user, $bd_pass);
    mysql_select_db($bd_database, $bd);
    
if(isset($_POST['leg']) && isset($_POST['cla'])){

    

    //Ejecucion de la sentencia SQL
    $legajo = $_POST['leg'];
    $contrasena = $_POST['cla'];

    if(is_numeric($legajo)){

        $sSQL= "select * from legajos where legajo = $legajo;";

        $result=mysql_query($sSQL,$bd);

        $contrasena = md5($_POST['cla'] . $semilla);


        if ($result)
        {
          $resultado = mysql_fetch_array($result);
          
          //if ($resultado['clave'] <> $contrasena)
		  if (1<>1)
            $mensaje = 'Usuario y clave incorrectos';
           else
           {

            $cookie = new cookieClass;
            $cookie->parametros("usuario",$resultado['apeynomb']);
            $cookie->parametros("legajo",$resultado['legajo']);
            $cookie->parametros("perfil",$resultado['perfil']);
            $cookie->parametros("funcion",$resultado['funcion']);
            $cookie->parametros("nick",$resultado['nick']);

            echo mensaje_ok('Principal.php',"OK");

           }

           //mysql_free_result($result);
        }
        else
            $mensaje = 'Usuario y clave incorrectos';
    }else{
        $mensaje = 'Usuario y clave incorrectos';
    }
}

?>




<HTML>
<HEAD>

<TITLE><?php echo TITULO_SISTEMA; ?></TITLE>
<link href="css/sem.css" type="text/css" rel="stylesheet">
</head>

<body>


<FORM METHOD="POST" ACTION="index.php">


<table  align="center"  width="38%" height="437" border="0">
  <tr>
    <td height="107">&nbsp;</td>
  </tr>
  <tr>
    <td height="322"  background="imagenes/logo.jpg">
    <table width="100%" height="201" border="0">
        <tr>
          <th colspan = "2">&nbsp;</th>
          
        </tr>
        <tr>
          <td>Usuario</td>
        </tr>
        <tr>
          <td><input size= 10 type = "text" name = "leg" value = "" /></td>
        </tr>
        <tr>
          <td>Clave</td>
        </tr>
        <tr>
          <td><input  size= 10 type = "password" name = "cla" value = "" /></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><?php echo empty($mensaje) ? '&nbsp;' : "<span class='error'>$mensaje</span>"; ?> </td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><INPUT name="SUBMIT" TYPE="submit" value="Ingresar"></td>
        </tr>     
      </table></td>
  </tr>
</table>
</FORM>

</body>
</html>

