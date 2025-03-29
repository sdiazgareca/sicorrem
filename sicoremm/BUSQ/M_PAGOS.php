<?php

include_once('../DAT/conf.php');
include_once('../DAT/bd.php');
include_once('../CLA/Datos.php');


$num = count($_POST);
$i = 1;
foreach($_POST AS $campos=>$valor){

    if ($valor == "" && $campos == 'rendicion'){
        echo '<div class="mensaje2">Error =(</div>';
        exit;
    }

    if ( $campos != 'rendicion' && $valor > 0 && $campos != "" && $campos != "fecha"){

        if($campos == 'fecha_mov'){

            $fecha = explode('-',$valor);
            $valor = $fecha[1].'-'.$fecha[0].'-1';

        }

        if ($campos == "bancos"){

            $campos = "bancos.codigo";
        }

        if ($campos == "tarjeta"){
            $campos = "t_credito.codigo";
        }

        if($campos == "bancos" && $valor == "MULTIBACO"){

            $condicion = $condicion.' bancos.codigo != "12"';
            $i ++;

        }

        else{
            $condicion = $condicion.' '.$campos.'="'.$valor.'"';
            $i ++;
        }
        
        if($i < $num){
            $condicion = $condicion.' AND';
        }
    }


$where = substr ($condicion, 0, strlen($condicion) - 3);

}

$sql="SELECT e_contrato.descripcion AS est,contratos.factu,DATE_FORMAT(cta.fecha_mov,'%d-%m-%Y') as fecha_mov,titular_cta,rut_titular_cta,titulares.nombre1, titulares.nombre2, titulares.apellido, t_mov.corta,
    contratos.titular,contratos.num_solici, contratos.f_ingreso,comprovante,valor_plan.valor,
     bancos.descripcion AS banco, t_credito.descripcion AS tc
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
WHERE ".$where." AND t_mov.operador='D' AND afectacion < 1 ORDER BY rut_titular_cta, titular ASC";

//echo '<br />'.$sql.'<br />';

$cta_query = mysql_query($sql);

$num = mysql_num_rows($cta_query);

if($num < 1){

    echo '<div class="mensaje2">No se encontraron datos</div>';
    exit;

}
echo'<h1>RENDICION '.$_POST['rendicion'].' FECHA '.date('d-m-Y').'</h1>';
?>

<form action="BIN/PAC_REN.php" method="post" name="PAC">

<table class="table">
<tr>
    <th>&zwnj;</th>
    <th>CONTRATO</th>
    <th>FACTU</th>
    <th>TITULAR</th>
    <th>APELLIDOS</th>
    <th>NOMBRES</th>
    <th>TITULR CTA</th>
    <th>RUT</th>
    <th>F_MOV</th>
    <th>COMP</th>
    <th>VALOR</th>
    <th>ESTADO</th>
    <th>&zwnj;</th>
</tr>

<?

$rut = new Datos;



while ($cta = mysql_fetch_array($cta_query)){

    if ( $cta['banco'] != "" ){
        
        
        $doc = $cta['banco'];
        $t_mov ='92';
    }
    else{
        
        $doc = $cta['tc'];
        $t_mov ='52';
    }

    echo '<tr>
            <td><strong>'.$cta['corta'].'</strong></td>
            <td>'.$cta['num_solici'].'</td>
            <td>'.$cta['factu'].'</td>
            <td>'.$rut->validar_rut($cta['titular']).$rut->nro_doc.'</td>
            <td>'.strtoupper($cta['apellido']).'</td>
            <td>'.strtoupper($cta['nombre1'].' '.$cta['nombre2']).'</td>
            <td>'.strtoupper($cta['titular_cta']).'</td>
            <td>'.$rut->validar_rut($cta['rut_titular_cta']).$rut->nro_doc.'</td>
            <td>'.$cta['fecha_mov'].'</td>
            <td>'.$cta['comprovante'].'</td>
            <td>'.$cta['valor'].'</td>
            <td>'.$cta['est'].'</td>
            <td>'.$doc.'</td>

            <td><input type="checkbox" name="'.$cta['comprovante'].$cta['num_solici'].'"  value="'.$cta['titular'].'/'.$cta['factu'].'/'.$cta['comprovante'].'/'.$t_mov.'/'.$cta['fecha_mov'].'/'.$cta['valor'].'/'.$cta['num_solici'].'/'.$_POST['rendicion'].'/'.$_POST['fecha'].'" checked></td>

            </tr>';

}
?>

</table>


      <div align="right" style="padding:5px;">

        <table class="table2">
        <tr>
        <td><select name="carga">
            <option value="1">Imprimir</option>
            <option value="2">Cargar</option></select></td> <td><input type="submit" value="=)" /></td>
        </tr>
        </table>

    </div>

</form>