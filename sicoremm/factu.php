<?php

define ('HOST','192.168.168.30');
define ('USUARIO','root');
define ('CLAVE','cuchitalinda');
define ('BD','sicoremm2');

include_once('CLA/Datos.php');

$periodo = '2011-03-01';

$p_facturacion = '2011-02-20';

//FORMATO FECHA Y-m-d
function diferenciaDiaz($fecha_inicial,$fecha_actual){

//defino fecha 1
$fecha1 = explode('-',$fecha_inicial);
$ano1 = $fecha1[0];
$mes1 = $fecha1[1];
$mes2 = $fecha1[2];

//defino fecha 2
$fecha2 = explode('-',$fecha_actual);
$ano2 = $fecha2[0];
$mes2 = $fecha2[1];
$mes2 = $fecha2[2];

//calculo timestam de las dos fechas
$timestamp1 = mktime(0,0,0,$mes1,$dia1,$ano1);
$timestamp2 = mktime(4,12,0,$mes2,$dia2,$ano2);

//resto a una fecha la otra
$segundos_diferencia = $timestamp1 - $timestamp2;
//echo $segundos_diferencia;

//convierto segundos en días
$dias_diferencia = $segundos_diferencia / (60 * 60 * 24);

//obtengo el valor absoulto de los días (quito el posible signo negativo)
$dias_diferencia = abs($dias_diferencia);

//quito los decimales a los días de diferencia
$dias_diferencia = floor($dias_diferencia);

return $dias_diferencia;
}

$conexion = mysql_connect (HOST,USUARIO,CLAVE) or die ("No se puede conectar con el servidor, compruebe que el nombre de usuario y contraseña sean correctos");
mysql_select_db (BD) or die ("No se puede seleccionar la base de datos.  Es probable que la BD no exista");


//F_BAJA

$aff = "SELECT fecha_baja,afiliados.fecha_ing, afiliados.titular, num_solici FROM afiliados GROUP BY titular";
$aff_q = mysql_query($aff);

while($afil = mysql_fetch_array($aff_q)){
    $sql ='UPDATE contratos SET f_baja="'.$afil['fecha_baja'].'" WHERE contratos.num_solici="'.$afil['num_solici'].'" AND titular="'.$afil['titular'].'"';

    echo "<br />".$sql.";<br />";
}



/* PROCESO DE FACTURACION */

// CALCULO DE SECUENCIAS

             $n_afi_sql ="SELECT COUNT(afiliados.num_solici) AS n_afi, titular, nro_doc, num_solici
                          FROM afiliados
                          WHERE (cod_baja = '00'  || cod_baja = 'AJ'  || cod_baja = '04'  || cod_baja ='AZ')
                          GROUP BY afiliados.num_solici";

             $n_afi_query = mysql_query($n_afi_sql);

             echo "<br /><strong>CALCULANDO SECUENCIA...</strong><br/>";

             while ($n_afi = mysql_fetch_array($n_afi_query)){

                 $cam_sec = "UPDATE contratos SET secuencia = '".$n_afi['n_afi']."' WHERE num_solici='".$n_afi['num_solici']."';";

                 if (mysql_query($cam_sec)){

                     echo "";
                 }

                 else{

                     echo '<br /><strong>ERROR</strong><br />';
                 }
             }

             echo "<br /><strong>SECUENCIA CALCULADA..</strong><br/>";
//SELECION DE AFILIADOS EXCLUYE DICOM, DESCUENTOS X PLANILLA, BAJA_AUTOMATICA, FALLECIMIENTO, EMPRESA, A

