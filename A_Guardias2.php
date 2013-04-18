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

if ($_POST['legajo'] == 0)
{  mensaje_error('A_Guardias.php','No seleccionó personal');
   exit;
}
if ($_POST['meses'] == 0)
{  mensaje_error('A_Guardias.php','No seleccionó mes');
   exit;
}

if ($_POST['anios'] == 0)
{  mensaje_error('A_Guardias.php','No seleccionó año');
   exit;
}

if ($_POST['base'] == 0)
{  mensaje_error('A_Guardias.php','No seleccionó base');
   exit;
}


if ($_POST['diai1'] > 0)
{    $fechai = $_POST['anios'].'/'.$_POST['meses'].'/'.$_POST['diai1'];
     $fechas = $_POST['anios'].'/'.$_POST['meses'].'/'.$_POST['dias1'];
    $horai = $_POST['horai1'].':00:00';
    $horas = $_POST['horas1'].':00:00';

 $sSQL="insert into guardias (legajo,fecingreso,horaingreso,fecsalida,horasalida,base)
  values ('".$_POST['legajo']."','".$fechai."','".$horai."','".$fechas."','".$horas."','".$_POST['base']."')";
   mysql_query($sSQL);

  insertolog($legajo, "A_Guardias2", "guardias", "insert", "1999-12-01", $sSQL);
}


///// PROCESO DEL DIA 2 ///////

if ($_POST['diai2'] > 0)
{    $fechai = $_POST['anios'].'/'.$_POST['meses'].'/'.$_POST['diai2'];
     $fechas = $_POST['anios'].'/'.$_POST['meses'].'/'.$_POST['dias2'];
    $horai = $_POST['horai2'].':00:00';
    $horas = $_POST['horas2'].':00:00';

 $sSQL="insert into guardias (legajo,fecingreso,horaingreso,fecsalida,horasalida,base)
  values ('".$_POST['legajo']."','".$fechai."','".$horai."','".$fechas."','".$horas."','".$_POST['base']."')";
   mysql_query($sSQL);

  insertolog($legajo, "A_Guardias2", "guardias", "insert", "1999-12-01", $sSQL);
}

///// PROCESO DEL DIA 3 ///////

if ($_POST['diai3'] > 0)
{    $fechai = $_POST['anios'].'/'.$_POST['meses'].'/'.$_POST['diai3'];
     $fechas = $_POST['anios'].'/'.$_POST['meses'].'/'.$_POST['dias3'];
    $horai = $_POST['horai3'].':00:00';
    $horas = $_POST['horas3'].':00:00';

 $sSQL="insert into guardias (legajo,fecingreso,horaingreso,fecsalida,horasalida,base)
  values ('".$_POST['legajo']."','".$fechai."','".$horai."','".$fechas."','".$horas."','".$_POST['base']."')";
   mysql_query($sSQL);

  insertolog($legajo, "A_Guardias2", "guardias", "insert", "1999-12-01", $sSQL);
}

///// PROCESO DEL DIA 4 ///////

if ($_POST['diai4'] > 0)
{    $fechai = $_POST['anios'].'/'.$_POST['meses'].'/'.$_POST['diai4'];
     $fechas = $_POST['anios'].'/'.$_POST['meses'].'/'.$_POST['dias4'];
    $horai = $_POST['horai4'].':00:00';
    $horas = $_POST['horas4'].':00:00';

 $sSQL="insert into guardias (legajo,fecingreso,horaingreso,fecsalida,horasalida,base)
  values ('".$_POST['legajo']."','".$fechai."','".$horai."','".$fechas."','".$horas."','".$_POST['base']."')";
   mysql_query($sSQL);

  insertolog($legajo, "A_Guardias2", "guardias", "insert", "1999-12-01", $sSQL);
}

///// PROCESO DEL DIA 5 ///////

if ($_POST['diai5'] > 0)
{    $fechai = $_POST['anios'].'/'.$_POST['meses'].'/'.$_POST['diai5'];
     $fechas = $_POST['anios'].'/'.$_POST['meses'].'/'.$_POST['dias5'];
    $horai = $_POST['horai5'].':00:00';
    $horas = $_POST['horas5'].':00:00';

 $sSQL="insert into guardias (legajo,fecingreso,horaingreso,fecsalida,horasalida,base)
  values ('".$_POST['legajo']."','".$fechai."','".$horai."','".$fechas."','".$horas."','".$_POST['base']."')";
   mysql_query($sSQL);

  insertolog($legajo, "A_Guardias2", "guardias", "insert", "1999-12-01", $sSQL);
}

