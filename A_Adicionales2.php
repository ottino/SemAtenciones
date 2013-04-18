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

//Ejecucion de la sentencia SQL

$idcontrato = $_POST["pasacont"];
$cla_idcliente  = $_POST["cla_idcliente"];
$cla_idcliente1 = $_POST["cla_idcliente1"];
$cla_idcliente2 = $_POST["cla_idcliente2"];
$cla_idcliente3 = $_POST["cla_idcliente3"];
$cla_idcliente4 = $_POST["cla_idcliente4"];
$cla_idcliente5 = $_POST["cla_idcliente5"];
$cla_idcliente6 = $_POST["cla_idcliente6"];
$cla_idcliente7 = $_POST["cla_idcliente7"];
$cla_idcliente8 = $_POST["cla_idcliente8"];
$cla_idcliente9 = $_POST["cla_idcliente9"];
$cla_idcliente10= $_POST["cla_idcliente10"];
$cla_idcliente11= $_POST["cla_idcliente11"];
$cla_idcliente12= $_POST["cla_idcliente12"];

$cla_idplan      = $_POST["cla_idplan"];
$cla_frecuencia  = $_POST["cla_frecuencia"];
$cla_fecalta     = $_POST["cla_fecha"];
$cla_fecvto      = $_POST["cla_fecha1"];
$cla_importe     = $_POST["cla_importe"];
$cla_ordenmax    = $_POST["cla_ordenmax"];
$cla_tipocomprob = $_POST["cla_tipocomprob"];


if ($cla_idcliente1 != 'A')
 {
  $sSQL="select * from clientes WHERE idcliente = ".$cla_idcliente1;
  $result=mysql_query($sSQL);
  $row=mysql_fetch_array($result);

  $cla_idcliente       = $row["idcliente"];
  $cla_nroafiliado     = $row["nroafiliado"];
  $cla_nombre          = $row["nombre"];
  $cla_documento       = $row["documento"];
  $cla_fnacimiento     = $row["fnacimiento"];
  $cla_sexo            = $row["sexo"];
  $cla_identificacion  = $row["documento"];
  $cla_calle           = $row["calle"];
  $cla_numero          = $row["nrocalle"];
  $cla_piso            = $row["piso"];
  $cla_depto           = $row["depto"];
  $cla_barrio          = $row["barrio"];
  $cla_localidad       = $row["localidad"];
  $cla_provincia       = $row["provincia"];
  $cla_ordenmax = $cla_ordenmax + 1;

  $sSQL= "insert into padron (idpadron, idcontrato, nombre, socio, plan, integrante, fnacimiento, sexo, identificacion, documento,calle, numero,
                            piso, depto, barrio, localidad, provincia)
    VALUES ('".$cla_documento."' ,'".$idcontrato."', '".$cla_nombre."', '".$cla_nroafiliado."' , '".$cla_idplan."' , '".$cla_ordenmax."' , '".$cla_fnacimiento."' ,
            '".$cla_sexo."' , '".$cla_nroafiliado."' , '".$cla_documento."','".$cla_calle."',
            '".$cla_numero."' ,'".$cla_piso."' ,'".$cla_depto."' ,'".$cla_barrio."' ,'".$cla_localidad."' ,'".$cla_provincia."')";
  mysql_query($sSQL);

  insertolog($legajo, "A_Adicionales2", "padron", "insert", "1999-12-01", $sSQL);

  $sSQL= "insert into cliadicionales (idcontrato, idpadron)
      VALUES ('".$idcontrato."' , '".$cla_idcliente."' )";
  mysql_query($sSQL);

  insertolog($legajo, "A_Adicionales2", "cliadicionales", "insert", "1999-12-01", $sSQL);

 }
