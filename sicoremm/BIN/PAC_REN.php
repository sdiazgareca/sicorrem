<?php
/*
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=archivo.xls");
header("Pragma: no-cache");
header("Expires: 0");
*/

include_once('../DAT/conf.php');
include_once('../DAT/bd.php');
include_once('../CLA/Datos.php');

function fecha_normal_a_mysql($fecha){
  
    $cambio = explode('-',$fecha);
    $fecha_final = $cambio[2].'-'.$cambio[1].'-'.$cambio[0];   
    return $fecha_final;
    
}

function pago_cta($nro_doc,$tipo_comp,$comprovante,$cod_mov,$afectacion,$fecha_mov,$fecha_vto,$importe,$cobrador,$num_solici,$fecha,$debe,$haber,$rendicion){

    $fecha_mov1 = fecha_normal_a_mysql($fecha_mov);
    $fecha_vto2 = fecha_normal_a_mysql($fecha_vto);
    $fecha3 = $fecha;

    $insert_sql = "INSERT INTO cta (tip_doc,nro_doc,tipo_comp,serie,comprovante,cod_mov,afectacion,fecha_mov,fecha_vto,importe,cobrador,num_solici,fecha,debe,haber,rendicion) VALUES(1,'".$nro_doc."','".$tipo_comp."','50','".$comprovante."','".$cod_mov."','".$afectacion."','".$fecha_mov1."','".$fecha_vto2."','".$importe."','".$cobrador."','".$num_solici."','".$fecha3."','".$debe."','".$haber."','".$rendicion."')";
    $update ="UPDATE cta SET afectacion='".$afectacion."' WHERE nro_doc='".$nro_doc."' AND cod_mov='1' AND fecha_mov='".$fecha_mov1."'";

    //echo '<br />'.$insert_sql.'<br />';

    $tran = new Datos;
    $query['pago']= $insert_sql;
    $query['afecta']= $update;
    $res = $tran->Trans3($query);
    return $res;

}