///// PROCESO DEL DIA 6 ///////

if ($_POST['diai6'] > 0)
{    $fechai = $_POST['anios'].'/'.$_POST['meses'].'/'.$_POST['diai6'];
     $fechas = $_POST['anios'].'/'.$_POST['meses'].'/'.$_POST['dias6'];
    $horai = $_POST['horai6'].':00:00';
    $horas = $_POST['horas6'].':00:00';

 $sSQL="insert into guardias (legajo,fecingreso,horaingreso,fecsalida,horasalida,base)
  values ('".$_POST['legajo']."','".$fechai."','".$horai."','".$fechas."','".$horas."','".$_POST['base']."')";
   mysql_query($sSQL);

  insertolog($legajo, "A_Guardias2", "guardias", "insert", "1999-12-01", $sSQL);
}

///// PROCESO DEL DIA 7 ///////

if ($_POST['diai7'] > 0)
{    $fechai = $_POST['anios'].'/'.$_POST['meses'].'/'.$_POST['diai7'];
     $fechas = $_POST['anios'].'/'.$_POST['meses'].'/'.$_POST['dias7'];
    $horai = $_POST['horai7'].':00:00';
    $horas = $_POST['horas7'].':00:00';

 $sSQL="insert into guardias (legajo,fecingreso,horaingreso,fecsalida,horasalida,base)
  values ('".$_POST['legajo']."','".$fechai."','".$horai."','".$fechas."','".$horas."','".$_POST['base']."')";
   mysql_query($sSQL);

  insertolog($legajo, "A_Guardias2", "guardias", "insert", "1999-12-01", $sSQL);
}

///// PROCESO DEL DIA 8 ///////

if ($_POST['diai8'] > 0)
{    $fechai = $_POST['anios'].'/'.$_POST['meses'].'/'.$_POST['diai8'];
     $fechas = $_POST['anios'].'/'.$_POST['meses'].'/'.$_POST['dias8'];
    $horai = $_POST['horai8'].':00:00';
    $horas = $_POST['horas8'].':00:00';

 $sSQL="insert into guardias (legajo,fecingreso,horaingreso,fecsalida,horasalida,base)
  values ('".$_POST['legajo']."','".$fechai."','".$horai."','".$fechas."','".$horas."','".$_POST['base']."')";
   mysql_query($sSQL);

  insertolog($legajo, "A_Guardias2", "guardias", "insert", "1999-12-01", $sSQL);
}

///// PROCESO DEL DIA 9 ///////

if ($_POST['diai9'] > 0)
{    $fechai = $_POST['anios'].'/'.$_POST['meses'].'/'.$_POST['diai9'];
     $fechas = $_POST['anios'].'/'.$_POST['meses'].'/'.$_POST['dias9'];
    $horai = $_POST['horai9'].':00:00';
    $horas = $_POST['horas9'].':00:00';

 $sSQL="insert into guardias (legajo,fecingreso,horaingreso,fecsalida,horasalida,base)
  values ('".$_POST['legajo']."','".$fechai."','".$horai."','".$fechas."','".$horas."','".$_POST['base']."')";
   mysql_query($sSQL);

  insertolog($legajo, "A_Guardias2", "guardias", "insert", "1999-12-01", $sSQL);
}

///// PROCESO DEL DIA 10 ///////

if ($_POST['diai10'] > 0)
{    $fechai = $_POST['anios'].'/'.$_POST['meses'].'/'.$_POST['diai10'];
     $fechas = $_POST['anios'].'/'.$_POST['meses'].'/'.$_POST['dias10'];
    $horai = $_POST['horai10'].':00:00';
    $horas = $_POST['horas10'].':00:00';

 $sSQL="insert into guardias (legajo,fecingreso,horaingreso,fecsalida,horasalida,base)
  values ('".$_POST['legajo']."','".$fechai."','".$horai."','".$fechas."','".$horas."','".$_POST['base']."')";
   mysql_query($sSQL);

  insertolog($legajo, "A_Guardias2", "guardias", "insert", "1999-12-01", $sSQL);
}

