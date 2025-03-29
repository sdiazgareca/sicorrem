<?php

define ('HOST','192.168.168.30');
define ('USUARIO','root');
define ('CLAVE','cuchitalinda');
define ('BD','sicoremm2');

include_once('CLA/Datos.php');

$conexion = mysql_connect (HOST,USUARIO,CLAVE) or die ("No se puede conectar con el servidor, compruebe que el nombre de usuario y contraseña sean correctos");
mysql_select_db (BD) or die ("No se puede seleccionar la base de datos.  Es probable que la BD no exista");

function unidad($numuero){
switch ($numuero)
{
case 9:
{
$numu = "NUEVE";
break;
}
case 8:
{
$numu = "OCHO";
break;
}
case 7:
{
$numu = "SIETE";
break;
}
case 6:
{
$numu = "SEIS";
break;
}
case 5:
{
$numu = "CINCO";
break;
}
case 4:
{
$numu = "CUATRO";
break;
}
case 3:
{
$numu = "TRES";
break;
}
case 2:
{
$numu = "DOS";
break;
}
case 1:
{
$numu = "UN";
break;
}
case 0:
{
$numu = "";
break;
}
}
return $numu;
}

function decena($numdero){

if ($numdero >= 90 && $numdero <= 99)
{
$numd = "NOVENTA ";
if ($numdero > 90)
$numd = $numd."Y ".(unidad($numdero - 90));
}
else if ($numdero >= 80 && $numdero <= 89)
{
$numd = "OCHENTA ";
if ($numdero > 80)
$numd = $numd."Y ".(unidad($numdero - 80));
}
else if ($numdero >= 70 && $numdero <= 79)
{
$numd = "SETENTA ";
if ($numdero > 70)
$numd = $numd."Y ".(unidad($numdero - 70));
}
else if ($numdero >= 60 && $numdero <= 69)
{
$numd = "SESENTA ";
if ($numdero > 60)
$numd = $numd."Y ".(unidad($numdero - 60));
}
else if ($numdero >= 50 && $numdero <= 59)
{
$numd = "CINCUENTA ";
if ($numdero > 50)
$numd = $numd."Y ".(unidad($numdero - 50));
}
else if ($numdero >= 40 && $numdero <= 49)
{
$numd = "CUARENTA ";
if ($numdero > 40)
$numd = $numd."Y ".(unidad($numdero - 40));
}
else if ($numdero >= 30 && $numdero <= 39)
{
$numd = "TREINTA ";
if ($numdero > 30)
$numd = $numd."Y ".(unidad($numdero - 30));
}
else if ($numdero >= 20 && $numdero <= 29)
{
if ($numdero == 20)
$numd = "VEINTE ";
else
$numd = "VEINTI".(unidad($numdero - 20));
}
else if ($numdero >= 10 && $numdero <= 19)
{
switch ($numdero){
case 10:
{
$numd = "DIEZ ";
break;
}
case 11:
{
$numd = "ONCE ";
break;
}
case 12:
{
$numd = "DOCE ";
break;
}
case 13:
{
$numd = "TRECE ";
break;
}
case 14:
{
$numd = "CATORCE ";
break;
}
case 15:
{
$numd = "QUINCE ";
break;
}
case 16:
{
$numd = "DIECISEIS ";
break;
}
case 17:
{
$numd = "DIECISIETE ";
break;
}
case 18:
{
$numd = "DIECIOCHO ";
break;
}
case 19:
{
$numd = "DIECINUEVE ";
break;
}
}
}
else
$numd = unidad($numdero);
return $numd;
}

