<script type="text/javascript">

$(document).ready(function() {

$('#ajax1 a:contains("Recargar")').click(function() {
	var ruta = $(this).attr('href');
 	$('#ajax3').load(ruta);
	$.ajax({cache: false});
	ruta = "";
 	return false;
 });



});

</script>

<?php
include_once('../DAT/conf.php');
include_once('../DAT/bd.php');
include_once('../CLA/Datos.php');
include_once('../CLA/Select.php');
include_once('../CLA/Afiliados.php');

//COMPROBAR RUT EXISTENTES

if ($_POST['afi'] > 0){
$rut = new Datos;

$rut->Rut($_POST['nro_doc']);

$sql = "SELECT nro_doc FROM afiliados WHERE nro_doc = '".$rut->nro_doc."'
    AND (cod_baja = 'AZ' || cod_baja ='00' || cod_baja= '01' || cod_baja='05')";
$query = mysql_query($sql);
$num = mysql_num_rows($query);

$sql2 = "SELECT titulares.nro_doc, contratos.estado FROM titulares
INNER JOIN contratos ON contratos.titular = titulares.nro_doc
WHERE titulares.nro_doc='".$rut->nro_doc."' AND (estado = 900 || estado ='3600' || estado='3100')";
$query2 = mysql_query($sql2);
$num2 = mysql_num_rows($query2);


if ($num > 0 || $num2 > 0){

        if($num2 > 0){
	echo '<div class="mensaje2"><img src="IMG/M2.png" />El afiliado existe como titular en otro contrato y tiene deuda pendiente</div>';
	echo '<div align="right" style="padding:10px;">
	  <a href="INT/M_CONT.php?ver=1&CONTRATO='.$_POST['num_solici'].'" class="boton">Recargar</a>
	  </div>';
        }

        if($num > 0){
	echo '<div class="mensaje2"><img src="IMG/M2.png" />El afiliado existe en la base de datos como activo</div>';
	echo '<div align="right" style="padding:10px;">
	  <a href="INT/M_CONT.php?ver=1&CONTRATO='.$_POST['num_solici'].'" class="boton">Recargar</a>
	  </div>';
        }

}
else{

$fech = $rut->cambiaf_a_mysql($_POST['fecha_nac']);

if ( $_POST['titular'] != $rut->nro_doc ) {
	$categoria = '2';
}

else{
	$categoria = '1';
}

$dat = new Datos;

$inser['cont'] ="INSERT INTO afiliados (nro_doc,nombre1,nombre2,apellido,sexo,obra_afi,obra_numero,fecha_nac,cod_parentesco,
num_solici,cod_plan,tipo_plan,fecha_alta,titular,fecha_act,fecha_ing,pais,cod_baja, categoria)
VALUES('".$rut->nro_doc."','".$_POST['nombre1']."','".$_POST['nombre2']."','".$_POST['apellido']."','".$_POST['sexo']."','".$_POST['obra_afi']."','".$_POST['obra_afi']."',
'".$fech."' ,'".$_POST['cod_parentesco']."','".$_POST['num_solici']."',
'".$_POST['cod_plan']."','".$_POST['tipo_plan']."','".$_POST['fecha_alta']."','".$_POST['titular']."','".$_POST['fecha_act']."',
'".$_POST['fecha_ing']."','".$_POST['pais']."','".$_POST['cod_baja']."','".$categoria."')";


foreach( $_POST as $campo => $valor){

	$cadena = explode("_",$campo);

	if ($cadena[0] == "ATE"  &&  $valor > 0){
		$inser[$campo.$valor] = "INSERT INTO `sicoremm2`.`ate_medicos_reg`(`codigo`,`ate_medicos`) VALUES ( '".$rut->nro_doc."','".$valor."')";

	}
}


$dat->Trans($inser);

	//DATOS DEL CONTRATO

	$sql = "SELECT num_solici, contratos.titular, contratos.secuencia, contratos.cod_plan, contratos.tipo_plan FROM contratos WHERE contratos.num_solici='".$_POST[�num_solici�]."'";
	$query = mysql_query($sql);
	$comi = mysql_fetch_array($query);

	$campos = "SELECT nro_doc AS RUT,nombre1 AS NOMBRE1,nombre2 AS NOMBRE2,apellido AS APELLIDOS,
	sexo AS SEXO,des_obras_soc AS P_SALUD,fecha_nac AS F_NAC,
	num_solici AS N_CONTRATO,cod_plan AS COD_PLAN,tipo_plan AS T_PLAN,
	desc_plan AS PLAN,fecha_ing AS F_INGRESO,
	des_mot_baja AS ESTADO,des_categoria AS CATEGORIA
	FROM afi WHERE afi.num_solici='".$_POST['num_solici']."'";

	$query = mysql_query($campos);

?>

<h2>Afiliado</h2>
<table class="table">
<tr>

<?php

	$cont = 0;
	$mat = mysql_fetch_assoc($query);

	foreach($mat as $campos => $values){
		echo '<td><strong>'.$campos.'</strong></td><td>'.$values.'</td>';
		$cont ++;
		if ( ($cont % 4)  < 1){
			echo '</tr>';
		}
	}
?>
</tr>
</table>
<br /><br/>
<?php
}

}