if ($_POST['carga'] == 2){

?>
<table class="table2" border="1">

    <caption><strong>RESUMEN CARGA MASIVA <?php echo date('d-m-Y'); ?></strong></caption>

    <tr>
        <th>CONTRATO</th>
        <th>FAC</th>
        <th>TITULAR</th>
        <th>APELLIDOS</th>
        <th>NOMBRES</th>
        <th>TITULAR CTA</th>
        <th>RUT</th>
        <th>F_MOV</th>
        <th>COMP</th>
        <th>VALOR</th>
        <th>BANCO</th>
        <th>ESTADO</th>
        <th>ACCION</th>
    </tr>
<?php

    foreach ($_POST AS $campos => $valor){

        //echo '<br />'.$campos.' '.$valor.'<br />';

     if($campos != 'carga' ){

         $ctacte = explode('/',$valor);
              //pago_cta($nro_doc,$tipo_comp,$comprovante,$cod_mov,$afectacion,$fecha_mov,$fecha_vto,$importe,$cobrador,$num_solici,$fecha,$debe,$haber,$rendicion)
         $cta = pago_cta($ctacte[0],$ctacte[1],$ctacte[2],'92',$ctacte[2],$ctacte[4],$ctacte[4],$ctacte[5],10,$ctacte[6],$ctacte[8],0,$ctacte[5],$ctacte[7]);


         if($cta == 1){

         $sql ="SELECT
        doc_f_pago.apellidos AS apellidos_titular,
        contratos.factu,
        titular_cta,
        rut_titular_cta,
        titulares.nombre1,
        titulares.nombre2,
        titulares.apellido,
        bancos.descripcion AS banco,
        t_credito.descripcion AS tc,
        e_contrato.descripcion AS estado

        FROM contratos

        INNER JOIN cta ON cta.nro_doc = contratos.titular AND cta.num_solici = contratos.num_solici
        INNER JOIN f_pago ON f_pago.codigo = contratos.f_pago
        INNER JOIN valor_plan ON valor_plan.cod_plan = contratos.cod_plan AND valor_plan.tipo_plan = contratos.tipo_plan AND valor_plan.secuencia = contratos.secuencia
        INNER JOIN t_mov ON cta.cod_mov = t_mov.codigo
        INNER JOIN titulares ON titulares.nro_doc = contratos.titular
        INNER JOIN doc_f_pago ON contratos.num_solici = doc_f_pago.numero
        LEFT JOIN  bancos ON bancos.codigo = doc_f_pago.banco
        LEFT JOIN t_credito ON t_credito.codigo = doc_f_pago.t_credito
        INNER JOIN e_contrato ON e_contrato.cod = contratos.estado

        WHERE contratos.num_solici='".$ctacte[6]."' AND contratos.titular='".$ctacte[0]."'";

        $con_query = mysql_query($sql);

        $dat = mysql_fetch_array($con_query);

        
        if ($dat['banco'] != "" && $dat['tc'] == ""){

            $doc =$dat['banco'];
        }

        if ($dat['banco'] == "" && $dat['tc'] != ""){

            $doc =$dat['tc'];
        }

        ?>

        <tr>
        <td><?php echo $ctacte[6]; ?></td>
        <td><?php echo $ctacte[1]; ?></td>
        <td><?php echo $ctacte[0]; ?></td>
        <td><?php echo $dat['apellido']; ?></td>
        <td><?php echo $dat['nombre1'].' '.$dat['nombre2']; ?></td>
        <td><?php echo strtoupper($dat['titular_cta']).' '.strtoupper($dat['apellidos_titular']); ?></td>
        <td><?php echo $dat['rut_titular_cta']; ?></td>
        <td><?php echo $ctacte[4]; ?></td>
        <td><?php echo $ctacte[2]; ?></td>
        <td><?php echo $ctacte[5]; ?></td>
        <td><?php echo $doc; ?></td>
        <td><?php echo strtoupper($dat['estado']); ?></td>
        <td><strong>PROCESADO</strong></td>
        </tr>
            <?php
         }

         if($cta == 0){
?>
        <tr>
        <td><?php echo $ctacte[6]; ?></td>
        <td><?php echo $ctacte[1]; ?></td>
        <td><?php echo $ctacte[0]; ?></td>
        <td><?php echo $dat['apellido']; ?></td>
        <td><?php echo $dat['nombre1'].' '.$dat['nombre2']; ?></td>
        <td><?php echo strtoupper($dat['titular_cta']).' '.strtoupper($dat['apellidos_titular']); ?></td>
        <td><?php echo $dat['rut_titular_cta']; ?></td>
        <td><?php echo $ctacte[4]; ?></td>
        <td><?php echo $ctacte[2]; ?></td>
        <td><?php echo $ctacte[5]; ?></td>
        <td><?php echo $doc; ?></td>
        <td><?php echo strtoupper($dat['estado']); ?></td>
        <td><strong>Error</strong></td>
        </tr>
 <?php
         }

}
}
?>
     </table>
<?php
}
if ($_POST['carga'] == 1){

?>
<table class="table2" border="1">

    <caption><strong>LISTADO <?php echo date('d-m-Y'); ?></strong></caption>

    <tr>
        <th>CONTRATO</th>
        <th>FAC</th>
        <th>TITULAR</th>
        <th>APELLIDOS</th>
        <th>NOMBRES</th>
        <th>TITULAR CTA</th>
        <th>RUT</th>
        <th>F_MOV</th>
        <th>COMP</th>
        <th>VALOR</th>
        <th>BANCO</th>
        <th>ESTADO</th>
    </tr>
<?php

    foreach ($_POST AS $campos => $valor){

     if($campos != 'carga' ){

         $ctacte = explode('/',$valor);
              //pago_cta($nro_doc,$tipo_comp,$comprovante,$cod_mov,$afectacion,$fecha_mov,$fecha_vto,$importe,$cobrador,$num_solici,$fecha,$debe,$haber,$rendicion)
         //$cta = pago_cta($ctacte[0],$ctacte[1],$ctacte[2],$ctacte[3],$ctacte[2],$ctacte[4],$ctacte[4],$ctacte[5],10,$ctacte[6],date('d-m-Y'),0,$ctacte[5],$ctacte[7]);


         $sql ="SELECT
        doc_f_pago.apellidos AS apellidos_titular,
        contratos.factu,
        titular_cta,
        rut_titular_cta,
        titulares.nombre1,
        titulares.nombre2,
        titulares.apellido,
        bancos.descripcion AS banco,
        t_credito.descripcion AS tc,
        e_contrato.descripcion AS estado

        FROM contratos

        INNER JOIN cta ON cta.nro_doc = contratos.titular AND cta.num_solici = contratos.num_solici
        INNER JOIN f_pago ON f_pago.codigo = contratos.f_pago
        INNER JOIN valor_plan ON valor_plan.cod_plan = contratos.cod_plan AND valor_plan.tipo_plan = contratos.tipo_plan AND valor_plan.secuencia = contratos.secuencia
        INNER JOIN t_mov ON cta.cod_mov = t_mov.codigo
        INNER JOIN titulares ON titulares.nro_doc = contratos.titular
        INNER JOIN doc_f_pago ON contratos.num_solici = doc_f_pago.numero
        LEFT JOIN  bancos ON bancos.codigo = doc_f_pago.banco
        LEFT JOIN t_credito ON t_credito.codigo = doc_f_pago.t_credito
        INNER JOIN e_contrato ON e_contrato.cod = contratos.estado

        WHERE contratos.num_solici='".$ctacte[6]."' AND contratos.titular='".$ctacte[0]."'";

        $con_query = mysql_query($sql);

        $dat = mysql_fetch_array($con_query);


        if ($dat['banco'] != "" && $dat['tc'] == ""){

            $doc =$dat['banco'];
        }

        if ($dat['banco'] == "" && $dat['tc'] != ""){

            $doc =$dat['tc'];
        }

        ?>

        <tr>
        <td><?php echo $ctacte[6]; ?></td>
        <td><?php echo $ctacte[1]; ?></td>
        <td><?php echo $ctacte[0]; ?></td>
        <td><?php echo $dat['apellido']; ?></td>
        <td><?php echo $dat['nombre1'].' '.$dat['nombre2']; ?></td>
        <td><?php echo strtoupper($dat['titular_cta']).' '.strtoupper($dat['apellidos_titular']); ?></td>
        <td><?php echo $dat['rut_titular_cta']; ?></td>
        <td><?php echo $ctacte[4]; ?></td>
        <td><?php echo $ctacte[2]; ?></td>
        <td><?php echo $ctacte[5]; ?></td>
        <td><?php echo $doc; ?></td>
        <td><?php echo strtoupper($dat['estado']); ?></td>
        </tr>
            <?php


}
}
?>
     </table>
<?php
}