////////////////////////////////////
if ($cla_idcliente2 != 'A')
 {
  $sSQL="select * from clientes WHERE idcliente = ".$cla_idcliente2;
  $result=mysql_query($sSQL);
  $row=mysql_fetch_array($result);

  $cla_idcliente       = $row["idcliente"];
  $cla_nroafiliado     = $row["nroafiliado"];
  $cla_nombre          = $row["nombre"];
  $cla_documento       = $row["documento"];
  $cla_fnacimiento     = $row["fnacimiento"];
  $cla_sexo            = $row["sexo"];
  $cla_identificacion  = $row["documento"];
  $cla_calle           = $row["calle"];
  $cla_numero          = $row["nrocalle"];
  $cla_piso            = $row["piso"];
  $cla_depto           = $row["depto"];
  $cla_barrio          = $row["barrio"];
  $cla_localidad       = $row["localidad"];
  $cla_provincia       = $row["provincia"];
  $cla_ordenmax = $cla_ordenmax + 1;

  $sSQL= "insert into padron (idpadron, idcontrato, nombre, socio, plan, integrante, fnacimiento, sexo, identificacion, documento,calle, numero,
                            piso, depto, barrio, localidad, provincia)
    VALUES ('".$cla_documento."' ,'".$idcontrato."', '".$cla_nombre."', '".$cla_nroafiliado."' , '".$cla_idplan."' , '".$cla_ordenmax."' , '".$cla_fnacimiento."' ,
            '".$cla_sexo."' , '".$cla_nroafiliado."' , '".$cla_documento."','".$cla_calle."',
            '".$cla_numero."' ,'".$cla_piso."' ,'".$cla_depto."' ,'".$cla_barrio."' ,'".$cla_localidad."' ,'".$cla_provincia."')";
  mysql_query($sSQL);

 insertolog($legajo, "A_Adicionales2", "padron", "insert", "1999-12-01", $sSQL);

  $sSQL= "insert into cliadicionales (idcontrato, idpadron)
      VALUES ('".$idcontrato."' , '".$cla_idcliente."' )";
  mysql_query($sSQL);

  insertolog($legajo, "A_Adicionales2", "cliadicionales", "insert", "1999-12-01", $sSQL);

 }
////////////////////////////////////
if ($cla_idcliente3 != 'A')
 {
  $sSQL="select * from clientes WHERE idcliente = ".$cla_idcliente3;
  $result=mysql_query($sSQL);
  $row=mysql_fetch_array($result);

  $cla_idcliente       = $row["idcliente"];
  $cla_nroafiliado     = $row["nroafiliado"];
  $cla_nombre          = $row["nombre"];
  $cla_documento       = $row["documento"];
  $cla_fnacimiento     = $row["fnacimiento"];
  $cla_sexo            = $row["sexo"];
  $cla_identificacion  = $row["documento"];
  $cla_calle           = $row["calle"];
  $cla_numero          = $row["nrocalle"];
  $cla_piso            = $row["piso"];
  $cla_depto           = $row["depto"];
  $cla_barrio          = $row["barrio"];
  $cla_localidad       = $row["localidad"];
  $cla_provincia       = $row["provincia"];
  $cla_ordenmax = $cla_ordenmax + 1;

  $sSQL= "insert into padron (idpadron, idcontrato, nombre, socio, plan, integrante, fnacimiento, sexo, identificacion, documento,calle, numero,
                            piso, depto, barrio, localidad, provincia)
    VALUES ('".$cla_documento."' ,'".$idcontrato."', '".$cla_nombre."', '".$cla_nroafiliado."' , '".$cla_idplan."' , '".$cla_ordenmax."' , '".$cla_fnacimiento."' ,
            '".$cla_sexo."' , '".$cla_nroafiliado."' , '".$cla_documento."','".$cla_calle."',
            '".$cla_numero."' ,'".$cla_piso."' ,'".$cla_depto."' ,'".$cla_barrio."' ,'".$cla_localidad."' ,'".$cla_provincia."')";
  mysql_query($sSQL);

  insertolog($legajo, "A_Adicionales2", "padron", "insert", "1999-12-01", $sSQL);

  $sSQL= "insert into cliadicionales (idcontrato, idpadron)
      VALUES ('".$idcontrato."' , '".$cla_idcliente."' )";
  mysql_query($sSQL);

  insertolog($legajo, "A_Adicionales2", "cliadicionales", "insert", "1999-12-01", $sSQL);
 }
