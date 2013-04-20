<?php

session_start();

include_once ('config.php');
require_once("cookie.php");

include ('funciones.php');
require ('xajax/xajax.inc.php');


$bd= mysql_connect($bd_host, $bd_user, $bd_pass);
mysql_select_db($bd_database, $bd);
    
if(isset($_POST['leg']) && isset($_POST['cla'])){

    $legajo = $_POST['leg'];
    $contrasena = $_POST['cla'];

    if(is_numeric($legajo)){

        $sSQL= "select * from legajos where legajo = $legajo;";

        $result=mysql_query($sSQL,$bd);

        // Con la encriptacion
        # $contrasena = md5($_POST['cla'] . $semilla);     
         
        $contrasena = $_POST['cla'];

        if ($result)
        {
          $resultado = mysql_fetch_array($result);
          
          if ($resultado['clave'] <> $contrasena)
            $mensaje = 'Usuario y clave incorrectos';
           else
           {

            $cookie = new cookieClass;
            $cookie->parametros("usuario",$resultado['apeynomb']);
            $cookie->parametros("legajo",$resultado['legajo']);
            $cookie->parametros("perfil",$resultado['perfil']);
            $cookie->parametros("funcion",$resultado['funcion']);
            $cookie->parametros("nick",$resultado['nick']);

            echo mensaje_ok('principal.php',"OK");

           }
           mysql_free_result($result);
        }
        else
            $mensaje = 'Usuario y clave incorrectos';
    }else{
        $mensaje = 'Usuario y clave incorrectos';
    }
}

?>


<html>
    <head>
        <title>
             <?php 
                echo TITULO_SISTEMA; 
            ?>
        </title>
    
        <link href="css/sem.css" type="text/css" rel="stylesheet">
    </head>

<body>

    <form method="POST" action="index.php">

        <table border="0">
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
              <td><?php echo empty($mensaje) ? '&nbsp;' : "<span class='error'>$mensaje</span>"; ?> </td>
            </tr>
            <tr>
              <td><input name="submit" type="submit" value="Ingresar"></td>
            </tr>     
          </table>
    </form>

</body>
</html>