function centena($numc){
if ($numc >= 100)
{
if ($numc >= 900 && $numc <= 999)
{
$numce = "NOVECIENTOS ";
if ($numc > 900)
$numce = $numce.(decena($numc - 900));
}
else if ($numc >= 800 && $numc <= 899)
{
$numce = "OCHOCIENTOS ";
if ($numc > 800)
$numce = $numce.(decena($numc - 800));
}
else if ($numc >= 700 && $numc <= 799)
{
$numce = "SETECIENTOS ";
if ($numc > 700)
$numce = $numce.(decena($numc - 700));
}
else if ($numc >= 600 && $numc <= 699)
{
$numce = "SEISCIENTOS ";
if ($numc > 600)
$numce = $numce.(decena($numc - 600));
}
else if ($numc >= 500 && $numc <= 599)
{
$numce = "QUINIENTOS ";
if ($numc > 500)
$numce = $numce.(decena($numc - 500));
}
else if ($numc >= 400 && $numc <= 499)
{
$numce = "CUATROCIENTOS ";
if ($numc > 400)
$numce = $numce.(decena($numc - 400));
}
else if ($numc >= 300 && $numc <= 399)
{
$numce = "TRESCIENTOS ";
if ($numc > 300)
$numce = $numce.(decena($numc - 300));
}
else if ($numc >= 200 && $numc <= 299)
{
$numce = "DOSCIENTOS ";
if ($numc > 200)
$numce = $numce.(decena($numc - 200));
}
else if ($numc >= 100 && $numc <= 199)
{
if ($numc == 100)
$numce = "CIEN ";
else
$numce = "CIENTO ".(decena($numc - 100));
}
}
else
$numce = decena($numc);

return $numce;
}

function miles($nummero){
if ($nummero >= 1000 && $nummero < 2000){
$numm = "MIL ".(centena($nummero%1000));
}
if ($nummero >= 2000 && $nummero <10000){
$numm = unidad(Floor($nummero/1000))." MIL ".(centena($nummero%1000));
}
if ($nummero < 1000)
$numm = centena($nummero);

return $numm;
}

function decmiles($numdmero){
if ($numdmero == 10000)
$numde = "DIEZ MIL";
if ($numdmero > 10000 && $numdmero <20000){
$numde = decena(Floor($numdmero/1000))."MIL ".(centena($numdmero%1000));
}
if ($numdmero >= 20000 && $numdmero <100000){
$numde = decena(Floor($numdmero/1000))." MIL ".(miles($numdmero%1000));
}
if ($numdmero < 10000)
$numde = miles($numdmero);

return $numde;
}

function cienmiles($numcmero){
if ($numcmero == 100000)
$num_letracm = "CIEN MIL";
if ($numcmero >= 100000 && $numcmero <1000000){
$num_letracm = centena(Floor($numcmero/1000))." MIL ".(centena($numcmero%1000));
}
if ($numcmero < 100000)
$num_letracm = decmiles($numcmero);
return $num_letracm;
}

function millon($nummiero){
if ($nummiero >= 1000000 && $nummiero <2000000){
$num_letramm = "UN MILLON ".(cienmiles($nummiero%1000000));
}
if ($nummiero >= 2000000 && $nummiero <10000000){
$num_letramm = unidad(Floor($nummiero/1000000))." MILLONES ".(cienmiles($nummiero%1000000));
}
if ($nummiero < 1000000)
$num_letramm = cienmiles($nummiero);

return $num_letramm;
}

function decmillon($numerodm){
if ($numerodm == 10000000)
$num_letradmm = "DIEZ MILLONES";
if ($numerodm > 10000000 && $numerodm <20000000){
$num_letradmm = decena(Floor($numerodm/1000000))."MILLONES ".(cienmiles($numerodm%1000000));
}
if ($numerodm >= 20000000 && $numerodm <100000000){
$num_letradmm = decena(Floor($numerodm/1000000))." MILLONES ".(millon($numerodm%1000000));
}
if ($numerodm < 10000000)
$num_letradmm = millon($numerodm);

return $num_letradmm;
}

function cienmillon($numcmeros){
if ($numcmeros == 100000000)
$num_letracms = "CIEN MILLONES";
if ($numcmeros >= 100000000 && $numcmeros <1000000000){
$num_letracms = centena(Floor($numcmeros/1000000))." MILLONES ".(millon($numcmeros%1000000));
}
if ($numcmeros < 100000000)
$num_letracms = decmillon($numcmeros);
return $num_letracms;
}