////////////////////////////////////
if ($cla_idcliente4 != 'A')
 {
  $sSQL="select * from clientes WHERE idcliente = ".$cla_idcliente4;
  $result=mysql_query($sSQL);
  $row=mysql_fetch_array($result);

  $cla_idcliente       = $row["idcliente"];
  $cla_nroafiliado     = $row["nroafiliado"];
  $cla_nombre          = $row["nombre"];
  $cla_documento       = $row["documento"];
  $cla_fnacimiento     = $row["fnacimiento"];
  $cla_sexo            = $row["sexo"];
  $cla_identificacion  = $row["documento"];
  $cla_calle           = $row["calle"];
  $cla_numero          = $row["nrocalle"];
  $cla_piso            = $row["piso"];
  $cla_depto           = $row["depto"];
  $cla_barrio          = $row["barrio"];
  $cla_localidad       = $row["localidad"];
  $cla_provincia       = $row["provincia"];
  $cla_ordenmax = $cla_ordenmax + 1;

  $sSQL= "insert into padron (idpadron, idcontrato, nombre, socio, plan, integrante, fnacimiento, sexo, identificacion, documento,calle, numero,
                            piso, depto, barrio, localidad, provincia)
    VALUES ('".$cla_documento."' ,'".$idcontrato."', '".$cla_nombre."', '".$cla_nroafiliado."' , '".$cla_idplan."' , '".$cla_ordenmax."' , '".$cla_fnacimiento."' ,
            '".$cla_sexo."' , '".$cla_nroafiliado."' , '".$cla_documento."','".$cla_calle."',
            '".$cla_numero."' ,'".$cla_piso."' ,'".$cla_depto."' ,'".$cla_barrio."' ,'".$cla_localidad."' ,'".$cla_provincia."')";
  mysql_query($sSQL);

  insertolog($legajo, "A_Adicionales2", "padron", "insert", "1999-12-01", $sSQL);

  $sSQL= "insert into cliadicionales (idcontrato, idpadron)
      VALUES ('".$idcontrato."' , '".$cla_idcliente."' )";
  mysql_query($sSQL);

  insertolog($legajo, "A_Adicionales2", "cliadicionales", "insert", "1999-12-01", $sSQL);
 }
////////////////////////////////////
if ($cla_idcliente5 != 'A')
 {
  $sSQL="select * from clientes WHERE idcliente = ".$cla_idcliente5;
  $result=mysql_query($sSQL);
  $row=mysql_fetch_array($result);

  $cla_idcliente       = $row["idcliente"];
  $cla_nroafiliado     = $row["nroafiliado"];
  $cla_nombre          = $row["nombre"];
  $cla_documento       = $row["documento"];
  $cla_fnacimiento     = $row["fnacimiento"];
  $cla_sexo            = $row["sexo"];
  $cla_identificacion  = $row["documento"];
  $cla_calle           = $row["calle"];
  $cla_numero          = $row["nrocalle"];
  $cla_piso            = $row["piso"];
  $cla_depto           = $row["depto"];
  $cla_barrio          = $row["barrio"];
  $cla_localidad       = $row["localidad"];
  $cla_provincia       = $row["provincia"];
  $cla_ordenmax = $cla_ordenmax + 1;

  $sSQL= "insert into padron (idpadron, idcontrato, nombre, socio, plan, integrante, fnacimiento, sexo, identificacion, documento,calle, numero,
                            piso, depto, barrio, localidad, provincia)
    VALUES ('".$cla_documento."' ,'".$idcontrato."', '".$cla_nombre."', '".$cla_nroafiliado."' , '".$cla_idplan."' , '".$cla_ordenmax."' , '".$cla_fnacimiento."' ,
            '".$cla_sexo."' , '".$cla_nroafiliado."' , '".$cla_documento."','".$cla_calle."',
            '".$cla_numero."' ,'".$cla_piso."' ,'".$cla_depto."' ,'".$cla_barrio."' ,'".$cla_localidad."' ,'".$cla_provincia."')";
  mysql_query($sSQL);

  insertolog($legajo, "A_Adicionales2", "padron", "insert", "1999-12-01", $sSQL);

  $sSQL= "insert into cliadicionales (idcontrato, idpadron)
      VALUES ('".$idcontrato."' , '".$cla_idcliente."' )";
  mysql_query($sSQL);

  insertolog($legajo, "A_Adicionales2", "cliadicionales", "insert", "1999-12-01", $sSQL);

 }