if ($_POST['BOLL']){


/*
    foreach($_POST AS $campo=>$valor){

        echo $campo.' '.$valor.'<br />';

    }


*/
	//CALCULCA COMISIONES
	$sql = "SELECT
                        ventas_reg.rendicion,
			ventas_reg.monto,
                        mes_pago_inicial,
			ventas_reg.vendedor,
			vendedor.cat,
			ventas_reg.num_solici,
			contratos.f_pago,
			f_pago.comi_free,
			f_pago.locomocion,
			contratos.cod_plan,
			contratos.tipo_plan,
                        contratos.titular,
                        ventas_reg.pago_venta
			FROM ventas_reg
			INNER JOIN vendedor ON ventas_reg.vendedor = vendedor.nro_doc
			INNER JOIN contratos ON contratos.num_solici = ventas_reg.num_solici
			INNER JOIN f_pago ON f_pago.codigo = contratos.f_pago
			WHERE contratos.num_solici ='".$_POST['num_solici']."' AND rendicion='".$_POST['rendicion']."'
			ORDER BY f_pago";


        echo '<br />'.$sql.'<br />';

        $query = mysql_query($sql);
	$comi = mysql_fetch_array($query);


        echo 'monto'.$comi['monto'].'<br />pago_venta '.$comi['pago_venta'].'<br />';
       // echo 'categoria '.$comi['cat'];

        if( $comi['cat'] == '100'){
	$comision = $comi['monto'] * $comi['comi_free'] /100;
        }

        else{
            $comision = '0';
        }

	$query2['boleta'] = "UPDATE ventas_reg SET ff_factu='".$_POST['tipo_doc']."',tipo_plan='".$comi['tipo_plan']."',cod_plan='".$comi['cod_plan']."',estado_venta='100', n_documento='".$_POST['n_boleta']."',locominion='".$comi['locomocion']."',comision='".$comision."', porcentaje = '".$comi['comi_free']."' WHERE num_solici='".$_POST['num_solici']."' AND cat_venta='200' AND vendedor='".$comi['vendedor']."'";

        if($comi['pago_venta'] == 10 && $comi['monto'] > 0){
            
            $query2['cta'] ="INSERT INTO cta
                            (rendicion,fecha,DEV,tipo_comp,serie,tip_doc,nro_doc,comprovante,cod_mov,afectacion,fecha_mov,importe,cobrador,num_solici,debe)
                             VALUES ('".$comi['rendicion']."','".$comi['mes_pago_inicial']."',1,'".$_POST['tipo_doc']."','50','1','".$comi['titular']."','".$_POST['n_boleta']."','100','".$_POST['n_boleta']."','".$comi['mes_pago_inicial']."','".$comi['monto']."','1','".$_POST['num_solici']."','".$comi['monto']."')";

            $query2['cta2'] ="INSERT INTO cta
                             (rendicion,fecha,DEV,tipo_comp,serie,tip_doc,nro_doc,comprovante,cod_mov,afectacion,fecha_mov,importe,cobrador,num_solici,haber)
                              VALUES ('".$comi['rendicion']."','".$comi['mes_pago_inicial']."',1,'".$_POST['tipo_doc']."','50','1','".$comi['titular']."','".$_POST['n_boleta']."','95','".$_POST['n_boleta']."','".$comi['mes_pago_inicial']."','".$comi['monto']."','1','".$_POST['num_solici']."','".$comi['monto']."')";
            
        }
        
        if($comi['pago_venta'] == 20 && $comi['monto'] > 0){
            

            $query2['cta'] ="INSERT INTO cta
                            (rendicion,fecha,DEV,tipo_comp,serie,tip_doc,nro_doc,comprovante,cod_mov,afectacion,fecha_mov,importe,cobrador,num_solici,debe)
                             VALUES ('".$comi['rendicion']."','".$comi['mes_pago_inicial']."',1,'".$_POST['tipo_doc']."','50','1','".$comi['titular']."','".$_POST['n_boleta']."','100','".$_POST['n_boleta']."','".$comi['mes_pago_inicial']."','".$comi['monto']."','1','".$_POST['num_solici']."','".$comi['monto']."')";

            $query2['cta2'] ="INSERT INTO cta
                             (rendicion,fecha,DEV,tipo_comp,serie,tip_doc,nro_doc,comprovante,cod_mov,afectacion,fecha_mov,importe,cobrador,num_solici,haber)
                              VALUES ('".$comi['rendicion']."','".$comi['mes_pago_inicial']."',1,'".$_POST['tipo_doc']."','50','1','".$comi['titular']."','".$_POST['n_boleta']."','93','".$_POST['n_boleta']."','".$comi['mes_pago_inicial']."','".$comi['monto']."','1','".$_POST['num_solici']."','".$comi['monto']."')";
            
        }  
        
        if($comi['pago_venta'] == 30 && $comi['monto'] > 0){
            

            $query2['cta'] ="INSERT INTO cta
                            (rendicion,fecha,DEV,tipo_comp,serie,tip_doc,nro_doc,comprovante,cod_mov,afectacion,fecha_mov,importe,cobrador,num_solici,debe)
                             VALUES ('".$comi['rendicion']."','".$comi['mes_pago_inicial']."',1,'".$_POST['tipo_doc']."','50','1','".$comi['titular']."','".$_POST['n_boleta']."','100','".$_POST['n_boleta']."','".$comi['mes_pago_inicial']."','".$comi['monto']."','1','".$_POST['num_solici']."','".$comi['monto']."')";

            $query2['cta2'] ="INSERT INTO cta
                             (rendicion,fecha,DEV,tipo_comp,serie,tip_doc,nro_doc,comprovante,cod_mov,afectacion,fecha_mov,importe,cobrador,num_solici,haber)
                              VALUES ('".$comi['rendicion']."','".$comi['mes_pago_inicial']."',1,'".$_POST['tipo_doc']."','50','1','".$comi['titular']."','".$_POST['n_boleta']."','52','".$_POST['n_boleta']."','".$comi['mes_pago_inicial']."','".$comi['monto']."','1','".$_POST['num_solici']."','".$comi['monto']."')";


        }

        if($comi['pago_venta'] == 40 && $comi['monto'] > 0){

            $query2['cta'] ="INSERT INTO cta
                            (rendicion,fecha,DEV,tipo_comp,serie,tip_doc,nro_doc,comprovante,cod_mov,afectacion,fecha_mov,importe,cobrador,num_solici,debe)
                             VALUES ('".$comi['rendicion']."','".$comi['mes_pago_inicial']."',1,'".$_POST['tipo_doc']."','50','1','".$comi['titular']."','".$_POST['n_boleta']."','100','".$_POST['n_boleta']."','".$comi['mes_pago_inicial']."','".$comi['monto']."','1','".$_POST['num_solici']."','".$comi['monto']."')";

            $query2['cta2'] ="INSERT INTO cta
                             (rendicion,fecha,DEV,tipo_comp,serie,tip_doc,nro_doc,comprovante,cod_mov,afectacion,fecha_mov,importe,cobrador,num_solici,haber)
                              VALUES ('".$comi['rendicion']."','".$comi['mes_pago_inicial']."',1,'".$_POST['tipo_doc']."','50','1','".$comi['titular']."','".$_POST['n_boleta']."','51','".$_POST['n_boleta']."','".$comi['mes_pago_inicial']."','".$comi['monto']."','1','".$_POST['num_solici']."','".$comi['monto']."')";

        }
        


        $query2['contrato'] = "UPDATE contratos SET estado='500' WHERE num_solici='".$_POST['num_solici']."'";



	$tr = new Datos;
	$tr->Trans($query2);

        $afi = new Afiliados;
        $afi->Secuencia($_POST['num_solici']);

?>
<div>
    <br />
<a target="_blank" href="BIN/DOC1.pdf" class="boton">C. Bienv</a>
<a target="_blank" href="BIN/BOLL.php?tipo=INCO&" class="boton">Boleta</a>
</div>
<?php
}
?>