function milmillon($nummierod){
if ($nummierod >= 1000000000 && $nummierod <2000000000){
$num_letrammd = "MIL ".(cienmillon($nummierod%1000000000));
}
if ($nummierod >= 2000000000 && $nummierod <10000000000){
$num_letrammd = unidad(Floor($nummierod/1000000000))." MIL ".(cienmillon($nummierod%1000000000));
}
if ($nummierod < 1000000000)
$num_letrammd = cienmillon($nummierod);

return $num_letrammd;
}


function convertir($numero){
$numf = milmillon($numero);
return $numf;
}

function cambiarDicomAfiliados($num_solici,$f_baja){
    $query="UPDATE afiliados SET afiliados.cod_baja ='DI', afiliados.fecha_baja='".$f_baja."' WHERE num_solici = '".$num_solici."' AND afiliados.cod_baja != '02' AND afiliados.cod_baja != '01'AND afiliados.cod_baja != '03'";
    return $query;
}

function cambiarDicomContratos($num_solici,$f_baja){
    $query="UPDATE contratos SET estado='3600', f_baja='".$f_baja."' WHERE num_solici='".$num_solici."'";
    return $query;
}

//01 fallecimiento 02 renuncia 03 otras causas
function cambiaraRenuncaiAfiliados($num_solici,$f_baja){
    $query="UPDATE afiliados SET afiliados.cod_baja ='02', afiliados.fecha_baja='".$f_baja."' WHERE num_solici = '".$num_solici."' AND afiliados.cod_baja != '01'";
    return $query;
}

function cambiarRenunciaContratos($num_solici,$f_baja){
    $query="UPDATE contratos SET estado='700', f_baja='".$f_baja."' WHERE num_solici='".$num_solici."'";
    return $query;
}


//F_BAJA
/*
$aff = "SELECT fecha_baja,afiliados.fecha_ing, afiliados.titular, num_solici FROM afiliados GROUP BY titular";
$aff_q = mysql_query($aff);

while($afil = mysql_fetch_array($aff_q)){
    $sql ='UPDATE contratos SET f_baja="'.$afil['fecha_baja'].'" WHERE contratos.num_solici="'.$afil['num_solici'].'" AND titular="'.$afil['titular'].'"';

    echo "<br />".$sql.";<br />";
}
*/


$periodo_afacturar = '2011-03-01';

$fecha_facturacion = '2011-02-20';

$sql = "SELECT domicilios.calle, numero, piso, departamento,telefono,poblacion,pasaje,titulares.nombre1, titulares.nombre2, titulares.apellido,empresa.empresa,cobrador,contratos.titular,contratos.ZO, contratos.SE, contratos.MA,
        e_contrato.descripcion,contratos.num_solici, valor_plan.valor AS importe, contratos.f_pago, contratos.titular,f_baja, f_ingreso,contratos.secuencia,contratos.estado
        ,e_contrato.descripcion, f_pago.descripcion AS f_pago_des,contratos.cod_plan, contratos.tipo_plan

        FROM contratos

        LEFT JOIN valor_plan ON valor_plan.secuencia = contratos.secuencia AND contratos.cod_plan = valor_plan.cod_plan AND contratos.tipo_plan = valor_plan.tipo_plan
        LEFT JOIN e_contrato ON e_contrato.cod = contratos.estado
        LEFT JOIN f_pago ON f_pago.codigo = contratos.f_pago
        LEFT JOIN ZOSEMA ON ZOSEMA.ZO = contratos.ZO AND ZOSEMA.SE = contratos.SE AND ZOSEMA.MA = contratos.MA
        LEFT JOIN domicilios ON domicilios.nro_doc = contratos.titular AND domicilios.num_solici = contratos.num_solici
        INNER JOIN empresa ON contratos.empresa = empresa.nro_doc
        LEFT JOIN titulares ON titulares.nro_doc = contratos.titular

        WHERE
        contratos.empresa IS NOT NULL AND empresa.f_factu=1 AND
       contratos.estado !='200' AND contratos.estado !='300' AND contratos.estado !='600'
        AND contratos.estado !='1000' AND contratos.factu='B' AND
        contratos.estado !=  '3600' AND f_pago = '400' ORDER BY empresa.empresa";