////////////////////////////////////
if ($cla_idcliente6 != 'A')
 {
  $sSQL="select * from clientes WHERE idcliente = ".$cla_idcliente6;
  $result=mysql_query($sSQL);
  $row=mysql_fetch_array($result);

  $cla_idcliente       = $row["idcliente"];
  $cla_nroafiliado     = $row["nroafiliado"];
  $cla_nombre          = $row["nombre"];
  $cla_documento       = $row["documento"];
  $cla_fnacimiento     = $row["fnacimiento"];
  $cla_sexo            = $row["sexo"];
  $cla_identificacion  = $row["documento"];
  $cla_calle           = $row["calle"];
  $cla_numero          = $row["nrocalle"];
  $cla_piso            = $row["piso"];
  $cla_depto           = $row["depto"];
  $cla_barrio          = $row["barrio"];
  $cla_localidad       = $row["localidad"];
  $cla_provincia       = $row["provincia"];
  $cla_ordenmax = $cla_ordenmax + 1;

  $sSQL= "insert into padron (idpadron, idcontrato, nombre, socio, plan, integrante, fnacimiento, sexo, identificacion, documento,calle, numero,
                            piso, depto, barrio, localidad, provincia)
    VALUES ('".$cla_documento."' ,'".$idcontrato."', '".$cla_nombre."', '".$cla_nroafiliado."' , '".$cla_idplan."' , '".$cla_ordenmax."' , '".$cla_fnacimiento."' ,
            '".$cla_sexo."' , '".$cla_nroafiliado."' , '".$cla_documento."','".$cla_calle."',
            '".$cla_numero."' ,'".$cla_piso."' ,'".$cla_depto."' ,'".$cla_barrio."' ,'".$cla_localidad."' ,'".$cla_provincia."')";
  mysql_query($sSQL);

  insertolog($legajo, "A_Adicionales2", "padron", "insert", "1999-12-01", $sSQL);

  $sSQL= "insert into cliadicionales (idcontrato, idpadron)
      VALUES ('".$idcontrato."' , '".$cla_idcliente."' )";
  mysql_query($sSQL);

  insertolog($legajo, "A_Adicionales2", "cliadicionales", "insert", "1999-12-01", $sSQL);
 }
////////////////////////////////////
if ($cla_idcliente7 != 'A')
 {
  $sSQL="select * from clientes WHERE idcliente = ".$cla_idcliente7;
  $result=mysql_query($sSQL);
  $row=mysql_fetch_array($result);

  $cla_idcliente       = $row["idcliente"];
  $cla_nroafiliado     = $row["nroafiliado"];
  $cla_nombre          = $row["nombre"];
  $cla_documento       = $row["documento"];
  $cla_fnacimiento     = $row["fnacimiento"];
  $cla_sexo            = $row["sexo"];
  $cla_identificacion  = $row["documento"];
  $cla_calle           = $row["calle"];
  $cla_numero          = $row["nrocalle"];
  $cla_piso            = $row["piso"];
  $cla_depto           = $row["depto"];
  $cla_barrio          = $row["barrio"];
  $cla_localidad       = $row["localidad"];
  $cla_provincia       = $row["provincia"];
  $cla_ordenmax = $cla_ordenmax + 1;

  $sSQL= "insert into padron (idpadron, idcontrato, nombre, socio, plan, integrante, fnacimiento, sexo, identificacion, documento,calle, numero,
                            piso, depto, barrio, localidad, provincia)
    VALUES ('".$cla_documento."' ,'".$idcontrato."', '".$cla_nombre."', '".$cla_nroafiliado."' , '".$cla_idplan."' , '".$cla_ordenmax."' , '".$cla_fnacimiento."' ,
            '".$cla_sexo."' , '".$cla_nroafiliado."' , '".$cla_documento."','".$cla_calle."',
            '".$cla_numero."' ,'".$cla_piso."' ,'".$cla_depto."' ,'".$cla_barrio."' ,'".$cla_localidad."' ,'".$cla_provincia."')";
  mysql_query($sSQL);

  insertolog($legajo, "A_Adicionales2", "padron", "insert", "1999-12-01", $sSQL);

  $sSQL= "insert into cliadicionales (idcontrato, idpadron)
      VALUES ('".$idcontrato."' , '".$cla_idcliente."' )";
  mysql_query($sSQL);

  insertolog($legajo, "A_Adicionales2", "cliadicionales", "insert", "1999-12-01", $sSQL);

 }
