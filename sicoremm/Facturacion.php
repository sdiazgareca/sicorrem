<?php

define ('HOST','192.168.168.30');
define ('USUARIO','root');
define ('CLAVE','cuchitalinda');
define ('BD','sicoremm2');

include_once('CLA/Datos.php');

$conexion = mysql_connect (HOST,USUARIO,CLAVE) or die ("No se puede conectar con el servidor, compruebe que el nombre de usuario y contraseña sean correctos");
mysql_select_db (BD) or die ("No se puede seleccionar la base de datos.  Es probable que la BD no exista");


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

$sql = "SELECT cobrador,contratos.titular,contratos.ZO, contratos.SE, contratos.MA,
        e_contrato.descripcion,contratos.num_solici, valor_plan.valor AS importe, contratos.f_pago, contratos.titular,f_baja, f_ingreso,contratos.secuencia,contratos.estado
        ,e_contrato.descripcion, f_pago.descripcion AS f_pago_des,contratos.cod_plan, contratos.tipo_plan

        FROM contratos

        LEFT JOIN valor_plan ON valor_plan.secuencia = contratos.secuencia AND contratos.cod_plan = valor_plan.cod_plan AND contratos.tipo_plan = valor_plan.tipo_plan
        LEFT JOIN e_contrato ON e_contrato.cod = contratos.estado
        LEFT JOIN f_pago ON f_pago.codigo = contratos.f_pago
        LEFT JOIN zosema ON zosema.ZO = contratos.ZO AND zosema.SE = contratos.SE AND zosema.MA = contratos.MA
        LEFT JOIN domicilios ON domicilios.nro_doc = contratos.titular AND domicilios.num_solici = contratos.num_solici

        WHERE
        contratos.empresa IS NOT NULL AND
       contratos.estado !='200' AND contratos.estado !='300' AND contratos.estado !='600'
        AND contratos.estado !='1000' AND contratos.factu='B' AND
        contratos.estado !=  '3600' AND f_pago != '600' ORDER BY cobrador";

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

    //F_PAGO 100 PAC, 200 TC, 300 COBRO DOM, 400 D X PLANILLA, 500 TRANFE, 600 PAGO EMPRESA
    if ( ($afi['f_pago'] == '100' || $afi['f_pago'] == '200') && $num_deuda >= 6 ){

            //dicom

            echo '<tr>';
            echo '<td>'.$afi['cobrador'].'</td><td>'.$afi['ZO'].'</td><td>'.$afi['SE'].'</td><td>'.$afi['MA'].'</td><td>'.$z.'</td><td>'.$afi['num_solici'].'</td><td>'.$afi['titular'].'</td><td>'.$afi['f_ingreso'].'</td><td><strong>'.$afi['f_baja'].'</strong></td><td>'.$afi['descripcion'].'</td><td>'.$afi['titular'].'</td><td>'.$afi['f_pago_des'].'</td><td>INGRESAR A DICOM</td><td>'.$num_deuda.'</td><td>'.$b_ipaga.'</td><td>'.$afi['cod_plan'].'</td><td>'.$afi['tipo_plan'].'</td><td>'.$afi['importe'].'</td>';
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
                    echo '<td>'.$dia_fac.'-'.$mes_baja.'-'.$anio_baja.'  '.$dia_fac.'-'.$mes_fac.'-'.$anio_baja.'</td>';
                    echo '<td>'.$afi['cobrador'].'</td><td>'.$afi['ZO'].'</td><td>'.$afi['SE'].'</td><td>'.$afi['MA'].'</td><td>'.$z.'</td><td>'.$afi['num_solici'].'</td><td>'.$afi['titular'].'</td><td>'.$afi['f_ingreso'].'</td><td><strong>'.$afi['f_baja'].'</strong></td><td>'.$afi['descripcion'].'</td><td>'.$afi['titular'].'</td><td>'.$afi['f_pago_des'].'</td><td>FACTURAR</td><td>'.$num_deuda.'</td><td>'.$b_ipaga.'</td><td>'.$afi['cod_plan'].'</td><td>'.$afi['tipo_plan'].'</td><td>'.$afi['importe'].'</td>';
                    echo '<tr>';
                }
                else{
                    echo '<tr>';
                    echo '<td>'.$afi['cobrador'].'</td><td>'.$afi['num_solici'].'</td><td>'.$afi['titular'].'</td><td>'.$afi['f_ingreso'].'</td><td><strong>'.$afi['f_baja'].'</strong></td><td>'.$afi['descripcion'].'</td><td>'.$afi['titular'].'</td><td>'.$afi['f_pago_des'].'</td><td>NO FACTURA</td><td>'.$num_deuda.'</td><td>'.$b_ipaga.'</td><td>'.$afi['cod_plan'].'</td><td>'.$afi['tipo_plan'].'</td><td>'.$afi['importe'].'</td>';
                    echo '<tr>';
                }

            }

            // ACTIVOS
            if ($afi['estado'] == 500 || $afi['estado'] == 400  || $afi['estado'] == 3500){
                    echo '<tr>';
                    echo '<td>'.$afi['cobrador'].'</td><td>'.$afi['ZO'].'</td><td>'.$afi['SE'].'</td><td>'.$afi['MA'].'</td><td>'.$z.'</td><td>'.$afi['num_solici'].'</td><td>'.$afi['nro_doc'].'</td><td>'.$afi['f_ingreso'].'</td><td><strong>'.$afi['f_baja'].'</strong></td><td>'.$afi['descripcion'].'</td><td>'.$afi['titular'].'</td><td>'.$afi['f_pago_des'].'</td><td>FACTURA</td><td>'.$num_deuda.'</td><td>'.$b_ipaga.'</td><td>'.$afi['cod_plan'].'</td><td>'.$afi['tipo_plan'].'</td><td>'.$afi['importe'].'</td>';
                    echo '<tr>';
            }

    }


    //300 COBRO DOM, TRANFERENCIA ELECTRONICA 500
    if ( ($afi['f_pago'] == '300' || $afi['f_pago'] == '500') && $num_deuda >= 3 ){

            echo '<tr>';
            echo '<td>'.$afi['cobrador'].'</td><td>'.$afi['ZO'].'</td><td>'.$afi['SE'].'</td><td>'.$afi['MA'].'</td><td>'.$z.'</td><td>'.$afi['num_solici'].'</td><td>'.$afi['titular'].'</td><td>'.$afi['f_ingreso'].'</td><td><strong>'.$afi['f_baja'].'</strong></td><td>'.$afi['descripcion'].'</td><td>'.$afi['titular'].'</td><td>'.$afi['f_pago_des'].'</td><td>INGRESAR A DICOM</td><td>'.$num_deuda.'</td><td>'.$b_ipaga.'</td><td>'.$afi['cod_plan'].'</td><td>'.$afi['tipo_plan'].'</td><td>'.$afi['importe'].'</td>';
            echo '<tr>';
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
                    echo '<td>'.$afi['cobrador'].'</td><td>'.$afi['ZO'].'</td><td>'.$afi['SE'].'</td><td>'.$afi['MA'].'</td><td>'.$z.'</td><td>'.$afi['num_solici'].'</td><td>'.$afi['titular'].'</td><td>'.$afi['f_ingreso'].'</td><td><strong>'.$afi['f_baja'].'</strong></td><td>'.$afi['descripcion'].'</td><td>'.$afi['titular'].'</td><td>'.$afi['f_pago_des'].'</td><td>GENERAR BOLETA</td><td>'.$num_deuda.'</td><td>'.$b_ipaga.'</td><td>'.$afi['cod_plan'].'</td><td>'.$afi['tipo_plan'].'</td><td>'.$afi['importe'].'</td>';
                    echo '<tr>';
                }
                
                else{
                    echo '<tr>';
                    echo '<td>'.$afi['cobrador'].'</td><td>'.$afi['ZO'].'</td><td>'.$afi['SE'].'</td><td>'.$afi['MA'].'</td><td>'.$afi['ZO'].'</td><td>'.$afi['SE'].'</td><td>'.$afi['MA'].'</td><td>'.$z.'</td><td>'.$afi['num_solici'].'</td><td>'.$afi['titular'].'</td><td>'.$afi['f_ingreso'].'</td><td><strong>'.$afi['f_baja'].'</strong></td><td>'.$afi['descripcion'].'</td><td>'.$afi['titular'].'</td><td>'.$afi['f_pago_des'].'</td><td>NO FACTURA</td><td>'.$num_deuda.'</td><td>'.$b_ipaga.'</td><td>'.$afi['cod_plan'].'</td><td>'.$afi['tipo_plan'].'</td><td>'.$afi['importe'].'</td>';
                    echo '<tr>';
                }

            }

            //ACTIVOS
             if ($afi['estado'] == 500 || $afi['estado'] == 400  || $afi['estado'] == 3500){
                    echo '<tr>';
                    echo '<td>'.$afi['cobrador'].'</td><td>'.$afi['ZO'].'</td><td>'.$afi['SE'].'</td><td>'.$afi['MA'].'</td><td>'.$afi['ZO'].'</td><td>'.$afi['SE'].'</td><td>'.$afi['MA'].'</td><td>'.$z.'</td><td>'.$afi['num_solici'].'</td><td>'.$afi['nro_doc'].'</td><td>'.$afi['f_ingreso'].'</td><td><strong>'.$afi['f_baja'].'</strong></td><td>'.$afi['descripcion'].'</td><td>'.$afi['titular'].'</td><td>'.$afi['f_pago_des'].'</td><td>FACTURA</td><td>'.$num_deuda.'</td><td>'.$b_ipaga.'</td><td>'.$afi['cod_plan'].'</td><td>'.$afi['tipo_plan'].'</td><td>'.$afi['importe'].'</td>';
                    echo '<tr>';
            }

            //900 falta de pago 3100 CLIENTE OROSO
            if ($afi['estado'] == 900 || $afi['estado'] == 3100){
                    echo '<tr>';
                    echo '<td>'.$afi['cobrador'].'</td><td>'.$afi['ZO'].'</td><td>'.$afi['SE'].'</td><td>'.$afi['MA'].'</td>'.$afi['ZO'].'</td><td>'.$afi['SE'].'</td><td>'.$afi['MA'].'</td><td>'.$z.'</td><td>'.$afi['num_solici'].'</td><td>'.$afi['titular'].'</td><td>'.$afi['f_ingreso'].'</td><td><strong>'.$afi['f_baja'].'</strong></td><td>'.$afi['descripcion'].'</td><td>'.$afi['titular'].'</td><td>'.$afi['f_pago_des'].'</td><td>NO FACTURA</td><td>'.$num_deuda.'</td><td>'.$b_ipaga.'</td><td>'.$afi['cod_plan'].'</td><td>'.$afi['tipo_plan'].'</td><td>'.$afi['importe'].'</td>';
                    echo '<tr>';
            }


    }



}// FIN COPRUEBA DEUDAS ATRASADAS

    else{

            //ACTIVOS
             if ($afi['estado'] == 500 || $afi['estado'] == 400  || $afi['estado'] == 3500){
                    echo '<tr>';
                    echo '<td>'.$afi['cobrador'].'</td><td>'.$afi['ZO'].'</td><td>'.$afi['SE'].'</td><td>'.$afi['MA'].'</td><td>'.$afi['ZO'].'</td><td>'.$afi['SE'].'</td><td>'.$afi['MA'].'</td><td>'.$z.'</td><td>'.$afi['num_solici'].'</td><td>'.$afi['nro_doc'].'</td><td>'.$afi['f_ingreso'].'</td><td><strong>'.$afi['f_baja'].'</strong></td><td>'.$afi['descripcion'].'</td><td>'.$afi['titular'].'</td><td>'.$afi['f_pago_des'].'</td><td>FACTURA</td><td>'.$num_deuda.'</td><td>'.$b_ipaga.'</td><td>'.$afi['cod_plan'].'</td><td>'.$afi['tipo_plan'].'</td><td>'.$afi['importe'].'</td>';
                    echo '<tr>';
            }

            //900 falta de pago 3100 CLIENTE OROSO
            if ($afi['estado'] == 900 || $afi['estado'] == 3100){
                    echo '<tr>';
                    echo '<td>'.$afi['cobrador'].'</td><td>'.$afi['ZO'].'</td><td>'.$afi['SE'].'</td><td>'.$afi['MA'].'</td><td>'.$afi['ZO'].'</td><td>'.$afi['SE'].'</td><td>'.$afi['MA'].'</td><td>'.$z.'</td><td>'.$afi['num_solici'].'</td><td>'.$afi['titular'].'</td><td>'.$afi['f_ingreso'].'</td><td><strong>'.$afi['f_baja'].'</strong></td><td>'.$afi['descripcion'].'</td><td>'.$afi['titular'].'</td><td>'.$afi['f_pago_des'].'</td><td>NO FACTURA</td><td>'.$num_deuda.'</td><td>'.$b_ipaga.'</td><td>'.$afi['cod_plan'].'</td><td>'.$afi['tipo_plan'].'</td><td>'.$afi['importe'].'</td>';
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
                    echo '<td>'.$dia_fac.'-'.$mes_baja.'-'.$anio_baja.'  '.$dia_fac.'-'.$mes_fac.'-'.$anio_baja.'</td>';
                    echo '<td>'.$afi['cobrador'].'</td><td>'.$afi['ZO'].'</td><td>'.$afi['SE'].'</td><td>'.$afi['MA'].'</td><td>'.$afi['ZO'].'</td><td>'.$afi['SE'].'</td><td>'.$afi['MA'].'</td><td>'.$z.'</td><td>'.$afi['num_solici'].'</td><td>'.$afi['titular'].'</td><td>'.$afi['f_ingreso'].'</td><td><strong>'.$afi['f_baja'].'</strong></td><td>'.$afi['descripcion'].'</td><td>'.$afi['titular'].'</td><td>'.$afi['f_pago_des'].'</td><td>GENERAR BOLETA</td><td>'.$num_deuda.'</td><td>'.$b_ipaga.'</td><td>'.$afi['cod_plan'].'</td><td>'.$afi['tipo_plan'].'</td><td>'.$afi['importe'].'</td>';
                    echo '<tr>';
                }

                else{
                    echo '<tr>';
                    echo '<td>'.$afi['cobrador'].'</td><td>'.$afi['ZO'].'</td><td>'.$afi['SE'].'</td><td>'.$afi['MA'].'</td><td>'.$afi['ZO'].'</td><td>'.$afi['SE'].'</td><td>'.$afi['MA'].'</td><td>'.$z.'</td><td>'.$afi['num_solici'].'</td><td>'.$afi['titular'].'</td><td>'.$afi['f_ingreso'].'</td><td><strong>'.$afi['f_baja'].'</strong></td><td>'.$afi['descripcion'].'</td><td>'.$afi['titular'].'</td><td>'.$afi['f_pago_des'].'</td><td>NO FACTURA</td><td>'.$num_deuda.'</td><td>'.$b_ipaga.'</td><td>'.$afi['cod_plan'].'</td><td>'.$afi['tipo_plan'].'</td><td>'.$afi['importe'].'</td>';
                    echo '<tr>';
                }

            }

    }

$i = $i +1;
$z = $z+1;
}//FIN WHILE 1







echo '</table>';