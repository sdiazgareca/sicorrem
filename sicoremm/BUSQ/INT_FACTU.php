<?php

include('../DAT/conf.php');
include('../DAT/bd.php');

if ( isset($_POST['boletas']) && $_POST['boletas'] > 0 && isset($_POST['periodo'])){

    echo '<strong>Iniciando Proceso de Facturación<br />';
    echo '<strong>Boleta Inicio '.$_POST['boletas'].' <br /></strong>';


    //PERIODO DE FACTURACION
    $periodo = explode('-',$_POST['periodo']);
    $fecha_fact = $periodo[2].'-'.$periodo[1].'-'.$periodo[0];

    //CALCULO DE SECUENCIAS
    echo '<strong>Calculando Secuncias</strong><br />';



    //BOLETAS
    $sql =" SELECT COUNT(num_solici) AS secuencia,num_solici,nro_doc
        FROM afiliados
        WHERE afiliados.cod_baja='00'  ||  afiliados.cod_baja='AJ' || afiliados.cod_baja='AZ'  ||  afiliados.cod_baja='04' || afiliados.cod_baja='DI'
        GROUP BY num_solici";

    $query = mysql_query($sql);

    while ($secuencia = mysql_fetch_array($query) ){

        $con = 'UPDATE contratos SET secuencia="'.$secuencia['secuencia'].'"
                WHERE num_solici="'.$secuencia['num_solici'].'"';

        if (mysql_query($con)){
            $mensaje ='Secuencia calculada<br />';
        }
    
    else{
        echo '<br />ERROR<br />';
    }
}
    //mensaje de secuencia
    echo $mensaje;



    //OBTENIENDO PAGOS CON BOLETA DESCARTANDO CONVENIOS
    $con_sql = "SELECT e_contrato.descripcion AS es,valor_plan.valor, contratos.cod_plan, contratos.tipo_plan,contratos.secuencia, contratos.num_solici, contratos.titular, DATE_FORMAT(contratos.f_ingreso,'%d-%m-%Y') AS f_ingreso, contratos.ZO, contratos.SE, contratos.MA,contratos.factu
                FROM contratos
                LEFT JOIN valor_plan ON contratos.secuencia = valor_plan.secuencia AND contratos.cod_plan = valor_plan.cod_plan AND contratos.tipo_plan = valor_plan.tipo_plan
                LEFT JOIN e_contrato ON e_contrato.cod = contratos.estado
                WHERE contratos.empresa IS NULL AND factu = 'B' AND contratos.f_pago != 400 AND contratos.f_pago != 600 AND estado != '700' AND estado != '800' AND estado != '600' AND estado != '1000' AND estado != '1100'
                ORDER BY f_ingreso";

    $sql_query = mysql_query($con_sql);
    echo '<br />';

    echo '<table class=table2>';

        echo '<tr>';
        echo '<th>RUT TUTLAR</th>';
        echo '<th>CONTRATO</th>';
        echo '<th>N AFI</th>';
        echo '<th>COD_PLAN</th>';
        echo '<th>TIPO_PLAN</th>';
        echo '<th>F_INGRESO</th>';
        echo '<th>VALOR</th>';
        echo '<th>%</th>';
        echo '<th>AJUSTE</th>';
        echo '<th>ZO</th>';
        echo '<th>SE</th>';
        echo '<th>MA</th>';
        echo '<th>ESTADO</th>';
        echo '<th>N MENSUALIDAD NO PAGADA</th>';
        echo '<th>FECHA ULTIMA MENSUALIDAD NO PAGADA</th>';
        echo '<th>FECHA PRIMERA MENSUALIDAD NO PAGADA</th>';
        echo '<th>SALDO DEUDA</th>';
        echo '</tr>';


    while($contratos = mysql_fetch_array($sql_query)){

        $ajuste =0;

        $pro_fe = explode('-',$contratos['f_ingreso']);


        $mes = $pro_fe[1];
        $anio = $pro_fe[2];

        if ($mes == '12' && $anio < date('Y')){

            $ajuste = 3.0;

        }

        if ($mes == '01' && $anio < date('Y')){

            $ajuste = 2.7;

        }


        echo '<tr>';

        echo '<td>'.$contratos['titular'].'</td>';
        echo '<td>'.$contratos['num_solici'].'</td>';
        echo '<td>'.$contratos['secuencia'].'</td>';
        echo '<td>'.$contratos['cod_plan'].'</td>';
        echo '<td>'.$contratos['tipo_plan'].'</td>';
        echo '<td>'.$contratos['f_ingreso'].'</td>';
        echo '<td>'.$contratos['valor'].'</td>';
        echo '<td>'.$ajuste.'</td>';
        echo '<td>'.($contratos['valor'] * $ajuste /100).'</td>';
        echo '<td>'.$contratos['ZO'].'</td>';
        echo '<td>'.$contratos['SE'].'</td>';
        echo '<td>'.$contratos['MA'].'</td>';
        echo '<td>'.$contratos['es'].'</td>';

        $cta ="SELECT cta.cod_mov, COUNT(fecha_mov) AS Num, MAX(fecha_mov) AS Nueva,MIN(fecha_mov) AS antigua, SUM(importe) AS deuda
               FROM cta
               WHERE (cta.afectacion IS NULL || cta.afectacion =0 || cta.afectacion ='' AND cod_mov ='1') AND nro_doc='".$contratos['titular']."' AND num_solici='".$contratos['num_solici']."'
               GROUP BY num_solici,nro_doc";

        $query2 = mysql_query($cta);
        $num = mysql_num_rows($query2);

        if($num >0){

        while($ctaa = mysql_fetch_array($query2)){
            echo '<td>'.$ctaa['Num'].'</td>';
            echo '<td>'.$ctaa['Nueva'].'</td>';
            echo '<td>'.$ctaa['antigua'].'</td>';
            echo '<td>'.$ctaa['deuda'].'</td>';
            

        }
        }
        else{
            echo '<td>&zwj;</td>';
            echo '<td>&zwj;</td>';
            echo '<td>&zwj;</td>';
            echo '<td>&zwj;</td>';
        }

        echo '</tr>';
    }
    
    echo '</table>';






  

    //CONVENIOS
    $con_sql = "SELECT f_factu.breve,empresa.empresa,e_contrato.descripcion AS es,valor_plan.valor, contratos.cod_plan, contratos.tipo_plan,contratos.secuencia, contratos.num_solici, contratos.titular, DATE_FORMAT(contratos.f_ingreso,'%d-%m-%Y') AS f_ingreso, contratos.ZO, contratos.SE, contratos.MA,contratos.factu
                FROM contratos
                LEFT JOIN valor_plan ON contratos.secuencia = valor_plan.secuencia AND contratos.cod_plan = valor_plan.cod_plan AND contratos.tipo_plan = valor_plan.tipo_plan
                LEFT JOIN e_contrato ON e_contrato.cod = contratos.estado
                LEFT JOIN empresa ON contratos.empresa = empresa.nro_doc
                LEFT JOIN f_factu ON f_factu.codigo = empresa.f_factu
                WHERE contratos.empresa IS NOT NULL AND contratos.f_pago = 400 AND contratos.f_pago != 600 AND contratos.estado != '700' AND contratos.estado != '800' AND contratos.estado != '600' AND contratos.estado != '1000' AND contratos.estado != '1100'
                ORDER BY f_ingreso";

    $sql_query = mysql_query($con_sql);
    echo '<br />';

    echo '<table class=table2>';

        echo '<tr>';
        echo '<th>CONVENIO</th>';
        echo '<th>FORMA DE PAGO</th>';
        echo '<th>RUT TUTLAR</th>';
        echo '<th>CONTRATO</th>';
        echo '<th>N AFI</th>';
        echo '<th>COD_PLAN</th>';
        echo '<th>TIPO_PLAN</th>';
        echo '<th>F_INGRESO</th>';
        echo '<th>VALOR</th>';
        echo '<th>%</th>';
        echo '<th>AJUSTE</th>';
        echo '<th>ZO</th>';
        echo '<th>SE</th>';
        echo '<th>MA</th>';
        echo '<th>ESTADO</th>';
        echo '<th>N MENSUALIDAD NO PAGADA</th>';
        echo '<th>FECHA ULTIMA MENSUALIDAD NO PAGADA</th>';
        echo '<th>FECHA PRIMERA MENSUALIDAD NO PAGADA</th>';
        echo '<th>SALDO DEUDA</th>';
        echo '</tr>';


    while($contratos = mysql_fetch_array($sql_query)){

        $ajuste =0;

        $pro_fe = explode('-',$contratos['f_ingreso']);


        $mes = $pro_fe[1];
        $anio = $pro_fe[2];

        if ($mes == '12' && $anio < date('Y')){

            $ajuste = 3.0;

        }

        if ($mes == '01' && $anio < date('Y')){

            $ajuste = 2.7;

        }


        echo '<tr>';
        echo '<td>'.$contratos['empresa'].'</td>';
        echo '<td>'.$contratos['breve'].'</td>';
        echo '<td>'.$contratos['titular'].'</td>';
        echo '<td>'.$contratos['num_solici'].'</td>';
        echo '<td>'.$contratos['secuencia'].'</td>';
        echo '<td>'.$contratos['cod_plan'].'</td>';
        echo '<td>'.$contratos['tipo_plan'].'</td>';
        echo '<td>'.$contratos['f_ingreso'].'</td>';
        echo '<td>'.$contratos['valor'].'</td>';
        echo '<td>'.$ajuste.'</td>';
        echo '<td>'.($contratos['valor'] * $ajuste /100).'</td>';
        echo '<td>'.$contratos['ZO'].'</td>';
        echo '<td>'.$contratos['SE'].'</td>';
        echo '<td>'.$contratos['MA'].'</td>';
        echo '<td>'.$contratos['es'].'</td>';

        $cta ="SELECT cta.cod_mov, COUNT(fecha_mov) AS Num, MAX(fecha_mov) AS Nueva,MIN(fecha_mov) AS antigua, SUM(importe) AS deuda
               FROM cta
               WHERE (cta.afectacion IS NULL || cta.afectacion =0 || cta.afectacion ='' AND cod_mov ='1') AND nro_doc='".$contratos['titular']."' AND num_solici='".$contratos['num_solici']."'
               GROUP BY num_solici,nro_doc";

        $query2 = mysql_query($cta);
        $num = mysql_num_rows($query2);

        if($num >0){

        while($ctaa = mysql_fetch_array($query2)){
            echo '<td>'.$ctaa['Num'].'</td>';
            echo '<td>'.$ctaa['Nueva'].'</td>';
            echo '<td>'.$ctaa['antigua'].'</td>';
            echo '<td>'.$ctaa['deuda'].'</td>';


        }
        }
        else{
            echo '<td>&zwj;</td>';
            echo '<td>&zwj;</td>';
            echo '<td>&zwj;</td>';
            echo '<td>&zwj;</td>';
        }

        echo '</tr>';
    }

    echo '</table>';












































        $sql =" SELECT COUNT(num_solici) AS secuencia,num_solici,nro_doc
        FROM afiliados
        WHERE afiliados.cod_baja='00'  ||  '05'  ||  'AJ' || 'AZ'  ||  '04' || 'DI'
        GROUP BY num_solici";

    $query = mysql_query($sql);

    while ($secuencia = mysql_fetch_array($query) ){

        $con = 'UPDATE contratos SET secuencia="'.$secuencia['secuencia'].'"
                WHERE num_solici="'.$secuencia['num_solici'].'"';

        if (mysql_query($con)){
            $mensaje ='Secuencia calculada<br />';
        }

    else{
        echo '<br />ERROR<br />';
    }
}
    //mensaje de secuencia
    echo $mensaje;

    //OBTENIENDO PAGOS CON BOLETA DESCARTANDO CONVENIOS
    $con_sql = "SELECT e_contrato.descripcion AS es,valor_plan.valor, contratos.cod_plan, contratos.tipo_plan,contratos.secuencia, contratos.num_solici, contratos.titular, DATE_FORMAT(contratos.f_ingreso,'%d-%m-%Y') AS f_ingreso, contratos.ZO, contratos.SE, contratos.MA,contratos.factu
                FROM contratos
                LEFT JOIN valor_plan ON contratos.secuencia = valor_plan.secuencia AND contratos.cod_plan = valor_plan.cod_plan AND contratos.tipo_plan = valor_plan.tipo_plan
                LEFT JOIN e_contrato ON e_contrato.cod = contratos.estado
                WHERE contratos.empresa IS NULL AND factu = 'A' AND contratos.f_pago != 400 AND contratos.f_pago != 600 AND estado != '700' AND estado != '800' AND estado != '600' AND estado != '1000' AND estado != '1100'
                ORDER BY f_ingreso";

    $sql_query = mysql_query($con_sql);
    echo '<br />';

    echo '<table class=table2>';

        echo '<tr>';
        echo '<th>RUT TUTLAR</th>';
        echo '<th>CONTRATO</th>';
        echo '<th>N AFI</th>';
        echo '<th>COD_PLAN</th>';
        echo '<th>TIPO_PLAN</th>';
        echo '<th>F_INGRESO</th>';
        echo '<th>VALOR</th>';
        echo '<th>%</th>';
        echo '<th>AJUSTE</th>';
        echo '<th>ZO</th>';
        echo '<th>SE</th>';
        echo '<th>MA</th>';
        echo '<th>ESTADO</th>';
        echo '<th>N MENSUALIDAD NO PAGADA</th>';
        echo '<th>FECHA ULTIMA MENSUALIDAD NO PAGADA</th>';
        echo '<th>FECHA PRIMERA MENSUALIDAD NO PAGADA</th>';
        echo '<th>SALDO DEUDA</th>';
        echo '</tr>';


    while($contratos = mysql_fetch_array($sql_query)){

        $ajuste =0;

        $pro_fe = explode('-',$contratos['f_ingreso']);


        $mes = $pro_fe[1];
        $anio = $pro_fe[2];

        if ($mes == '12' && $anio < date('Y')){

            $ajuste = 3.0;

        }

        if ($mes == '01' && $anio < date('Y')){

            $ajuste = 2.7;

        }


        echo '<tr>';

        echo '<td>'.$contratos['titular'].'</td>';
        echo '<td>'.$contratos['num_solici'].'</td>';
        echo '<td>'.$contratos['secuencia'].'</td>';
        echo '<td>'.$contratos['cod_plan'].'</td>';
        echo '<td>'.$contratos['tipo_plan'].'</td>';
        echo '<td>'.$contratos['f_ingreso'].'</td>';
        echo '<td>'.$contratos['valor'].'</td>';
        echo '<td>'.$ajuste.'</td>';
        echo '<td>'.($contratos['valor'] * $ajuste /100).'</td>';
        echo '<td>'.$contratos['ZO'].'</td>';
        echo '<td>'.$contratos['SE'].'</td>';
        echo '<td>'.$contratos['MA'].'</td>';
        echo '<td>'.$contratos['es'].'</td>';

        $cta ="SELECT cta.cod_mov, COUNT(fecha_mov) AS Num, MAX(fecha_mov) AS Nueva,MIN(fecha_mov) AS antigua, SUM(importe) AS deuda
               FROM cta
               WHERE (cta.afectacion IS NULL || cta.afectacion =0 || cta.afectacion ='' AND cod_mov ='1') AND nro_doc='".$contratos['titular']."' AND num_solici='".$contratos['num_solici']."'
               GROUP BY num_solici,nro_doc";

        $query2 = mysql_query($cta);
        $num = mysql_num_rows($query2);

        if($num >0){

        while($ctaa = mysql_fetch_array($query2)){
            echo '<td>'.$ctaa['Num'].'</td>';
            echo '<td>'.$ctaa['Nueva'].'</td>';
            echo '<td>'.$ctaa['antigua'].'</td>';
            echo '<td>'.$ctaa['deuda'].'</td>';


        }
        }
        else{
            echo '<td>&zwj;</td>';
            echo '<td>&zwj;</td>';
            echo '<td>&zwj;</td>';
            echo '<td>&zwj;</td>';
        }

        echo '</tr>';
    }

    echo '</table>';























    exit;
    //FIN PRIMER IF
}
?>