////////////////////////////////////
if ($cla_idcliente8 != 'A')
 {
  $sSQL="select * from clientes WHERE idcliente = ".$cla_idcliente8;
  $result=mysql_query($sSQL);
  $row=mysql_fetch_array($result);

  $cla_idcliente       = $row["idcliente"];
  $cla_nroafiliado     = $row["nroafiliado"];
  $cla_nombre          = $row["nombre"];
  $cla_documento       = $row["documento"];
  $cla_fnacimiento     = $row["fnacimiento"];
  $cla_sexo            = $row["sexo"];
  $cla_identificacion  = $row["documento"];
  $cla_calle           = $row["calle"];
  $cla_numero          = $row["nrocalle"];
  $cla_piso            = $row["piso"];
  $cla_depto           = $row["depto"];
  $cla_barrio          = $row["barrio"];
  $cla_localidad       = $row["localidad"];
  $cla_provincia       = $row["provincia"];
  $cla_ordenmax = $cla_ordenmax + 1;

  $sSQL= "insert into padron (idpadron, idcontrato, nombre, socio, plan, integrante, fnacimiento, sexo, identificacion, documento,calle, numero,
                            piso, depto, barrio, localidad, provincia)
    VALUES ('".$cla_documento."' ,'".$idcontrato."', '".$cla_nombre."', '".$cla_nroafiliado."' , '".$cla_idplan."' , '".$cla_ordenmax."' , '".$cla_fnacimiento."' ,
            '".$cla_sexo."' , '".$cla_nroafiliado."' , '".$cla_documento."','".$cla_calle."',
            '".$cla_numero."' ,'".$cla_piso."' ,'".$cla_depto."' ,'".$cla_barrio."' ,'".$cla_localidad."' ,'".$cla_provincia."')";
  mysql_query($sSQL);

  insertolog($legajo, "A_Adicionales2", "padron", "insert", "1999-12-01", $sSQL);

  $sSQL= "insert into cliadicionales (idcontrato, idpadron)
      VALUES ('".$idcontrato."' , '".$cla_idcliente."' )";
  mysql_query($sSQL);

  insertolog($legajo, "A_Adicionales2", "cliadicionales", "insert", "1999-12-01", $sSQL);

 }