///// PROCESO DEL DIA 11 ///////

if ($_POST['diai11'] > 0)
{    $fechai = $_POST['anios'].'/'.$_POST['meses'].'/'.$_POST['diai11'];
     $fechas = $_POST['anios'].'/'.$_POST['meses'].'/'.$_POST['dias11'];
    $horai = $_POST['horai11'].':00:00';
    $horas = $_POST['horas11'].':00:00';

 $sSQL="insert into guardias (legajo,fecingreso,horaingreso,fecsalida,horasalida,base)
  values ('".$_POST['legajo']."','".$fechai."','".$horai."','".$fechas."','".$horas."','".$_POST['base']."')";
   mysql_query($sSQL);

  insertolog($legajo, "A_Guardias2", "guardias", "insert", "1999-12-01", $sSQL);
}

///// PROCESO DEL DIA 12 ///////

if ($_POST['diai12'] > 0)
{    $fechai = $_POST['anios'].'/'.$_POST['meses'].'/'.$_POST['diai12'];
     $fechas = $_POST['anios'].'/'.$_POST['meses'].'/'.$_POST['dias12'];
    $horai = $_POST['horai12'].':00:00';
    $horas = $_POST['horas12'].':00:00';

 $sSQL="insert into guardias (legajo,fecingreso,horaingreso,fecsalida,horasalida,base)
  values ('".$_POST['legajo']."','".$fechai."','".$horai."','".$fechas."','".$horas."','".$_POST['base']."')";
   mysql_query($sSQL);

  insertolog($legajo, "A_Guardias2", "guardias", "insert", "1999-12-01", $sSQL);
}

///// PROCESO DEL DIA 13 ///////

if ($_POST['diai13'] > 0)
{    $fechai = $_POST['anios'].'/'.$_POST['meses'].'/'.$_POST['diai13'];
     $fechas = $_POST['anios'].'/'.$_POST['meses'].'/'.$_POST['dias13'];
    $horai = $_POST['horai13'].':00:00';
    $horas = $_POST['horas13'].':00:00';

 $sSQL="insert into guardias (legajo,fecingreso,horaingreso,fecsalida,horasalida,base)
  values ('".$_POST['legajo']."','".$fechai."','".$horai."','".$fechas."','".$horas."','".$_POST['base']."')";
   mysql_query($sSQL);

  insertolog($legajo, "A_Guardias2", "guardias", "insert", "1999-12-01", $sSQL);
}

///// PROCESO DEL DIA 14 ///////

if ($_POST['diai14'] > 0)
{    $fechai = $_POST['anios'].'/'.$_POST['meses'].'/'.$_POST['diai14'];
     $fechas = $_POST['anios'].'/'.$_POST['meses'].'/'.$_POST['dias14'];
    $horai = $_POST['horai14'].':00:00';
    $horas = $_POST['horas14'].':00:00';

 $sSQL="insert into guardias (legajo,fecingreso,horaingreso,fecsalida,horasalida,base)
  values ('".$_POST['legajo']."','".$fechai."','".$horai."','".$fechas."','".$horas."','".$_POST['base']."')";
   mysql_query($sSQL);

  insertolog($legajo, "A_Guardias2", "guardias", "insert", "1999-12-01", $sSQL);
}

///// PROCESO DEL DIA 15 ///////

if ($_POST['diai15'] > 0)
{    $fechai = $_POST['anios'].'/'.$_POST['meses'].'/'.$_POST['diai15'];
     $fechas = $_POST['anios'].'/'.$_POST['meses'].'/'.$_POST['dias15'];
    $horai = $_POST['horai15'].':00:00';
    $horas = $_POST['horas15'].':00:00';

 $sSQL="insert into guardias (legajo,fecingreso,horaingreso,fecsalida,horasalida,base)
  values ('".$_POST['legajo']."','".$fechai."','".$horai."','".$fechas."','".$horas."','".$_POST['base']."')";
   mysql_query($sSQL);

  insertolog($legajo, "A_Guardias2", "guardias", "insert", "1999-12-01", $sSQL);
}

///// PROCESO DEL DIA 16 ///////

