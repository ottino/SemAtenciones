<?php

session_start();

include_once ('config.php');
include ('funciones.php');
require ('xajax/xajax.inc.php');

$bd= mysql_connect($bd_host, $bd_user, $bd_pass);
mysql_select_db($bd_database, $bd);

?>


<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
    <title>
        <?php 
            echo TITULO_SISTEMA; 
        ?>
    </title>

    <link href="css/sem.css" type="text/css" rel="stylesheet">
</head>

<body>


<?php
    echo titulo_encabezado ('Menu principal del Sistema' , $path_imagen_logo);
?>


</body>
</html>