$query = mysql_query($sql);

echo '<table>';

$i = 1;
$z = 1;

while ($afi = mysql_fetch_array($query)){

    $cta ='SELECT COUNT(cta.fecha_mov) AS num_deuda,nro_doc, num_solici, importe, fecha_mov
           FROM cta
           WHERE cta.cod_mov=1  AND afectacion < 1 AND num_solici="'.$afi['num_solici'].'" AND nro_doc="'.$afi['titular'].'" AND YEAR(fecha_mov) >= "2009"
           GROUP BY num_solici';

    $cta_query = mysql_query($cta);

    $cta = mysql_fetch_array($cta_query);
    $cta_num = $cta['num_deuda'];
    $b_ipaga = $cta['fecha_mov'];
    $num_deuda = $cta_num;

    //COMPROBAR SI EXISTEN DEUDAS ATRAZADAS
    if ($cta_num > 0){


        $f_ingreso = explode('-',$afi['f_ingreso']);

        if( $f_ingreso[1]== 12  && $f_ingreso[0] < 2011 ){
            
            $num = $afi['importe'] * 2.7 /100;
        }
        
        if( $f_ingreso[1]== 1  && $f_ingreso[0] < 2011 ){
            
            $num = $afi['importe'] * 3 /100;
        }


$num = convertir($afi['importe']);


    //300 COBRO DOM, TRANFERENCIA ELECTRONICA 500
    if ( $num_deuda >= 6 ){

            echo '<tr>';
            echo '<td>'.$afi['calle'].' '.$afi['numero'].' '.$afi['poblacion'].'</td><td>'.$afi['nombre1'].' '.$afi['nombre2'].' '.$afi['apellido'].'</td><td>'.$afi['empresa'].'</td><td>'.$afi['cobrador'].'</td><td>'.$afi['ZO'].'</td><td>'.$afi['SE'].'</td><td>'.$afi['MA'].'</td><td>'.$afi['ZO'].'</td><td>'.$afi['SE'].'</td><td>'.$afi['MA'].'</td><td>'.$afi['num_solici'].'</td><td>'.$afi['nro_doc'].'</td><td>'.$afi['f_ingreso'].'</td><td><strong>'.$afi['f_baja'].'</strong></td><td>'.$afi['descripcion'].'</td><td>'.$afi['titular'].'</td><td>'.$afi['f_pago_des'].'</td><td>DICOM</td><td>'.$num_deuda.'</td><td>'.$b_ipaga.'</td><td>'.$afi['cod_plan'].'</td><td>'.$afi['tipo_plan'].'</td><td>'.$afi['importe'].'</td><td>'.$num.'</td>';
            echo '<tr>';
    }

    if ( $num_deuda <  6 ){

            //RENUNCIA 700, OTRAS CAUSAS 800, BAJA AUTOMATICA 1100

            if ($afi['estado'] == 700 || $afi['estado'] == 800 || $afi['estado'] == 1100 ){

                $f_baja  = explode('-',$afi['f_baja']);

                $dia_baja = $f_baja[2]; $mes_baja = $f_baja[1]; $anio_baja = $f_baja[0];

                $_facturacio = explode('-',$fecha_facturacion);
                $dia_fac = $_facturacio[2]; $mes_fac = $_facturacio[1]; $anio_fac = $_facturacio[0];

                if ($dia_baja > 15 && $mes_fac == $mes_baja && $anio_baja == $anio_fac ){
                    echo '<tr>';
                    //echo '<td>'.$dia_fac.'-'.$mes_baja.'-'.$anio_baja.'  '.$dia_fac.'-'.$mes_fac.'-'.$anio_baja.'</td>';
                    echo '<td>'.$afi['calle'].' '.$afi['numero'].' '.$afi['poblacion'].'</td><td>'.$afi['nombre1'].' '.$afi['nombre2'].' '.$afi['apellido'].'</td><td>'.$afi['empresa'].'</td><td>'.$afi['cobrador'].'</td><td>'.$afi['ZO'].'</td><td>'.$afi['SE'].'</td><td>'.$afi['MA'].'</td><td>'.$afi['ZO'].'</td><td>'.$afi['SE'].'</td><td>'.$afi['MA'].'</td><td>'.$afi['num_solici'].'</td><td>'.$afi['nro_doc'].'</td><td>'.$afi['f_ingreso'].'</td><td><strong>'.$afi['f_baja'].'</strong></td><td>'.$afi['descripcion'].'</td><td>'.$afi['titular'].'</td><td>'.$afi['f_pago_des'].'</td><td>BOLETA</td><td>'.$num_deuda.'</td><td>'.$b_ipaga.'</td><td>'.$afi['cod_plan'].'</td><td>'.$afi['tipo_plan'].'</td><td>'.$afi['importe'].'</td><td>'.$num.'</td>';
                    echo '<tr>';
                }

                else{
                    echo '<tr>';
                    echo '<td>'.$afi['nombre1'].' '.$afi['nombre2'].' '.$afi['apellido'].'</td><td>'.$afi['empresa'].'</td><td>'.$afi['cobrador'].'</td><td>'.$afi['ZO'].'</td><td>'.$afi['SE'].'</td><td>'.$afi['MA'].'</td><td>'.$afi['ZO'].'</td><td>'.$afi['SE'].'</td><td>'.$afi['MA'].'</td><td>'.$afi['num_solici'].'</td><td>'.$afi['nro_doc'].'</td><td>'.$afi['f_ingreso'].'</td><td><strong>'.$afi['f_baja'].'</strong></td><td>'.$afi['descripcion'].'</td><td>'.$afi['titular'].'</td><td>'.$afi['f_pago_des'].'</td><td>NO FACTURA</td><td>'.$num_deuda.'</td><td>'.$b_ipaga.'</td><td>'.$afi['cod_plan'].'</td><td>'.$afi['tipo_plan'].'</td><td>'.$afi['importe'].'</td><td>'.$num.'</td>';
                    echo '<tr>';
                }

            }

            //ACTIVOS
             if ($afi['estado'] == 500 || $afi['estado'] == 400  || $afi['estado'] == 3500){
                    echo '<tr>';
                    echo '<td>'.$afi['calle'].' '.$afi['numero'].' '.$afi['poblacion'].'</td><td>'.$afi['nombre1'].' '.$afi['nombre2'].' '.$afi['apellido'].'</td><td>'.$afi['empresa'].'</td><td>'.$afi['cobrador'].'</td><td>'.$afi['ZO'].'</td><td>'.$afi['SE'].'</td><td>'.$afi['MA'].'</td><td>'.$afi['ZO'].'</td><td>'.$afi['SE'].'</td><td>'.$afi['MA'].'</td><td>'.$afi['num_solici'].'</td><td>'.$afi['nro_doc'].'</td><td>'.$afi['f_ingreso'].'</td><td><strong>'.$afi['f_baja'].'</strong></td><td>'.$afi['descripcion'].'</td><td>'.$afi['titular'].'</td><td>'.$afi['f_pago_des'].'</td><td>FACTURA</td><td>'.$num_deuda.'</td><td>'.$b_ipaga.'</td><td>'.$afi['cod_plan'].'</td><td>'.$afi['tipo_plan'].'</td><td>'.$afi['importe'].'</td><td>'.$num.'</td>';
                    echo '<tr>';
            }

            //900 falta de pago 3100 CLIENTE OROSO
            if ($afi['estado'] == 900 || $afi['estado'] == 3100){
                    echo '<tr>';
                    echo '<td>'.$afi['calle'].' '.$afi['numero'].' '.$afi['poblacion'].'</td><td>'.$afi['nombre1'].' '.$afi['nombre2'].' '.$afi['apellido'].'</td><td>'.$afi['empresa'].'</td><td>'.$afi['cobrador'].'</td><td>'.$afi['ZO'].'</td><td>'.$afi['SE'].'</td><td>'.$afi['MA'].'</td><td>'.$afi['ZO'].'</td><td>'.$afi['SE'].'</td><td>'.$afi['MA'].'</td><td>'.$afi['num_solici'].'</td><td>'.$afi['nro_doc'].'</td><td>'.$afi['f_ingreso'].'</td><td><strong>'.$afi['f_baja'].'</strong></td><td>'.$afi['descripcion'].'</td><td>'.$afi['titular'].'</td><td>'.$afi['f_pago_des'].'</td><td>NO FACTURA</td><td>'.$num_deuda.'</td><td>'.$b_ipaga.'</td><td>'.$afi['cod_plan'].'</td><td>'.$afi['tipo_plan'].'</td><td>'.$afi['importe'].'</td><td>'.$num.'</td>';
                    echo '<tr>';
            }


    }



}// FIN COPRUEBA DEUDAS ATRASADAS

    else{

        $f_ingreso = explode('-',$afi['f_ingreso']);
        
        if( $f_ingreso[1]== 12  && $f_ingreso[0] < 2011 ){
            
            $num = $afi['importe'] * 2.7 /100;
        }
        
        if( $f_ingreso[1]== 1  && $f_ingreso[0] < 2011 ){
            
            $num = $afi['importe'] * 3 /100;
        }


        $num = convertir($afi['importe']);

            //ACTIVOS
             if ($afi['estado'] == 500 || $afi['estado'] == 400  || $afi['estado'] == 3500){
                    echo '<tr>';
                    echo '<td>'.$afi['calle'].' '.$afi['numero'].' '.$afi['poblacion'].'</td><td>'.$afi['nombre1'].' '.$afi['nombre2'].' '.$afi['apellido'].'</td><td>'.$afi['empresa'].'</td><td>'.$afi['cobrador'].'</td><td>'.$afi['ZO'].'</td><td>'.$afi['SE'].'</td><td>'.$afi['MA'].'</td><td>'.$afi['ZO'].'</td><td>'.$afi['SE'].'</td><td>'.$afi['MA'].'</td><td>'.$afi['num_solici'].'</td><td>'.$afi['nro_doc'].'</td><td>'.$afi['f_ingreso'].'</td><td><strong>'.$afi['f_baja'].'</strong></td><td>'.$afi['descripcion'].'</td><td>'.$afi['titular'].'</td><td>'.$afi['f_pago_des'].'</td><td>FACTURA</td><td>'.$num_deuda.'</td><td>'.$b_ipaga.'</td><td>'.$afi['cod_plan'].'</td><td>'.$afi['tipo_plan'].'</td><td>'.$afi['importe'].'</td><td>'.$num.'</td>';
                    echo '<tr>';
            }

            //900 falta de pago 3100 CLIENTE OROSO
            if ($afi['estado'] == 900 || $afi['estado'] == 3100){
                    echo '<tr>';
                    echo '<td>'.$afi['calle'].' '.$afi['numero'].' '.$afi['poblacion'].'</td><td>'.$afi['nombre1'].' '.$afi['nombre2'].' '.$afi['apellido'].'</td><td>'.$afi['cobrador'].'</td><td>'.$afi['ZO'].'</td><td>'.$afi['SE'].'</td><td>'.$afi['MA'].'</td><td>'.$afi['ZO'].'</td><td>'.$afi['SE'].'</td><td>'.$afi['MA'].'</td><td>'.$afi['num_solici'].'</td><td>'.$afi['nro_doc'].'</td><td>'.$afi['f_ingreso'].'</td><td><strong>'.$afi['f_baja'].'</strong></td><td>'.$afi['descripcion'].'</td><td>'.$afi['titular'].'</td><td>'.$afi['f_pago_des'].'</td><td>NO FACTURA</td><td>'.$num_deuda.'</td><td>'.$b_ipaga.'</td><td>'.$afi['cod_plan'].'</td><td>'.$afi['tipo_plan'].'</td><td>'.$afi['importe'].'</td><td>'.$num.'</td>';
                    echo '<tr>';
            }

            //RENUNCIA 700, OTRAS CAUSAS 800, BAJA AUTOMATICA 1100

            if ($afi['estado'] == 700 || $afi['estado'] == 800 || $afi['estado'] == 1100 ){

                $f_baja  = explode('-',$afi['f_baja']);

                $dia_baja = $f_baja[2]; $mes_baja = $f_baja[1]; $anio_baja = $f_baja[0];

                $_facturacio = explode('-',$fecha_facturacion);
                $dia_fac = $_facturacio[2]; $mes_fac = $_facturacio[1]; $anio_fac = $_facturacio[0];

                if ($dia_baja > 15 && $mes_fac == $mes_baja && $anio_baja == $anio_fac ){
                    echo '<tr>';
                    echo '<td>'.$afi['calle'].' '.$afi['numero'].' '.$afi['poblacion'].'</td><td>'.$afi['nombre1'].' '.$afi['nombre2'].' '.$afi['apellido'].'</td><td>'.$afi['empresa'].'</td><td>'.$afi['cobrador'].'</td><td>'.$afi['ZO'].'</td><td>'.$afi['SE'].'</td><td>'.$afi['MA'].'</td><td>'.$afi['ZO'].'</td><td>'.$afi['SE'].'</td><td>'.$afi['MA'].'</td><td>'.$afi['num_solici'].'</td><td>'.$afi['nro_doc'].'</td><td>'.$afi['f_ingreso'].'</td><td><strong>'.$afi['f_baja'].'</strong></td><td>'.$afi['descripcion'].'</td><td>'.$afi['titular'].'</td><td>'.$afi['f_pago_des'].'</td><td>FACTURA</td><td>'.$num_deuda.'</td><td>'.$b_ipaga.'</td><td>'.$afi['cod_plan'].'</td><td>'.$afi['tipo_plan'].'</td><td>'.$afi['importe'].'</td><td>'.$num.'</td>';
                    echo '<tr>';
                }

                else{
                    echo '<tr>';
                    echo '<td>'.$afi['calle'].' '.$afi['numero'].' '.$afi['poblacion'].'</td><td>'.$afi['nombre1'].' '.$afi['nombre2'].' '.$afi['apellido'].'</td><td>'.$afi['empresa'].'</td><td>'.$afi['cobrador'].'</td><td>'.$afi['ZO'].'</td><td>'.$afi['SE'].'</td><td>'.$afi['MA'].'</td><td>'.$afi['ZO'].'</td><td>'.$afi['SE'].'</td><td>'.$afi['MA'].'</td><td>'.$afi['num_solici'].'</td><td>'.$afi['nro_doc'].'</td><td>'.$afi['f_ingreso'].'</td><td><strong>'.$afi['f_baja'].'</strong></td><td>'.$afi['descripcion'].'</td><td>'.$afi['titular'].'</td><td>'.$afi['f_pago_des'].'</td><td>NO FACTURA</td><td>'.$num_deuda.'</td><td>'.$b_ipaga.'</td><td>'.$afi['cod_plan'].'</td><td>'.$afi['tipo_plan'].'</td><td>'.$afi['importe'].'</td><td>'.$num.'</td>';
                    echo '<tr>';
                }

            }

    }

$i = $i +1;
$z = $z+1;
}//FIN WHILE 1







echo '</table>';