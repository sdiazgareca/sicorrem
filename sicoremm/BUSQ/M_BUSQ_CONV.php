<?php

include_once('../DAT/conf.php');
include_once('../DAT/bd.php');
include_once('../CLA/Datos.php');
include_once('../CLA/Select.php');

$nempresa = "SELECT empresa, nro_doc, contacto,fono, email,celular,breve,ZO,SE,MA FROM empresa
INNER JOIN f_factu ON f_factu.codigo = empresa.f_factu WHERE nro_doc='".$_POST['empresa']."'";
$nempresa_q = mysql_query($nempresa);

$emp = mysql_fetch_array($nempresa_q);


echo '<h1>NOMINA '.$emp["empresa"].'</h1>';
?>

<!--<div align="right"><a href="DOC/Nomina_convenios.php?empresa=echo $_POST['empresa'];">Imprimir</a></div> -->

<table class="table2">
    <tr>
        <th><strong>Contacto</strong></th><td><?php echo $emp["contacto"]; ?></td>
        <th><strong>Fono</strong></th><td><?php echo $emp["fono"]; ?></td>
        <th><strong>Email</strong></th><td><?php echo $emp["email"]; ?></td>
        <th><strong>Factu</strong></th><td><?php echo $emp["breve"]; ?></td>
    </tr>
</table>


<table>
    <tr>
        <td></td>
    </tr>
</table>

<?php


//LISTADO NOMINAS EMPRESAS
if ($_POST['TIPO'] == 'NOMI'){

   $NOMI_SQL = "SELECT contratos.cod_plan, contratos.tipo_plan,contratos.ajuste,DATE_FORMAT(contratos.f_ingreso,'%d-%m-%Y') AS f_ingreso, DATE_FORMAT(contratos.f_baja,'%d-%m-%Y') AS f_baja,
       e_contrato.descripcion AS des_estado,valor_plan.valor,contratos.num_solici,contratos.f_ingreso,contratos.secuencia,titulares.nro_doc, titulares.nombre1, titulares.nombre2, titulares.apellido
                FROM titulares
                LEFT JOIN contratos ON contratos.titular = titulares.nro_doc
                LEFT JOIN e_contrato ON contratos.estado = e_contrato.cod
                LEFT JOIN valor_plan ON valor_plan.cod_plan = contratos.cod_plan AND valor_plan.tipo_plan = contratos.tipo_plan AND valor_plan.secuencia=contratos.secuencia
                WHERE contratos.empresa='".$_POST['empresa']."' AND
                (contratos.estado = '400'  || contratos.estado = '500' || contratos.estado = '3500' || contratos.estado = '1000') ORDER BY contratos.num_solici";


   //echo $NOMI_SQL;

   $NOMI_q = mysql_query($NOMI_SQL);

   $rut = new Datos;
   ?>

<h1>Nomina Afiliados Activos</h1>

<div style=" width: 900px; height: 200px; overflow: auto;">

<table class="table">
       <tr>
       <th><strong>CONTRATO</strong></th>
       <th><strong>FECHA AFILA</strong></th>
       <th><strong>RUT</strong></th>
       <th><strong>APELLIDOS</strong></th>
       <th><strong>NOMBRES</strong></th>
       <th><strong>N AFI</strong></th>
       <th><strong>MONTO</strong></th>
       <th><strong>AJUSTE</strong></th>
       <th><strong>TOTAL</strong></th>
       <th><strong>ESTADO</strong></th>

       </tr>
   <?php

   while ($NOMI = mysql_fetch_array($NOMI_q)){

       $rut->validar_rut($NOMI['nro_doc']);
       $fecha = new Datos;


       ?>
        <tr>
            <td><?php echo htmlentities($NOMI['num_solici']); ?></td>
            <td><?php echo $NOMI['f_ingreso']; ?></td>
            <td><?php echo $rut->nro_doc; ?></td>
            <td><?php echo htmlentities($NOMI['apellido']); ?></td>
            <td><?php echo htmlentities($NOMI['nombre1']).' '.htmlentities($NOMI['nombre2']); ?></td>
            <td><?php echo htmlentities($NOMI['secuencia']); ?></td>
            <td><?php echo htmlentities($NOMI['valor']); ?></td>
            <td><?php echo $NOMI['ajuste']; ?></td>
            <td><?php echo $NOMI['valor'] + $NOMI['ajuste']; ?></td>
            <td><?php echo htmlentities($NOMI['des_estado']); ?></td>
<?php
$total = $total + $NOMI['valor'] + $NOMI['ajuste'];
?>
        </tr>
       <?php

   }
   ?>
   <tr>
       <th>&zwnj;</th>
       <th>&zwnj;</th>
       <th>&zwnj;</th>
       <th>&zwnj;</th>
       <th>&zwnj;</th>
       <th>TOTAL</th>
       <th><?php echo $total;?></th>
       <th>&zwnj;</th>
   </tr>

   </table>
</div>
   <?php

   $NOMI_SQL = "SELECT DATE_FORMAT(contratos.f_ingreso,'%d-%m-%Y') AS f_ingreso, DATE_FORMAT(contratos.f_baja,'%d-%m-%Y') AS f_baja,
       e_contrato.descripcion AS des_estado,valor_plan.valor,contratos.num_solici,contratos.f_ingreso,contratos.secuencia,titulares.nro_doc, titulares.nombre1, titulares.nombre2, titulares.apellido
                FROM titulares
                LEFT JOIN contratos ON contratos.titular = titulares.nro_doc
                LEFT JOIN e_contrato ON contratos.estado = e_contrato.cod
                LEFT JOIN valor_plan ON valor_plan.cod_plan = contratos.cod_plan AND valor_plan.tipo_plan = contratos.tipo_plan AND valor_plan.secuencia=contratos.secuencia
                WHERE contratos.empresa='".$_POST['empresa']."' AND
                (contratos.estado = '600'  || contratos.estado = '700' || contratos.estado = '800' || contratos.estado ='1200' || contratos.estado ='900')";


   //echo '<br />'.$NOMI_SQL.'<br />';

   $NOMI_q = mysql_query($NOMI_SQL);

   $rut = new Datos;
   ?>

<br />
<h1>Nomina Afiliados Renuncias</h1>

<div style=" width: 900px; height: 200px; overflow: auto;">

<table class="table">
       <tr>
       <th><strong>CONTRATO</strong></th>
       <th><strong>FECHA AFILA</strong></th>
       <th><strong>RUT</strong></th>
       <th><strong>APELLIDOS</strong></th>
       <th><strong>NOMBRES</strong></th>
       <th><strong>N AFI</strong></th>
       <th><strong>MONTO</strong></th>
       <th><strong>ESTADO</strong></th>

       </tr>
   <?php

   while ($NOMI = mysql_fetch_array($NOMI_q)){

       $rut->validar_rut($NOMI['nro_doc']);
       $fecha = new Datos;


       ?>
        <tr>
            <td><?php echo htmlentities($NOMI['num_solici']); ?></td>
            <td><?php echo $NOMI['f_ingreso']; ?></td>
            <td><?php echo $rut->nro_doc; ?></td>
            <td><?php echo htmlentities($NOMI['apellido']); ?></td>
            <td><?php echo htmlentities($NOMI['nombre1']).' '.htmlentities($NOMI['nombre2']); ?></td>
            <td><?php echo htmlentities($NOMI['secuencia']); ?></td>
            <td><?php echo htmlentities($NOMI['valor']); ?></td>
            <td><?php echo htmlentities($NOMI['des_estado']); ?></td>
<?php
$total = $total + $NOMI['valor'];
?>
        </tr>
       <?php

   }
   ?>
   <tr>
       <th>&zwnj;</th>
       <th>&zwnj;</th>
       <th>&zwnj;</th>
       <th>&zwnj;</th>
       <th>&zwnj;</th>
       <th>TOTAL</th>
       <th><?php echo $total;?></th>
       <th>&zwnj;</th>
   </tr>

   </table>
</div>


<?php
}

