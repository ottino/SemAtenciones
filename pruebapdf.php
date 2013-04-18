<?php
require ('ComprobantesPDF.php');
include_once ('config.php');


$array_info_empresa = array (
                           'emp_dir'  =>'URQUIZA 1470',
                           'emp_tel'  =>'4225544 - 4074069',
                           'emp_loc'  =>'(3100) PARANA',
                           'emp_pro'  =>'E.R',
                           'emp_cuit' =>'30-70766126-3',
                           'emp_ingb' =>'30-70766126-3',
                           'emp_inic' =>'01/07/2001',
);

$array_param = array (
                           'fpdf_orientation'  =>'P',
                           'fpdf_unit'         =>'cm',
                           'fpdf_format'       =>'A4',
                           'comp_tiulo'        => 'SEM EMERGENCIAS S.R.L',
                           'comp_logo'         => 'logo.jpg',
                           'comp_fecha'        => '2012/09/24'
);


$array_comprobante = array (
                            'abonado'       =>'Ottino, Maximiliano Miguel',
                            'noComprobante' =>'03130763000',
                            'noSocio'       => '0001',
                            'domicilio'     =>'Diamante 232',
                            'condPago'      =>'xxx',
                            'cuit'          =>'20.31307630.0',
                            'periodo'       =>'201209',
                            'vencimiento'   =>'2012/09/20',
                            'servicios'     => array ( array (
                                                                'cantidad'      => 1 ,
                                                                'descripcion'   => 'SEM EMERGENCIAS',
                                                                'importe'       => 150
                                                             ),
                                                       array (
                                                                'cantidad'      => 1 ,
                                                                'descripcion'   => 'BELDENT',
                                                                'importe'       => 10
                                                             )
                                                      ),
                            'total'           => '250',
                            'leyenda_cuerpo'  => 'URGENCIAS AL 4311718',
                            'leyenda_pie'     => 'El certificado de pago puede solicitarlo en la administracion en el horario de 16 a 20 hs / 8 a 12 hs',
                            'fecha_cob'       => '2012/09/25',
                            'dom_cobro'       => '12345678901234567890123456789012345678901234567890',
                            'cobrador'        => 'Torres, Mariano',
                            'leyenda_mensaje' => 'Mensaje que se muestra arriba de la fecha de cobro. Ottino Maximiliano Miguel. Ottino Maximiliano Miguel',
                            'zona'            => 'S/D',
                            'telefono'        => '4315829',
                            'cant_adh'        => 3
);

for ($c= 0 ; $c<3 ; $c++)
$array_comprobate_indice[] = $array_comprobante;


$comprobante = new ComprobantesPDF($array_param , $array_info_empresa , $array_comprobate_indice);
$comprobante->generar_comprobantes3();
$comprobante->Output();
//$comprobante->Output('comprobante_00001.pdf','D');


?>