if ($_POST['diai16'] > 0)
{    $fechai = $_POST['anios'].'/'.$_POST['meses'].'/'.$_POST['diai16'];
     $fechas = $_POST['anios'].'/'.$_POST['meses'].'/'.$_POST['dias16'];
    $horai = $_POST['horai16'].':00:00';
    $horas = $_POST['horas16'].':00:00';

 $sSQL="insert into guardias (legajo,fecingreso,horaingreso,fecsalida,horasalida,base)
  values ('".$_POST['legajo']."','".$fechai."','".$horai."','".$fechas."','".$horas."','".$_POST['base']."')";
   mysql_query($sSQL);

  insertolog($legajo, "A_Guardias2", "guardias", "insert", "1999-12-01", $sSQL);
}

///// PROCESO DEL DIA 17 ///////

if ($_POST['diai17'] > 0)
{    $fechai = $_POST['anios'].'/'.$_POST['meses'].'/'.$_POST['diai17'];
     $fechas = $_POST['anios'].'/'.$_POST['meses'].'/'.$_POST['dias17'];
    $horai = $_POST['horai17'].':00:00';
    $horas = $_POST['horas17'].':00:00';

 $sSQL="insert into guardias (legajo,fecingreso,horaingreso,fecsalida,horasalida,base)
  values ('".$_POST['legajo']."','".$fechai."','".$horai."','".$fechas."','".$horas."','".$_POST['base']."')";
   mysql_query($sSQL);

  insertolog($legajo, "A_Guardias2", "guardias", "insert", "1999-12-01", $sSQL);
}

///// PROCESO DEL DIA 18 ///////

if ($_POST['diai18'] > 0)
{    $fechai = $_POST['anios'].'/'.$_POST['meses'].'/'.$_POST['diai18'];
     $fechas = $_POST['anios'].'/'.$_POST['meses'].'/'.$_POST['dias18'];
    $horai = $_POST['horai18'].':00:00';
    $horas = $_POST['horas18'].':00:00';

 $sSQL="insert into guardias (legajo,fecingreso,horaingreso,fecsalida,horasalida,base)
  values ('".$_POST['legajo']."','".$fechai."','".$horai."','".$fechas."','".$horas."','".$_POST['base']."')";
   mysql_query($sSQL);

  insertolog($legajo, "A_Guardias2", "guardias", "insert", "1999-12-01", $sSQL);
}

///// PROCESO DEL DIA 19 ///////

if ($_POST['diai19'] > 0)
{    $fechai = $_POST['anios'].'/'.$_POST['meses'].'/'.$_POST['diai19'];
     $fechas = $_POST['anios'].'/'.$_POST['meses'].'/'.$_POST['dias19'];
    $horai = $_POST['horai19'].':00:00';
    $horas = $_POST['horas19'].':00:00';

 $sSQL="insert into guardias (legajo,fecingreso,horaingreso,fecsalida,horasalida,base)
  values ('".$_POST['legajo']."','".$fechai."','".$horai."','".$fechas."','".$horas."','".$_POST['base']."')";
   mysql_query($sSQL);

  insertolog($legajo, "A_Guardias2", "guardias", "insert", "1999-12-01", $sSQL);
}

///// PROCESO DEL DIA 20 ///////

if ($_POST['diai20'] > 0)
{    $fechai = $_POST['anios'].'/'.$_POST['meses'].'/'.$_POST['diai20'];
     $fechas = $_POST['anios'].'/'.$_POST['meses'].'/'.$_POST['dias20'];
    $horai = $_POST['horai20'].':00:00';
    $horas = $_POST['horas20'].':00:00';

 $sSQL="insert into guardias (legajo,fecingreso,horaingreso,fecsalida,horasalida,base)
  values ('".$_POST['legajo']."','".$fechai."','".$horai."','".$fechas."','".$horas."','".$_POST['base']."')";
   mysql_query($sSQL);

  insertolog($legajo, "A_Guardias2", "guardias", "insert", "1999-12-01", $sSQL);
}

///// PROCESO DEL DIA 21 ///////