//ATENCIONES COPAGO
if ($_POST['TIPO'] == 'ATEN'){

        $sql ="SELECT contratos.num_solici FROM contratos WHERE contratos.empresa ='".$_POST['empresa']."'";
        $query = mysql_query($sql);
?>
<table class="table">
                <tr>
                <th><strong>Fecha</strong></th>
                <th><strong>PROT</strong></th>
                <th><strong>N CONT</strong></th>
                <th><strong>Boleta</strong></th>
                <th><strong>Importe</strong></th>
                <th><strong>Tipo_pago</strong></th>
                <th><strong>Folio</strong></th>
                <th><strong>Paciente</strong></th>
                </tr>
<?
        while($con = mysql_fetch_array($query)){

            $cop_sql = "SELECT fichas.paciente,tipo_pago.tipo_pago AS tp,fecha,protocolo,numero_socio,boleta,importe,folio_med
                        FROM copago
                        LEFT JOIN fichas ON fichas.correlativo = copago.protocolo
                        LEFT JOIN tipo_pago ON copago.tipo_pago = tipo_pago.cod
                        WHERE fichas.num_solici='".$con['num_solici']."'
                            AND (obser_man ='24' || obser_man='42' || obser_man='45')
                        GROUP BY protocolo";

            $cop_query = mysql_query($cop_sql);

            while($cop = mysql_fetch_array($cop_query)){
                ?>
                <tr>
                <td><?php echo $cop['fecha']; ?></td>
                <td><?php echo $cop['protocolo']; ?></td>
                <td><?php echo $cop['numero_socio']; ?></td>
                <td><?php echo $cop['boleta']; ?></td>
                <td><?php echo $cop['importe']; ?></td>
                <td><?php echo $cop['tp']; ?></td>
                <td><?php echo $cop['folio_med']; ?></td>
                <td><?php echo $cop['paciente']; ?></td>
                </tr>
                <?php
            }


        }
?>
</table>
<?php

}

?>
