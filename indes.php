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

################### Conexion a la base de datos##########################

$bd= mysql_connect($bd_host, $bd_user, $bd_pass);
mysql_select_db($bd_database, $bd);


$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }


$usuario = iconv("ISO-8859-1", "UTF-8", $_GET["usuario"]);

require_once dirname(__FILE__)."/src/phpfreechat.class.php";
$params = array();
$params["title"] = "A Tiempo S.A.";
$params["nick"] = "$usuario";  // setup the intitial nickname
//$params["nick"] = "guest".rand(1,1000);  // setup the intitial nickname
$params["isadmin"] = false; // do not use it on production servers ;)
$params["serverid"] = md5(localhost); // calculate a unique id for this chat
$params["language"] = "es_ES";
$params["quit_on_closedwindow"] = true;
//$params["frozen_nick"] = true;

$chat = new phpFreeChat( $params );

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
 <head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <title>A Tiempo S.A. - Sala de Chat</title>
  <link rel="stylesheet" title="classic" type="text/css" href="style/generic.css" />
  <link rel="stylesheet" title="classic" type="text/css" href="style/header.css" />
  <link rel="stylesheet" title="classic" type="text/css" href="style/footer.css" />
  <link rel="stylesheet" title="classic" type="text/css" href="style/menu.css" />
  <link rel="stylesheet" title="classic" type="text/css" href="style/content.css" />
 </head>
 <body>

<div class="header">
      <img alt="logo bulle" src="/at/imagenes/Logo_a_tiempo.jpg" width="85" height="55" class="logo2" />
      <h1>Servicio Emergencias - Sala de Chat</h1>
</div>

<div class="menu">
      <ul>
        <li class="sub title">General</li>
        <li>
          <ul class="sub">
            <li class="item">
              <a href="Principal.php">Menu Principal</a>
            </li>
            <li>
            </li>
          </ul>
        </li>
        <li class="sub title">Documentacion</li>
        <li>
          <ul>
          </ul>
        </li>
      </ul>
      <p class="partner">
      </p>
</div>

<div class="content">
  <?php $chat->printChat(); ?>
  <?php if (isset($params["isadmin"]) && $params["isadmin"]) { ?>
    <p style="color:red;font-weight:bold;">Warning: because of "isadmin" parameter, everybody is admin. Please modify this script before using it on production servers !</p>
  <?php } ?>
</div>

</body></html>
