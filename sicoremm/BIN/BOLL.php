<?php
// para utilizar la librería

include_once('../DAT/conf.php');
include_once('../DAT/bd.php');
include_once('../CLA/Datos.php');


$n_boleta = $_GET['boleta'];

$sql = "SELECT ventas_reg.num_solici, titular, titulares.nombre1, titulares.nombre2, titulares.apellido,fecha as fee,
domicilios.calle,domicilios.poblacion, domicilios.numero,domicilios.telefono,DATE_FORMAT(fecha,'%d     %m     %Y') as fecha, sec,monto,planes.desc_plan
FROM ventas_reg
INNER JOIN titulares ON titulares.nro_doc = ventas_reg.titular
INNER JOIN domicilios ON domicilios.nro_doc = titulares.nro_doc AND domicilios.num_solici = ventas_reg.num_solici AND domicilios.tipo_dom = '2'
LEFT JOIN planes ON planes.cod_plan = ventas_reg.cod_plan AND planes.tipo_plan = ventas_reg.tipo_plan
WHERE n_documento='".$_GET['boleta']."'";

//echo '<br />'.$sql.'<br />aca<br />';

$query = mysql_query($sql);
$boll = mysql_fetch_array($query);

$fecha2 = explode('-',$boll['fee']);


switch ($fecha2[1]) {
    case 1:
        $mess = "ENERO";
        break;
    case 2:
        $mess = "FEBRERO";
        break;
    case 3:
        $mess = "MARZO";
        break;
    case 4:
        $mess = "ABRIL";
        break;
    case 5:
        $mess = "MAYO";
        break;
    case 6:
        $mess = "JUNIO";
        break;
    case 7:
        $mess = "JULIO";
        break;
    case 8:
        $mess = "AGOSTO";
        break;
    case 9:
        $mess = "SEPTIEMBRE";
        break;
    case 10:
        $mess = "OCTUBRE";
        break;
    case 11:
        $mess = "NOVIEMBRE";
        break;
    case 12:
        $mess = "DICIEMBRE";
        break;
}

//OBTIENE MES

$direccion = $boll['calle']." ".$boll['numero']." ".$boll['poblacion'];


if ($_GET['tipo'] == "contrato"){
    $glosa ="                           MENSUALIDAD CUOTA N 1 PERIODO ".$mess." ".$fecha2[0]. " ".$boll['sec']." BENEFICIARIOS";
}

if ($_GET['tipo'] == "INCO"){
    $glosa ="                           INCORPORACION ".$mess." ".$fecha2[0]. " ".$boll['sec']." BENEFICIARIOS";
}

$rut = new Datos;
$rut->validar_rut($boll['titular']);
$nro_doc = $rut->nro_doc;

$fecha = new Datos;
$fe = $fecha->cambiaf_a_mysql($boll['fee']);

define('FPDF_FONTPATH','font/');
require_once('../CLA/fpdf.php');

//Creación del objeto de la clase heredada
$pdf=new FPDF();
$pdf->AliasNbPages();
$pdf->AddPage();




//Comenzamos a escribir el PDF:
$pdf->SetFont('Arial','B',10); //<-- Tipo de letra arial, Bold, tamaño 20

$pdf->Ln(17);

$pdf->write(8,"                                                                                                                        ".$boll['fecha']);  // <-- Cadena a escribir


$pdf->Ln(20);
$pdf->Write(8,"                            ".strtoupper($boll['nombre1']). " ".strtoupper($boll['apellido']));
$pdf->Ln(-1);
$pdf->Write(8,"                                                                                                                         ".$nro_doc);

$pdf->Ln(12);
$pdf->Write(8,"                             ".$direccion);
$pdf->Ln(-1);
$pdf->Write(8,"                                                                                                                         ANTOFAGASTA");

$pdf->Ln(10);
$pdf->Write(8,"                             ".$boll['telefono']);
$pdf->Ln(-1);
$pdf->Write(8,"                                                                                                                          ".$boll['num_solici']);

$pdf->Ln(30);
$pdf->Write(8,"   ".$glosa);
$pdf->Ln(8);
$pdf->Write(8,"                              PLAN ".strtoupper($boll['desc_plan']));


$pdf->Ln(41);
$pdf->Write(8,"                                                                                                                          $ ". number_format($boll['monto'],0,',','.'));

if ($_GET['f_pago'] == 40){
$pdf->Ln(13);
$pdf->Write(8,"                          X");
}

if ($_GET['f_pago'] == 20){
$pdf->Ln(10);
$pdf->Write(8,"                                        X");
}

if ($_GET['f_pago'] == 30){
$pdf->Ln(10);
$pdf->Write(8,"                                        X");
}

if ($_GET['f_pago'] != 20 && $_GET['f_pago'] != 30  && $_GET['f_pago'] != 40 ){
$pdf->Ln(10);
$pdf->Write(8,"                                                                  X");
}


$pdf->Ln(43);
$pdf->Write(8,"                            ".strtoupper($boll['nombre1']). " ".strtoupper($boll['apellido']));

$pdf->Ln(10);
$pdf->Write(8,"                            ".$nro_doc);
$pdf->Ln(-1);
$pdf->Write(8,"                                                                                      ".$boll['num_solici']);
$pdf->Ln(-1);
$pdf->Write(8,"                                                                                                                                                        ");

$pdf->Ln(12);
$pdf->Write(8,"                            ".$fe);
$pdf->Ln(-1);
$pdf->Write(8,"                                                                                           $ ".number_format($boll['monto'],0,',','.'));



//Terminamos el PDF y lo mandamos a la pantalla

$pdf->Output();



?>