////////////////////////////////////
if ($cla_idcliente9 != 'A')
 {
  $sSQL="select * from clientes WHERE idcliente = ".$cla_idcliente9;
  $result=mysql_query($sSQL);
  $row=mysql_fetch_array($result);

  $cla_idcliente       = $row["idcliente"];
  $cla_nroafiliado     = $row["nroafiliado"];
  $cla_nombre          = $row["nombre"];
  $cla_documento       = $row["documento"];
  $cla_fnacimiento     = $row["fnacimiento"];
  $cla_sexo            = $row["sexo"];
  $cla_identificacion  = $row["documento"];
  $cla_calle           = $row["calle"];
  $cla_numero          = $row["nrocalle"];
  $cla_piso            = $row["piso"];
  $cla_depto           = $row["depto"];
  $cla_barrio          = $row["barrio"];
  $cla_localidad       = $row["localidad"];
  $cla_provincia       = $row["provincia"];
  $cla_ordenmax = $cla_ordenmax + 1;

  $sSQL= "insert into padron (idpadron, idcontrato, nombre, socio, plan, integrante, fnacimiento, sexo, identificacion, documento,calle, numero,
                            piso, depto, barrio, localidad, provincia)
    VALUES ('".$cla_documento."' ,'".$idcontrato."', '".$cla_nombre."', '".$cla_nroafiliado."' , '".$cla_idplan."' , '".$cla_ordenmax."' , '".$cla_fnacimiento."' ,
            '".$cla_sexo."' , '".$cla_nroafiliado."' , '".$cla_documento."','".$cla_calle."',
            '".$cla_numero."' ,'".$cla_piso."' ,'".$cla_depto."' ,'".$cla_barrio."' ,'".$cla_localidad."' ,'".$cla_provincia."')";
  mysql_query($sSQL);

  insertolog($legajo, "A_Adicionales2", "padron", "insert", "1999-12-01", $sSQL);

  $sSQL= "insert into cliadicionales (idcontrato, idpadron)
      VALUES ('".$idcontrato."' , '".$cla_idcliente."' )";
  mysql_query($sSQL);

  insertolog($legajo, "A_Adicionales2", "cliadicionales", "insert", "1999-12-01", $sSQL);
 }
////////////////////////////////////
if ($cla_idcliente10 != 'A')
 {
  $sSQL="select * from clientes WHERE idcliente = ".$cla_idcliente10;
  $result=mysql_query($sSQL);
  $row=mysql_fetch_array($result);

  $cla_idcliente       = $row["idcliente"];
  $cla_nroafiliado     = $row["nroafiliado"];
  $cla_nombre          = $row["nombre"];
  $cla_documento       = $row["documento"];
  $cla_fnacimiento     = $row["fnacimiento"];
  $cla_sexo            = $row["sexo"];
  $cla_identificacion  = $row["documento"];
  $cla_calle           = $row["calle"];
  $cla_numero          = $row["nrocalle"];
  $cla_piso            = $row["piso"];
  $cla_depto           = $row["depto"];
  $cla_barrio          = $row["barrio"];
  $cla_localidad       = $row["localidad"];
  $cla_provincia       = $row["provincia"];
  $cla_ordenmax = $cla_ordenmax + 1;

  $sSQL= "insert into padron (idpadron, idcontrato, nombre, socio, plan, integrante, fnacimiento, sexo, identificacion, documento,calle, numero,
                            piso, depto, barrio, localidad, provincia)
    VALUES ('".$cla_documento."' ,'".$idcontrato."', '".$cla_nombre."', '".$cla_nroafiliado."' , '".$cla_idplan."' , '".$cla_ordenmax."' , '".$cla_fnacimiento."' ,
            '".$cla_sexo."' , '".$cla_nroafiliado."' , '".$cla_documento."','".$cla_calle."',
            '".$cla_numero."' ,'".$cla_piso."' ,'".$cla_depto."' ,'".$cla_barrio."' ,'".$cla_localidad."' ,'".$cla_provincia."')";
  mysql_query($sSQL);

  insertolog($legajo, "A_Adicionales2", "padron", "insert", "1999-12-01", $sSQL);

  $sSQL= "insert into cliadicionales (idcontrato, idpadron)
      VALUES ('".$idcontrato."' , '".$cla_idcliente."' )";
  mysql_query($sSQL);

  insertolog($legajo, "A_Adicionales2", "cliadicionales", "insert", "1999-12-01", $sSQL);

 }