if ($_POST['diai21'] > 0)
{    $fechai = $_POST['anios'].'/'.$_POST['meses'].'/'.$_POST['diai21'];
     $fechas = $_POST['anios'].'/'.$_POST['meses'].'/'.$_POST['dias21'];
    $horai = $_POST['horai21'].':00:00';
    $horas = $_POST['horas21'].':00:00';

 $sSQL="insert into guardias (legajo,fecingreso,horaingreso,fecsalida,horasalida,base)
  values ('".$_POST['legajo']."','".$fechai."','".$horai."','".$fechas."','".$horas."','".$_POST['base']."')";
   mysql_query($sSQL);

  insertolog($legajo, "A_Guardias2", "guardias", "insert", "1999-12-01", $sSQL);
}

///// PROCESO DEL DIA 22 ///////

if ($_POST['diai22'] > 0)
{    $fechai = $_POST['anios'].'/'.$_POST['meses'].'/'.$_POST['diai22'];
     $fechas = $_POST['anios'].'/'.$_POST['meses'].'/'.$_POST['dias22'];
    $horai = $_POST['horai22'].':00:00';
    $horas = $_POST['horas22'].':00:00';

 $sSQL="insert into guardias (legajo,fecingreso,horaingreso,fecsalida,horasalida,base)
  values ('".$_POST['legajo']."','".$fechai."','".$horai."','".$fechas."','".$horas."','".$_POST['base']."')";
   mysql_query($sSQL);

  insertolog($legajo, "A_Guardias2", "guardias", "insert", "1999-12-01", $sSQL);
}

///// PROCESO DEL DIA 23 ///////

if ($_POST['diai23'] > 0)
{    $fechai = $_POST['anios'].'/'.$_POST['meses'].'/'.$_POST['diai23'];
     $fechas = $_POST['anios'].'/'.$_POST['meses'].'/'.$_POST['dias23'];
    $horai = $_POST['horai23'].':00:00';
    $horas = $_POST['horas23'].':00:00';

 $sSQL="insert into guardias (legajo,fecingreso,horaingreso,fecsalida,horasalida,base)
  values ('".$_POST['legajo']."','".$fechai."','".$horai."','".$fechas."','".$horas."','".$_POST['base']."')";
   mysql_query($sSQL);

  insertolog($legajo, "A_Guardias2", "guardias", "insert", "1999-12-01", $sSQL);
}

///// PROCESO DEL DIA 24 ///////

if ($_POST['diai24'] > 0)
{    $fechai = $_POST['anios'].'/'.$_POST['meses'].'/'.$_POST['diai24'];
     $fechas = $_POST['anios'].'/'.$_POST['meses'].'/'.$_POST['dias24'];
    $horai = $_POST['horai24'].':00:00';
    $horas = $_POST['horas24'].':00:00';

 $sSQL="insert into guardias (legajo,fecingreso,horaingreso,fecsalida,horasalida,base)
  values ('".$_POST['legajo']."','".$fechai."','".$horai."','".$fechas."','".$horas."','".$_POST['base']."')";
   mysql_query($sSQL);

  insertolog($legajo, "A_Guardias2", "guardias", "insert", "1999-12-01", $sSQL);
}

///// PROCESO DEL DIA 25 ///////

if ($_POST['diai25'] > 0)
{    $fechai = $_POST['anios'].'/'.$_POST['meses'].'/'.$_POST['diai25'];
     $fechas = $_POST['anios'].'/'.$_POST['meses'].'/'.$_POST['dias25'];
    $horai = $_POST['horai25'].':00:00';
    $horas = $_POST['horas25'].':00:00';

 $sSQL="insert into guardias (legajo,fecingreso,horaingreso,fecsalida,horasalida,base)
  values ('".$_POST['legajo']."','".$fechai."','".$horai."','".$fechas."','".$horas."','".$_POST['base']."')";
   mysql_query($sSQL);

  insertolog($legajo, "A_Guardias2", "guardias", "insert", "1999-12-01", $sSQL);
}

///// PROCESO DEL DIA 26 ///////

if ($_POST['diai26'] > 0)
{    $fechai = $_POST['anios'].'/'.$_POST['meses'].'/'.$_POST['diai26'];
     $fechas = $_POST['anios'].'/'.$_POST['meses'].'/'.$_POST['dias26'];
    $horai = $_POST['horai26'].':00:00';
    $horas = $_POST['horas26'].':00:00';

 $sSQL="insert into guardias (legajo,fecingreso,horaingreso,fecsalida,horasalida,base)
  values ('".$_POST['legajo']."','".$fechai."','".$horai."','".$fechas."','".$horas."','".$_POST['base']."')";
   mysql_query($sSQL);

  insertolog($legajo, "A_Guardias2", "guardias", "insert", "1999-12-01", $sSQL);
}