$sql = "SELECT ZO,SE,MA,contratos.titular,
        e_contrato.descripcion,contratos.num_solici, valor_plan.valor AS importe, contratos.f_pago, contratos.titular,f_baja, f_ingreso,contratos.secuencia,estado
        FROM contratos

        INNER JOIN valor_plan ON valor_plan.secuencia = contratos.secuencia AND contratos.cod_plan = valor_plan.cod_plan AND contratos.tipo_plan = valor_plan.tipo_plan
        INNER JOIN e_contrato ON e_contrato.cod = contratos.estado

        WHERE
        contratos.empresa IS NOT NULL AND contratos.factu='B' AND
        contratos.estado !='100' AND contratos.estado !='200' AND contratos.estado !='300' AND contratos.estado !='600'
        AND contratos.estado !='1000'
        AND contratos.estado !=  '3600' AND f_pago != '600' ORDER BY ZO, SE, MA";

//echo $sql;

$query = mysql_query($sql);

echo '<table>';


$i = 1;

$z = 1;


while ( $afi = mysql_fetch_array($query)){

    $cta ='SELECT COUNT(cta.fecha_mov) AS num_deuda,nro_doc, num_solici, importe
           FROM cta
           WHERE cta.cod_mov=1  AND afectacion < 1 AND num_solici="'.$afi['num_solici'].'" AND nro_doc="'.$afi['titular'].'"
           GROUP BY nro_doc';

    $cta_query = mysql_query($cta);

    $cta_num = mysql_num_rows($cta_query);

    //COMPROBAR SI EXISTEN DEUDAS ATRAZADAS
    if ($cta_num > 0){
       //COMPROBAR DIAS PARA DECIR ENVIO A DICOM

        $ctacte = mysql_fetch_array($cta_query);

        //OBTIENE DIAS
        //$diferencia_dias = diferenciaDiaz($p_facturacion,$ctacte['f_deuda']);
        $num_deuda = $ctacte['num_deuda'];



        //FECHAS
        $_COMP = explode('-',$afi['f_baja']);
        $dia_comp = $_COMP[2]; $mes_comp = $_COMP[1];  $anio_comp = $_COMP[0]; // FECHA CILENTE


        $f_fac = explode('-',$p_facturacion);
        $dia_fac = $f_fac[2]; $mes_fac = $f_fac[1];  $anio_fac = $f_fac[0];


        //COMPARAR FORMA DE PAGO MENSUAL
        // MANDATO, TC

        if ( ($afi['f_pago'] == '100' || $afi['f_pago'] == '200') && $num_deuda >= 6 ){


            $transaccion[$i]="UPDATE afiliados SET afiliados.cod_baja ='DI', afiliados.fecha_baja='".$p_facturacion."' WHERE num_solici = '".$afi['num_solici']."' AND afiliados.cod_baja != '600' AND afiliados.cod_baja != '700'AND afiliados.cod_baja != '800'";
            $transaccion[$z]="UPDATE contratos SET estado='3600', f_baja='".$p_facturacion."' WHERE num_solici='".$afi['num_solici']."' AND afiliados.cod_baja != '600' AND afiliados.cod_baja != '01'AND afiliados.cod_baja != '02' AND afiliados.cod_baja != '03' AND afiliados.cod_baja != '09'";

            echo '<tr><td>'.$afi['titular'].'</td><td>1 importe '.$afi['importe'].'</td><td>fecha ingreso '.$afi['f_ingreso'].'</td><td>fecha baja '.$afi['f_baja'].'</td><td>f_pago '.$afi['f_pago'].'</td><td>secuencia '.$afi['secuencia'].'</td><td>DICOM</td><td>contrato '.$afi['num_solici'].'</td><td> fecha cuota impaga'.$ctacte['f_deuda'].'</td><td> n cuotas impagas'.$num_deuda.'</td><td>'.$afi['descripcion'].'</td></tr>';

            }
            


        if ( ($afi['f_pago'] == '100' || $afi['f_pago'] == '200') && $num_deuda < 6 ){

            if ($afi['estado'] != 700 && $afi['estado'] !=600 && $afi['estado'] != 800 && $afi['estado'] != 1100 && $afi['estado'] != 3100 && $afi['estado'] !=3500 && $afi['estado'] !=3600){
                 echo '<tr><td> '.$afi['titular'].'</td><td>2 importe '.$afi['importe'].'</td><td>fecha ingreso '.$afi['f_ingreso'].'</td><td>fecha baja '.$afi['f_baja'].'</td><td>f_pago '.$afi['f_pago'].'</td><td>secuencia '.$afi['secuencia'].'</td><td>FACTRURAR MES</td><td>contrato '.$afi['num_solici'].'</td><td> fecha cuota impaga'.$ctacte['f_deuda'].'</td><td> n cuotas impagas'.$num_deuda.'</td><td>'.$afi['descripcion'].'</td></tr>';
            }
           
            if ( $afi['f_ingreso'] > $afi['f_baja'] && $afi['estado'] == 700 ||  $afi['estado'] == 800 || $afi['estado'] == 1100){

                 if ($dia_comp > 15 && $anio_comp == $anio_fac && $mes_comp == $mes_fac ){
                    echo '<tr><td> '.$afi['titular'].'</td><td>3'.$dia_com.'-'.$mes_comp.'-'.$anio_comp.'  '.$dia_fac.'-'.$mes_fac.'-'.$anio_fac.' '.$anio_fac.'importe '.$afi['importe'].'</td><td>fecha ingreso '.$afi['f_ingreso'].'</td><td>fecha baja '.$afi['f_baja'].'</td><td>f_pago '.$afi['f_pago'].'</td><td>secuencia '.$afi['secuencia'].'</td><td>FACTURAR ESTE MES </td><td>contrato '.$afi['num_solici'].'</td><td> fecha cuota impaga'.$ctacte['f_deuda'].'</td><td> n cuotas impagas'.$num_deuda.'</td><td>'.$afi['descripcion'].'</td></tr>';
                 }

            }


                }

            
        }
        

        //COBRO DOMICILIARIO
         if ( ($afi['f_pago'] == '300' || $afi['f_pago'] == '500') && $num_deuda >= 3 ){

             $transaccion[$i]="UPDATE afiliados SET afiliados.cod_baja ='DI', afiliados.fecha_baja='".$p_facturacion."'
                                        WHERE num_solici = '".$afi['num_solici']."' AND afiliados.cod_baja != '600' AND
                                        afiliados.cod_baja != '700'AND afiliados.cod_baja != '800'";

            $transaccion[$z]="UPDATE contratos SET estado='3600', f_baja='".$p_facturacion."' WHERE num_solici='".$afi['num_solici']."'";

             echo '<tr><td>'.$afi['titular'].'</td><td>4 importe '.$afi['importe'].'</td><td>fecha ingreso '.$afi['f_ingreso'].'</td><td>fecha baja '.$afi['f_baja'].'</td><td>f_pago '.$afi['f_pago'].'</td><td>secuencia '.$afi['secuencia'].'</td><td>DICOM</td><td>contrato '.$afi['num_solici'].'</td><td> fecha cuota impaga '.$ctacte['f_deuda'].'</td><td> n cuotas impagas '.$num_deuda.'</td><td>'.$afi['descripcion'].'</td></tr>';

        }

        if ( ($afi['f_pago'] == '300' || $afi['f_pago'] == '500') && $num_deuda < 3 ){


            if ($afi['f_ingreso'] > $afi['f_baja'] && $afi['estado'] != 700 && $afi['estado'] !=600 && $afi['estado'] != 800 && $afi['estado'] != 1100 && $afi['estado'] != 3100 && $afi['estado'] !=3500 && $afi['estado'] !=3600 && $afi['estado']){
                 echo '<tr><td>'.$afi['titular'].'</td><td>5 importe '.$afi['importe'].'</td><td>fecha ingreso '.$afi['f_ingreso'].'</td><td>fecha baja '.$afi['f_baja'].'</td><td>f_pago '.$afi['f_pago'].'</td><td>secuencia '.$afi['secuencia'].'</td><td>FACTRURAR MES</td><td>contrato '.$afi['num_solici'].'</td><td> fecha cuota impaga'.$ctacte['f_deuda'].'</td><td> n cuotas impagas'.$num_deuda.'</td><td>'.$afi['descripcion'].'</td></tr>';
            }

            if ( $afi['estado'] == 700 ||  $afi['estado'] == 800 || $afi['estado'] == 1100){

                 if ($dia_comp > 15 && $anio_comp == $anio_fac && $mes_comp == $mes_fac ){
                        echo '<tr><td>'.$afi['titular'].'</td><td>6 '.$dia_com.'-'.$mes_comp.'-'.$anio_comp.'  '.$dia_fac.'-'.$mes_fac.'-'.$anio_fac.' '.$anio_fac.' '.$anio_fac.'importe '.$afi['importe'].'</td><td>fecha ingreso '.$afi['f_ingreso'].'</td><td>fecha baja '.$afi['f_baja'].'</td><td>f_pago '.$afi['f_pago'].'</td><td>secuencia '.$afi['secuencia'].'</td><td>FACTURAR ESTE MES </td><td>contrato '.$afi['num_solici'].'</td><td> fecha cuota impaga'.$ctacte['f_deuda'].'</td><td> n cuotas impagas'.$num_deuda.'</td><td>'.$afi['descripcion'].'</td></tr>';
                 }
            }


        }


    
 


    else{

        echo '<tr><td>importe '.$afi['importe'].'</td><td>fecha ingreso '.$afi['f_ingreso'].'</td><td>fecha baja '.$afi['f_baja'].'</td><td>f_pago '.$afi['f_pago'].'</td><td>secuencia '.$afi['secuencia'].'</td><td>ESTADUDIAR</td><td>contrato '.$afi['num_solici'].'</td><td> fecha cuota impaga'.$afi['f_deuda'].'</td><td> dias'.$diferencia_dias.'</td></tr>';


            if ($afi['f_ingreso'] > $afi['f_baja'] && $afi['estado'] != 700 && $afi['estado'] !=600 && $afi['estado'] != 800 && $afi['estado'] != 1100 && $afi['estado'] != 3100 && $afi['estado'] !=3500 && $afi['estado'] !=3600 && $afi['estado']){
                 echo '<tr><td>'.$afi['titular'].'</td><td>5 importe '.$afi['importe'].'</td><td>fecha ingreso '.$afi['f_ingreso'].'</td><td>fecha baja '.$afi['f_baja'].'</td><td>f_pago '.$afi['f_pago'].'</td><td>secuencia '.$afi['secuencia'].'</td><td>FACTRURAR MES</td><td>contrato '.$afi['num_solici'].'</td><td> fecha cuota impaga'.$ctacte['f_deuda'].'</td><td> n cuotas impagas'.$num_deuda.'</td><td>'.$afi['descripcion'].'</td></tr>';
            }

            if ( $afi['estado'] == 700 ||  $afi['estado'] == 800 || $afi['estado'] == 1100){

                 if ($dia_comp > 15 && $anio_comp == $anio_fac && $mes_comp == $mes_fac ){
                        echo '<tr><td>'.$afi['titular'].'</td><td>6 '.$dia_com.'-'.$mes_comp.'-'.$anio_comp.'  '.$dia_fac.'-'.$mes_fac.'-'.$anio_fac.' '.$anio_fac.' '.$anio_fac.'importe '.$afi['importe'].'</td><td>fecha ingreso '.$afi['f_ingreso'].'</td><td>fecha baja '.$afi['f_baja'].'</td><td>f_pago '.$afi['f_pago'].'</td><td>secuencia '.$afi['secuencia'].'</td><td>FACTURAR ESTE MES </td><td>contrato '.$afi['num_solici'].'</td><td> fecha cuota impaga'.$ctacte['f_deuda'].'</td><td> n cuotas impagas'.$num_deuda.'</td><td>'.$afi['descripcion'].'</td></tr>';
                 }
            }



}


}
echo '</table>';





$cerrar = mysql_close($conexion);
?>