////////////////////////////////////
if ($cla_idcliente11 != 'A')
 {
  $sSQL="select * from clientes WHERE idcliente = ".$cla_idcliente11;
  $result=mysql_query($sSQL);
  $row=mysql_fetch_array($result);

  $cla_idcliente       = $row["idcliente"];
  $cla_nroafiliado     = $row["nroafiliado"];
  $cla_nombre          = $row["nombre"];
  $cla_documento       = $row["documento"];
  $cla_fnacimiento     = $row["fnacimiento"];
  $cla_sexo            = $row["sexo"];
  $cla_identificacion  = $row["documento"];
  $cla_calle           = $row["calle"];
  $cla_numero          = $row["nrocalle"];
  $cla_piso            = $row["piso"];
  $cla_depto           = $row["depto"];
  $cla_barrio          = $row["barrio"];
  $cla_localidad       = $row["localidad"];
  $cla_provincia       = $row["provincia"];
  $cla_ordenmax = $cla_ordenmax + 1;

  $sSQL= "insert into padron (idpadron, idcontrato, nombre, socio, plan, integrante, fnacimiento, sexo, identificacion, documento,calle, numero,
                            piso, depto, barrio, localidad, provincia)
    VALUES ('".$cla_documento."' ,'".$idcontrato."', '".$cla_nombre."', '".$cla_nroafiliado."' , '".$cla_idplan."' , '".$cla_ordenmax."' , '".$cla_fnacimiento."' ,
            '".$cla_sexo."' , '".$cla_nroafiliado."' , '".$cla_documento."','".$cla_calle."',
            '".$cla_numero."' ,'".$cla_piso."' ,'".$cla_depto."' ,'".$cla_barrio."' ,'".$cla_localidad."' ,'".$cla_provincia."')";
  mysql_query($sSQL);

  insertolog($legajo, "A_Adicionales2", "padron", "insert", "1999-12-01", $sSQL);

  $sSQL= "insert into cliadicionales (idcontrato, idpadron)
      VALUES ('".$idcontrato."' , '".$cla_idcliente."' )";
  mysql_query($sSQL);

  insertolog($legajo, "A_Adicionales2", "cliadicionales", "insert", "1999-12-01", $sSQL);
 }
////////////////////////////////////
if ($cla_idcliente12 != 'A')
 {
  $sSQL="select * from clientes WHERE idcliente = ".$cla_idcliente12;
  $result=mysql_query($sSQL);
  $row=mysql_fetch_array($result);

  $cla_idcliente       = $row["idcliente"];
  $cla_nroafiliado     = $row["nroafiliado"];
  $cla_nombre          = $row["nombre"];
  $cla_documento       = $row["documento"];
  $cla_fnacimiento     = $row["fnacimiento"];
  $cla_sexo            = $row["sexo"];
  $cla_identificacion  = $row["documento"];
  $cla_calle           = $row["calle"];
  $cla_numero          = $row["nrocalle"];
  $cla_piso            = $row["piso"];
  $cla_depto           = $row["depto"];
  $cla_barrio          = $row["barrio"];
  $cla_localidad       = $row["localidad"];
  $cla_provincia       = $row["provincia"];
  $cla_ordenmax = $cla_ordenmax + 1;

  $sSQL= "insert into padron (idpadron, idcontrato, nombre, socio, plan, integrante, fnacimiento, sexo, identificacion, documento,calle, numero,
                            piso, depto, barrio, localidad, provincia)
    VALUES ('".$cla_documento."' ,'".$idcontrato."', '".$cla_nombre."', '".$cla_nroafiliado."' , '".$cla_idplan."' , '".$cla_ordenmax."' , '".$cla_fnacimiento."' ,
            '".$cla_sexo."' , '".$cla_nroafiliado."' , '".$cla_documento."','".$cla_calle."',
            '".$cla_numero."' ,'".$cla_piso."' ,'".$cla_depto."' ,'".$cla_barrio."' ,'".$cla_localidad."' ,'".$cla_provincia."')";
  mysql_query($sSQL);

  insertolog($legajo, "A_Adicionales2", "padron", "insert", "1999-12-01", $sSQL);

  $sSQL= "insert into cliadicionales (idcontrato, idpadron)
      VALUES ('".$idcontrato."' , '".$cla_idcliente."' )";
  mysql_query($sSQL);

  insertolog($legajo, "A_Adicionales2", "cliadicionales", "insert", "1999-12-01", $sSQL);
 }

    $sSQL= "update contratos set ordenmax   = '".$cla_ordenmax."'
               where idcontrato = '$idcontrato'";
  mysql_query($sSQL);

////////////////////////////////////


echo mensaje_ok('ABM_Adicionales.php?pasacont='.$idcontrato,'OK');

?>