///// PROCESO DEL DIA 27 ///////

if ($_POST['diai27'] > 0)
{    $fechai = $_POST['anios'].'/'.$_POST['meses'].'/'.$_POST['diai27'];
     $fechas = $_POST['anios'].'/'.$_POST['meses'].'/'.$_POST['dias27'];
    $horai = $_POST['horai27'].':00:00';
    $horas = $_POST['horas27'].':00:00';

 $sSQL="insert into guardias (legajo,fecingreso,horaingreso,fecsalida,horasalida,base)
  values ('".$_POST['legajo']."','".$fechai."','".$horai."','".$fechas."','".$horas."','".$_POST['base']."')";
   mysql_query($sSQL);

  insertolog($legajo, "A_Guardias2", "guardias", "insert", "1999-12-01", $sSQL);
}

///// PROCESO DEL DIA 28 ///////

if ($_POST['diai28'] > 0)
{    $fechai = $_POST['anios'].'/'.$_POST['meses'].'/'.$_POST['diai28'];
     $fechas = $_POST['anios'].'/'.$_POST['meses'].'/'.$_POST['dias28'];
    $horai = $_POST['horai28'].':00:00';
    $horas = $_POST['horas28'].':00:00';

 $sSQL="insert into guardias (legajo,fecingreso,horaingreso,fecsalida,horasalida,base)
  values ('".$_POST['legajo']."','".$fechai."','".$horai."','".$fechas."','".$horas."','".$_POST['base']."')";
   mysql_query($sSQL);

  insertolog($legajo, "A_Guardias2", "guardias", "insert", "1999-12-01", $sSQL);
}

///// PROCESO DEL DIA 29 ///////

if ($_POST['diai29'] > 0)
{    $fechai = $_POST['anios'].'/'.$_POST['meses'].'/'.$_POST['diai29'];
     $fechas = $_POST['anios'].'/'.$_POST['meses'].'/'.$_POST['dias29'];
    $horai = $_POST['horai29'].':00:00';
    $horas = $_POST['horas29'].':00:00';

 $sSQL="insert into guardias (legajo,fecingreso,horaingreso,fecsalida,horasalida,base)
  values ('".$_POST['legajo']."','".$fechai."','".$horai."','".$fechas."','".$horas."','".$_POST['base']."')";
   mysql_query($sSQL);

  insertolog($legajo, "A_Guardias2", "guardias", "insert", "1999-12-01", $sSQL);
}

///// PROCESO DEL DIA 30 ///////

if ($_POST['diai30'] > 0)
{    $fechai = $_POST['anios'].'/'.$_POST['meses'].'/'.$_POST['diai30'];
     $fechas = $_POST['anios'].'/'.$_POST['meses'].'/'.$_POST['dias30'];
    $horai = $_POST['horai30'].':00:00';
    $horas = $_POST['horas30'].':00:00';

 $sSQL="insert into guardias (legajo,fecingreso,horaingreso,fecsalida,horasalida,base)
  values ('".$_POST['legajo']."','".$fechai."','".$horai."','".$fechas."','".$horas."','".$_POST['base']."')";
   mysql_query($sSQL);

  insertolog($legajo, "A_Guardias2", "guardias", "insert", "1999-12-01", $sSQL);
}

///// PROCESO DEL DIA 31 ///////

if ($_POST['diai31'] > 0)
{    $fechai = $_POST['anios'].'/'.$_POST['meses'].'/'.$_POST['diai31'];
     $fechas = $_POST['anios'].'/'.$_POST['meses'].'/'.$_POST['dias31'];
    $horai = $_POST['horai31'].':00:00';
    $horas = $_POST['horas31'].':00:00';

 $sSQL="insert into guardias (legajo,fecingreso,horaingreso,fecsalida,horasalida,base)
  values ('".$_POST['legajo']."','".$fechai."','".$horai."','".$fechas."','".$horas."','".$_POST['base']."')";
   mysql_query($sSQL);

  insertolog($legajo, "A_Guardias2", "guardias", "insert", "1999-12-01", $sSQL);
}

   echo mensaje_ok('A_Guardias.php','OK');

?>
