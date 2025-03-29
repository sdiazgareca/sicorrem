<?php

include_once('../DAT/conf.php');
include_once('../DAT/bd.php');
include_once('../CLA/Datos.php');


function crearCuenta($num_solici,$nro_doc,$tipo_comp,$comprovante,$fecha_mov,$importe){
    
    $cta_men = "INSERT INTO cta 
        (tip_doc,nro_doc,tipo_comp,serie,comprovante,cod_mov,afectacion,fecha_mov,fecha_vto, importe,cobrador, num_solici,fecha,debe,haber) 
  VALUES(1,'".$nro_doc."','".$tipo_comp."','50','".$comprovante."','1',0,'".$fecha_mov."','".$fecha_mov."','".$importe."',0,'".$num_solici."','".$fecha_mov."','".$importe."','0')";
    
    return $cta_men;
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



$_periodo_f = explode('-',$_POST['f_factu']);
$fecha_facturacion = $_periodo_f[2].'-'.$_periodo_f[1].'-01';


echo 'fecha_facturacion '.$fecha_facturacion.' <br />';

$f_factu = explode('-',$_POST['periodo']);
$periodo_afacturar = $f_factu[2].'-'.$f_factu[1].'-01';

echo 'periodo a facturar '.$periodo_afacturar.' <br />';

$comprovante = $_POST['boletas'];

$sql = "SELECT contratos.titular,
        e_contrato.descripcion,contratos.num_solici, valor_plan.valor AS importe, contratos.f_pago, contratos.titular,f_baja, f_ingreso,contratos.secuencia,estado
        ,e_contrato.descripcion, f_pago.descripcion AS f_pago_des,contratos.cod_plan, contratos.tipo_plan

        FROM contratos

        LEFT JOIN valor_plan ON valor_plan.secuencia = contratos.secuencia AND contratos.cod_plan = valor_plan.cod_plan AND contratos.tipo_plan = valor_plan.tipo_plan
        LEFT JOIN e_contrato ON e_contrato.cod = contratos.estado
        LEFT JOIN f_pago ON f_pago.codigo = contratos.f_pago

        WHERE

       contratos.estado !='200' AND contratos.estado !='300' AND contratos.estado !='600'
        AND contratos.estado !='1000' AND contratos.factu='B' AND contratos.tipo_plan != 2 AND contratos.tipo_plan != 5
        AND contratos.estado != '3600' AND f_pago != '400' AND f_pago != '600'";

$query = mysql_query($sql);

echo '<table>';


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

    //F_PAGO 100 PAC, 200 TC, 300 COBRO DOM, 400 D X PLANILLA, 500 TRANFE, 600 PAGO EMPRESA
    if ( ($afi['f_pago'] == '100' || $afi['f_pago'] == '200') && $num_deuda >= 6 ){

            //dicom

            echo '<tr>';
            echo '<td>1</td><td>'.$afi['num_solici'].'</td><td>'.$afi['titular'].'</td><td>'.$afi['f_ingreso'].'</td><td><strong>'.$afi['f_baja'].'</strong></td><td>'.$afi['descripcion'].'</td><td>'.$afi['titular'].'</td><td>'.$afi['f_pago_des'].'</td><td>INGRESAR A DICOM</td><td>'.$num_deuda.'</td><td>'.$b_ipaga.'</td><td>'.$afi['cod_plan'].'</td><td>'.$afi['tipo_plan'].'</td><td>'.$afi['importe'].'</td>';
            echo '<tr>';

            $update1 = cambiarDicomAfiliados($afi['num_solici'],$fecha_facturacion);
            $update2 = cambiarDicomContratos($afi['num_solici'],$fecha_facturacion);

            $tra[] = $update1;
            $tra[] = $update2;
        

    }

    if ( ($afi['f_pago'] == '100' || $afi['f_pago'] == '200') && $num_deuda <  6 ){

            //RENUNCIA 700, OTRAS CAUSAS 800, 1100 BAJA AUTOMATICA
            if ($afi['estado'] == 700 || $afi['estado'] == 800 || $afi['estado'] == 1100 ){

                $f_baja  = explode('-',$afi['f_baja']);

                $dia_baja = $f_baja[2]; $mes_baja = $f_baja[1]; $anio_baja = $f_baja[0];

                $_facturacio = explode('-',$fecha_facturacion);
                $dia_fac = $_facturacio[2]; $mes_fac = $_facturacio[1]; $anio_fac = $_facturacio[0];

                if ($dia_baja > 15 && $mes_fac == $mes_baja && $anio_baja == $anio_fac ){
                    echo '<tr>';
                    echo '<td>2</td><td>'.$afi['num_solici'].'</td><td>'.$afi['titular'].'</td><td>'.$afi['f_ingreso'].'</td><td><strong>'.$afi['f_baja'].'</strong></td><td>'.$afi['descripcion'].'</td><td>'.$afi['titular'].'</td><td>'.$afi['f_pago_des'].'</td><td>FACTURAR</td><td>'.$num_deuda.'</td><td>'.$b_ipaga.'</td><td>'.$afi['cod_plan'].'</td><td>'.$afi['tipo_plan'].'</td><td>'.$afi['importe'].'</td>';
                    echo '<tr>';

                    $factura =crearCuenta($afi['num_solici'],$afi['titular'],'B', $comprovante, $periodo_afacturar,$afi['importe']);
                    $tra[] = $factura;
                    $comprovante ++;
                }
                
                else{
                    /*
                    echo '<tr>';
                    echo '<td>3</td><td>'.$z.'</td><td>'.$afi['num_solici'].'</td><td>'.$afi['titular'].'</td><td>'.$afi['f_ingreso'].'</td><td><strong>'.$afi['f_baja'].'</strong></td><td>'.$afi['descripcion'].'</td><td>'.$afi['titular'].'</td><td>'.$afi['f_pago_des'].'</td><td>NO FACTURA</td><td>'.$num_deuda.'</td><td>'.$b_ipaga.'</td><td>'.$afi['cod_plan'].'</td><td>'.$afi['tipo_plan'].'</td><td>'.$afi['importe'].'</td>';
                    echo '<tr>';
                    */
                    
                    $renuncia = cambiaraRenuncaiAfiliados($afi['num_solici'],$fecha_facturacion);
                    $tra[] = $renuncia;

                }
                
                 

            }

            // ACTIVOS
            if ($afi['estado'] == 500 || $afi['estado'] == 400  || $afi['estado'] == 3500){
                    echo '<tr>';
                    echo '<td>5</td><td>'.$afi['num_solici'].'</td><td>'.$afi['nro_doc'].'</td><td>'.$afi['f_ingreso'].'</td><td><strong>'.$afi['f_baja'].'</strong></td><td>'.$afi['descripcion'].'</td><td>'.$afi['titular'].'</td><td>'.$afi['f_pago_des'].'</td><td>FACTURA</td><td>'.$num_deuda.'</td><td>'.$b_ipaga.'</td><td>'.$afi['cod_plan'].'</td><td>'.$afi['tipo_plan'].'</td><td>'.$afi['importe'].'</td>';
                    echo '<tr>';

                    $factura =crearCuenta($afi['num_solici'],$afi['titular'],'B', $comprovante, $periodo_afacturar,$afi['importe']);
                    $tra[] = $factura;
                    $comprovante ++;

            }

    }


    //300 COBRO DOM, TRANFERENCIA ELECTRONICA 500
    if ( ($afi['f_pago'] == '300' || $afi['f_pago'] == '500') && $num_deuda >= 3 ){

            echo '<tr>';
            echo '<td>6</td><td>'.$afi['num_solici'].'</td><td>'.$afi['titular'].'</td><td>'.$afi['f_ingreso'].'</td><td><strong>'.$afi['f_baja'].'</strong></td><td>'.$afi['descripcion'].'</td><td>'.$afi['titular'].'</td><td>'.$afi['f_pago_des'].'</td><td>INGRESAR A DICOM</td><td>'.$num_deuda.'</td><td>'.$b_ipaga.'</td><td>'.$afi['cod_plan'].'</td><td>'.$afi['tipo_plan'].'</td><td>'.$afi['importe'].'</td>';
            echo '<tr>';

            $update1 = cambiarDicomAfiliados($afi['num_solici'],$fecha_facturacion);
            $update2 = cambiarDicomContratos($afi['num_solici'],$fecha_facturacion);

            $tra[] = $update1;
            $tra[] = $update2;


    }

    if ( ($afi['f_pago'] == '300' || $afi['f_pago'] == '500') && $num_deuda <  3 ){

            //RENUNCIA 700, OTRAS CAUSAS 800, BAJA AUTOMATICA 1100

            if ($afi['estado'] == 700 || $afi['estado'] == 800 || $afi['estado'] == 1100 ){

                $f_baja  = explode('-',$afi['f_baja']);

                $dia_baja = $f_baja[2]; $mes_baja = $f_baja[1]; $anio_baja = $f_baja[0];

                $_facturacio = explode('-',$fecha_facturacion);
                $dia_fac = $_facturacio[2]; $mes_fac = $_facturacio[1]; $anio_fac = $_facturacio[0];

                if ($dia_baja > 15 && $mes_fac == $mes_baja && $anio_baja == $anio_fac ){
                    echo '<tr>';
                    echo '<td>'.$dia_fac.'-'.$mes_baja.'-'.$anio_baja.'  '.$dia_fac.'-'.$mes_fac.'-'.$anio_baja.'</td>';
                    echo '<td>7</td>'.$afi['num_solici'].'</td><td>'.$afi['titular'].'</td><td>'.$afi['f_ingreso'].'</td><td><strong>'.$afi['f_baja'].'</strong></td><td>'.$afi['descripcion'].'</td><td>'.$afi['titular'].'</td><td>'.$afi['f_pago_des'].'</td><td>GENERAR BOLETA</td><td>'.$num_deuda.'</td><td>'.$b_ipaga.'</td><td>'.$afi['cod_plan'].'</td><td>'.$afi['tipo_plan'].'</td><td>'.$afi['importe'].'</td>';
                    echo '<tr>';

                    $factura =crearCuenta($afi['num_solici'],$afi['titular'],'B', $comprovante, $periodo_afacturar,$afi['importe']);
                    $tra[] = $factura;
                    $comprovante ++;

                }
/*
                else{
                    echo '<tr>';
                    echo '<td>8</td><td>'.$z.'</td><td>'.$afi['num_solici'].'</td><td>'.$afi['titular'].'</td><td>'.$afi['f_ingreso'].'</td><td><strong>'.$afi['f_baja'].'</strong></td><td>'.$afi['descripcion'].'</td><td>'.$afi['titular'].'</td><td>'.$afi['f_pago_des'].'</td><td>NO FACTURA</td><td>'.$num_deuda.'</td><td>'.$b_ipaga.'</td><td>'.$afi['cod_plan'].'</td><td>'.$afi['tipo_plan'].'</td><td>'.$afi['importe'].'</td>';
                    echo '<tr>';
                }
*/
            }

            //ACTIVOS
             if ($afi['estado'] == 500 || $afi['estado'] == 400  || $afi['estado'] == 3500){
                    echo '<tr>';
                    echo '<td>9</td><td>'.$afi['num_solici'].'</td><td>'.$afi['nro_doc'].'</td><td>'.$afi['f_ingreso'].'</td><td><strong>'.$afi['f_baja'].'</strong></td><td>'.$afi['descripcion'].'</td><td>'.$afi['titular'].'</td><td>'.$afi['f_pago_des'].'</td><td>FACTURA</td><td>'.$num_deuda.'</td><td>'.$b_ipaga.'</td><td>'.$afi['cod_plan'].'</td><td>'.$afi['tipo_plan'].'</td><td>'.$afi['importe'].'</td>';
                    echo '<tr>';

                    $factura =crearCuenta($afi['num_solici'],$afi['titular'],'B', $comprovante, $periodo_afacturar,$afi['importe']);
                    $tra[] = $factura;
                    $comprovante ++;
            }

            //900 falta de pago 3100 CLIENTE OROSO
            if ($afi['estado'] == 900 || $afi['estado'] == 3100){
                /*
                    echo '<tr>';
                    echo '<td>10</td><td>'.$z.'</td><td>'.$afi['num_solici'].'</td><td>'.$afi['titular'].'</td><td>'.$afi['f_ingreso'].'</td><td><strong>'.$afi['f_baja'].'</strong></td><td>'.$afi['descripcion'].'</td><td>'.$afi['titular'].'</td><td>'.$afi['f_pago_des'].'</td><td>NO FACTURA</td><td>'.$num_deuda.'</td><td>'.$b_ipaga.'</td><td>'.$afi['cod_plan'].'</td><td>'.$afi['tipo_plan'].'</td><td>'.$afi['importe'].'</td>';
                    echo '<tr>';
                 * 
                 */
            }


    }



}// FIN COPRUEBA DEUDAS ATRASADAS

    else{

            //ACTIVOS
             if ($afi['estado'] == 500 || $afi['estado'] == 400  || $afi['estado'] == 3500){
                    echo '<tr>';
                    echo '<td>9</td><td>'.$afi['num_solici'].'</td><td>'.$afi['nro_doc'].'</td><td>'.$afi['f_ingreso'].'</td><td><strong>'.$afi['f_baja'].'</strong></td><td>'.$afi['descripcion'].'</td><td>'.$afi['titular'].'</td><td>'.$afi['f_pago_des'].'</td><td>FACTURA</td><td>'.$num_deuda.'</td><td>'.$b_ipaga.'</td><td>'.$afi['cod_plan'].'</td><td>'.$afi['tipo_plan'].'</td><td>'.$afi['importe'].'</td>';
                    echo '<tr>';

                    $factura =crearCuenta($afi['num_solici'],$afi['titular'],'B', $comprovante, $periodo_afacturar,$afi['importe']);
                    $tra[] = $factura;
                    $comprovante ++;

            }

            //900 falta de pago 3100 CLIENTE OROSO
            if ($afi['estado'] == 900 || $afi['estado'] == 3100){
                /*
                    echo '<tr>';
                    echo '<td>10</td><td>'.$z.'</td><td>'.$afi['num_solici'].'</td><td>'.$afi['titular'].'</td><td>'.$afi['f_ingreso'].'</td><td><strong>'.$afi['f_baja'].'</strong></td><td>'.$afi['descripcion'].'</td><td>'.$afi['titular'].'</td><td>'.$afi['f_pago_des'].'</td><td>NO FACTURA</td><td>'.$num_deuda.'</td><td>'.$b_ipaga.'</td><td>'.$afi['cod_plan'].'</td><td>'.$afi['tipo_plan'].'</td><td>'.$afi['importe'].'</td>';
                    echo '<tr>';
                 *
                 */
            }

            //RENUNCIA 700, OTRAS CAUSAS 800, BAJA AUTOMATICA 1100

            if ($afi['estado'] == 700 || $afi['estado'] == 800 || $afi['estado'] == 1100 ){

                $f_baja  = explode('-',$afi['f_baja']);

                $dia_baja = $f_baja[2]; $mes_baja = $f_baja[1]; $anio_baja = $f_baja[0];

                $_facturacio = explode('-',$fecha_facturacion);
                $dia_fac = $_facturacio[2]; $mes_fac = $_facturacio[1]; $anio_fac = $_facturacio[0];

                if ($dia_baja > 15 && $mes_fac == $mes_baja && $anio_baja == $anio_fac ){
                    echo '<tr>';
                    echo '<td>'.$dia_fac.'-'.$mes_baja.'-'.$anio_baja.'  '.$dia_fac.'-'.$mes_fac.'-'.$anio_baja.'</td>';
                    echo '<td>7</td><td>'.$afi['num_solici'].'</td><td>'.$afi['titular'].'</td><td>'.$afi['f_ingreso'].'</td><td><strong>'.$afi['f_baja'].'</strong></td><td>'.$afi['descripcion'].'</td><td>'.$afi['titular'].'</td><td>'.$afi['f_pago_des'].'</td><td>GENERAR BOLETA</td><td>'.$num_deuda.'</td><td>'.$b_ipaga.'</td><td>'.$afi['cod_plan'].'</td><td>'.$afi['tipo_plan'].'</td><td>'.$afi['importe'].'</td>';
                    echo '<tr>';

                    $factura =crearCuenta($afi['num_solici'],$afi['titular'],'B', $comprovante, $periodo_afacturar,$afi['importe']);
                    $tra[] = $factura;
                    $comprovante ++;

                }

                else{
                    /*
                    echo '<tr>';
                    echo '<td>8</td><td>'.$z.'</td><td>'.$afi['num_solici'].'</td><td>'.$afi['titular'].'</td><td>'.$afi['f_ingreso'].'</td><td><strong>'.$afi['f_baja'].'</strong></td><td>'.$afi['descripcion'].'</td><td>'.$afi['titular'].'</td><td>'.$afi['f_pago_des'].'</td><td>NO FACTURA</td><td>'.$num_deuda.'</td><td>'.$b_ipaga.'</td><td>'.$afi['cod_plan'].'</td><td>'.$afi['tipo_plan'].'</td><td>'.$afi['importe'].'</td>';
                    echo '<tr>';
                     * 
                     */
                }

            }

    }

}//FIN WHILE 1




echo '</table>';

$facturar = new Datos;
$facturar->Trans2($tra);